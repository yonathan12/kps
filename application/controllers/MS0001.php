<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'/third_party/spout/src/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class MS0001 extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PM0001_model');
        $this->load->model('PM0005_model');
        $this->load->model('PM0006_model');
        $this->load->model('MS0001_model');
    }
    public function index()
    {
        $data['user'] = $this->username;
        $data['class'] = $this->PM0001_model->index();
        $data['semester'] = $this->PM0005_model->index();
        $data['scholl_year'] = $this->PM0006_model->index();
        $data['student'] = $this->MS0001_model->index();
        $data['title'] = 'Master Data Siswa';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('MS0001/index', $data);
        $this->load->view('templates/footer');
    }

    public function subclass($id)
    {
        header('Content-Type: application/json');
        $this->db->select('id,descr');
        $getData = $this->db->get_where('param_subclass', ['param_class_id' => $id])->result();
        if (($getData)) {
            $data = ['data' => ['status' => true, 'data' => $getData]];
        } else {
            $data = ['data' => ['status' => false, 'message' => 'Data Tidak Ditemukan']];
        }

        echo json_encode($data);
    }

    public function create()
    {
        $this->form_validation->set_rules('nisn', 'NISN', 'required');
        $this->form_validation->set_rules('fullnm', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('brthdt', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('class', 'Kelas', 'required');
        $this->form_validation->set_rules('subclass', 'Sub Kelas', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required');
        $this->form_validation->set_rules('scholl_year', 'Tahun Ajaran', 'required');

        $nisn = $this->input->post('nisn');
        $fullnm = $this->input->post('fullnm');
        $brthdt = $this->input->post('brthdt');
        $kelas = $this->input->post('class');
        $subclass = $this->input->post('subclass');
        $semester = $this->input->post('semester');
        $scholl_year = $this->input->post('scholl_year');
        $user_id = $this->uid;
        $tgl = $this->datenow;

        $data = [
            'nisn' => $nisn,
            'fullnm' => ucwords($fullnm),
            'brthdt' => $brthdt,
            'param_class_id' => $kelas,
            'param_subclass_id' => $subclass,
            'param_semester_id' => $semester,
            'param_scholl_year_id' => $scholl_year,
            'created_by' => $user_id,
            'created_at' => $tgl
        ];

        $password = explode("-", $brthdt);
        $user_login = [
            'nisn' => $nisn,
            'password' => password_hash($password[2] . $password[1] . $password[0], PASSWORD_DEFAULT),
            'created_by' => $user_id,
            'created_at' => $tgl
        ];

        if ($this->form_validation->run() == FALSE) {
            die(print_r($data,1));
            redirect('MS0001');
        } else {
            $check_nisn = $this->db->get_where('mast_student', ['nisn' => $nisn])->num_rows();
            if ($check_nisn === 0) {
                $insert = $this->MS0001_model->create($data, $user_login);
                if ($insert) {
                    $this->session->set_flashdata('message', 'Siswa Berhasil Ditambahkan');
                    redirect('MS0001');
                } else {
                    $this->session->set_flashdata('error', 'Siswa Gagal Ditambahkan');
                    redirect('MS0001');
                }
            } else {
                $this->session->set_flashdata('error', 'NISN Sudah Terdaftar');
                redirect('MS0001');
            }
        }
    }

    public function show($id)
    {
        header('Content-Type: application/json');
        $this->db->select('id,nisn,fullnm,brthdt,param_class_id, param_subclass_id, param_semester_id, param_scholl_year_id');
        $getData = $this->db->get_where('mast_student', ['id' => $id])->row_array();
        if (($getData)) {
            $data = ['data' => ['status' => true, 'data' => $getData]];
        } else {
            $data = ['data' => ['status' => false, 'message' => 'Data Tidak Ditemukan']];
        }

        echo json_encode($data);
    }

    public function update()
    {
        $this->form_validation->set_rules('nisn', 'NISN', 'required');
        $this->form_validation->set_rules('fullnm', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('brthdt', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('class', 'Kelas', 'required');
        $this->form_validation->set_rules('subclass', 'Sub Kelas', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required');
        $this->form_validation->set_rules('scholl_year', 'Tahun Ajaran', 'required');

        $nisn = $this->input->post('nisn');
        $fullnm = $this->input->post('fullnm');
        $brthdt = $this->input->post('brthdt');
        $kelas = $this->input->post('class');
        $subclass = $this->input->post('subclass');
        $semester = $this->input->post('semester');
        $scholl_year = $this->input->post('scholl_year');
        $user_id = $this->uid;
        $tgl = $this->datenow;

        $data = [
            'nisn' => $nisn,
            'fullnm' => ucwords($fullnm),
            'brthdt' => $brthdt,
            'param_class_id' => $kelas,
            'param_subclass_id' => $subclass,
            'param_semester_id' => $semester,
            'param_scholl_year_id' => $scholl_year,
            'updated_by' => $user_id,
            'updated_at' => $tgl
        ];

        if ($this->form_validation->run() == FALSE) {
            redirect('MS0001');
        } else {
            $get_id = $this->MS0001_model->update($data, $this->input->post('id'));
            if ($get_id) {
                $this->session->set_flashdata('message', 'Data Siswa Berhasil Diubah');
                redirect('MS0001');
            } else {
                $this->session->set_flashdata('error', 'Data Siswa Gagal Diubah');
                redirect('MS0001');
            }
        }
    }

    public function destroy($id)
    {
        $delete = $this->MS0001_model->destroy($id);
        if ($delete) {
            $this->session->set_flashdata('message', 'Data Siswa Berhasil Dihapus');
            redirect('MS0001');
        } else {
            $this->session->set_flashdata('error', 'Data Siswa Gagal Dihapus');
            redirect('MS0001');
        }
    }

    public function template()
    {
        $data = [];
        $class = $this->db->query("select id, descr, 'kelas' as keterangan from param_class")->result_array();
        $data = array_merge($data,$class);
        $subclass = $this->db->query("select id, descr, 'subkelas' as keterangan from param_subclass")->result_array();
        $data = array_merge($data, $subclass);

        $semester = $this->db->query("select id, descr, 'semester' as keterangan from param_semester")->result_array();
        $data = array_merge($data, $semester);

        $scholl_year = $this->db->query("select id, descr, 'thn_ajaran' as keterangan from param_scholl_year")->result_array();
        $data = array_merge($data, $scholl_year);
        
        $writer = WriterEntityFactory::createXLSXWriter();

        $writer->openToBrowser("Export Data Dosis.xlsx");
        $header = WriterEntityFactory::createRowFromArray([
            'Sumber Data Siswa'
        ]);
        $sub_header = WriterEntityFactory::createRowFromArray(array(
            "Deskripsi",
            "ID",
            "Keterangan"
        ));

        $header_template = WriterEntityFactory::createRowFromArray([
            'Contoh Data Siswa'
        ]);
        $sub_header_template = WriterEntityFactory::createRowFromArray(array(
            "NISN",
            "Nama Lengkap",
            "Tanggal Lahir",
            "Kelas",
            "Sub Kelas",
            "Semester",
            "Tahun Ajaran"
        ));

        $value_template = WriterEntityFactory::createRowFromArray(array(
            "0123123",
            "Joni",
            "1995-12-31",
            "2",
            "2",
            "1",
            "2"
        ));

        $sumberData = $writer->getCurrentSheet();
        $sumberData->setName('Sumber Data');
        $writer->addRow($header);
        $writer->addRow($sub_header);
        foreach ($data as $key => $value) { 
            $row = WriterEntityFactory::createRowFromArray([
                $value['descr'],
                $value['id'],
                $value['keterangan'],
            ]);
            $writer->addRow($row);
        }

        $templateSheet = $writer->addNewSheetAndMakeItCurrent();
        $templateSheet->setName('Data');
        $writer->addRow($header_template);
        $writer->addRow($sub_header_template);
        $writer->addRow($value_template);

        $writer->setCurrentSheet($sumberData);

        $writer->close();
    }
}
