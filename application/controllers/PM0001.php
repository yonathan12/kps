<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');

class PM0001 extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PM0001_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['user'] = $this->username;
        $data['kelas'] = $this->PM0001_model->index();
        $data['title'] = 'Parameter Kelas';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pm0001/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('descr', 'Kelas', 'required');
        $this->form_validation->set_rules('code', 'Kode', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('PM0001');
        } else {
            $code = $this->input->post('code');
            $descr = $this->input->post('descr');
            $created_by = $this->uid;
            $created_at = $this->datenow;
            $data = array(
                'code' => $code,
                'descr' => $descr,
                'created_by' => $created_by,
                'created_at' => $created_at
            );
            $insert = $this->PM0001_model->create($data);
            if ($insert) {
                $this->session->set_flashdata('message', 'Kelas Berhasil Ditambahkan');
                redirect('PM0001');
            } else {
                $this->session->set_flashdata('message1', 'Kelas Gagal Ditambahkan');
                redirect('PM0001');
            }
        }
    }

    public function show($id)
    {
        header('Content-Type: application/json');
        $this->db->select('id,code,descr');
        $getData = $this->db->get_where('param_class', ['id' => $id])->row_array();
        if (($getData)) {
            $data = ['data' => ['status' => true, 'data' => $getData]];
        } else {
            $data = ['data' => ['status' => false, 'message' => 'Data Tidak Ditemukan']];
        }

        echo json_encode($data);
    }

    public function update()
    {
        $this->form_validation->set_rules('descr', 'Kelas', 'required');
        $this->form_validation->set_rules('code', 'Kode', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('PM0001');
        } else {
            $data = [
                'code' => $this->input->post('code'),
                'descr' => $this->input->post('descr'),
                'updated_by' => $this->input->post('user_id'),
                'updated_at' => $this->datenow
            ];
            $get_id = $this->PM0001_model->update($data, $this->input->post('id'));
            if ($get_id) {
                $this->session->set_flashdata('message', 'Kelas Berhasil Diubah');
                redirect('PM0001');
            } else {
                $this->session->set_flashdata('message', 'Kelas Gagal Diubah');
                redirect('PM0001');
            }
        }
    }

    public function destroy($id)
    {
        $delete = $this->PM0001_model->destroy($id);
        if ($delete) {
            $this->session->set_flashdata('message', 'Kelas Berhasil Dihapus');
            redirect('PM0001');
        } else {
            $this->session->set_flashdata('message', 'Kelas Gagal Dihapus');
            redirect('PM0001');
        }
    }
}
