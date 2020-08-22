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
        $this->db->select('param_class_id,param_subclass_id,param_semester_id,param_scholl_year_id');
        $get_old = $this->db->get_where('mast_student',['id' => $id])->result_array()[0];
        $new_data = $data;
        unset($new_data['nisn']);
        unset($new_data['fullnm']);
        unset($new_data['brthdt']);
        unset($new_data['updated_by']);
        unset($new_data['updated_at']);
        
        $check_value = 0;
        foreach ($get_old as $key => $value) {
            if($value !== $new_data[$key]){
                $check_value = 1;
            }
        }
        if($check_value > 0){
            $user_id = $this->uid;
            $tgl = $this->datenow;
            $hist_student = array_merge($get_old, [
                'mast_student_id' => $id,
                'created_by' => $user_id,
                'created_at' => $tgl
            ]);
            $this->db->insert('hist_mast_student',$hist_student);
        }
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
