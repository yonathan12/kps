<?php
require('BaseController.php');
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends BaseController 
{
    public function index()
    {
        $data['user'] = $this->db->get_where('param_user',['username' => $this->session->userdata('username')])->row_array();
        
        $data['title'] = 'Profile';
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('user/index',$data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['user'] = $this->db->get_where('param_user',['username' => $this->session->userdata('username')])->row_array();

        $this->form_validation->set_rules('fullnm','Full Name', 'required|trim');
        
        if ($this->form_validation->run()==false) {
        $data['title'] = 'Edit Profile';
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('user/edit',$data);
        $this->load->view('templates/footer');
        } else {
            $fullnm = $this->input->post('fullnm');
            $username = $this->input->post('username');
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2048;
                $config['upload_path']          = './assets/img/profile/';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $oldImage = $data['user']['image'];
                    if ($oldImage != 'default.jpg') {
                        unlink('FCPATH'.'./assets/img/profile/'.$oldImage);
                    }
                    $newImage = $this->upload->data('file_name');
                    $this->db->set('image', $newImage);
                }else{
                    echo $this->upload->display_errors();
                }
            } 
            
            $this->db->set('fullnm', $fullnm);
            $this->db->where('username',$username);
            $this->db->update('param_user');
            $this->session->set_flashdata('message','Perbarui Data Profile');
            redirect('user');
        }
    }

    public function changepassword()
    {
        $data['user'] = $this->db->get_where('param_user',['username' => $this->session->userdata('username')])->row_array();

        $this->form_validation->set_rules('current_password','Current Password',
        'required|trim');
        $this->form_validation->set_rules('new_password1','New Password','required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2','Confirm New Password','required|trim|min_length[3]|matches[new_password1]');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Ganti Password';
            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('user/changepassword',$data);
            $this->load->view('templates/footer');    
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password,$data['user']['password'])) {
            $this->session->set_flashdata('message1','Password Salah');
            redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message1','Password Harus Berbeda dengan Password lama');
                    redirect('user/changepassword');
                } else {
                    $password = password_hash($new_password,PASSWORD_DEFAULT);
                    $this->db->set('password',$password);
                    $this->db->where('username',$this->session->userdata('username'));
                    $this->db->update('param_user');

                    $this->session->set_flashdata('message','Password Berhasil Di Perbarui');
                    redirect('user/changepassword');
                }                
            }            
        }               
    }
}

?>