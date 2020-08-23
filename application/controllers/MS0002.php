<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');

class MS0002 extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MS0002_model');
        $this->load->model('PM0001_model');
        $this->load->model('PM0002_model');
        $this->load->model('PM0005_model');
        $this->load->model('PM0006_model');
    }

    public function index()
    {
        $data['user'] = $this->username;
        $data['title'] = 'Data Pelanggaran Siswa';
        $data['class'] = $this->PM0001_model->index();
        $data['semester'] = $this->PM0005_model->index();
        $data['scholl_year'] = $this->PM0006_model->index();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('ms0002/index', $data);
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

    public function show()
    {
        $this->form_validation->set_rules('class', 'Kelas', 'required');
        $this->form_validation->set_rules('subclass', 'Sub Kelas', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required');
        $this->form_validation->set_rules('scholl_year', 'Tahun Ajaran', 'required');

        $param_class_id = $this->input->post('class');
        $param_subclass_id = $this->input->post('subclass');
        $param_semester_id = $this->input->post('semester');
        $param_scholl_year_id = $this->input->post('scholl_year');

        if ($this->form_validation->run() == FALSE) {
            redirect('MS0002');
        } else {
            $data['user'] = $this->username;
            $data['title'] = 'Data Pelanggaran Siswa';
            $data['class'] = $this->db->get_where('param_class',['id' => $param_class_id])->result_array()[0]['descr'];
            $data['subclass'] = $this->db->get_where('param_subclass',['id' => $param_subclass_id])->result_array()[0]['descr'];
            $data['semester'] = $this->db->get_where('param_semester',['id' => $param_semester_id])->result_array()[0]['descr'];
            $data['scholl_year'] = $this->db->get_where('param_scholl_year',['id' => $param_scholl_year_id])->result_array()[0]['descr'];
            $data['datakps'] = $this->MS0002_model->index($param_class_id, $param_subclass_id, $param_semester_id, $param_scholl_year_id);
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('ms0002/show', $data);
            $this->load->view('templates/footer');
        }
    }
}
