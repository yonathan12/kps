<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');

class PM0002 extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PM0001_model');
        $this->load->model('PM0002_model');
    }

    public function index()
    {
        $data['user'] = $this->username;
        $data['kelas'] = $this->PM0001_model->index();
        $data['subkelas'] = $this->PM0002_model->index();
        $data['title'] = 'Parameter Sub Kelas';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pm0002/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('descr', 'Sub Kelas', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('PM0002');
        } else {
            $kelas = $this->input->post('kelas');
            $descr = $this->input->post('descr');
            $created_by = $this->uid;
            $created_at = $this->datenow;
            $data = array(
                'param_class_id' => $kelas,
                'descr' => $descr,
                'created_by' => $created_by,
                'created_at' => $created_at
            );
            $insert = $this->PM0002_model->create($data);
            if ($insert) {
                $this->session->set_flashdata('message', 'Sub Kelas Berhasil Ditambahkan');
                redirect('PM0002');
            } else {
                $this->session->set_flashdata('error', 'Sub Kelas Gagal Ditambahkan');
                redirect('PM0002');
            }
        }
    }

    public function show($id)
    {
        header('Content-Type: application/json');
        $this->db->select('id,param_class_id,descr');
        $getData = $this->db->get_where('param_subclass', ['id' => $id])->row_array();
        if (($getData)) {
            $data = ['data' => ['status' => true, 'data' => $getData]];
        } else {
            $data = ['data' => ['status' => false, 'message' => 'Data Tidak Ditemukan']];
        }

        echo json_encode($data);
    }

    public function update()
    {
        $this->form_validation->set_rules('descr', 'Sub Kelas', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('PM0002');
        } else {
            $data = [
                'param_class_id' => $this->input->post('kelas'),
                'descr' => $this->input->post('descr'),
                'updated_by' => $this->input->post('user_id'),
                'updated_at' => $this->datenow
            ];
            $get_id = $this->PM0002_model->update($data, $this->input->post('id'));
            if ($get_id) {
                $this->session->set_flashdata('message', 'Sub Kelas Berhasil Diubah');
                redirect('PM0002');
            } else {
                $this->session->set_flashdata('error', 'Sub Kelas Gagal Diubah');
                redirect('PM0002');
            }
        }
    }

    public function destroy($id)
    {
        $delete = $this->PM0002_model->destroy($id);
        if ($delete) {
            $this->session->set_flashdata('message', 'Sub Kelas Berhasil Dihapus');
            redirect('PM0002');
        } else {
            $this->session->set_flashdata('error', 'Sub Kelas Gagal Dihapus');
            redirect('PM0002');
        }
    }
}
