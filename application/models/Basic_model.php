<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Basic_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function insert_ret($table_name, $table_data)
    {
        $this->db->insert($table_name, $table_data);
        return $this->db->insert_id();
    }

    public function get_where($selector, $condition, $table_name)
    {
        $this->db->select($selector);
        $this->db->from($table_name);
        $this->db->where($condition);
        $result = $this->db->get();
        return $result;
    }

    public function get_data($selector, $table_name)
    {
        $this->db->select($selector);
        return $this->db->get($table_name);
    }

    public function update_function($column_name, $column_value, $table_name, $data)
    {
        $this->db->where($column_name, $column_value);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    public function delete_function($table_name, $column_name, $column_val)
    {
        $this->db->where($column_name, $column_val);
        $this->db->delete($table_name);
        return $this->db->affected_rows();
    }

    public function count_data($table_name)
    {
        return $this->db->count_all($table_name);
    }
    public function count_data_with_condition($condition, $table_name)
    {
        $this->db->where($condition);
        return $this->db->count_all($table_name);
    }
}


?>