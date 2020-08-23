<?php
require APPPATH . 'controllers/api/v1/BaseController.php';
class KPS extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KPS001_model');
    }

    public function index_get()
    {
        $get_data = $this->KPS001_model->show($this->nisn)->result_object();
        if($get_data){
            $this->res([
                'status' => true,
                'data' => [
                    'kps' => $get_data,
                    'student' => $this->KPS001_model->showStudent($this->nisn)
                ]
            ],'OK');
        }else{
            $this->res([
                'status' => true,
                'data' => $get_data
            ],'OK');
        }
        
    }
}
