<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');

class PM0009 extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PM0009_model');
    }

    public function index()
    {
        $data['user'] = $this->username;
        $data['user_data'] = $this->PM0009_model->index();
        $data['title'] = 'Parameter User Student';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('PM0009/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('nisn', 'NISN', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('PM0009');
        } else {
            $nisn = $this->input->post('nisn');
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $created_by = $this->uid;
            $created_at = $this->datenow;
            $data = array(
                'nisn' => $nisn,
                'password' => $password,
                'created_by' => $created_by,
                'created_at' => $created_at
            );
            $check_nisn = $this->PM0009_model->show($nisn);
            if ($check_nisn > 0) {
                $checknisn = $this->PM0009_model->checknisn($nisn);
                if ($checknisn < 1) {
                    $insert = $this->PM0009_model->create($data);
                    if ($insert) {
                        $this->session->set_flashdata('message', 'User Berhasil Ditambahkan');
                        redirect('PM0009');
                    } else {
                        $this->session->set_flashdata('error', 'User Gagal Ditambahkan');
                        redirect('PM0009');
                    }
                } else {
                    $this->session->set_flashdata('error', 'NISN Sudah Terdaftar');
                    redirect('PM0009');
                }
            } else {
                $this->session->set_flashdata('error', 'NISN Tidak Terdaftar');
                redirect('PM0009');
            }
        }
    }

    public function show($id)
    {
        header('Content-Type: application/json');
        $this->db->select('id,nisn');
        $getData = $this->db->get_where('param_user_student', ['id' => $id])->row_array();
        if (($getData)) {
            $data = ['data' => ['status' => true, 'data' => $getData]];
        } else {
            $data = ['data' => ['status' => false, 'message' => 'Data Tidak Ditemukan']];
        }

        echo json_encode($data);
    }

    public function update()
    {
        $this->form_validation->set_rules('password', 'Password', 'required');

        $password = $this->input->post('password');
        if ($this->form_validation->run() == FALSE) {
            redirect('PM0009');
        } else {
            $data = [
                'updated_by' => $this->input->post('user_id'),
                'updated_at' => $this->datenow
            ];

            if ($password) {
                $data = array_merge($data, ['password' => password_hash($password, PASSWORD_DEFAULT)]);
            }
            $get_id = $this->PM0009_model->update($data, $this->input->post('id'));
            if ($get_id) {
                $this->session->set_flashdata('message', 'Password User Berhasil Diubah');
                redirect('PM0009');
            } else {
                $this->session->set_flashdata('error', 'Password User Gagal Diubah');
                redirect('PM0009');
            }
        }
    }

    public function destroy($id)
    {
        $delete = $this->PM0009_model->destroy($id);
        if ($delete) {
            $this->session->set_flashdata('message', 'User Berhasil Dihapus');
            redirect('PM0009');
        } else {
            $this->session->set_flashdata('error', 'User Gagal Dihapus');
            redirect('PM0009');
        }
    }
}
