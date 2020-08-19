<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    public function editMenu(){
        $data = [
            'menu' => $this->input->post('menu'),
            'user_id_updated' => $this->input->post('user_id'),
            'date_updated' => date('Y-m-d')
        ];
        $this->db->where('Id',$this->input->post('id'));
        $this->db->update('d_user_menu',$data);
    }

    public function getSubMenu()
    {
        $query = "  SELECT d_user_sub_menu.*, d_user_menu.menu 
                    FROM d_user_sub_menu JOIN d_user_menu 
                    ON d_user_sub_menu.menu_id = d_user_menu.Id";
        return $this->db->query($query)->result_array();
    }

    public function addSubmenu()
    {
        $title = $this->input->post('title');
        $menu_id = $this->input->post('menu_id');
        $url = $this->input->post('url');
        $icon = $this->input->post('icon');
        $active = $this->input->post('is_active');
        $user_id = $this->input->post('user_id');
        $tgl = date('Y-m-d');

        $data = [
            'menu_id' => $menu_id,
            'title' => $title,
            'url' => $url,
            'icon' => $icon,
            'is_active' => $active,
            'user_id_created' => $user_id,
            'date_created' => $tgl
        ];
        $this->db->insert('d_user_sub_menu',$data);
    }

    public function editSub()
    {
        $id = $this->input->post('Id');
        $title = $this->input->post('title');
        $menu_id = $this->input->post('menu_id');
        $url = $this->input->post('url');
        $icon = $this->input->post('icon');
        $active = $this->input->post('is_active');
        $user_id = $this->input->post('user_id');
        $tgl = date('Y-m-d');

        $data = [
            'menu_id' => $menu_id,
            'title' => $title,
            'url' => $url,
            'icon' => $icon,
            'is_active' => $active,
            'user_id_updated' => $user_id,
            'date_update' => $tgl
        ];
        $this->db->where('Id',$id);
        $this->db->update('d_user_sub_menu',$data);
    }
}