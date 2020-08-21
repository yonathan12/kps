<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PM0009_model extends CI_Model
{

    public function index()
    {
        return $this->db->get('param_user_student')->result_array();
    }

    public function show($nisn)
    {
        return $this->db->get_where('mast_student',['nisn' => $nisn])->num_rows();
    }

    public function checknisn($nisn)
    {
        return $this->db->get_where('param_user_student',['nisn' => $nisn])->num_rows();
    }

    public function create($data)
    {   
        $this->db->insert('param_user_student',$data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data, $id){
        $this->db->where('id',$id);
        $get_id = $this->db->update('param_user_student',$data);
        return $get_id;
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);
        $get_id = $this->db->delete('param_user_student');
        return $get_id;
    }
}