<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		$this->load->library('basic_lib');
    }
    public function index()
    {
        $this->show_home();
    }
	public function show_home()
    {
//        $data = array();
//        $data['active_page'] = 'Dashboard';
//        $data['top_header'] = $this->load->view('layouts/backend/top_header', '', true);
//        $data['left_nav'] = $this->load->view('layouts/backend/left_nav', $data, true);
//        $data['footer'] = $this->load->view('layouts/backend/footer', '', true);
//        $data['master_body'] = $this->load->view('dashboard_view', '', true);
        $this->load->view('index', '');
    }

    public function view_test()
	{
		$this->load->view('test', '');
	}


}
