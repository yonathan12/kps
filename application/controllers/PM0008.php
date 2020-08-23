<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');

class PM0008 extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PM0003_model');
        $this->load->model('PM0008_model');
    }

    public function index()
    {
        $data['user'] = $this->username;
        $data['role'] = $this->PM0003_model->index();
        $data['user_data'] = $this->PM0008_model->index();
        $data['title'] = 'Parameter User';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pm0008/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('fullnm', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('PM0008');
        } else {
            $fullnm = $this->input->post('fullnm');
            $username = $this->input->post('username');
            $password = password_hash($this->input->post('password'),PASSWORD_DEFAULT);
            $role = $this->input->post('role');
            $created_by = $this->uid;
            $created_at = $this->datenow;
            $data = array(
                'fullnm' => $fullnm,
                'username' => $username,
                'password' => $password,
                'param_role_id' => $role,
                'is_active' => 1,
                'created_by' => $created_by,
                'created_at' => $created_at
            );
            $insert = $this->PM0008_model->create($data);
            if ($insert) {
                $this->session->set_flashdata('message', 'User Berhasil Ditambahkan');
                redirect('PM0008');
            } else {
                $this->session->set_flashdata('error', 'User Gagal Ditambahkan');
                redirect('PM0008');
            }
        }
    }

    public function show($id)
    {
        header('Content-Type: application/json');
        $this->db->select('id,fullnm, username, param_role_id');
        $getData = $this->db->get_where('param_user', ['id' => $id])->row_array();
        if (($getData)) {
            $data = ['data' => ['status' => true, 'data' => $getData]];
        } else {
            $data = ['data' => ['status' => false, 'message' => 'Data Tidak Ditemukan']];
        }

        echo json_encode($data);
    }

    public function update()
    {
        $this->form_validation->set_rules('fullnm', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');

        $password = $this->input->post('password');
        if ($this->form_validation->run() == FALSE) {
            redirect('PM0008');
        } else {
            $data = [
                'fullnm' => $this->input->post('fullnm'),
                'username' => $this->input->post('username'),
                'param_role_id' => $this->input->post('role'),
                'updated_by' => $this->input->post('user_id'),
                'updated_at' => $this->datenow
            ];

            if($password){
                $data = array_merge($data, ['password' => password_hash($password,PASSWORD_DEFAULT)]);
            }
            $get_id = $this->PM0008_model->update($data, $this->input->post('id'));
            if ($get_id) {
                $this->session->set_flashdata('message', 'User Berhasil Diubah');
                redirect('PM0008');
            } else {
                $this->session->set_flashdata('error', 'User Gagal Diubah');
                redirect('PM0008');
            }
        }
    }

    public function destroy($id)
    {
        $delete = $this->PM0008_model->destroy($id);
        if ($delete) {
            $this->session->set_flashdata('message', 'User Berhasil Dihapus');
            redirect('PM0008');
        } else {
            $this->session->set_flashdata('error', 'User Gagal Dihapus');
            redirect('PM0008');
        }
    }
}
