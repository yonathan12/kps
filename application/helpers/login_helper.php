<?php 
function is_logged_in()
{
    $lib = get_instance(); //memanggil library CI
    if (!$lib->session->userdata('username')) {
        redirect('auth');
    } else {
        $role_id = $lib->session->userdata('role_id');
        $menu = $lib->uri->segment(1);

        $queryMenu = $lib->db->get_where('param_menu',['descr' => $menu])->row_array();
        $menuId = $queryMenu['id'];

        $querySubMenu = $lib->db->get_where('param_submenu',['param_menu_id' => $menuId])->row_array();
        $subMenuId = $querySubMenu['id'];

        $userAccess = $lib->db->query("
            SELECT a.id, a.param_role_id, a.param_menu_id, b.descr, c.descr
            FROM param_access a
            LEFT JOIN param_menu b
            ON a.param_menu_id = b.id 
            JOIN param_submenu c
            ON b.id = c.param_menu_id
            WHERE a.param_role_id = $role_id
        ");
        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}

function check_access($role_id,$menu_id)
{
    $lib = get_instance();

    $lib->db->where('param_role_id',$role_id);
    $lib->db->where('param_menu_id',$menu_id);
    $result = $lib->db->get('param_access');
    
    if ($result->num_rows()>0) {
        return "checked='checked'";
    }
}
?>