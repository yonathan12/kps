<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');

class SubMenu extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SubMenu_model');
        $this->load->model('Menu_model');
        $this->load->library('form_validation');
    }
    public function index()
    {
        $data['user'] = $this->username;
        $data['sub_menu'] = $this->SubMenu_model->index();
        $data['menu'] = $this->Menu_model->index();
        $data['title'] = 'SubMenu';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('submenu/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('descr', 'Title', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('menu_id', 'URL', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('submenu');
        } else {
            $title = $this->input->post('descr');
            $menu_id = $this->input->post('menu_id');
            $url = $this->input->post('url');
            $icon = $this->input->post('icon');
            $active = $this->input->post('is_active');
            $user_id = $this->uid;
            $tgl = $this->datenow;

            $data = [
                'param_menu_id' => $menu_id,
                'descr' => strtoupper($title),
                'url' => $url,
                'icon' => $icon,
                'is_active' => $active,
                'created_by' => $user_id,
                'created_at' => $tgl
            ];
            $insert = $this->SubMenu_model->create($data);
            if ($insert) {
                $this->session->set_flashdata('message', 'SubMenu Berhasil Ditambahkan');
                redirect('submenu');
            } else {
                $this->session->set_flashdata('message1', 'SubMenu Gagal Ditambahkan');
                redirect('submenu');
            }
        }
    }

    public function show($id)
    {
        header('Content-Type: application/json');
        $this->db->select('id,param_menu_id,descr,url,icon, is_active');
        $getData = $this->db->get_where('param_submenu', ['id' => $id])->row_array();
        if (($getData)) {
            $data = ['data' => ['status' => true, 'data' => $getData]];
        } else {
            $data = ['data' => ['status' => false, 'message' => 'Data Tidak Ditemukan']];
        }

        echo json_encode($data);
    }

    public function update()
    {
        $this->form_validation->set_rules('descr', 'Title', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('menu_id', 'URL', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('submenu');
        } else {
            $title = $this->input->post('descr');
            $menu_id = $this->input->post('menu_id');
            $url = $this->input->post('url');
            $icon = $this->input->post('icon');
            $active = $this->input->post('is_active')=="on"?"1":"0";
            $user_id = $this->uid;
            $tgl = $this->datenow;

            $data = [
                'param_menu_id' => $menu_id,
                'descr' => strtoupper($title),
                'url' => $url,
                'icon' => $icon,
                'is_active' => $active,
                'created_by' => $user_id,
                'created_at' => $tgl
            ];
            $get_id = $this->SubMenu_model->update($data, $this->input->post('id'));
            if ($get_id) {
                $this->session->set_flashdata('message', 'SubMenu Berhasil Diubah');
                redirect('submenu');
            } else {
                $this->session->set_flashdata('message', 'SubMenu Gagal Diubah');
                redirect('submenu');
            }
        }
    }

    public function destroy($id)
    {
        $delete = $this->SubMenu_model->destroy($id);
        if ($delete) {
            $this->session->set_flashdata('message', 'SubMenu Berhasil Dihapus');
            redirect('submenu');
        } else {
            $this->session->set_flashdata('message', 'SubMenu Gagal Dihapus');
            redirect('submenu');
        }
    }
}
