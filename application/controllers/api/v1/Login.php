<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/RESTController.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/JWT.php';
require APPPATH . 'libraries/ExpiredException.php';
require APPPATH . 'libraries/SignatureInvalidException.php';
use \Firebase\JWT\JWT;
use chriskacerguis\RestServer\RestController;

class Login extends RestController {

    private $secretkey = 'apaanpasswordnya?';
    function __construct()
    {
        parent::__construct();
        $this->date_reg = new DateTime();
        
    }

    public function index_post()
    {
        $nisn = strtolower($this->post('nisn'));
        $password = $this->post('password');

        $user = $this->db->get_where('param_user_student',['nisn' => $nisn])->row_array();
        if($user){
            if(password_verify($password,$user['password'])){
                $payload['nisn'] = $nisn;
                $payload['id'] = $user['id'];
                $payload['iat'] = $this->date_reg->getTimestamp(); 
                $payload['exp'] = strtotime('+1 day', $this->date_reg->getTimestamp());; 
                $this->response([
                    'status' => TRUE,
                    'message' => 'Login Sukses',
                    'data' => [
                        'token' => JWT::encode($payload,$this->secretkey)
                    ]
                ], RESTController::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Login Gagal, Masukan NISN & Password yang terdaftar'
                ], RESTController::HTTP_UNAUTHORIZED);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Login Gagal, Masukan NISN & Password yang terdaftar'
            ], RESTController::HTTP_UNAUTHORIZED);
        }
    }
}