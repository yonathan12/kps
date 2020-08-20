<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PM0003_model extends CI_Model
{

    public function index()
    {
        $this->db->order_by('descr ASC');
        return $this->db->get('param_role')->result_array();
    }

    public function create($data)
    {   
        $this->db->insert('param_role',$data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data, $id){
        $this->db->where('id',$id);
        $get_id = $this->db->update('param_role',$data);
        return $get_id;
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);
        $get_id = $this->db->delete('param_role');
        return $get_id;
    }
}