<?php
require('BaseController.php');
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends BaseController 
{
    public function role()
    {
        $data['user'] = $this->db->get_where('d_user',['email' => $this->session->userdata('email')])->row_array();
        
        $data['title'] = 'Hak Akses Menu';

        $data['role'] = $this->db->get('d_user_role')->result_array();

        $this->form_validation->set_rules('role','Role','required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('admin/role',$data);
            $this->load->view('templates/footer');
        } else {
            $this->Admin_model->simpanRole();
        }
    }

    public function roleAccess($role_id)
    {
        $data['user'] = $this->db->get_where('d_user',['email' => $this->session->userdata('email')])->row_array();
        
        $data['title'] = 'Hak Akses Menu';

        $data['role'] = $this->db->get_where('d_user_role',['Id' => $role_id])->row_array();

        $this->db->order_by('menu', 'ASC');
        $this->db->where('Id !=',1);
        $data['menu'] = $this->db->get('d_user_menu')->result_array();

        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('admin/roleaccess',$data);
        $this->load->view('templates/footer');
    }

    public function deleteRoleAccess($Id)
    {
        $this->Admin_model->deleteRole($Id);
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id,
            'date_created' => date('Y-m-d'),
            'user_id_created' => $this->session->userdata('id')
        ];

        $result = $this->db->get_where('d_user_access_menu',$data);

        if ($result->num_rows() < 1) {
            $this->db->insert('d_user_access_menu',$data);
        }else{
            $this->db->delete('d_user_access_menu',$data);
        }
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
            Access Changed!
          </div>');
    }

    public function user()
    {
            $data['user'] = $this->db->get_where('d_user',['email' => $this->session->userdata('email')])->row_array();
            $data['title'] = 'All User';
            $queryUser = "SELECT * FROM d_user ORDER BY is_active DESC";

            $data['AllData'] = $this->db->query($queryUser)->result_array();
            $data['role'] = $this->db->get('d_user_role')->result_array();

            $this->form_validation->set_rules('name','Name','required|trim');
            $this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[user.email]',[
                'is_unique' => 'This email has been registered!'
            ]);
            $this->form_validation->set_rules('password','Password','required|trim|min_length[3]',
            [
            'min_length' => 'Password to short!'
            ]);
            $this->form_validation->set_rules('role_id','Level','required');

            if ($this->form_validation->run()== FALSE) {
                $this->load->view('templates/header',$data);
                $this->load->view('templates/sidebar',$data);
                $this->load->view('templates/topbar',$data);
                $this->load->view('admin/user',$data);
                $this->load->view('templates/footer');
            }else{
                $this->Admin_model->addUser();
                $this->session->set_flashdata('message','Menambahkan User Baru');
                redirect('admin/user');
            }               
    }

    public function editUser()
    {
        $this->Admin_model->editUser();
        $this->session->set_flashdata('message','Mengubah User');
        redirect('admin/user');
    }

    public function hapusUser($id)
    {
        $this->Admin_model->hapusUser($id,$this->session->userdata('id'));

        $this->session->set_flashdata('message','Menonaktifkan User');
        redirect('admin/user');
    }
}
?>