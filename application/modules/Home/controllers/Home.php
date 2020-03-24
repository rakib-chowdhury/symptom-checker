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
        $this->load->view('index', '');
    }

    public function view_test()
	{
		$this->load->view('test', '');
	}

	public function submit_symptom_data()
	{
		$data = array();
		$data['user_session_id'] = $_SESSION['__ci_last_regenerate'];
		$data['asking_for'] = $this->input->post('asking_for');
		$data['age_range'] = $this->input->post('age_range');
		$data['symptom_page_1'] = $this->input->post('symptom_page_1');
		$data['additional_symptom'] = $this->input->post('additional_symptom');
		$data['symptom_duration'] = $this->input->post('symptom_duration');
		$data['pre_existing_history'] = $this->input->post('pre_existing_history');
		$data['percentage_seventy_points'] = $this->input->post('percentage_seventy_points');
		$data['percentage_thirty_points'] = $this->input->post('percentage_thirty_points');
		$data['total_points'] = $this->input->post('total_points');
		$data['created_on'] = $this->basic_lib->convert_date_time_to_millisecond(date('Y-m-d'), date('H:i:s'));
		if($this->basic_model->insert_ret('question_answers', $data) > 0){
			echo 1;
		}else{
			echo 0;
		}
	}
}
