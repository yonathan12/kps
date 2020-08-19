<?php
require('BaseController.php');
defined('BASEPATH') or exit('No direct script access allowed');

class Gunung extends BaseController
{
    public function index()
    {
        $data['user'] = $this->db->get_where('d_user', ['email' => $this->session->userdata('email')])->row_array();
        $data['AllData'] = $this->db->get('p_gunung')->result_array();
        $data['title'] = 'Master Data Gunung';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/gunung', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        $gunung = $this->input->post('gunung');
        $url = $this->input->post('url');
        $upload_image = $_FILES['image']['name']?uniqid().$_FILES['image']['name']:$_FILES['image']['name'];
        $date_created = date('Y-m-d');
        $user_id_created = $this->session->userdata('id');
        
        if ($upload_image) {
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 2048;
            $config['upload_path']          = './assets/img/gunung/';
            $config['file_name'] = $upload_image;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $newImage = $this->upload->data('file_name');
            } else {
                echo $this->upload->display_errors();
            }
        }
        $this->db->insert('p_gunung',array(
            'gunung' => $gunung,
            'url' => $url,
            'foto' => $upload_image,
            'date_created' => $date_created,
            'user_id_created' => $user_id_created
        ));
        $this->session->set_flashdata('message', 'Berhasil Menambahkan Data Gunung');
        redirect('gunung');
    }

    public function getDetail($id)
    {
        header('Content-Type: application/json');
        $getData = $this->db->get_where('p_gunung',['Id' => $id])->row_array();
        $data = ['data' => ['status' => true, $getData]];
        echo json_encode($data);
    }

    public function edit()
    {

        $id = $this->input->post('idEdit');
        
        $gunung = $this->input->post('gunung');
        $url = $this->input->post('url');
        $upload_image = $_FILES['image']['name']?uniqid().$_FILES['image']['name']:$_FILES['image']['name'];
        $date_update = date('Y-m-d');
        $user_id_update = $this->session->userdata('id');

        $data['old'] = $this->db->get_where('p_gunung',['Id' => $id])->row_array();

        if ($upload_image) {
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 2048;
            $config['upload_path']          = './assets/img/gunung/';
            $config['filename'] = $upload_image;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $oldImage = $data['old']['image'];
                if ($oldImage != $upload_image) {
                    unlink('FCPATH'.'./assets/img/gunung/'.$oldImage);
                }
                
                $this->db->set('foto', $upload_image);
            }else{
                echo $this->upload->display_errors();
            }
        }

        $this->db->where('Id',$id);
        $this->db->update('p_gunung',[
            'gunung' => $gunung,
            'url' => $url,
            'date_update' => $date_update,
            'user_id_update' => $user_id_update
        ]);
        $this->session->set_flashdata('message', 'Berhasil Mengubah Data Gunung');
        redirect('gunung');
    }

    public function hapus($id)
    {
        $foto = $this->db->get_where('p_gunung',['Id' => $id])->row_array()['foto'];
        if($foto){
            $cwd = getcwd();
            unlink($cwd.'/assets/img/gunung/'.$foto);
        }
        $this->db->delete('p_gunung',['Id' => $id]);
        $this->session->set_flashdata('message', 'Berhasil Menghapus Data Gunung');
        redirect('gunung');
    }
}
