<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/RESTController.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/JWT.php';
require APPPATH . 'libraries/ExpiredException.php';
require APPPATH . 'libraries/SignatureInvalidException.php';

use \Firebase\JWT\JWT;
use chriskacerguis\RestServer\RestController;

class BaseController extends RESTController
{
    private $secretkey = 'apaanpasswordnya?';
    private $decode;
    public $nisn, $uid;
    public function __construct()
    {
        parent::__construct();
        $jwt = $this->input->get_request_header('Authorization');
        try {
            $this->decode = JWT::decode($jwt, $this->secretkey, array('HS256'));
            $checkUser = $this->db->get_where('param_user_student', ['nisn' => $this->decode->nisn]);
            if ($checkUser->num_rows() > 0) {
                $this->nisn = $this->decode->nisn;
                $this->uid = $this->decode->id;
                return true;
            }
        } catch (Exception $e) {
            $this->response([
                'status' => FALSE,
                'message' => 'Wrong Token'
            ], RESTController::HTTP_UNAUTHORIZED);
        }
    }

    public function res($response, $status)
    {
        switch ($status) {
            case 'OK':
                return $this->response($response, RESTController::HTTP_OK);
                break;
            
            default:
            return $this->response($response, RESTController::HTTP_NOT_FOUND);
                break;
        }
    }
}
