<?php
require('BaseController.php');
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends BaseController 
{
    public function index()
    {
        $data['user'] = $this->db->get_where('d_user',['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Dashboard';
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('dashboard/index',$data);
        $this->load->view('templates/footer');
    }
}