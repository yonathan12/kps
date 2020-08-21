<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MS0001_model extends CI_Model
{
    public function index()
    {
        $query = "SELECT mast.id, mast.nisn, mast.fullnm, CONCAT(class.descr,' - ',subclass.descr) AS kelas, 
        CONCAT(semester.descr,' - ',sch_year.descr) AS tahun_ajaran
        FROM mast_student mast
        JOIN param_class AS class ON class.id = mast.param_class_id
        JOIN param_subclass AS subclass ON subclass.id = mast.param_subclass_id
        JOIN param_semester AS semester ON semester.id = mast.param_semester_id
        JOIN param_scholl_year AS sch_year ON sch_year.id = mast.param_scholl_year_id";
        return $this->db->query($query)->result_array();
    }

    public function create($data, $user_login)
    {
        $this->db->insert('mast_student', $data);
        $insert_id = $this->db->insert_id();

        $this->db->insert('param_user_student', $user_login);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data, $id)
    {
        $this->db->where('id', $id);
        $get_id = $this->db->update('mast_student', $data);
        return $get_id;
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);
        $get_id = $this->db->delete('mast_student');
        return $get_id;
    }
}
