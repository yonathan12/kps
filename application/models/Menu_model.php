<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    public function index()
    {
        $this->db->order_by('descr ASC');
        return $this->db->get('param_menu')->result_array();
    }

    public function create($data)
    {   
        $this->db->insert('param_menu',$data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data, $id){
        $this->db->where('id',$id);
        $get_id = $this->db->update('param_menu',$data);
        return $get_id;
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);
        $get_id = $this->db->delete('param_menu');
        return $get_id;
    }
}