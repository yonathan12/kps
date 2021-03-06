<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');

class PM0006 extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PM0006_model');
    }

    public function index()
    {
        $data['user'] = $this->username;
        $data['kps'] = $this->PM0006_model->index();
        $data['title'] = 'Parameter Tahun Ajaran';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pm0006/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('descr', 'Tahun Ajaran', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('PM0006');
        } else {
            $descr = $this->input->post('descr');
            $created_by = $this->uid;
            $created_at = $this->datenow;
            $data = array(
                'descr' => $descr,
                'created_by' => $created_by,
                'created_at' => $created_at
            );
            $insert = $this->PM0006_model->create($data);
            if ($insert) {
                $this->session->set_flashdata('message', 'Tahun Ajaran Berhasil Ditambahkan');
                redirect('PM0006');
            } else {
                $this->session->set_flashdata('error', 'Tahun Ajaran Gagal Ditambahkan');
                redirect('PM0006');
            }
        }
    }

    public function show($id)
    {
        header('Content-Type: application/json');
        $this->db->select('id,descr');
        $getData = $this->db->get_where('param_scholl_year', ['id' => $id])->row_array();
        if (($getData)) {
            $data = ['data' => ['status' => true, 'data' => $getData]];
        } else {
            $data = ['data' => ['status' => false, 'message' => 'Data Tidak Ditemukan']];
        }

        echo json_encode($data);
    }

    public function update()
    {
        $this->form_validation->set_rules('descr', 'Tahun Ajaran', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('PM0006');
        } else {
            $data = [
                'descr' => $this->input->post('descr'),
                'updated_by' => $this->input->post('user_id'),
                'updated_at' => $this->datenow
            ];
            $get_id = $this->PM0006_model->update($data, $this->input->post('id'));
            if ($get_id) {
                $this->session->set_flashdata('message', 'Tahun Ajaran Berhasil Diubah');
                redirect('PM0006');
            } else {
                $this->session->set_flashdata('error', 'Tahun Ajaran Gagal Diubah');
                redirect('PM0006');
            }
        }
    }

    public function destroy($id)
    {
        $delete = $this->PM0006_model->destroy($id);
        if ($delete) {
            $this->session->set_flashdata('message', 'Tahun Ajaran Berhasil Dihapus');
            redirect('PM0006');
        } else {
            $this->session->set_flashdata('error', 'Tahun Ajaran Gagal Dihapus');
            redirect('PM0006');
        }
    }
}
