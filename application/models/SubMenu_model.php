<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubMenu_model extends CI_Model
{
    public function index()
    {
        $query = "SELECT sub.id, sub.param_menu_id, sub.descr, sub.url, sub.icon, sub.is_active, param_menu.descr as menu, param_menu.id as idmenu
                    FROM param_submenu sub JOIN param_menu 
                    ON sub.param_menu_id = param_menu.id order by sub.descr asc";
        return $this->db->query($query)->result_array();
    }

    public function create($data)
    {   
        $this->db->insert('param_submenu',$data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function update($data, $id){
        $this->db->where('id',$id);
        $get_id = $this->db->update('param_submenu',$data);
        return $get_id;
    }

    public function destroy($id)
    {
        $this->db->where('id', $id);
        $get_id = $this->db->delete('param_submenu');
        return $get_id;
    }
}