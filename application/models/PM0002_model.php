<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PM0002_model extends CI_Model
{

    public function index()
    {
        $this->db->order_by('param_subclass.descr ASC');
        $this->db->select('param_subclass.id, param_subclass.descr, param_class.descr as kelas');
        $this->db->from('param_subclass');
        $this->db->join('param_class', 'param_subclass.param_class_id = param_class.id');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function create($data)
    {   
        $this->db->insert('param_subclass',$data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data, $id){
        $this->db->where('id',$id);
        $get_id = $this->db->update('param_subclass',$data);
        return $get_id;
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);
        $get_id = $this->db->delete('param_subclass');
        return $get_id;
    }
}