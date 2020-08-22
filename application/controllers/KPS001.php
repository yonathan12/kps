<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');

class KPS001 extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KPS001_model');
        $this->load->model('PM0007_model');
    }

    public function index()
    {
        $data['user'] = $this->username;
        $data['title'] = 'Kartu Pelanggaran Siswa';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('KPS001/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('kps_id', 'Jenis Pelanggaran', 'required');
        $this->form_validation->set_rules('id', 'Student ID', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('KPS001');
        } else {
            $kps_id = $this->input->post('kps_id');
            $student_id = $this->input->post('id');
            $created_by = $this->uid;
            $created_at = $this->datenow;
            $data = array(
                'param_kps_id' => $kps_id,
                'mast_student_id' => $student_id,
                'created_by' => $created_by,
                'created_at' => $created_at
            );
            $insert = $this->KPS001_model->create($data);
            if ($insert) {
                $this->session->set_flashdata('message', 'Pelanggaran Berhasil Ditambahkan');
                redirect('KPS001');
            } else {
                $this->session->set_flashdata('error', 'Pelanggaran Gagal Ditambahkan');
                redirect('KPS001');
            }
        }
    }

    public function show()
    {
        $this->form_validation->set_rules('nisn', 'NISN', 'required');
        $nisn = $this->input->post('nisn');
        if ($this->form_validation->run() == FALSE) {
            redirect('KPS001');
        } else {
            $check_nisn = $this->db->get_where('mast_student', ['nisn' => $nisn])->num_rows();
            if ($check_nisn === 0) {
                $this->session->set_flashdata('error', 'Siswa Tidak Terdaftar');
                redirect('KPS001');
            } else {
                $data['user'] = $this->username;
                $data['title'] = 'Kartu Pelanggaran Siswa';
                $data['datakps'] = $this->KPS001_model->show($nisn);
                $data['total_pelanggaran'] = count($this->KPS001_model->show($nisn));
                $data['student'] = $this->KPS001_model->showStudent($nisn);
                $data['kps'] = $this->PM0007_model->index();
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('KPS001/show', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function update()
    {
        $this->form_validation->set_rules('descr', 'Kelas', 'required');
        $this->form_validation->set_rules('code', 'Kode', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('KPS001');
        } else {
            $data = [
                'code' => $this->input->post('code'),
                'descr' => $this->input->post('descr'),
                'updated_by' => $this->input->post('user_id'),
                'updated_at' => $this->datenow
            ];
            $get_id = $this->KPS001_model->update($data, $this->input->post('id'));
            if ($get_id) {
                $this->session->set_flashdata('message', 'Kelas Berhasil Diubah');
                redirect('KPS001');
            } else {
                $this->session->set_flashdata('error', 'Kelas Gagal Diubah');
                redirect('KPS001');
            }
        }
    }

    public function destroy($id)
    {
        $delete = $this->KPS001_model->destroy($id);
        if ($delete) {
            $this->session->set_flashdata('message', 'Kelas Berhasil Dihapus');
            redirect('KPS001');
        } else {
            $this->session->set_flashdata('error', 'Kelas Gagal Dihapus');
            redirect('KPS001');
        }
    }
}
