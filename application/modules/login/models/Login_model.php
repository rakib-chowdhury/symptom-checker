<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login_check($user_name,$password)
    {
        $data=array(
            'l.user_name'=>$user_name,
            'l.password'=>md5($password)
        );
        $query =  $this->db->select('*, l.id as login_id')
            ->from('login l')
            ->join('admin_users a', 'a.user_name = l.user_name AND l.status = 1')
            ->where($data)
            ->get();
        return $query->row();
    }
    public function user_login_check($user_id,$password)
    {
        $data=array(
            'ul.email_id'=>$user_id,
            'ul.password'=>md5($password),
            'ul.status'=>1
        );
        $query =  $this->db->select('*')->from('tbl_user_login ul')->join('tbl_suppliers s', 'ul.email_id=s.email')->where($data)->get();
        return $query->row();
    }

    public function get_user_info($user_id)
    {
        $this->db->select('a.admin_id, a.admin_name, a.tbl_admin_user_type_tbl_admin_user_type_id, al.password, al.tbl_admin_login_id');
        $this->db->from('tbl_admin_user a');
        $this->db->join('tbl_admin_login al', 'al.tbl_admin_user_tbl_admin_user_id = a.tbl_admin_user_id AND al.status = 1');
        $this->db->where('a.admin_id', $user_id);
        return $this->db->get()->row();
    }
    public function get_password($login_id)
    {
        $this->db->select('a.tbl_admin_login_id, a.password');
        $this->db->from('tbl_admin_login a');
        $this->db->where('a.tbl_admin_login_id', $login_id);
        return $this->db->get()->row();
    }
    public function get_where($selector, $condition, $table_name)
    {
        $this->db->select($selector);
        $this->db->from($table_name);
        $this->db->where($condition);
        $result = $this->db->get();
        return $result;
    }

    public function update_function($column_name, $column_value, $table_name, $data)
    {
        $this->db->where($column_name, $column_value);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }
}


?>