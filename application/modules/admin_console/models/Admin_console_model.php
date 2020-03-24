<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_console_model extends Basic_model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_group_permission($user_type_id, $permission_array)
    {
        $this->db->trans_start();
        $check_old_permissions = $this->get_where('id', "user_type_id='$user_type_id'", 'group_permissions')->result();
        if($check_old_permissions){
            $permission_data = array();
            $permission_data['status'] = 0;
            $this->update_function('user_type_id',$user_type_id, 'group_permissions',  $permission_data);
        }
        foreach ($permission_array as $row){
            $data = array();
            $data['user_type_id'] = $user_type_id;
            $data['permission_id'] = $row;
            $data['status'] = 1;
            $data['created_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
            $this->insert_ret('group_permissions', $data);
        }
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
}


?>