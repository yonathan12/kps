<?php
require('BaseController.php');
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends BaseController 
{
    public function index()
    {
        $data['user'] = $this->username;
        
        $data['menu'] = $this->db->get('param_menu')->result_array();

        $this->form_validation->set_rules('menu','Menu','required');

        if ($this->form_validation->run()== FALSE) {
            $data['title'] = 'Menu Management';
            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('menu/index',$data);
            $this->load->view('templates/footer');
        } else {
            $menu = $this->input->post('menu');
            $user_id = $this->input->post('user_id');
            $tgl = date('Y-m-d H:i:s');
            $data = array(
                'descr' => $menu,
                'created_by' => $user_id,
                'created_at' => $tgl
            );
            $this->db->insert('param_menu',$data);
            $this->session->set_flashdata('message','Menu Berhasil Ditambahkan');
            redirect('menu');   
        }             
    }

    public function deleteMenu($Id)
    {
        $this->db->where('id',$Id);
        $this->db->delete('param_menu');
        $this->session->set_flashdata('message','Menghapus Menu');
        redirect('menu');   
    }

    public function editMenu(){
        $this->Menu_model->editMenu();
        $this->session->set_flashdata('message','Mengubah Menu');
        redirect('menu');
    }

    public function submenu()
    {
        // $data['user'] = $this->db->get_where('d_user',['email' => $this->session->userdata('email')])->row_array();
        
        $this->load->model('Menu_model');
        $data['menu'] = $this->db->get('param_menu')->result_array();
        $data['subMenu'] = $this->Menu_model->getSubMenu();

        $this->form_validation->set_rules('descr','Title','required');
        $this->form_validation->set_rules('url','URL','required');

        if ($this->form_validation->run()== FALSE) {
            $data['title'] = 'SubMenu Management';
            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('menu/submenu',$data);
            $this->load->view('templates/footer');
        } else {
            $this->Menu_model->addSubmenu();
            $this->session->set_flashdata('message','Menambahkan Sub Menu');
            redirect('menu/submenu');  
        }       
            
    }

    public function editSubmenu()
    {
        $data['user'] = $this->db->get_where('d_user',['email' => $this->session->userdata('email')])->row_array();
        
        $this->load->model('Menu_model');
        $data['menu'] = $this->db->get('d_user_menu')->result_array();
        $data['subMenu'] = $this->Menu_model->getSubMenu();

        $this->form_validation->set_rules('title','Title','required');
        $this->form_validation->set_rules('menu_id','Menu','required');
        $this->form_validation->set_rules('url','URL','required');
        
        if ($this->form_validation->run()== FALSE) {
            $data['title'] = 'SubMenu Management';
            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('menu/submenu',$data);
            $this->load->view('templates/footer');
        } else {
            $this->Menu_model->editSub();
            $this->session->set_flashdata('message','Mengubah Sub Menu');
            redirect('menu/submenu');  
        }       
    }

    public function deleteSubmenu($Id)
    {
        $this->db->where('Id',$Id);
        $this->db->delete('d_user_sub_menu');
        $this->session->set_flashdata('message','Menghapus Sub Menu');
        redirect('menu/submenu');  
    }
}