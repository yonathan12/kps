<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');   
    }

    public function index()
    {
        $data['user'] = $this->username;
        $data['menu'] = $this->Menu_model->index();
        $data['title'] = 'Menu';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('menu','Menu','required');

        if ($this->form_validation->run()== FALSE) {
            redirect('menu');
        } else {
            $menu = $this->input->post('menu');
            $created_by = $this->uid;
            $created_at = $this->datenow;
            $data = array(
                'descr' => $menu,
                'created_by' => $created_by,
                'created_at' => $created_at
            );
            $insert = $this->Menu_model->create($data);
            if($insert){
                $this->session->set_flashdata('message','Menu Berhasil Ditambahkan');
                redirect('menu');
            }else{
                $this->session->set_flashdata('error','Menu Gagal Ditambahkan');
                redirect('menu');
            }
        }     
    }

    public function show($id)
    {
        header('Content-Type: application/json');
        $this->db->select('id,descr');
        $getData = $this->db->get_where('param_menu',['id' => $id])->row_array();
        if(($getData)){
            $data = ['data' => ['status' => true, 'data' => $getData]];
        }else{
            $data = ['data' => ['status' => false, 'message' => 'Data Tidak Ditemukan']];
        }
        
        echo json_encode($data);
    }

    public function update()
    {
        $data = [
            'descr' => $this->input->post('menu'),
            'updated_by' => $this->input->post('user_id'),
            'updated_at' => $this->datenow
        ];
        $get_id = $this->Menu_model->update($data, $this->input->post('id'));
        if($get_id){
            $this->session->set_flashdata('message', 'Menu Berhasil Diubah');
            redirect('menu');
        }else{
            $this->session->set_flashdata('error', 'Menu Gagal Diubah');
            redirect('menu');
        }
    }

    public function destroy($id)
    {
        $delete = $this->Menu_model->destroy($id);
        if($delete){
            $this->session->set_flashdata('message', 'Menu Berhasil Dihapus');
            redirect('menu');
        }else{
            $this->session->set_flashdata('error', 'Menu Gagal Dihapus');
            redirect('menu');
        }
    }
}
