<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('login_id') != null){
            $this->load->library('basic_lib');
        }else{
            redirect(base_url().'login');
        }
    }
    public function index()
    {
        $this->show_dashboard();
    }
	public function show_dashboard()
    {
    	//echo '<pre>';print_r($_SESSION['user_permissions']);die();
        $data = array();
        $data['active_page'] = 'Dashboard';
        $data['top_header'] = $this->load->view('layouts/backend/top_header', '', true);
        $data['left_nav'] = $this->load->view('layouts/backend/left_nav', $data, true);
        $data['footer'] = $this->load->view('layouts/backend/footer', '', true);
        $data['master_body'] = $this->load->view('dashboard_view', '', true);
        $this->load->view('layouts/backend/master', $data);
    }


}
