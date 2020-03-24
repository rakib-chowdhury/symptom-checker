<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends Basic_model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_user_data($user_data, $login_data)
    {
        $this->db->trans_start();
        $this->insert_ret('admin_users', $user_data);
        $this->insert_ret('login', $login_data);
        $user_type = $this->input->post('user_type');
        if($user_type){
            foreach ($user_type as $type){
                $role_data = array();
                $role_data['user_name'] = $login_data['user_name'];
                $role_data['user_type_id'] = $type;
                $role_data['status'] = 1;
                $role_data['created_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
                $role_data['created_by'] = $this->session->userdata('user_name');
                $role_data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
                $role_data['last_updated_by'] = $this->session->userdata('user_name');
                $this->insert_ret('user_roles', $role_data);
            }
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_all_users_data()
    {
        $this->db->select("a.id as admin_id, a.name, a.last_name, 
        FROM_UNIXTIME(a.dob/1000, '%d %M, %Y')  as dob, a.email, 
        a.phone_number, a.address, l.last_login, l.id as login_id, l.status, l.user_name,
        (case when a.gender = 1 then 'Male' else 'Female' end) as gender");
        $this->db->from('admin_users a');
        $this->db->join('login l', 'l.user_name = a.user_name');
        $this->db->join('user_roles ur', 'ur.user_name = a.user_name', 'left');
        $this->db->where("ur.user_type_id <> 1 AND ur.user_type_id <> 2");
        $this->db->group_by("a.user_name");
        return $this->db->get();
    }

    public function delete_user_info($user_name)
    {
        $this->db->trans_start();
        $this->delete_function('admin_users', 'user_name', $user_name);
        $this->delete_function('login', 'user_name', $user_name);
        $this->delete_function('user_roles', 'user_name', $user_name);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_user_role($user_name, $user_type, $old_role_data)
    {
        $this->db->trans_start();
        $this->update_function('user_name', $user_name, 'user_roles', $old_role_data);
        foreach ($user_type as $type){
            $role_data = array();
            $role_data['user_name'] = $user_name;
            $role_data['user_type_id'] = $type;
            $role_data['status'] = 1;
            $role_data['created_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
            $role_data['created_by'] = $this->session->userdata('user_name');
            $role_data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
            $role_data['last_updated_by'] = $this->session->userdata('user_name');
            $this->insert_ret('user_roles', $role_data);
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_user_wise_permissions($user_name)
	{
		$this->db->select('ur.user_name, gp.permission_id');
		$this->db->from('user_roles ur');
		$this->db->join('group_permissions gp', 'gp.user_type_id = ur.user_type_id AND gp.status = 1');
		$this->db->where('ur.user_name', $user_name);
		$this->db->group_by('gp.permission_id');
		return $this->db->get();
	}
}


?>
