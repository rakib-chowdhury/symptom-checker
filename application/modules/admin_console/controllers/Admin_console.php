<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_console extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('login_id') != null){
            $this->load->library('basic_lib');
            $this->load->model('admin_console_model');
        }else{
            redirect(base_url().'login');
        }
    }

    public function manage_user_permissions()
    {
    	if($_SESSION['is_super_user'] == SUPER_ADMIN){
			$data = array();
			$data['active_page'] = 'User Permissions';
			$data['top_header'] = $this->load->view('layouts/backend/top_header', '', true);
			$data['left_nav'] = $this->load->view('layouts/backend/left_nav', $data, true);
			$data['footer'] = $this->load->view('layouts/backend/footer', '', true);
			$data['master_body'] = $this->load->view('manage_permissions', $data, true);
			$this->load->view('layouts/backend/master', $data);
		}else{
			redirect('access_denied', 'refresh');
		}
    }

    public function get_permissions_data()
    {
        if($_SESSION['is_super_user'] == SUPER_ADMIN){
			$get_permissions_data = $this->admin_console_model->get_data('id as permission_id, name as permission_name, status, created_on', 'permissions')->result();
			$data = array();
			if($get_permissions_data){
				foreach ($get_permissions_data as $row){
					$temp = array();
					$id = $row->permission_id;
					$name = $row->permission_name;
					$created_on = $this->basic_lib->format_date_for_view_pages($this->basic_lib->millisecond_to_date($row->created_on));
					if($row->status == 1){
						$status_message = "Permission will be deactivated! Are you sure?";
						$status = "<div class=\"label label-success\">Active</div>";
					}else{
						$status_message = "Permission will be activated! Are you sure?";
						$status = "<div class=\"label label-danger\">Inactive</div>";
					}
					$edit_url = site_url('edit_permission/').$id;
					$delete_url = site_url('delete_permission/').$id;
					$status_url = site_url('change_permission_status/').$id;
					if($row->status == 1){
						$button = "<div class=\"btn-group\">
								<button type=\"button\" class=\"btn btn-red dropdown-toggle\" data-toggle=\"dropdown\">
									Action <span class=\"caret\"></span>
								</button>
								<ul class=\"dropdown-menu dropdown-red\" role=\"menu\">
									<li><a href='javascript:void(0)' onclick='set_edit_modal(\"$id\", \"$name\")'>Edit</a>
									</li>
									<li><a href=\"$status_url\" onclick=\"return confirm('$status_message')\">Deactivate</a>
									</li>
									<li class=\"divider\"></li>
									<li><a href=\"$delete_url\" onclick=\"return confirm('Permission will be deleted! Are you sure?')\">Delete</a>
									</li>
								</ul>
							</div>";
					}else{
						$button = "<div class=\"btn-group\">
								<button type=\"button\" class=\"btn btn-blue dropdown-toggle\" data-toggle=\"dropdown\">
									Action <span class=\"caret\"></span>
								</button>
								<ul class=\"dropdown-menu dropdown-blue\" role=\"menu\">
									<li><a href=\"$edit_url\">Edit</a>
									</li>
									<li><a href=\"$status_url\" onclick=\"return confirm('$status_message')\">Activate</a>
									</li>
									<li class=\"divider\"></li>
									<li><a href=\"$delete_url\" onclick=\"return confirm('Permission will be deleted! Are you sure?')\">Delete</a>
									</li>
								</ul>
							</div>";
					}

					array_push($temp, $name);
					array_push($temp, $created_on);
                    array_push($temp, $status);
					array_push($temp, $button);
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

    public function permission_add_post()
    {
        if($_SESSION['is_super_user'] == SUPER_ADMIN){
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            if($this->form_validation->run() === FALSE){
                $this->session->set_flashdata('error_msg', validation_errors());
            }else{
                $data = array();
                $data['name'] = $this->input->post('name');
                $data['status'] = 1;
                $data['created_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
                $check_name = $this->admin_console_model->get_where('id', "name='$data[name]'", 'permissions')->num_rows();
                if($check_name == 0){
                    if($this->admin_console_model->insert_ret('permissions', $data) > 0){
                        $this->session->set_flashdata('success_msg', 'Permission added successfully.');
                    }else{
                        $this->session->set_flashdata('success_msg', 'An error occurred!');
                    }

                }else{
                    $this->session->set_flashdata('error_msg', 'This permission already exists!');
                }
            }
            redirect('manage_user_permissions', 'refresh');
        }else{
            redirect('access_denied', 'refresh');
        }
    }

    public function change_permission_status($permission_id)
    {
        if($this->session->userdata('is_super_user') == SUPER_ADMIN){
            $get_status = $this->admin_console_model->get_where('status', "id='$permission_id'", 'permissions')->row();
            if($get_status){
                $data = array();
                if($get_status->status == 1){
                    $data['status'] = 0;
                    if($this->admin_console_model->update_function('id', $permission_id, 'permissions', $data) > 0){
                        $this->session->set_flashdata('success_msg', 'Permission deactivated successfully.');
                    }else{
                        $this->session->set_flashdata('error_msg', 'Permission deactivation is not successful!');
                    }
                }else{
                    $data['status'] = 1;
                    if($this->admin_console_model->update_function('id', $permission_id, 'permissions', $data) > 0){
                        $this->session->set_flashdata('success_msg', 'Permission activated successfully.');
                    }else{
                        $this->session->set_flashdata('error_msg', 'Permission activation is not successful!');
                    }
                }
            }else{
                $this->session->set_flashdata('error_msg', 'Permission not found!');
            }
            redirect('manage_user_permissions', 'refresh');
        }else{
            redirect('access_denied', 'refresh');
        }
    }

    public function permission_edit_post()
    {
        if($_SESSION['is_super_user'] == SUPER_ADMIN){
            $this->form_validation->set_rules('edit_permission_name', 'Permission Name', 'trim|required');
            if($this->form_validation->run() === FALSE){
                $this->session->set_flashdata('error_msg', validation_errors());
            }else{
                $data = array();
                $permission_id = $this->input->post('edit_permission_id');
                $data['name'] = $this->input->post('edit_permission_name');
                $check_name = $this->admin_console_model->get_where('id', "name='$data[name]' AND id != $permission_id", 'permissions')->num_rows();
                if($check_name == 0){
                    if($this->admin_console_model->update_function('id', $permission_id, 'permissions', $data) > 0){
                        $this->session->set_flashdata('success_msg', 'Permission updated successfully.');
                    }else{
                        $this->session->set_flashdata('error_msg', 'An error occurred!');
                    }
                }else{
                    $this->session->set_flashdata('error_msg', 'This permission already exists!');
                }
            }
            redirect('manage_user_permissions', 'refresh');
        }else{
            redirect('access_denied', 'refresh');
        }
    }

    public function permission_delete_post($permission_id)
    {
        if($this->session->userdata('is_super_user') == SUPER_ADMIN){
            $check_permission = $this->admin_console_model->get_where('*', "id='$permission_id'", 'permissions')->num_rows();
            if($check_permission > 0){
                $group_permission_data = array();
                $group_permission_data['status'] = 2;
                $this->admin_console_model->update_function('permission_id', $permission_id, 'group_permissions', $group_permission_data);
                $this->admin_console_model->delete_function('permissions', 'id', $permission_id);
                $this->session->set_flashdata('success_msg', 'Permission deleted successfully.');
            }else{
                $this->session->set_flashdata('error_msg', 'Permission not found!');
            }
            redirect('manage_user_permissions', 'refresh');
        }else{
            redirect('access_denied', 'refresh');
        }
    }

    public function check_permission_name()
    {
        $permission_name = $this->input->post('permission_name');
        $check_permission = $this->admin_console_model->get_where('*', "name = '$permission_name'", 'permissions')->num_rows();
        if($check_permission == 0){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function check_permission_availability()
    {
        $permission_id = $this->input->post('permission_id');
        $permission_name = $this->input->post('permission_name');
        $check_permission = $this->admin_console_model->get_where('*', "name = '$permission_name' AND id != '$permission_id'", 'permissions')->num_rows();
        if($check_permission == 0){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function manage_user_types()
    {
        if($_SESSION['is_super_user'] == SUPER_ADMIN || in_array(ADMIN, $_SESSION['user_roles'])){
			$data = array();
			$data['active_page'] = 'Manage User Groups';
			$data['top_header'] = $this->load->view('layouts/backend/top_header', '', true);
			$data['left_nav'] = $this->load->view('layouts/backend/left_nav', $data, true);
			$data['footer'] = $this->load->view('layouts/backend/footer', '', true);
			$data['master_body'] = $this->load->view('manage_user_groups', $data, true);
			$this->load->view('layouts/backend/master', $data);
		} else{
        	redirect('access_denied', 'refresh');
		}
    }

    public function get_user_type_data()
    {
		if($_SESSION['is_super_user'] == SUPER_ADMIN || in_array(ADMIN, $_SESSION['user_roles'])){
			$get_user_type_data = $this->admin_console_model->get_where('id, name as user_type_name, status, created_on',"name != 'Super_admin' AND name != 'Admin'", 'user_type')->result();
			$data = array();
			if($get_user_type_data){
				foreach ($get_user_type_data as $row){
					$temp = array();
					$id = $row->id;
					$name = $row->user_type_name;
					$created_on = $this->basic_lib->format_date_for_view_pages($this->basic_lib->millisecond_to_date($row->created_on));
					if($row->status == 1){
						$status_message = "User group will be deactivated! Are you sure?";
						$status = "<div class=\"label label-success\">Active</div>";
					}else{
						$status_message = "User group will be activated! Are you sure?";
						$status = "<div class=\"label label-danger\">Inactive</div>";
					}
					$edit_url = site_url('edit_user_group/').$id;
					$delete_url = site_url('delete_user_type/').$id;
					$status_url = site_url('change_user_type_status/').$id;
					$config_url = site_url('config_user_type/').$id;
					if($row->status == 1){
						$button = "<div class=\"btn-group\">
								<button type=\"button\" class=\"btn btn-red dropdown-toggle\" data-toggle=\"dropdown\">
									Action <span class=\"caret\"></span>
								</button>
								<ul class=\"dropdown-menu dropdown-red\" role=\"menu\">
									<li><a href='javascript:void(0)' onclick='set_edit_modal(\"$id\", \"$name\")'>Edit</a>
									</li>
									<li><a href=\"$status_url\" onclick=\"return confirm('$status_message')\">Deactivate</a>
									</li>
									<li><a href=\"$config_url\">Config</a>
									</li>
									<li class=\"divider\"></li>
									<li><a href=\"$delete_url\" onclick=\"return confirm('User group will be deleted! Are you sure?')\">Delete</a>
									</li>
								</ul>
							</div>";
					}else{
						$button = "<div class=\"btn-group\">
								<button type=\"button\" class=\"btn btn-blue dropdown-toggle\" data-toggle=\"dropdown\">
									Action <span class=\"caret\"></span>
								</button>
								<ul class=\"dropdown-menu dropdown-blue\" role=\"menu\">
									<li><a href=\"$edit_url\">Edit</a>
									</li>
									<li><a href=\"$status_url\" onclick=\"return confirm('$status_message')\">Activate</a>
									</li>
									<li><a href=\"$config_url\">Config</a>
									</li>
									<li class=\"divider\"></li>
									<li><a href=\"$delete_url\" onclick=\"return confirm('User group will be deleted! Are you sure?')\">Delete</a>
									</li>
								</ul>
							</div>";
					}

					array_push($temp, $name);
					array_push($temp, $created_on);
					array_push($temp, $status);
					array_push($temp, $button);
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

    public function check_user_type_name()
    {
        $user_type_name = $this->input->post('user_type_name');
        $check_user_type_name = $this->admin_console_model->get_where('*', "name = '$user_type_name'", 'user_type')->num_rows();
        if($check_user_type_name == 0){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function user_group_add_post()
    {
        if($_SESSION['is_super_user'] == SUPER_ADMIN || in_array(ADMIN, $_SESSION['user_roles'])){
            $this->form_validation->set_rules('user_type_name', 'User group Name', 'trim|required');
            if($this->form_validation->run() === FALSE){
                $this->session->set_flashdata('error_msg', validation_errors());
            }else{
                $data = array();
                $data['name'] = $this->input->post('user_type_name');
                $data['status'] = 1;
                $data['created_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
                $check_name = $this->admin_console_model->get_where('id', "name='$data[name]'", 'user_type')->num_rows();
                if($check_name == 0){
                    if($this->admin_console_model->insert_ret('user_type', $data) > 0){
                        $this->session->set_flashdata('success_msg', 'User type added successfully.');
                    }else{
                        $this->session->set_flashdata('success_msg', 'An error occurred!');
                    }
                }else{
                    $this->session->set_flashdata('error_msg', 'This user type already exists!');
                }
            }
            redirect('manage_user_types', 'refresh');
        }else{
            redirect('access_denied');
        }
    }

    public function check_user_type_availability()
    {
        $user_type_id = $this->input->post('user_type_id');
        $user_type_name = $this->input->post('user_type_name');
        $check_admin_user_type = $this->admin_console_model->get_where('*', "name = '$user_type_name' AND id != '$user_type_id'", 'user_type')->num_rows();
        if($check_admin_user_type == 0){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function user_type_edit_post()
    {
        if($_SESSION['is_super_user'] == SUPER_ADMIN || in_array(ADMIN, $_SESSION['user_roles'])){
            $this->form_validation->set_rules('edit_user_type_name', 'User Type Name', 'trim|required');
            if($this->form_validation->run() === FALSE){
                $this->session->set_flashdata('error_msg', validation_errors());
            }else{
                $data = array();
                $user_type_id = $this->input->post('edit_user_type_id');
                $data['name'] = $this->input->post('edit_user_type_name');
                $data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
                $data['last_updated_by'] = $this->session->userdata('user_name');
                $check_name = $this->admin_console_model->get_where('id', "name='$data[name]' AND id != $user_type_id", 'user_type')->num_rows();
                if($check_name == 0){
                    if($this->admin_console_model->update_function('id', $user_type_id, 'user_type', $data) > 0){
                        $this->session->set_flashdata('success_msg', 'User type updated successfully.');
                    }else{
                        $this->session->set_flashdata('error_msg', 'An error occurred!');
                    }
                }else{
                    $this->session->set_flashdata('error_msg', 'User type already exists!');
                }
            }
            redirect('manage_user_types', 'refresh');
        }else{
            redirect('access_denied');
        }
    }

    public function change_user_type_status($user_type_id)
    {
        if($this->session->userdata('is_super_user') == SUPER_ADMIN || in_array(ADMIN, $_SESSION['user_roles'])){
            $get_status = $this->admin_console_model->get_where('status', "id='$user_type_id'", 'user_type')->row();
            if($get_status){
                $data = array();
                if($get_status->status == 1){
                    $data['status'] = 0;
                    $data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
                    $data['last_updated_by'] = $this->session->userdata('user_name');
                    if($this->admin_console_model->update_function('id', $user_type_id, 'user_type', $data) > 0){
                        $this->session->set_flashdata('success_msg', 'User type deactivated successfully.');
                    }else{
                        $this->session->set_flashdata('error_msg', 'User type deactivation is not successful!');
                    }
                }else{
                    $data['status'] = 1;
                    $data['last_updated_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
                    $data['last_updated_by'] = $this->session->userdata('user_name');
                    if($this->admin_console_model->update_function('id', $user_type_id, 'user_type', $data) > 0){
                        $this->session->set_flashdata('success_msg', 'User type activated successfully.');
                    }else{
                        $this->session->set_flashdata('error_msg', 'User type activation is not successful!');
                    }
                }
            }else{
                $this->session->set_flashdata('error_msg', 'User type not found!');
            }
            redirect('manage_user_types', 'refresh');
        }else{
            redirect('access_denied', 'refresh');
        }
    }

    public function delete_user_type($user_type_id)
    {
        if($this->session->userdata('is_super_user') == SUPER_ADMIN){
            $check_permission = $this->admin_console_model->get_where('*', "id='$user_type_id'", 'user_type')->num_rows();
            if($check_permission > 0){
                $this->admin_console_model->delete_function('user_type', 'id', $user_type_id);
                $this->session->set_flashdata('success_msg', 'User type deleted successfully.');
            }else{
                $this->session->set_flashdata('error_msg', 'User type not found!');
            }
            redirect('manage_user_types', 'refresh');
        }else{
            redirect('access_denied', 'refresh');
        }
    }

    public function config_user_type($user_type_id)
    {
        if($_SESSION['is_super_user'] == SUPER_ADMIN || in_array(ADMIN, $_SESSION['user_roles'])){
			$check_id = $this->admin_console_model->get_where('name', "id=$user_type_id", 'user_type')->row();
			if($check_id){
				$data = array();
				$data['active_page'] = 'Manage User Groups';
				$data['top_header'] = $this->load->view('layouts/backend/top_header', '', true);
				$data['left_nav'] = $this->load->view('layouts/backend/left_nav', $data, true);
				$data['footer'] = $this->load->view('layouts/backend/footer', '', true);
				$data['permissions'] = $this->admin_console_model->get_where('id as permission_id, name as permission_name', "status = 1", 'permissions')->result();
				$data['user_permissions'] = $this->admin_console_model->get_where('permission_id as group_permission_id', "user_type_id = '$user_type_id' AND status = 1", 'group_permissions')->result_array();
				$data['type_id'] = $user_type_id;
				$data['master_body'] = $this->load->view('group_config', $data, true);
				$this->load->view('layouts/backend/master', $data);
			}else{
				redirect('error_404', 'refresh');
			}
		}else{
			redirect('access_denied', 'refresh');
		}
    }

    public function group_permission_add_post()
    {
		if($_SESSION['is_super_user'] == SUPER_ADMIN || in_array(ADMIN, $_SESSION['user_roles'])){
			$user_type_id = $this->input->post('user_type_id');
			$check_type = $this->admin_console_model->get_where('name', "id='$user_type_id'", 'user_type')->num_rows();
			if($check_type == 1){
				if($this->input->post('permission_id')){
					if($this->admin_console_model->insert_group_permission($user_type_id, $this->input->post('permission_id'))){
						$this->session->set_flashdata('success_msg', 'Permissions Added Successfully');
						redirect('manage_user_types', 'refresh');
					}else{
						$this->session->set_flashdata('error_msg', 'An error occurred!');
						redirect('config_user_group', 'refresh');
					}
				}else{
					$permission_data = array();
					$permission_data['status'] = 0;
					if($this->admin_console_model->update_function('user_type_id', $user_type_id, 'group_permissions', $permission_data) > 0){
						$this->session->set_flashdata('success_msg', 'Permissions Updated Successfully');
						redirect('manage_user_types', 'refresh');
					}else{
						$this->session->set_flashdata('error_msg', 'An error occurred!');
						redirect('manage_user_types', 'refresh');
					}
				}
			}else{
				redirect('access_denied', 'refresh');
			}
		}else{
			redirect('access_denied', 'refresh');
		}
    }
}
