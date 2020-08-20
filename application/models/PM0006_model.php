<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PM0006_model extends CI_Model
{

    public function index()
    {
        $this->db->order_by('descr ASC');
        return $this->db->get('param_scholl_year')->result_array();
    }

    public function create($data)
    {   
        $this->db->insert('param_scholl_year',$data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data, $id){
        $this->db->where('id',$id);
        $get_id = $this->db->update('param_scholl_year',$data);
        return $get_id;
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);
        $get_id = $this->db->delete('param_scholl_year');
        return $get_id;
    }
}