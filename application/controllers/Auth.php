<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Auth_model','auth');
    }
    public function index()
    {
        if($this->session->userdata('username')){
            redirect('user');
        }

        $this->form_validation->set_rules('username','Username','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');
        if ($this->form_validation->run() == FALSE) 
        {
            $data['title'] = 'User Login';
            $this->load->view('templates/auth_header',$data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }               
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password =$this->input->post('password');
        
        $user = $this->db->get_where('param_user',['username' => $username])->row_array();
        
        if($user){
            if($user['is_active']== 1){
                if(password_verify($password,$user['password'])){
                    $data = [
                        'username' => $user['username'],
                        'role_id' => $user['param_role_id'],
                        'id' => $user['id'],
                        'nama' => $user['fullnm']
                    ];
                    $this->session->set_userdata($data);
                    $this->session->set_flashdata('message',', Selamat Datang '.$user['fullnm']);
                    redirect('user');
                }else{
                    $this->session->set_flashdata('message','Password Salah');
                    redirect('auth');        
                }
            }else{
                $this->session->set_flashdata('message','Username Tidak Aktif');
            redirect('auth');    
            }
        }else{
            $this->session->set_flashdata('message','Username Tidak Terdaftar');
            redirect('auth');
        }

    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://mail.yonathanrizky.com',
            'smtp_user' => 'info@yonathanrizky.com',
            'smtp_pass' => '*#info2012',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email',$config);
        $this->email->initialize($config);
        $this->email->from('info@yonathanrizky.com','Info Yonathan Rizky');
        $this->email->to($this->input->post('email'));

        if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="'.base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');    
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }        
    }

    public function forgotpassword()
    {
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header',$data);
            $this->load->view('auth/forgot_password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->auth->getUser($email);
            
            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('d_user_token',$user_token);
                $this->_sendEmail($token,'forgot');
                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                Reset Password Sent!
                </div>');
                redirect('auth');
            } else {
                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                Email is not registered or actived!
                </div>');
                redirect('auth/forgotPassword');
            }            
        }        
    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->auth->getUser($email);

        if ($user) {
            $user_token = $this->auth->getUserToken($token);
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60*60*24)) {
                    $this->session->set_userdata('reset_email',$email);
                    $this->changePassword();
                } else {
                    $this->db->delete('d_user_token',['email' => $email]);
    
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                    Account activation failed! Token Expired
                    </div>');
                    redirect('auth'); 
                }
            } else {
                $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                Reset password failed! Wrong token
              </div>');
                redirect('auth');  
            }            
        } else {
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                Reset Password Failed! Wrong Email!
                </div>');
                redirect('auth');    
        }        
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1','Password','trim|required|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2','Repeat Password','trim|required|min_length[3]|matches[password1]');
        if($this->form_validation->run() == false)
        {
            $data['title'] = 'Change Password';
            $this->load->view('templates/auth_header',$data);
            $this->load->view('auth/change_password');
            $this->load->view('templates/auth_footer');
        }else{
            $password = password_hash($this->input->post('password1'),PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');
            $this->db->set('password',$password);
            $this->db->where('email',$email);
            $this->db->update('d_user');

            $this->db->where('email',$email);
            $this->db->delete('user_token');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                Password has been change!
                </div>');
                redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
?>