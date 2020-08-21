<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PM0004_model extends CI_Model
{

    public function index()
    {
        $this->db->order_by('descr ASC');
        return $this->db->get('param_access')->result_array();
    }

    public function create($data)
    {   
        $condition = $data;
        unset($condition['created_by']);
        unset($condition['created_at']);
        $result = $this->db->get_where('param_access',$condition);
        if ($result->num_rows() < 1) {
            $this->db->insert('param_access',$data);
            $insert_id = $this->db->insert_id();
        }else{
            $insert_id = $this->db->delete('param_access',$condition);
        }
        return  $insert_id;
    }

    public function destroy($id)
    {
        $this->db->where('param_role_id', $id);
        $get_id = $this->db->delete('param_access');
        return $get_id;
    }
}