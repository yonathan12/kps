<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller 
{
    public function __construct(){
        parent::__construct();
        is_logged_in();
        $get_uid = $this->db->get_where('param_user',['username' => $this->session->userdata('username')])->row_array();
        $this->username = $get_uid;
        $this->uid = $get_uid['id'];
        $this->datenow = date('Y-m-d H:i:s');
        $this->load->library('form_validation');
    }
}
?>