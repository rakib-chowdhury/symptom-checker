<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->library('basic_lib');
    }

    public function index()
    {
        if($this->session->userdata('login_id') != null){
            return redirect(site_url('show_dashboard'));
        }else{
            return redirect(site_url('login'));
        }
    }

    public function view_login()
    {
        if ($this->session->userdata('login_id') != null) {
            redirect('show_dashboard');
        }else{
            $this->load->view('login/login_view');
        }
    }

    public function login_check()
    {
        $resp = array();
        $login_status = 'invalid';
        $user_name= $_POST["user_name"];
        $password = $_POST["password"];
        $result = $this->login_model->login_check($user_name, $password);
        if($result){
            if($result->status == 1){
                $session_data = array('login' => true, 'user_name' => $result->user_name, 'name' => $result->name, 'login_id' => $result->login_id, 'is_super_user'=>$result->is_super_user);
                $this->session->set_userdata($session_data);
                $last_login = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
                $last_login_data = array();
                $last_login_data['last_login'] = $last_login;
                $this->login_model->update_function('user_name', $user_name, 'login', $last_login_data);
                $get_user_roles = $this->login_model->get_where('user_type_id', "user_name = '$user_name' AND status = 1", 'user_roles')->result_array();
				$this->session->set_userdata('user_roles', $get_user_roles);
                $get_permissions = $this->basic_lib->get_user_permissions($user_name);
                $this->session->set_userdata('user_permissions', $get_permissions);
                $login_status = 'success';
            }
        }
        $resp['login_status'] = $login_status;
        if($login_status == 'success')
        {
            $resp['redirect_url'] = site_url('dashboard');
        }
        echo json_encode($resp);
    }

    public function view_change_password()
    {
        $data = array();
        $data['active_page'] = 'Home';
        $data['top_header'] = $this->load->view('layouts/backend/top_header', '', true);
        $data['left_nav'] = $this->load->view('layouts/backend/left_nav', $data, true);
        $data['footer'] = $this->load->view('layouts/backend/footer', '', true);
        $data['master_body'] = $this->load->view('change_password_view', $data, true);
        $this->load->view('layouts/backend/master', $data);
    }

    public function check_old_password()
    {
        $login_id = $this->input->post('login_id');
        $password = md5($this->input->post('password'));
        $result = $this->login_model->get_where('status', "id = '$login_id' AND password = '$password' AND status = 1", 'login')->row();
        if($result){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function password_change_post()
    {
        $login_id = $this->input->post('login_id');
        $old_password = md5($this->input->post('old_password'));
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');
        $result = $this->login_model->get_where('status', "id = '$login_id' AND password = '$old_password' AND status = 1", 'login')->num_rows();
        if($result == 1){
            if($new_password == $confirm_password){
                $data['password'] = md5($confirm_password);
                $data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
                $data['last_updated_by'] = $this->session->userdata('user_name');
                if($this->basic_model->update_function('id', $login_id, 'login', $data) > 0){
                    $this->session->set_flashdata('success_msg', 'Password changed successfully.');
                    $this->user_log_out();
                }else{
                    $this->session->set_flashdata('error_msg', 'Unable to change password! Please try again.');
                    redirect('change_password', 'refresh');
                }
            }else{
                $this->session->set_flashdata('error_msg', "Passwords doesn't match!");
                redirect('change_password', 'refresh');
            }
        }else{
            $this->session->set_flashdata('error_msg', "Incorrect old password!");
            redirect('change_password', 'refresh');
        }
    }

    public function user_log_out()
    {
        $data=$data=array('login' => false, 'user_name' => '', 'login_id' => '','user_type'=>'', 'is_super_user'=>'');
        $this->session->unset_userdata($data);
        $this->session->sess_destroy();
        return redirect(site_url('login'));
    }

	public function show_error()
	{
		$data = array();
		$data['active_page'] = 'Dashboard';
		$data['top_header'] = $this->load->view('layouts/backend/top_header', '', true);
		$data['left_nav'] = $this->load->view('layouts/backend/left_nav', $data, true);
		$data['footer'] = $this->load->view('layouts/backend/footer', '', true);
		$data['master_body'] = $this->load->view('layouts/backend/error_page', $data, true);
		$this->load->view('layouts/backend/master', $data);
	}

	public function show_access_denied()
	{
		$data = array();
		$data['active_page'] = 'Dashboard';
		$data['top_header'] = $this->load->view('layouts/backend/top_header', '', true);
		$data['left_nav'] = $this->load->view('layouts/backend/left_nav', $data, true);
		$data['footer'] = $this->load->view('layouts/backend/footer', '', true);
		$data['master_body'] = $this->load->view('layouts/backend/access_denied_page', $data, true);
		$this->load->view('layouts/backend/master', $data);
	}
}
