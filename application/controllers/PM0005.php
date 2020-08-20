<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');

class PM0005 extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PM0005_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['user'] = $this->username;
        $data['kps'] = $this->PM0005_model->index();
        $data['title'] = 'Parameter Semester';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('PM0005/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('descr', 'Semester', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('PM0005');
        } else {
            $descr = $this->input->post('descr');
            $created_by = $this->uid;
            $created_at = $this->datenow;
            $data = array(
                'descr' => $descr,
                'created_by' => $created_by,
                'created_at' => $created_at
            );
            $insert = $this->PM0005_model->create($data);
            if ($insert) {
                $this->session->set_flashdata('message', 'Semester Berhasil Ditambahkan');
                redirect('PM0005');
            } else {
                $this->session->set_flashdata('message1', 'Semester Gagal Ditambahkan');
                redirect('PM0005');
            }
        }
    }

    public function show($id)
    {
        header('Content-Type: application/json');
        $this->db->select('id,descr');
        $getData = $this->db->get_where('param_semester', ['id' => $id])->row_array();
        if (($getData)) {
            $data = ['data' => ['status' => true, 'data' => $getData]];
        } else {
            $data = ['data' => ['status' => false, 'message' => 'Data Tidak Ditemukan']];
        }

        echo json_encode($data);
    }

    public function update()
    {
        $this->form_validation->set_rules('descr', 'Semester', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('PM0005');
        } else {
            $data = [
                'descr' => $this->input->post('descr'),
                'updated_by' => $this->input->post('user_id'),
                'updated_at' => $this->datenow
            ];
            $get_id = $this->PM0005_model->update($data, $this->input->post('id'));
            if ($get_id) {
                $this->session->set_flashdata('message', 'Semester Berhasil Diubah');
                redirect('PM0005');
            } else {
                $this->session->set_flashdata('message', 'Semester Gagal Diubah');
                redirect('PM0005');
            }
        }
    }

    public function destroy($id)
    {
        $delete = $this->PM0005_model->destroy($id);
        if ($delete) {
            $this->session->set_flashdata('message', 'Semester Berhasil Dihapus');
            redirect('PM0005');
        } else {
            $this->session->set_flashdata('message', 'Semester Gagal Dihapus');
            redirect('PM0005');
        }
    }
}
