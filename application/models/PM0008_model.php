<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PM0008_model extends CI_Model
{

    public function index()
    {
        return $this->db->get('param_user')->result_array();
    }

    public function create($data)
    {   
        $this->db->insert('param_user',$data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data, $id){
        $this->db->where('id',$id);
        $get_id = $this->db->update('param_user',$data);
        return $get_id;
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);
        $get_id = $this->db->delete('param_user');
        return $get_id;
    }
}