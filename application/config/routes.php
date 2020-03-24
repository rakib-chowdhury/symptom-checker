<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//$route['error_404'] = 'login/Login/show_error';
//$route['access_denied'] = 'login/Login/show_access_denied';
//
//$route['show_dashboard'] = 'dashboard/Dashboard/show_dashboard';
//$route['login'] = 'login/Login/view_login';
//$route['login_check'] = 'login/Login/login_check';
//$route['log_out'] = 'login/Login/user_log_out';
//$route['change_password'] = 'login/Login/view_change_password';
//$route['check_old_password'] = 'login/Login/check_old_password';
//$route['password_change_post'] = 'login/Login/password_change_post';
//
//$route['manage_user_types'] = 'admin_console/Admin_console/manage_user_types';
//$route['get_user_type_data'] = 'admin_console/Admin_console/get_user_type_data';
//$route['check_user_type_name'] = 'admin_console/Admin_console/check_user_type_name';
//$route['user_group_add_post'] = 'admin_console/Admin_console/user_group_add_post';
//$route['check_user_type_availability'] = 'admin_console/Admin_console/check_user_type_availability';
//$route['user_type_edit_post'] = 'admin_console/Admin_console/user_type_edit_post';
//$route['change_user_type_status/(:any)'] = 'admin_console/Admin_console/change_user_type_status/$1';
//$route['config_user_type/(:any)'] = 'admin_console/Admin_console/config_user_type/$1';
//$route['delete_user_type/(:any)'] = 'admin_console/Admin_console/delete_user_type/$1';
//$route['group_permission_add_post'] = 'admin_console/Admin_console/group_permission_add_post';
//
//$route['manage_user_permissions'] = 'admin_console/Admin_console/manage_user_permissions';
//$route['get_permissions_data'] = 'admin_console/Admin_console/get_permissions_data';
//$route['check_permission_name'] = 'admin_console/Admin_console/check_permission_name';
//$route['check_permission_availability'] = 'admin_console/Admin_console/check_permission_availability';
//$route['permission_add_post'] = 'admin_console/Admin_console/permission_add_post';
//$route['permission_edit_post'] = 'admin_console/Admin_console/permission_edit_post';
//$route['change_permission_status/(:any)'] = 'admin_console/Admin_console/change_permission_status/$1';
//$route['delete_permission/(:any)'] = 'admin_console/Admin_console/permission_delete_post/$1';
//
//$route['add_new_user'] = 'users/User/add_new_user';
//$route['user_add_post'] = 'users/User/user_add_post';
//$route['get_users_data'] = 'users/User/fetch_users_data';
//$route['manage_users'] = 'users/User/manage_users';
//$route['check_user_name'] = 'users/User/check_user_name';
//$route['user_status_change_post/(:any)'] = 'users/User/user_status_change_post/$1';
//$route['delete_user_info/(:any)'] = 'users/User/user_info_delete_post/$1';
//$route['reset_user_password/(:any)'] = 'users/User/reset_user_password/$1';
//$route['edit_user_info/(:any)'] = 'users/User/edit_user/$1';
//$route['user_edit_post'] = 'users/User/user_edit_post';


$route['initiate_test'] = 'home/Home/view_test';
$route['submit_symptom_data'] = 'home/Home/submit_symptom_data';

