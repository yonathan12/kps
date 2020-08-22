<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MS0002_model extends CI_Model
{
    public function index($param_class_id, $param_subclass_id, $param_semester_id, $param_scholl_year_id)
    {
        $query = "                
        SELECT tmp.*, COUNT(tmp.id) AS total FROM (
            SELECT mast.id, mast.nisn, mast.fullnm, kps.id AS kps_id
        FROM mast_student AS mast
        LEFT JOIN mast_kps kps ON mast.id = kps.mast_student_id
        WHERE mast.param_class_id = $param_class_id AND mast.param_subclass_id = $param_subclass_id AND mast.param_semester_id = $param_semester_id
        AND mast.param_scholl_year_id = $param_scholl_year_id
        UNION
        SELECT mast.id, mast.nisn, mast.fullnm, kps.id AS kps_id
        FROM hist_mast_student AS hist
        JOIN mast_student AS mast ON mast.id = hist.mast_student_id
        LEFT JOIN mast_kps kps ON mast.id = kps.mast_student_id
        WHERE hist.param_class_id = $param_class_id AND hist.param_subclass_id = $param_subclass_id AND hist.param_semester_id = $param_semester_id
        AND hist.param_scholl_year_id = $param_scholl_year_id
            ) AS tmp GROUP BY tmp.nisn
        ";
        return $this->db->query($query)->result_array();
    }
}