<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KPS001_model extends CI_Model
{
    public function show($nisn)
    {
        $query = "
            SELECT kps.id, pkps.descr, DATE_FORMAT(mast.created_at,'%d/%m/%Y') AS tanggal
            FROM mast_kps AS kps
            JOIN mast_student mast ON mast.id = kps.mast_student_id
            JOIN param_kps pkps ON pkps.id = kps.param_kps_id
            WHERE mast.nisn = '$nisn'
        ";
        return $this->db->query($query);
    }

    public function showStudent($nisn)
    {
        $query = "
        SELECT mast.id, mast.nisn, mast.fullnm, CONCAT(class.descr,' - ',subclass.descr) AS kelas, 
        CONCAT(semester.descr,' - ',sch_year.descr) AS tahun_ajaran
        FROM mast_student mast
        JOIN param_class AS class ON class.id = mast.param_class_id
        JOIN param_subclass AS subclass ON subclass.id = mast.param_subclass_id
        JOIN param_semester AS semester ON semester.id = mast.param_semester_id
        JOIN param_scholl_year AS sch_year ON sch_year.id = mast.param_scholl_year_id
        WHERE mast.nisn = '$nisn'
        ";
        return $this->db->query($query)->result_array()[0];
    }

    public function create($data)
    {
        $this->db->insert('mast_kps',$data);
        return $this->db->insert_id();
    }

    public function update($data, $id)
    {
        return $this->db->update('mast_kps',$data,['id' => $id]);
    }

    public function destroy($id)
    {
        return $this->db->delete('mast_kps',['id' => $id]);
    }
}