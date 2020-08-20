<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PM0007_model extends CI_Model
{

    public function index()
    {
        $this->db->order_by('descr ASC');
        return $this->db->get('param_kps')->result_array();
    }

    public function create($data)
    {   
        $this->db->insert('param_kps',$data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data, $id){
        $this->db->where('id',$id);
        $get_id = $this->db->update('param_kps',$data);
        return $get_id;
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);
        $get_id = $this->db->delete('param_kps');
        return $get_id;
    }
}