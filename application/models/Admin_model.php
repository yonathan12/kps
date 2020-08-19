<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model 
{

    public function addUser()
    {
        $data = [
            'nama' => htmlspecialchars($this->input->post('name',true)),
            'email' => htmlspecialchars($this->input->post('email',true)),
            'image' => 'default.jpg',
            'password' => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
            'role_id' => $this->input->post('role_id'),
            'is_active' => 1,
            'date_created' => time(),
            'user_id_created' => $this->input->post('user_id')
        ];

        $this->db->insert('d_user',$data);
    }

    public function editUser()
    {
        $data = [
            'nama' => htmlspecialchars($this->input->post('name',true)),
            'email' => htmlspecialchars($this->input->post('email',true)),
            'role_id' => $this->input->post('role_id'),
            'is_active' => 1,
            'date_update' => time(),
            'user_id_update' => $this->input->post('user_id')
        ];

        $this->db->where('Id',htmlspecialchars($this->input->post('id')));
        $this->db->update('d_user',$data);
    }

    public function hapusUser($id, $user_id)
    {
        $data = array
        (
            'date_update' => time(),
            'is_active' => 0,
            'user_id_update' => $user_id
        );

        $this->db->where('Id',$id);
        $this->db->update('d_user',$data);
    }

    public function simpanRole()
    {
        $role = $this->input->post('role');
        $data = [
            'role' => $role,
            'date_created' => date('Y-m-d'),
            'user_id_created' => $this->session->userdata('id')
        ];
        $this->db->insert('d_user_role',$data);
        redirect('admin/role');
    }
    
    public function deleteRole($id)
    {
        $this->db->where('Id',$id);
        $this->db->delete('d_user_role');
        redirect('admin/role');
    }
}