<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');

class PM0004 extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PM0003_model');
        $this->load->model('PM0004_model');
    }

    public function index()
    {
        $data['user'] = $this->username;
        $data['role'] = $this->PM0003_model->index();
        $data['title'] = 'Parameter Akses';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pm0004/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('PM0004');
        } else {
            $menu = $this->input->post('menu_id');
            $role = $this->input->post('role_id');
            $created_by = $this->uid;
            $created_at = $this->datenow;
            $data = array(
                'param_role_id' => $role,
                'param_menu_id' => $menu,
                'created_by' => $created_by,
                'created_at' => $created_at
            );
            $insert = $this->PM0004_model->create($data);
            if ($insert) {
                $this->session->set_flashdata('message', 'Role Berhasil Ditambahkan');
                redirect('PM0004');
            } else {
                $this->session->set_flashdata('error', 'Role Gagal Ditambahkan');
                redirect('PM0004');
            }
        }
    }

    public function show($id)
    {
        $data['user'] = $this->username;
        $data['title'] = 'Hak Akses Menu';
        $data['role'] = $this->db->get_where('param_role',['id' => $id])->row_array();
        $this->db->order_by('descr', 'ASC');
        $data['menu'] = $this->db->get('param_menu')->result_array();

        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('pm0004/show',$data);
        $this->load->view('templates/footer');
    }

    public function destroy($id)
    {
        $delete = $this->PM0004_model->destroy($id);
        if ($delete) {
            $this->session->set_flashdata('message', 'Role Berhasil Dihapus');
            redirect('PM0004');
        } else {
            $this->session->set_flashdata('error', 'Role Gagal Dihapus');
            redirect('PM0004');
        }
    }
}
