<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('login_id') != null){
            $this->load->library('basic_lib');
            $this->load->model('user_model');
        }else{
            redirect(base_url().'login');
        }
    }

    public function add_new_user()
    {
        $data = array();
        $data['active_page'] = 'Add User';
        $data['top_header'] = $this->load->view('layouts/backend/top_header', '', true);
        $data['left_nav'] = $this->load->view('layouts/backend/left_nav', $data, true);
        $user_types = $this->user_model->get_where('id, name', "status = 1 AND id <> 1 AND id <> 2 AND name <> 'Super_admin' AND name <> 'Admin'", 'user_type');
        $data['user_types'] = $user_types->num_rows() > 0 ? $user_types->result() : null;
        $data['footer'] = $this->load->view('layouts/backend/footer', '', true);
        $data['master_body'] = $this->load->view('add_user_view', $data, true);
        $this->load->view('layouts/backend/master', $data);
    }

    public function user_add_post()
    {
    	if($this->basic_lib->check_permission('add_users')){
			if($this->form_validation->run('user_add_form') === FALSE){
				$this->session->set_flashdata('error_msg', validation_errors());
				redirect('add_new_user', 'refresh');
			}else{
				$user_name = $this->input->post('user_name');
				$password_confirmation = $this->input->post('confirm_password');
				$user_data = array();
				$user_data['user_name'] = $user_name;
				$user_data['name'] = $this->input->post('name');
				$user_data['last_name'] = $this->input->post('last_name');
				$user_data['dob'] = $this->input->post('dob') ? $this->basic_lib->convert_date_to_millisecond($this->input->post('dob')) : null;
				$user_data['gender'] = $this->input->post('gender');
				$user_data['email'] = $this->input->post('email');
				$user_data['phone_number'] = $this->input->post('phone_number');
				$user_data['address'] = $this->input->post('address');
				$user_data['is_super_user'] = 0;
				$user_data['created_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
				$user_data['created_by'] = $this->session->userdata('user_name');
				$user_data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
				$user_data['last_updated_by'] = $this->session->userdata('user_name');

				$login_data = array();
				$login_data['user_name'] = $user_name;
				$login_data['password'] = md5($password_confirmation);
				$login_data['status'] = 1;
				$login_data['created_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
				$login_data['created_by'] = $this->session->userdata('user_name');
				$login_data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
				$login_data['last_updated_by'] = $this->session->userdata('user_name');

				if(!preg_match('/\s/',$user_name)){
					$check_user_name = $this->user_model->get_where('status', "user_name = '$user_name'", 'login')->num_rows();
					if($check_user_name == 0){
						if($this->user_model->insert_user_data($user_data, $login_data)){
							$this->session->set_flashdata('success_msg', 'User added successfully.');
							redirect('manage_users', 'refresh');
						}else{
							$this->session->set_flashdata('error_msg', 'An error occurred! Please try again.');
							redirect('add_new_user', 'refresh');
						}
					}else{
						$this->session->set_flashdata('error_msg', 'User name already exists!');
						redirect('add_new_user', 'refresh');
					}
				}else{
					$this->session->set_flashdata('error_msg', 'Spaces are not allowed in user name field.');
					redirect('add_new_user', 'refresh');
				}
			}
		}else{
    		redirect('access_denied', 'refresh');
		}
    }

    public function edit_user($user_name)
    {
    	if($this->basic_lib->check_permission('edit_user')){
			$user_data = $this->user_model->get_where('id, name, last_name, dob, gender, email,
        		phone_number, address', "user_name = '$user_name'", 'admin_users');
			if($user_data->num_rows() == 1){
				$data = array();
				$data['active_page'] = 'Manage Users';
				$data['top_header'] = $this->load->view('layouts/backend/top_header', '', true);
				$data['left_nav'] = $this->load->view('layouts/backend/left_nav', $data, true);
				$user_roles = $this->user_model->get_where('user_type_id as role_id',
					"user_name = '$user_name'", 'user_roles')->result_array();
				$data['user_data'] = $user_data->row();
				$data['user_roles'] = isset($user_roles) ? $user_roles : null;
				$data['user_name'] = $user_name;
				$user_types = $this->user_model->get_where('id, name', "status = 1 AND id <> 1 AND name <> 'Admin'", 'user_type');
				$data['user_types'] = $user_types->num_rows() > 0 ? $user_types->result() : null;
				$data['footer'] = $this->load->view('layouts/backend/footer', '', true);
				$data['master_body'] = $this->load->view('edit_user_view', $data, true);
				$this->load->view('layouts/backend/master', $data);
			}else{
				redirect('error_404', 'refresh');
			}
		}else{
    		redirect('access_denied', 'refresh');
		}
    }

    public function manage_users()
    {
    	if($this->basic_lib->check_permission('view_user_list')){
			$data = array();
			$data['active_page'] = 'Manage Users';
			$data['top_header'] = $this->load->view('layouts/backend/top_header', '', true);
			$data['left_nav'] = $this->load->view('layouts/backend/left_nav', $data, true);
			$data['footer'] = $this->load->view('layouts/backend/footer', '', true);
			$data['master_body'] = $this->load->view('manage_users_view', $data, true);
			$this->load->view('layouts/backend/master', $data);
		}else{
    		redirect('access_denied', 'refresh');
		}
    }

    public function fetch_users_data()
    {
    	if($this->basic_lib->check_permission('view_user_list')){
			$get_users_data = $this->user_model->get_all_users_data();
			if($get_users_data->num_rows() > 0){
				$data = array();
				foreach ($get_users_data->result() as $row){
					$temp = array();

					$id = $row->admin_id;
					$name = $row->name;
					$last_name = $row->last_name;
					$user_name = $row->user_name;
					$gender = $row->gender;
					$dob = $row->dob ? $row->dob : "N/A";
					$email = $row->email ? $row->email : "N/A";
					$phone_number = $row->phone_number;
					$address = $row->address ? $row->address : "N/A";

					$user_status_post_url = site_url('user_status_change_post/').$user_name;
					$edit_user_info_url = site_url('edit_user_info/').$user_name;
					$delete_user_info_url = site_url('delete_user_info/').$user_name;
					$reset_user_password_url = site_url('reset_user_password/').$user_name;

					if($row->status == 1){
						$message = "User will be deactivated! Are you sure?";
						$toggle_status_btn = "<a href=\"$user_status_post_url\"><button type=\"submit\" onclick=\"return confirm('$message')\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Change Status\" class=\"btn btn-red\"><i class=\"glyphicon glyphicon-remove\"></i></button></a>";
						$status = "<div class=\"label label-success\">Active</div>";
					}else{
						$message = "User will be activated! Are you sure?";
						$toggle_status_btn = "<a href=\"$user_status_post_url\"><button type=\"submit\" onclick=\"return confirm('$message')\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Change Status\" class=\"btn btn-green\"><i class=\"entypo-check\"></i></button></a>";
						$status = "<div class=\"label label-danger\">Inactive</div>";
					}
					$edit_btn = "<a href=\"$edit_user_info_url\"><button type=\"button\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\" class=\"btn btn-green\"><i class=\"glyphicon glyphicon-edit\"></i></button></a>";
					$reset_password_btn = "<a href=\"$reset_user_password_url\"><button type=\"submit\" onclick=\"return confirm('This will reset user password! Are you sure?')\" data-toggle=\"tooltip\" data-toggle=\"top\" title=\"Reset Password\" class=\"btn btn-primary\"><i class=\"glyphicon glyphicon-lock\"></i></button></a>";
					$delete_btn = "<a href=\"$delete_user_info_url\"><button type=\"submit\" onclick=\"return confirm('User info will be deleted! Are you sure?')\" data-toggle=\"tooltip\" data-toggle=\"top\" title=\"Delete\" class=\"btn btn-danger\"><i class=\"glyphicon glyphicon-trash\"></i></button></a>";
					$action = "";
					if($this->basic_lib->check_permission('edit_user')){
						$action .= "$edit_btn ";
					}
					if($this->basic_lib->check_permission('change_user_status')){
						$action .= "$toggle_status_btn ";
					}
					if($this->basic_lib->check_permission('reset_user_password')){
						$action .= "$reset_password_btn ";
					}
					if($this->basic_lib->check_permission('delete_user')){
						$action .= "$delete_btn ";
					}
					array_push($temp, $user_name);
					array_push($temp, $name);
					array_push($temp, $last_name);
					array_push($temp, $gender);
					array_push($temp, $dob);
					array_push($temp, $phone_number);
					array_push($temp, $email);
					array_push($temp, $address);
					array_push($temp, $status);
					array_push($temp, $action);
					array_push($data, $temp);
				}
				echo json_encode(array('data'=>$data));
			}else{
				echo '{
                    "sEcho": 1,
                    "iTotalRecords": "0",
                    "iTotalDisplayRecords": "0",
                    "aaData": []
                }';
			}
		}else{
			echo '{
                    "sEcho": 1,
                    "iTotalRecords": "0",
                    "iTotalDisplayRecords": "0",
                    "aaData": []
                }';
		}
    }

    public function check_user_name()
    {
        $user_name = $this->input->post('user_name');
        $check_name = $this->user_model->get_where('status', "user_name = '$user_name'", 'login')->num_rows();
        if($check_name == 0){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function user_status_change_post($user_name)
    {
    	if($this->basic_lib->check_permission('change_user_status')){
			$get_status = $this->user_model->get_where('status', "user_name='$user_name'", 'login');
			if($get_status->num_rows() == 1){
				$data = array();
				if($get_status->row()->status == 1){
					$data['status'] = 0;
					$user_data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
					$user_data['last_updated_by'] = $this->session->userdata('user_name');
					if($this->user_model->update_function('user_name', $user_name, 'login', $data) > 0){
						$this->session->set_flashdata('success_msg', 'User deactivated successfully.');
					}else{
						$this->session->set_flashdata('error_msg', 'User deactivation is not successful!');
					}
				}else{
					$data['status'] = 1;
					$user_data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
					$user_data['last_updated_by'] = $this->session->userdata('user_name');
					if($this->user_model->update_function('user_name', $user_name, 'login', $data) > 0){
						$this->session->set_flashdata('success_msg', 'User activated successfully.');
					}else{
						$this->session->set_flashdata('error_msg', 'User activation is not successful!');
					}
				}
			}else{
				$this->session->set_flashdata('error_msg', 'User not found!');
			}
			redirect('manage_users', 'refresh');
		}else{
    		redirect('access_denied', 'refresh');
		}
    }

    public function user_info_delete_post($user_name)
    {
		if($this->basic_lib->check_permission('delete_user')){
			$check_user_info = $this->user_model->get_where('status', "user_name='$user_name'", 'login')->num_rows();
			if($check_user_info > 0){
				if($this->user_model->delete_user_info($user_name)){
					$this->session->set_flashdata('success_msg', 'User info deleted successfully.');
				}else{
					$this->session->set_flashdata('error_msg', 'An error occurred!');
				}
				redirect('manage_users', 'refresh');
			}else{
				redirect('error_404', 'refresh');
			}
		}else{
			redirect('access_denied', 'refresh');
		}
    }

    public function reset_user_password($user_name)
    {
		if($this->basic_lib->check_permission('reset_user_password')){
			$check_user_info = $this->user_model->get_where('status', "user_name='$user_name'", 'login');
			if($check_user_info->num_rows() > 0){
				$login_data = array();
				$login_data['password'] = md5('welcome');
				$login_data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
				$login_data['last_updated_by'] = $this->session->userdata('user_name');
				if($this->user_model->update_function('user_name', $user_name, 'login', $login_data) > 0){
					$this->session->set_flashdata('success_msg', 'User password updated successfully.');
				}else{
					$this->session->set_flashdata('error_msg', 'An error occurred! Please try again.');
				}

			}else{
				redirect('error_404', 'refresh');
			}
			redirect('manage_users', 'refresh');
		}else{
			redirect('access_denied', 'refresh');
		}
    }

    public function user_edit_post()
    {
		if($this->basic_lib->check_permission('edit_user')){
			$user_name = $this->input->post('user_name');
			$user_id = $this->input->post('user_id');
			if($this->form_validation->run('user_edit_form') === FALSE){
				$this->session->set_flashdata('error_msg', validation_errors());
				redirect('edit_user_info/'.$user_name, 'refresh');
			}else{
				$user_type = $this->input->post('user_type');
				$data = array();
				$data['name'] = $this->input->post('name');
				$data['last_name'] = $this->input->post('last_name');
				$data['dob'] = $this->input->post('dob') ? $this->basic_lib->convert_date_to_millisecond($this->input->post('dob')) : "";
				$data['phone_number'] = $this->input->post('phone_number');
				$data['email'] = $this->input->post('email') ? $this->input->post('email') : "";
				$data['address'] = $this->input->post('address') ? $this->input->post('address') : "";
				$data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
				$data['last_updated_by'] = $this->session->userdata('user_name');

				$old_role_data = array();
				$old_role_data['status'] = 0;
				$old_role_data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
				$old_role_data['last_updated_by'] = $this->session->userdata('user_name');

				$this->user_model->update_function('id', $user_id, 'admin_users', $data);
				if($user_type){
					$this->user_model->update_user_role($user_name, $user_type, $old_role_data, $data);
				}else{
					$this->user_model->update_function('user_name', $user_name, 'user_roles', $old_role_data);
				}
				$this->session->set_flashdata('success_msg', 'User updated successfully.');
				redirect('manage_users', 'refresh');
			}
		}else{
			redirect('access_denied', 'refresh');
		}
    }
}
