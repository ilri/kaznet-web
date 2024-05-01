<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url');

		$baseurl = base_url();
		$this->load->model('Auth_model');
		$this->load->model('User_model');
		$this->load->model('Helper_model');
	}

	public function index(){
		show_404();
	}

	public function create(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}
		
		$result = array();
		
		$all_roles = $this->User_model->all_roles();
		$result['all_roles'] = $this->security->xss_clean($all_roles);

		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('menu',$menu_result);
		$this->load->view('user/create', $result);
		$this->load->view('footer');
	}

	public function insert_user(){
		$baseurl = base_url();	
		
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'session_err' => 1,
				'msg' => 'Session Expired! Please login again to continue.',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
			));
			exit();
		}

		$error = array(
			'status' => 0,
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);

		$fname = $this->input->post('first_name');
		if(empty($fname)) {
			$error['first_name'] = 'First name is mandatory.';
			$error['status'] = 1;
		}

		$lname = $this->input->post('last_name');
		if(empty($lname)) {
			$error['last_name'] = 'Last name is mandatory.';
			$error['status'] = 1;
		}
		$mobile_number = $this->input->post('mobile_number');
		if(empty($mobile_number)) {
			$error['mobile_number'] = 'Mobile number is mandatory.';
			$error['status'] = 1;
		}

		$role = $this->input->post('user_role');
		if(empty($role)) {
			$error['user_role'] = 'Role selection is mandatory.';
			$error['status'] = 1;
		}

		$email = $this->input->post('email');
		if(empty($email)) {
			$error['email'] = 'Email is mandatory.';
			$error['status'] = 1;
		} else {
			$check_emaiid = $this->User_model->check_emaiid();

			if($check_emaiid) {
				if($check_emaiid['status'] == 0) {
					$error['email'] = 'Email has been blocked. Please contact admin for more details.';
					$error['status'] = 1;
				} else {
					$error['email'] = 'Email already exists.';
					$error['status'] = 1;
				}
			}
		}

		$username = $this->input->post('username');
		if(empty($username)) {
			$error['username'] = 'Username is mandatory.';
			$error['status'] = 1;
		} else {
			$check_username = $this->User_model->check_username();

			if($check_username) {
				if($check_username['status'] == 0) {
					$error['username'] = 'Username has been blocked. Please contact admin for more details.';
					$error['status'] = 1;
				} else {
					$error['username'] = 'Username already exists.';
					$error['status'] = 1;
				}
			}
		}

		$password = $this->input->post('password');
		if(empty($password)) {
			$error['password'] = 'Password is mandatory.';
			$error['status'] = 1;
		}

		$cpassword = $this->input->post('cpassword');
		if(empty($cpassword)) {
			$error['cpassword'] = 'Confirm password is mandatory.';
			$error['status'] = 1;
		}

		if(!empty($password) && !empty($cpassword) && $password != $cpassword) {
			$error['password'] = 'Both password and confirm password should be same.';
			$error['cpassword'] = 'Both password and confirm password should be same.';
			$error['status'] = 1;
		}

		if($error['status'] > 0) {
			echo json_encode($error);
			exit();
		}

		$insert_user = $this->User_model->insert_user();
		if(!$insert_user){
			echo json_encode(array(
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'msg'=>'Sorry! Please try after sometime.',
				'insertstatus' => 0
			));
			exit();
		}else{
			echo json_encode(array(
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'msg'=>'User added successfully.',
				'insertstatus' => 1
			));
			exit();
		}
	}

	public function manage_task(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}

		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		
		$result = array();
		
		// Get all non-registration surveys
		// $this->db->where('type !=', 'Registration')->where('status', 1);
		$this->db->where('type', 'Household Task')->where('status', 1);
		// $this->db->order_by('type');
		$surveys = $this->db->get('form')->result_array();
		foreach ($surveys as $key => $surv) {
			// Get total assigned
			$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
			$total = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

			if($total) $surveys[$key]['assigned'] = $total;
			else $surveys[$key]['assigned'] = 0;

			// get not yet started contributors count
			$this->db->select('*')->where('survey_id', $surv['id']);
			$this->db->where('start_date >', date("Y-m-d"));
			$nstotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

			if($nstotal) $surveys[$key]['nstotal'] = $nstotal;
			else $surveys[$key]['nstotal'] = 0;

			// get Active contributors count
			$this->db->select('*')->where('survey_id', $surv['id']);
			$this->db->where('start_date <=', date("Y-m-d"));
			$this->db->where('end_date >=', date("Y-m-d"));
			$actotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();
			// print_r($this->db->last_query());exit();

			if($actotal) $surveys[$key]['actotal'] = $actotal;
			else $surveys[$key]['actotal'] = 0;

			// get Expired contributors count
			$this->db->select('*')->where('survey_id', $surv['id']);
			$this->db->where('end_date <', date("Y-m-d"));
			$extotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();
			if($surv['id']==6){

				// print_r($this->db->last_query());exit();
			}
			

			if($extotal) $surveys[$key]['extotal'] = $extotal;
			else $surveys[$key]['extotal'] = 0;
		}
		$result['surveys_ht'] = $this->security->xss_clean($surveys);

		$this->db->where('type', 'Market Task')->where('status', 1);
		// $this->db->order_by('type');
		$surveys_mt = $this->db->get('form')->result_array();
		foreach ($surveys_mt as $key => $surv) {
			// Get total assigned
			$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
			$total = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

			if($total) $surveys_mt[$key]['assigned'] = $total;
			else $surveys_mt[$key]['assigned'] = 0;

			// get not yet started contributors count
			$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
			$this->db->where('start_date >', date("Y-m-d"));
			$nstotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

			if($nstotal) $surveys_mt[$key]['nstotal'] = $nstotal;
			else $surveys_mt[$key]['nstotal'] = 0;

			// get Active contributors count
			$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
			$this->db->where('start_date <=', date("Y-m-d"));
			$this->db->where('end_date >=', date("Y-m-d"));
			$actotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

			if($actotal) $surveys_mt[$key]['actotal'] = $actotal;
			else $surveys_mt[$key]['actotal'] = 0;

			// get Expired contributors count
			$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
			$this->db->where('end_date <', date("Y-m-d"));
			$extotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

			if($extotal) $surveys_mt[$key]['extotal'] = $extotal;
			else $surveys_mt[$key]['extotal'] = 0;
		}
		$result['surveys_mt'] = $this->security->xss_clean($surveys_mt);

		$this->db->where('type', 'Rangeland Task')->where('status', 1);
		// $this->db->order_by('type');
		$surveys_rt = $this->db->get('form')->result_array();
		foreach ($surveys_rt as $key => $surv) {
			// Get total assigned
			$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
			$total = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

			if($total) $surveys_rt[$key]['assigned'] = $total;
			else $surveys_rt[$key]['assigned'] = 0;

			// get not yet started contributors count
			$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
			$this->db->where('start_date >', date("Y-m-d"));
			$nstotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

			if($nstotal) $surveys_rt[$key]['nstotal'] = $nstotal;
			else $surveys_rt[$key]['nstotal'] = 0;

			// get Active contributors count
			$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
			$this->db->where('start_date <=', date("Y-m-d"));
			$this->db->where('end_date >=', date("Y-m-d"));
			$actotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

			if($actotal) $surveys_rt[$key]['actotal'] = $actotal;
			else $surveys_rt[$key]['actotal'] = 0;

			// get Expired contributors count
			$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
			$this->db->where('end_date <', date("Y-m-d"));
			$extotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

			if($extotal) $surveys_rt[$key]['extotal'] = $extotal;
			else $surveys_rt[$key]['extotal'] = 0;
		}
		$result['surveys_rt'] = $this->security->xss_clean($surveys_rt);

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('menu',$menu_result);
		$this->load->view('survey/manage_task', $result);
		$this->load->view('footer');
	}
	
	public function assign_task(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}

		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		
		$result = array();

		$task_type = $this->uri->segment(3);
		$result['task_type'] = ($task_type && strlen($task_type) > 0) ? urldecode($task_type) : null;

		$task = $this->uri->segment(4);
		$result['task'] = ($task && strlen($task) > 0) ? $task : null;
		
		// Get all tasks types
		$tasks_types = $this->db->distinct()->select('type')->where('status', 1)->get('form')->result_array();
		$result['tasks_types'] = $this->security->xss_clean($tasks_types);

		// Get all countries
		$countries = $this->db->where('status', 1)->get('lkp_country')->result_array();
		$result['countries'] = $this->security->xss_clean($countries);

		// var_dump($result); die();

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('menu',$menu_result);
		$this->load->view('survey/assign_task', $result);
		$this->load->view('footer');
	}
	public function get_tasks_by_type(){
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);
		
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';

			echo json_encode($result);
			exit();
		}

		if(!$this->input->post('task_type') || $this->input->post('task_type') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}

		$task_type = $this->input->post('task_type');

		// Get all tasks
		$tasks = $this->db->where('status', 1)->where('type', $task_type)->get('form')->result_array();
		$result['tasks'] = $this->security->xss_clean($tasks);

		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}
	public function get_all_tasks(){
		$baseurl = base_url();
		$result = array();
		// $result = array(
		// 	'csrfHash' => $this->security->get_csrf_hash(),
		// 	'csrfName' => $this->security->get_csrf_token_name()
		// );
		
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';

			echo json_encode($result);
			exit();
		}


		// Get all tasks
		$tasks = $this->db->where('status', 1)->get('form')->result_array();
		$result['tasks'] = $this->security->xss_clean($tasks);

		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}
	public function get_location(){
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);
		
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';

			echo json_encode($result);
			exit();
		}

		if(!$this->input->post('loc_type') || $this->input->post('loc_type') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}
		if(!$this->input->post('country') || $this->input->post('country') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}

		$loc_type = $this->input->post('loc_type');
		$country = $this->input->post('country');

		// Get location
		if($loc_type == 'uai') {
			if($this->input->post('uai') && $this->input->post('uai') != '') {
				$uai = $this->input->post('uai');
				
				$this->db->select('sub_loc_id AS id, location_name AS name')->from('lkp_sub_location');
				$this->db->where('uai_id', $uai)->where('status', 1);
				$locations = $this->db->get()->result_array();
			} else {
				$this->db->select('uai_id AS id, uai AS name')->from('lkp_uai');
				$this->db->where('country_id', $country)->where('status', 1);
				$locations = $this->db->get()->result_array();
			}
		} else if($loc_type == 'cluster') {
			$this->db->select('cluster_id AS id, name AS name')->from('lkp_cluster');
			$this->db->where('country_id', $country)->where('status', 1);
			$locations = $this->db->get()->result_array();
		}

		$result['status'] = 1;
		$result['locations'] = $locations;

		echo json_encode($result);
		exit();
	}
	public function get_contributers(){
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);
		
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';

			echo json_encode($result);
			exit();
		}

		if(!$this->input->post('loc_type') || $this->input->post('loc_type') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}
		if(!$this->input->post('location') || $this->input->post('location') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}

		$loc_type = $this->input->post('loc_type');
		$location = $this->input->post('location');

		$loc_data = NULL;
		// Get related UAI
		if($loc_type == 'uai') {
			$this->db->where('sub_loc_id', $location)->where('status', 1);
			$loc_data = $this->db->get('lkp_sub_location')->row_array();
		}

		// Get all markets
		// if($loc_type == 'cluster') $this->db->where('cluster_id', $location);
		// else if($loc_type == 'uai') $this->db->where('uai_id', $loc_data['uai_id']);
		// $result['markets'] = $this->db->get('lkp_market')->result_array();

		// Get all approved respondents 
		// if($loc_type == 'cluster') $this->db->where('cluster_id', $location);
		// else if($loc_type == 'uai') $this->db->where('sub_location_id', $location);
		// $result['respondents'] = $this->db->where('pa_verified_status', 2)->get('tbl_respondent_users')->result_array();

		// Get all approved contributers
		$this->db->select('tu.user_id, tu.first_name, tu.last_name')->from('tbl_users AS tu');
		$this->db->join('tbl_user_unit_location AS tuul', 'tuul.user_id = tu.user_id');
		$this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
		if($loc_type == 'cluster') $this->db->where('tuul.cluster_id', $location);
		else if($loc_type == 'uai') $this->db->where('tuul.sub_loc_id', $location);
		$result['contributers'] = $this->db->where('tup.pa_verified_status', 2)->where('tuul.status', 1)->where('tu.status', 1)->get()->result_array();

		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}
	public function get_respondents(){
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);
		
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';

			echo json_encode($result);
			exit();
		}

		if(!$this->input->post('loc_type') || $this->input->post('loc_type') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}
		if(!$this->input->post('location') || $this->input->post('location') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}

		$loc_type = $this->input->post('loc_type');
		$location = $this->input->post('location');
		$contributers = $this->input->post('contributer');

		$loc_data = NULL;
		// Get related UAI
		if($loc_type == 'uai') {
			$this->db->where('sub_loc_id', $location)->where('status', 1);
			$loc_data = $this->db->get('lkp_sub_location')->row_array();
		}

		$this->db->select('tu.user_id, tu.first_name, tu.last_name')->from('tbl_users AS tu');
		$this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
		$result['contributers'] = $this->db->where_in('tu.user_id',$contributers)->where('tup.pa_verified_status', 2)->where('tu.status', 1)->get()->result_array();

		// Get all markets
		if($loc_type == 'cluster') $this->db->where('cluster_id', $location);
		else if($loc_type == 'uai') $this->db->where('uai_id', $loc_data['uai_id']);
		$result['markets'] = $this->db->get('lkp_market')->result_array();

		// Get all approved respondents 
		// if($loc_type == 'cluster') $this->db->where('cluster_id', $location);
		// else if($loc_type == 'uai') $this->db->where('sub_location_id', $location);
		$result['respondents'] = $this->db->where_in('added_by', $contributers)->where('pa_verified_status', 2)->get('tbl_respondent_users')->result_array();

		

		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}
	public function assign_task_respondent(){
		date_default_timezone_set("UTC");
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);
		
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';

			echo json_encode($result);
			exit();
		}

		$type = $this->input->post('task_type');
		if(!isset($type) || strlen($type) === 0) {
			$result['status'] = 0;
			$result['msg'] = 'Task type selection is mandatory.';

			echo json_encode($result);
			exit();
		}
		
		$surveys = $this->input->post('tasks');
		if(!isset($surveys) || count($surveys) === 0) {
			$result['status'] = 0;
			$result['msg'] = 'Task selection is mandatory.';

			echo json_encode($result);
			exit();
		}
		
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		if((!isset($start_date) || strlen($start_date) === 0)
		|| (!isset($end_date) || strlen($end_date) === 0)) {
			$result['status'] = 0;
			$result['msg'] = 'Start and end date are mandatory.';

			echo json_encode($result);
			exit();
		}

		$contributer = $this->input->post('contributer');
		if(!isset($contributer) || count($contributer) === 0) {
			$result['status'] = 0;
			$result['msg'] = 'Contributor selection is mandatory.';

			echo json_encode($result);
			exit();
		}

		// Get contributer details
		$contriDetails = $this->db->where_in('user_id', $contributer)->get('tbl_users')->result_array();
		
		$succResps = array();
		$errorResps = array();

		define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');
		
		$msg = '';
		foreach ($surveys as $skey => $survey) {
			// Get survey details
			$survDetails = $this->db->where('id', $survey)->get('form')->row_array();
			
			$insertArray = array();

			foreach ($contriDetails as $ckey => $contri) {
				
				if(strtolower($type) == 'household task') {
					$respondents = $this->input->post('respondents');
					if(!$respondents || count($respondents) === 0) {
						$result['status'] = 0;
						$result['msg'] = 'No respondent found. Atleast 1 respondent is mandatory to assign task.';

						echo json_encode($result);
						exit();
					}
					
					foreach ($respondents as $key => $resp) {
						// Get respondent details
						$respDetails = $this->db->where('data_id', $resp)->get('tbl_respondent_users')->row_array();
						
						// Check if repondent is already assigned to this task
						$assignment = $this->db->where_in('user_id',$contri['user_id'])->where('start_date <=', $start_date)->where('end_date >=', $start_date)->where(array(
							'status' => 1,
							'survey_id' => $survey,
							'respondent_id' => $resp
						))->get('tbl_survey_assignee');
						if($assignment->num_rows() > 0) {
							array_push($errorResps, ($respDetails['first_name'].' '.$respDetails['last_name']));
						}else {
							array_push($succResps, ($respDetails['first_name'].' '.$respDetails['last_name']));

							array_push($insertArray, array(
								'survey_id' => $survey,
								'user_id' => $contri['user_id'],
								'respondent_id' => $resp,
								'start_date' => $start_date,
								'end_date' => $end_date,
								'country_id' => $this->input->post('country'),
								'cluster_id' => $this->input->post('cluster') && $this->input->post('cluster') != '' ? $this->input->post('cluster') : NULL,
								'uai_id' => $this->input->post('uai') && $this->input->post('uai') != '' ? $this->input->post('uai') : NULL,
								'sub_loc_id' => $this->input->post('sub_loc') && $this->input->post('sub_loc') != '' ? $this->input->post('sub_loc') : NULL,
								'assigned_by' => $this->session->userdata('login_id'),
								'assigned_date' => date('Y-m-d H:i:s'),
								'added_ip_address' => $this->input->ip_address()
							));
						}
					}
					if(count($insertArray) > 0) {
						$this->db->insert_batch('tbl_survey_assignee', $insertArray);
					
						// Send Push to Contributer
						$pushtoken = array();
						// Get user's device tokens to send push
						$this->db->distinct()->select('token');
						$this->db->where('user_id', $contri['user_id'])->where('status', 1);
						$usertoken = $this->db->get('tbl_push_notification')->result_array();
						foreach ($usertoken as $tkey => $utoken) {
							array_push($pushtoken, $utoken['token']);
						}

						if(count($pushtoken) > 0) {
							$msg = array(
								'body'		=> "Dear ".$contri['first_name']." ".$contri['last_name'].",\n
											".$survDetails['title']." has been assigned to you.\n
											Respondent Name(s): ".implode(', ', array_unique($succResps))."\n
											Please sync the application and you can see the task in the To Do list.\n
											Kindly reach out to the administrator adminkaznet@ilri.org in case of any further questions or assistance",
								'title'		=> "New task have been assigned to you - ".$survDetails['title'],
								// 'content'	=> json_encode($content),
								'type'		=> "task",
								'vibrate'	=> 1,
								'sound'		=> 1,
							);

							$fields = array(
								'registration_ids' => $pushtoken,
								'priority' => 'high',
								'data' => $msg
							);

							$headers = array(
								'Authorization: key=' . FIREBASE_API_KEY,
								'Content-Type: application/json'
							);
							$ch = curl_init();
							curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
							curl_setopt( $ch,CURLOPT_POST, true );
							curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
							curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
							curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
							curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

							$chResult = curl_exec($ch );
							curl_close( $ch );
						}
					}

					// if(count($succResps) > 0) {
					// 	$msg .= $survDetails['title'].' has been successfully assigned to ';
					// 	$msg .= implode(', ', $succResps);
					// }
					// if(count($errorResps) > 0) {
					// 	if(count($errorResps) == count($respondents)) $result['status'] = 0;
					// 	$msg .= 'Unable to assign ';
					// 	$msg .= implode(', ', $errorResps);
					// 	$msg .= ' to the '.$survDetails['title'].'. Because they are already assigned.';
					// }
					// $msg .= "</br></br>";
				} else if(strtolower($type) == 'market task') {
					$markets = $this->input->post('markets');
					if(!$markets || count($markets) === 0) {
						$result['status'] = 0;
						$result['msg'] = 'No market selected. Market selection is mandatory to assign task.';

						echo json_encode($result);
						exit();
					}
					
					foreach ($markets as $key => $mark) {
						// Get market details
						$markDetails = $this->db->where('market_id', $mark)->get('lkp_market')->row_array();
						
						// Check if market is already assigned to this task
						
						$assignment = $this->db->where('start_date <=', $start_date)->where('end_date >=', $start_date)->where(array(
							'status' => 1,
							'user_id' => $contri['user_id'],
							'survey_id' => $survey,
							'market_id' => $mark
						))->get('tbl_survey_assignee');
						if($assignment->num_rows() > 0) {
							array_push($errorResps, ($markDetails['name']));
						} else {
							array_push($succResps, ($markDetails['name']));

							array_push($insertArray, array(
								'survey_id' => $survey,
								'user_id' => $contri['user_id'],
								'market_id' => $mark,
								'start_date' => $start_date,
								'end_date' => $end_date,
								'country_id' => $this->input->post('country'),
								'cluster_id' => $this->input->post('cluster') && $this->input->post('cluster') != '' ? $this->input->post('cluster') : NULL,
								'uai_id' => $this->input->post('uai') && $this->input->post('uai') != '' ? $this->input->post('uai') : NULL,
								'sub_loc_id' => $this->input->post('sub_loc') && $this->input->post('sub_loc') != '' ? $this->input->post('sub_loc') : NULL,
								'assigned_by' => $this->session->userdata('login_id'),
								'assigned_date' => date('Y-m-d H:i:s'),
								'added_ip_address' => $this->input->ip_address()
							));
						}
					}
					if(count($insertArray) > 0) {
						$this->db->insert_batch('tbl_survey_assignee', $insertArray);
					
						// Send Push to Contributer
						$pushtoken = array();
						// Get user's device tokens to send push
						$this->db->distinct()->select('token');
						$this->db->where('user_id', $contri['user_id'])->where('status', 1);
						$usertoken = $this->db->get('tbl_push_notification')->result_array();
						foreach ($usertoken as $tkey => $utoken) {
							array_push($pushtoken, $utoken['token']);
						}

						if(count($pushtoken) > 0) {
							$msg = array(
								'body'		=> "Dear ".$contri['first_name']." ".$contri['last_name'].",\n
											".$survDetails['title']." has been assigned to you.\n
											Market Name(s): ".implode(', ', array_unique($succResps))."\n
											Please sync the application and you can see the task in the To Do list.\n
											Kindly reach out to the administrator adminkaznet@ilri.org in case of any further questions or assistance",
								'title'		=> "New task have been assigned to you - ".$survDetails['title'],
								// 'content'	=> json_encode($content),
								'type'		=> "task",
								'vibrate'	=> 1,
								'sound'		=> 1,
							);

							$fields = array(
								'registration_ids' => $pushtoken,
								'priority' => 'high',
								'data' => $msg
							);

							$headers = array(
								'Authorization: key=' . FIREBASE_API_KEY,
								'Content-Type: application/json'
							);
							$ch = curl_init();
							curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
							curl_setopt( $ch,CURLOPT_POST, true );
							curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
							curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
							curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
							curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

							$chResult = curl_exec($ch );
							curl_close( $ch );
						}
					}

					// if(count($succResps) > 0) {
					// 	$msg .= $survDetails['title'].' has been successfully assigned to ';
					// 	$msg .= implode(', ', $succResps);
					// }
					// if(count($errorResps) > 0) {
					// 	if(count($errorResps) == count($markets)) $result['status'] = 0;
					// 	$msg .= 'Unable to assign ';
					// 	$msg .= implode(', ', $errorResps);
					// 	$msg .= ' to the '.$survDetails['title'].'. Because they are already assigned.';
					// }
					// $msg .= "</br></br>";
				} else if(strtolower($type) == 'rangeland task') {
					$assignment = $this->db->where('start_date <=', $start_date)->where('end_date >=', $start_date)->where(array(
						'status' => 1,
						'user_id' => $contri['user_id'],
						'survey_id' => $survey
					))->get('tbl_survey_assignee');
					if($assignment->num_rows() > 0) {
						array_push($errorResps, ($contri['user_id']));
					} else {
						array_push($succResps, ($contri['user_id']));

						array_push($insertArray, array(
							'survey_id' => $survey,
							'user_id' => $contri['user_id'],
							'start_date' => $start_date,
							'end_date' => $end_date,
							'country_id' => $this->input->post('country'),
							'cluster_id' => $this->input->post('cluster') && $this->input->post('cluster') != '' ? $this->input->post('cluster') : NULL,
							'uai_id' => $this->input->post('uai') && $this->input->post('uai') != '' ? $this->input->post('uai') : NULL,
							'sub_loc_id' => $this->input->post('sub_loc') && $this->input->post('sub_loc') != '' ? $this->input->post('sub_loc') : NULL,
							'assigned_by' => $this->session->userdata('login_id'),
							'assigned_date' => date('Y-m-d H:i:s'),
							'added_ip_address' => $this->input->ip_address()
						));
					}
					
					
					
					if(count($insertArray) > 0) {
						$this->db->insert_batch('tbl_survey_assignee', $insertArray);
					
						// Send Push to Contributer
						$pushtoken = array();
						// Get user's device tokens to send push
						$this->db->distinct()->select('token');
						$this->db->where('user_id', $contri['user_id'])->where('status', 1);
						$usertoken = $this->db->get('tbl_push_notification')->result_array();
						foreach ($usertoken as $tkey => $utoken) {
							array_push($pushtoken, $utoken['token']);
						}

						if(count($pushtoken) > 0) {
							$msg = array(
								'body'		=> "Dear ".$contri['first_name']." ".$contri['last_name'].",\n
											".$survDetails['title']." has been assigned to you.\n
											Please sync the application and you can see the task in the To Do list.\n
											Kindly reach out to the administrator adminkaznet@ilri.org in case of any further questions or assistance",
								'title'		=> "New task have been assigned to you - ".$survDetails['title'],
								// 'content'	=> json_encode($content),
								'type'		=> "task",
								'vibrate'	=> 1,
								'sound'		=> 1,
							);

							$fields = array(
								'registration_ids' => $pushtoken,
								'priority' => 'high',
								'data' => $msg
							);

							$headers = array(
								'Authorization: key=' . FIREBASE_API_KEY,
								'Content-Type: application/json'
							);
							$ch = curl_init();
							curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
							curl_setopt( $ch,CURLOPT_POST, true );
							curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
							curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
							curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
							curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

							$chResult = curl_exec($ch );
							curl_close( $ch );
						}
					}
				}

			}
		}

		// if(strlen($msg) > 0) {
		// 	$result['status'] = 1;
		// 	$result['msg'] = "Task(s) has been assigned successfully.";
		// } else {
		// 	$result['status'] = 0;
		// 	$result['msg'] = $msg;
		// }
		// $result['status'] = 1;
		// $result['msg'] = "Task(s) has been assigned successfully.";
		$msg = '';
		$msg1 = '';
		$msg2 = '';
		if(count($succResps) > 0 && count($errorResps) == 0) {
			$result['status'] = 1;
			$msg .= 'Task(s) have been successfully assigned.';
			$msg1 .= 'You can check the assignment details in Task Management --> Task Contributors';
		}else if(count($errorResps) > 0 && count($succResps) == 0) {
			$result['status'] = 0;
			$msg .= 'Task(s) which are already assigned in the given date range, are not updated.';
			$msg1 .= 'You can check the assignment details in Task Management --> Task Contributors';
		}else if(count($succResps) > 0 && count($errorResps) > 0) {
			$result['status'] = 2;
			$msg .= 'Task(s) have been successfully assigned.';
			$msg1 .= 'Task(s) which are already assigned in the given date range, are not updated.';
			$msg2 .= 'You can check the assignment details in Task Management --> Task Contributors';
		}
		$result['msg'] = $msg;
		$result['msg1'] = $msg1;
		$result['msg2'] = $msg2;

		echo json_encode($result);
		exit();
	}

	//Unassign Task user
	public function unassign_task_user()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'status' => 0
			));
			exit();
		}
		$survey_ids= array();
		$contributer= array();
		$unassign_survey_list = $this->db->where_in('assignee_id', $_POST['assignee_id'])->get('tbl_survey_assignee')->result_array();
		foreach ($unassign_survey_list as $skey => $survey) {
			array_push($survey_ids , $survey['survey_id']);
			array_push($contributer , $survey['user_id']);
		}
		$survey_list = $this->db->where_in('id', $survey_ids)->where('status', 1)->get('form')->result_array();
		$reject_user = $this->db->where('assignee_id', $_POST['assignee_id'])->update('tbl_survey_assignee', array(
			'status' => 0 , 'unassigned_date' => date('Y-m-d H:i:s')
		));

		if($reject_user){
			
			define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');
			$contriDetails = $this->db->where_in('user_id', $contributer)->get('tbl_users')->result_array();
			foreach ($survey_list as $skey => $survDetails) {
				foreach ($contriDetails as $ckey => $contri) {
					// Send Push to Contributer
					$pushtoken = array();
					// Get user's device tokens to send push
					$this->db->distinct()->select('token');
					$this->db->where('user_id', $contri['user_id'])->where('status', 1);
					$usertoken = $this->db->get('tbl_push_notification')->result_array();
					foreach ($usertoken as $tkey => $utoken) {
						array_push($pushtoken, $utoken['token']);
					}

					if(count($pushtoken) > 0) {
						$msg = array(
							'body'		=> "".$survDetails['title']." has been assigned to you.\n
										Please sync the application to reflect the changes.\n
										Kindly reach out to the administrator adminkaznet@ilri.org in case of any further questions or assistance",
							'title'		=> "Task has been unassigned / revoked - ".$survDetails['title'],
							// 'content'	=> json_encode($content),
							'type'		=> "task",
							'vibrate'	=> 1,
							'sound'		=> 1,
						);

						$fields = array(
							'registration_ids' => $pushtoken,
							'priority' => 'high',
							'data' => $msg
						);

						$headers = array(
							'Authorization: key=' . FIREBASE_API_KEY,
							'Content-Type: application/json'
						);
						$ch = curl_init();
						curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
						curl_setopt( $ch,CURLOPT_POST, true );
						curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
						curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

						$chResult = curl_exec($ch );
						curl_close( $ch );
					}
				}
			}
		}

		echo json_encode(array(
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash(),
			'msg' => 'Task Unassigned Successfully!',
			'status'=> 1
		));
		exit();
	}
	//Unassign Multiple Task user
	public function unassign_task_multiple_user()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'status' => 0
			));
			exit();
		}
		if($this->session->userdata('role') == 1){
			$ids = $this->input->post('check_sub');

		} else{
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}
		$survey_ids= array();
		$contributer= array();
		$unassign_survey_list = $this->db->where_in('assignee_id', $ids)->get('tbl_survey_assignee')->result_array();
		foreach ($unassign_survey_list as $skey => $survey) {
			array_push($survey_ids , $survey['survey_id']);
			array_push($contributer , $survey['user_id']);
		}
		$survey_list = $this->db->where_in('id', $survey_ids)->where('status', 1)->get('form')->result_array();
		// foreach ($ids as $id) {
			$reject_user = $this->db->where_in('assignee_id', $ids)->update('tbl_survey_assignee', array(
				'status' => 0 , 'unassigned_date' => date('Y-m-d H:i:s')
			));
		// }
		if($reject_user){
			
			define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');
			$contriDetails = $this->db->where_in('user_id', $contributer)->get('tbl_users')->result_array();
			foreach ($survey_list as $skey => $survDetails) {
				foreach ($contriDetails as $ckey => $contri) {
					// Send Push to Contributer
					$pushtoken = array();
					// Get user's device tokens to send push
					$this->db->distinct()->select('token');
					$this->db->where('user_id', $contri['user_id'])->where('status', 1);
					$usertoken = $this->db->get('tbl_push_notification')->result_array();
					foreach ($usertoken as $tkey => $utoken) {
						array_push($pushtoken, $utoken['token']);
					}

					if(count($pushtoken) > 0) {
						$msg = array(
							'body'		=> "".$survDetails['title']." has been assigned to you.\n
										Please sync the application to reflect the changes.\n
										Kindly reach out to the administrator adminkaznet@ilri.org in case of any further questions or assistance",
							'title'		=> "Task has been unassigned / revoked - ".$survDetails['title'],
							// 'content'	=> json_encode($content),
							'type'		=> "task",
							'vibrate'	=> 1,
							'sound'		=> 1,
						);

						$fields = array(
							'registration_ids' => $pushtoken,
							'priority' => 'high',
							'data' => $msg
						);

						$headers = array(
							'Authorization: key=' . FIREBASE_API_KEY,
							'Content-Type: application/json'
						);
						$ch = curl_init();
						curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
						curl_setopt( $ch,CURLOPT_POST, true );
						curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
						curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

						$chResult = curl_exec($ch );
						curl_close( $ch );
					}
				}
			}
		}

		// echo json_encode(array(
		// 	'csrfName' => $this->security->get_csrf_token_name(),
		// 	'csrfHash' => $this->security->get_csrf_hash(),
		// 	'msg' => 'Task Unassigned Successfully!',
		// 	'status'=> 1
		// ));
		// exit();
		$result['status'] = 1;
		
		$result['msg'] = 'Task Unassigned Successfully.';
		
		// $result['verified_by'] = $this->session->userdata('name');
		// $result['verified_role'] = $this->session->userdata('role');
		echo json_encode($result);
		exit();
	}


	// Abhinash Code commented, contibutor multi select
	public function assign_task_respondent_old(){
		date_default_timezone_set("UTC");
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);
		
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';

			echo json_encode($result);
			exit();
		}

		$type = $this->input->post('task_type');
		if(!isset($type) || strlen($type) === 0) {
			$result['status'] = 0;
			$result['msg'] = 'Task type selection is mandatory.';

			echo json_encode($result);
			exit();
		}
		
		$surveys = $this->input->post('tasks');
		if(!isset($surveys) || count($surveys) === 0) {
			$result['status'] = 0;
			$result['msg'] = 'Task selection is mandatory.';

			echo json_encode($result);
			exit();
		}
		
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		if((!isset($start_date) || strlen($start_date) === 0)
		|| (!isset($end_date) || strlen($end_date) === 0)) {
			$result['status'] = 0;
			$result['msg'] = 'Start and end date are mandatory.';

			echo json_encode($result);
			exit();
		}

		$contributer = $this->input->post('contributer');
		if(!isset($contributer) || strlen($contributer) === 0) {
			$result['status'] = 0;
			$result['msg'] = 'Contributor selection is mandatory.';

			echo json_encode($result);
			exit();
		}

		// Get contributer details
		$contriDetails = $this->db->where('user_id', $contributer)->get('tbl_users')->row_array();
		
		$succResps = array();
		$errorResps = array();

		define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');
		
		$msg = '';
		foreach ($surveys as $skey => $survey) {
			// Get survey details
			$survDetails = $this->db->where('id', $survey)->get('form')->row_array();
			
			$insertArray = array();

			if(strtolower($type) == 'household task') {
				$respondents = $this->input->post('respondents');
				if(!$respondents || count($respondents) === 0) {
					$result['status'] = 0;
					$result['msg'] = 'No respondent found. Atleast 1 respondent is mandatory to assign task.';

					echo json_encode($result);
					exit();
				}
				
				foreach ($respondents as $key => $resp) {
					// Get respondent details
					$respDetails = $this->db->where('data_id', $resp)->get('tbl_respondent_users')->row_array();
					
					// Check if repondent is already assigned to this task
					$assignment = $this->db->where(array(
						'status' => 1,
						'user_id' => $contributer,
						'survey_id' => $survey,
						'respondent_id' => $resp,
					))->get('tbl_survey_assignee');
					if($assignment->num_rows() > 0) {
						array_push($errorResps, ($respDetails['first_name'].' '.$respDetails['last_name']));
					} else {
						array_push($succResps, ($respDetails['first_name'].' '.$respDetails['last_name']));

						array_push($insertArray, array(
							'survey_id' => $survey,
							'user_id' => $contributer,
							'respondent_id' => $resp,
							'start_date' => $start_date,
							'end_date' => $end_date,
							'cluster_id' => $this->input->post('cluster') && $this->input->post('cluster') != '' ? $this->input->post('cluster') : NULL,
							'uai_id' => $this->input->post('uai') && $this->input->post('uai') != '' ? $this->input->post('uai') : NULL,
							'sub_loc_id' => $this->input->post('sub_loc') && $this->input->post('sub_loc') != '' ? $this->input->post('sub_loc') : NULL,
							'assigned_by' => $this->session->userdata('login_id'),
							'assigned_date' => date('Y-m-d H:i:s'),
							'added_ip_address' => $this->input->ip_address()
						));
					}
				}
				if(count($insertArray) > 0) {
					$this->db->insert_batch('tbl_survey_assignee', $insertArray);
				
					// Send Push to Contributer
					$pushtoken = array();
					// Get user's device tokens to send push
					$this->db->distinct()->select('token');
					$this->db->where('user_id', $contributer)->where('status', 1);
					$usertoken = $this->db->get('tbl_push_notification')->result_array();
					foreach ($usertoken as $tkey => $utoken) {
						array_push($pushtoken, $utoken['token']);
					}

					if(count($pushtoken) > 0) {
						$msg = array(
							'body'		=> "Dear ".$contriDetails['first_name']." ".$contriDetails['last_name'].",\n
										".$survDetails['title']." has been assigned to you.\n
										Respondent Name(s): ".implode(', ', $succResps)."\n
										Please sync the application and you can see the task in the To Do list.\n
										Kindly reach out to the administrator adminkaznet@ilri.org in case of any further questions or assistance",
							'title'		=> "New task have been assigned to you - ".$survDetails['title'],
							// 'content'	=> json_encode($content),
							'type'		=> "task",
							'vibrate'	=> 1,
							'sound'		=> 1,
						);

						$fields = array(
							'registration_ids' => $pushtoken,
							'priority' => 'high',
							'data' => $msg
						);

						$headers = array(
							'Authorization: key=' . FIREBASE_API_KEY,
							'Content-Type: application/json'
						);
						$ch = curl_init();
						curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
						curl_setopt( $ch,CURLOPT_POST, true );
						curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
						curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

						$chResult = curl_exec($ch );
						curl_close( $ch );
					}
				}

				// if(count($succResps) > 0) {
				// 	$msg .= $survDetails['title'].' has been successfully assigned to ';
				// 	$msg .= implode(', ', $succResps);
				// }
				// if(count($errorResps) > 0) {
				// 	if(count($errorResps) == count($respondents)) $result['status'] = 0;
				// 	$msg .= 'Unable to assign ';
				// 	$msg .= implode(', ', $errorResps);
				// 	$msg .= ' to the '.$survDetails['title'].'. Because they are already assigned.';
				// }
				// $msg .= "</br></br>";
			} else if(strtolower($type) == 'market task') {
				$markets = $this->input->post('markets');
				if(!$markets || count($markets) === 0) {
					$result['status'] = 0;
					$result['msg'] = 'No market selected. Market selection is mandatory to assign task.';

					echo json_encode($result);
					exit();
				}
				
				foreach ($markets as $key => $mark) {
					// Get market details
					$markDetails = $this->db->where('market_id', $mark)->get('lkp_market')->row_array();
					
					// Check if market is already assigned to this task
					$assignment = $this->db->where(array(
						'status' => 1,
						'user_id' => $contributer,
						'survey_id' => $survey,
						'market_id' => $mark
					))->get('tbl_survey_assignee');
					if($assignment->num_rows() > 0) {
						array_push($errorResps, ($markDetails['name']));
					} else {
						array_push($succResps, ($markDetails['name']));

						array_push($insertArray, array(
							'survey_id' => $survey,
							'user_id' => $contributer,
							'market_id' => $mark,
							'start_date' => $start_date,
							'end_date' => $end_date,
							'cluster_id' => $this->input->post('cluster') && $this->input->post('cluster') != '' ? $this->input->post('cluster') : NULL,
							'uai_id' => $this->input->post('uai') && $this->input->post('uai') != '' ? $this->input->post('uai') : NULL,
							'sub_loc_id' => $this->input->post('sub_loc') && $this->input->post('sub_loc') != '' ? $this->input->post('sub_loc') : NULL,
							'assigned_by' => $this->session->userdata('login_id'),
							'assigned_date' => date('Y-m-d H:i:s'),
							'added_ip_address' => $this->input->ip_address()
						));
					}
				}
				if(count($insertArray) > 0) {
					$this->db->insert_batch('tbl_survey_assignee', $insertArray);
				
					// Send Push to Contributer
					$pushtoken = array();
					// Get user's device tokens to send push
					$this->db->distinct()->select('token');
					$this->db->where('user_id', $contributer)->where('status', 1);
					$usertoken = $this->db->get('tbl_push_notification')->result_array();
					foreach ($usertoken as $tkey => $utoken) {
						array_push($pushtoken, $utoken['token']);
					}

					if(count($pushtoken) > 0) {
						$msg = array(
							'body'		=> "Dear ".$contriDetails['first_name']." ".$contriDetails['last_name'].",\n
										".$survDetails['title']." has been assigned to you.\n
										Market Name(s): ".implode(', ', $succResps)."\n
										Please sync the application and you can see the task in the To Do list.\n
										Kindly reach out to the administrator adminkaznet@ilri.org in case of any further questions or assistance",
							'title'		=> "New task have been assigned to you - ".$survDetails['title'],
							// 'content'	=> json_encode($content),
							'type'		=> "task",
							'vibrate'	=> 1,
							'sound'		=> 1,
						);

						$fields = array(
							'registration_ids' => $pushtoken,
							'priority' => 'high',
							'data' => $msg
						);

						$headers = array(
							'Authorization: key=' . FIREBASE_API_KEY,
							'Content-Type: application/json'
						);
						$ch = curl_init();
						curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
						curl_setopt( $ch,CURLOPT_POST, true );
						curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
						curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

						$chResult = curl_exec($ch );
						curl_close( $ch );
					}
				}

				// if(count($succResps) > 0) {
				// 	$msg .= $survDetails['title'].' has been successfully assigned to ';
				// 	$msg .= implode(', ', $succResps);
				// }
				// if(count($errorResps) > 0) {
				// 	if(count($errorResps) == count($markets)) $result['status'] = 0;
				// 	$msg .= 'Unable to assign ';
				// 	$msg .= implode(', ', $errorResps);
				// 	$msg .= ' to the '.$survDetails['title'].'. Because they are already assigned.';
				// }
				// $msg .= "</br></br>";
			}
		}

		// if(strlen($msg) > 0) {
		// 	$result['status'] = 1;
		// 	$result['msg'] = "Task(s) has been assigned successfully.";
		// } else {
		// 	$result['status'] = 0;
		// 	$result['msg'] = $msg;
		// }
		$result['status'] = 1;
		$result['msg'] = "Task(s) has been assigned successfully.";
		// $msg = '';
		// if(count($succResps) > 0) {
		// 	$msg .= 'Task(s) has been successfully assigned to '.implode(', ', $succResps);
		// }
		// if(count($errorResps) > 0) {
		// 	if(count($errorResps) == count($respondents)) $result['status'] = 0;
		// 	$msg .= 'Unable to assign '.implode(', ', $errorResps).' to the task. Because they are already assigned.';
		// }
		// $result['msg'] = $msg;

		echo json_encode($result);
		exit();
	}

	public function task_contributer(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}

		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		
		$result = array();

		$task = $this->uri->segment(3);
		$user_id = $this->session->userdata('login_id');
		$result['selectedTask'] = ($task && strlen($task) > 0) ? $task : null;
		if($task !== NULL){
			// Get selected task
			$this->db->where('id', $task);
			$tasks = $this->db->where('status', 1)->get('form')->result_array();
			$result['tasks_list'] = $this->security->xss_clean($tasks);
		}else{
			// Get all tasks
			$tasks = $this->db->where('status', 1)->get('form')->result_array();
			$result['tasks_list'] = $this->security->xss_clean($tasks);
		}
		// $c1=0;$c2=0;$c3=0;
		// $this->db->select('*');
		
		
		if($this->session->userdata('role') != 1){
			// $this->db->distinct('tul.country_id')->select('lc.country_id as c_id, lc.name');
			// if($task !== NULL){
			// 	$this->db->where('survey_id', $task);
			// }
			// $this->db->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
			// $this->db->where('tul.user_id', $user_id);
			// $this->db->where('lc.status', 1);
			// $this->db->where('tul.status', 1);
			// $result['lkp_country'] = $this->db->get()->result_array();

			$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['lkp_country'] = $this->db->where('lc.status', 1)->where('tul.status', 1)->group_by('tul.country_id')->get()->result_array();
		}else{
			$this->db->select('*');
			$result['lkp_country'] =  $this->db->where('status', 1)->get('lkp_country')->result_array();
		}
		
		// print_r($this->db->last_query());exit();
		$result['status'] =1;

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('menu',$menu_result);
		$this->load->view('survey/task_contributer', $result);
		$this->load->view('footer');
	}
	public function get_task_contributers(){
		date_default_timezone_set("UTC");
		$baseurl = base_url();
		$result = array();

		// $survey_id = $this->input->post('survey_id');
		$country_id = $this->input->post('country_id');
		$uai_id = $this->input->post('uai_id');
		$sub_location_id = $this->input->post('sub_location_id');
		$cluster_id = $this->input->post('cluster_id');
		$contributor_id = $this->input->post('contributor_id');
		$respondent_id = $this->input->post('respondent_id');
		$user_id = $this->session->userdata('login_id');
		$survey_id = $this->input->post('survey_id');
		$status_id = $this->input->post('status');
		
		$page_no =  1;
		$record_per_page = 100;
			if($this->input->post('pagination')){
			$pagination = $this->input->post('pagination');
			$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
			$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			}

			

		$data = array(
			'country_id' => $country_id,
			'uai_id' => $uai_id,
			'sub_location_id' => $sub_location_id,
			'cluster_id' => $cluster_id,
			'contributor_id' => $contributor_id,
			'respondent_id' => $respondent_id,
			'user_id' => $user_id,
			'survey_id' => $survey_id,
			"page_no" => $page_no,
			"record_per_page" => $record_per_page,
			"is_pagination" => $this->input->post('pagination') != null
		);
		$task_list1 =$this->db->select('type')->where('id', $survey_id)->where('status', 1)->get('form')->row_array();
		$task_type = $task_list1['type'];
		$this->db->select('survey.*');
		if($survey_id !== NULL && $survey_id!=0){
			$this->db->where('survey_id', $survey_id);
		}
		if(!empty($data['country_id'])) {
            $this->db->where('survey.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('survey.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('survey.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('survey.sub_loc_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('survey.user_id', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            $this->db->where('survey.respondent_id', $data['respondent_id']);
        }

		switch ($status_id) {
			case '1':
				$this->db->where('survey.start_date >', date("Y-m-d"));
				break;
			case '2':
				$this->db->where('survey.start_date <=', date("Y-m-d"));
				$this->db->where('survey.end_date >=', date("Y-m-d"));
				break;
			case '3':
				$this->db->where('survey.end_date <', date("Y-m-d"));
				break;
			
			default:
				# code...
				break;
		}
		$contributor_list = $this->db->where('status', 1)->get('tbl_survey_assignee as survey')->result_array();
		// print_r($this->db->last_query());exit();
		foreach ($contributor_list as $ckey => $contributor) {
			$task_list =$this->db->select('title')->where('id', $contributor['survey_id'])->where('status', 1)->get('form')->row_array();
			$contributor_list[$ckey]['task_name'] = $task_list['title'];

			$country_list =$this->db->select('name')->where('country_id', $contributor['country_id'])->where('status', 1)->get('lkp_country')->row_array();
			$contributor_list[$ckey]['country_name'] = $country_list['name'];

			$cluster_list =$this->db->select('name')->where('cluster_id', $contributor['cluster_id'])->where('status', 1)->get('lkp_cluster')->row_array();
			$contributor_list[$ckey]['cluster_name'] = $cluster_list['name'];

			$uai_list =$this->db->select('uai')->where('uai_id', $contributor['uai_id'])->where('status', 1)->get('lkp_uai')->row_array();
			$contributor_list[$ckey]['uai_name'] = $uai_list['uai'];

			$sub_loc_list =$this->db->select('location_name')->where('sub_loc_id', $contributor['sub_loc_id'])->where('status', 1)->get('lkp_sub_location')->row_array();
			$contributor_list[$ckey]['location_name'] = $sub_loc_list['location_name'];

			$user_list =$this->db->select('first_name,last_name')->where('user_id', $contributor['user_id'])->where('status', 1)->get('tbl_users')->row_array();
			$contributor_list[$ckey]['contributor_name'] = $user_list['first_name']." ".$user_list['last_name'];

			$respondent_list =$this->db->select('first_name,last_name')->where('data_id', $contributor['respondent_id'])->where('status', 1)->get('tbl_respondent_users')->row_array();
			$contributor_list[$ckey]['respondent_name'] = $respondent_list['first_name']." ".$respondent_list['last_name'];
			// $contributor_list[$ckey]['respondent_name'] = $contributor['user_id'];

			$this->db->select('name')->where('market_id', $contributor['market_id']);
			$market_name_list = $this->db->where('status', 1)->get('lkp_market')->row_array();
			$contributor_list[$ckey]['market_name'] = $market_name_list['name'];

			$status="";
			if($contributor['start_date'] > date("Y-m-d")){
				$status="Not started";
				// $c1++;
			}
			if(($contributor['start_date'] <= date("Y-m-d")) && ($contributor['end_date'] >= date("Y-m-d"))){
				$status="Active";
				// $c2++;
			}
			if($contributor['end_date'] < date("Y-m-d")){
				$status="Expired";
				// $c3++;
			}
			$contributor_list[$ckey]['status'] =$status;
		}
		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();

		$result['submited_data'] = $contributor_list;
		$result['task_type'] = $task_type;
		
		
        $this->db->select('survey.*');
		if($survey_id !== NULL && $survey_id!=0){
			$this->db->where('survey_id', $survey_id);
		}
		if(!empty($data['country_id'])) {
            $this->db->where('survey.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('survey.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('survey.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('survey.sub_loc_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('survey.user_id', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            $this->db->where('survey.respondent_id', $data['respondent_id']);
        }

		switch ($status_id) {
			case '1':
				$this->db->where('survey.start_date >', date("Y-m-d"));
				break;
			case '2':
				$this->db->where('survey.start_date <=', date("Y-m-d"));
				$this->db->where('survey.end_date >=', date("Y-m-d"));
				break;
			case '3':
				$this->db->where('survey.end_date <', date("Y-m-d"));
				break;
			
			default:
				# code...
				break;
		}
		$submited_data = $this->db->where('survey.status', 1)->get('tbl_survey_assignee as survey')->num_rows();
        
		// $submited_data = $this->db->order_by('survey.id', 'DESC')->get()->num_rows();

		$result['total_records'] =$submited_data;
		$result['status'] =1;
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';

			echo json_encode($result);
			exit();
		}

		echo json_encode($result);
		exit();
	}

	public function map(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}

		// $this->load->model('Dynamicmenu_model');
		// $main_menu = $this->Dynamicmenu_model->menu_details();
		// $main_menu = $this->security->xss_clean($main_menu);
		// $header_result = array('main_menu' => $main_menu);
		
		$result = array();
		
		$this->load->model('User_model');
		$all_users = $this->User_model->all_users();
		$result['users'] = $this->security->xss_clean($all_users);

		$this->load->model('Helper_model');
		$all_units = $this->Helper_model->all_units();
		$result['units'] = $this->security->xss_clean($all_units);

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('user/map', $result);
		$this->load->view('footer');
	}
	
	public function get_user_locations_old(){
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);
		
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';

			echo json_encode($result);
			exit();
		}

		// if(!$this->input->post('agency') || !$this->input->post('user_id')) {
		if(!$this->input->post('user_id')) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}

		$agency = $this->input->post('agency');
		$user_id = $this->input->post('user_id');
		// if(strlen($agency) == 0 || strlen($user_id) == 0) {
		if(strlen($user_id) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}

		$result['status'] = 1;
		ini_set('memory_limit', '-1');

		// Get all locations
		$this->load->model('Helper_model');
		$states = $this->Helper_model->all_states();
		// $districts = $this->Helper_model->all_districts();
		// $tehsils = $this->Helper_model->all_tehsils();
		// $blocks = $this->Helper_model->all_blocks();
		// $gps = $this->Helper_model->all_gps();
		// $villages = $this->Helper_model->all_villages();
		foreach ($states as $skey => $state) {
			$districts = $this->Helper_model->all_districts($state['state_id']);
			
			foreach ($districts as $dkey => $dist) {
				$tehsils = $this->Helper_model->all_tehsils($dist['district_id']);

				foreach ($tehsils as $tkey => $tehsil) {
					$blocks = $this->Helper_model->all_blocks($tehsil['tehsil_id']);

					// foreach ($blocks as $bkey => $block) {
					// 	$gps = $this->Helper_model->all_gps($block['block_id']);

					// 	foreach ($gps as $gkey => $gp) {
					// 		$villages = $this->Helper_model->all_villages($gp['grampanchayat_id']);
							
					// 		$gps[$gkey]['villages'] = $villages;
					// 	}
						
					// 	$blocks[$bkey]['gps'] = $gps;
					// }
					
					$tehsils[$tkey]['blocks'] = $blocks;
				}
				
				$districts[$dkey]['tehsils'] = $tehsils;
			}

			$states[$skey]['districts'] = $districts;
		}
		$result['states'] = $states;
		
		// Get locations assigned to user
		$this->db->select('state_id, district_id, tehsil_id, block_id, grampanchayat_id, village_id');
		$this->db->where('UNIT_ID', $agency)->where('user_id', $user_id);
		$assignedLoc = $this->db->where('status', 1)->get('tbl_user_unit_location');
		if($assignedLoc->num_rows() === 0) { $selectedLoc = array(); }
		else { $selectedLoc = array(
			'states' => array(),
			'districts' => array(),
			'tehsils' => array(),
			'blocks' => array(),
			'gps' => array(),
			'villages' => array()
		); }
		$assignedLoc = $assignedLoc->result_array();
		foreach ($assignedLoc as $key => $loc) {
			if(!in_array($loc['state_id'], $selectedLoc['states'])) array_push($selectedLoc['states'], $loc['state_id']);
			if(!in_array($loc['district_id'], $selectedLoc['districts'])) array_push($selectedLoc['districts'], $loc['district_id']);
			if(!in_array($loc['tehsil_id'], $selectedLoc['tehsils'])) array_push($selectedLoc['tehsils'], $loc['tehsil_id']);
			if(!in_array($loc['block_id'], $selectedLoc['blocks'])) array_push($selectedLoc['blocks'], $loc['block_id']);
			if(!in_array($loc['grampanchayat_id'], $selectedLoc['gps'])) array_push($selectedLoc['gps'], $loc['grampanchayat_id']);
			if(!in_array($loc['village_id'], $selectedLoc['villages'])) array_push($selectedLoc['villages'], $loc['village_id']);
		}
		$result['selectedLoc'] = json_encode($selectedLoc);

		echo json_encode($result);
		exit();
	}

	public function get_user_locations()
	{
		$baseurl = base_url();
		
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'session_err' => 1,
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		// if(!$this->input->post('partner_id')) {
		// 	echo json_encode(array(
		// 		'status' => 0,
		// 		'csrfName' => $this->security->get_csrf_token_name(),
		// 		'csrfHash' => $this->security->get_csrf_hash(),
		// 		'msg' => 'Invalid request. Please refresh the page and try again.'
		// 	));
		// 	exit();
		// }
		// $partner_id = $this->input->post('partner_id');
		// if(strlen($partner_id) == 0) {
		// 	echo json_encode(array(
		// 		'status' => 0,
		// 		'csrfName' => $this->security->get_csrf_token_name(),
		// 		'csrfHash' => $this->security->get_csrf_hash(),
		// 		'msg' => 'Invalid request. Please refresh the page and try again.'
		// 	));
		// 	exit();
		// }
		$partner_id=1;
		$user_id = $this->input->post('user_id');
		
		$data = array(
			'partner_id' => $partner_id,
			'user_id' => $user_id
		);
		$this->load->model('Helper_model');
		$user_details = $this->Helper_model->get_user_details($data);
		if(count($user_details) === 0) {
			echo json_encode(array(
				'status' => 2,
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'msg'=>'No location has been assigned to this partner.'
			));
			exit();
		}
		if(!$user_details) {
			echo json_encode(array(
				'status' => 0,
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'msg'=>'Sorry! Please try after sometime.'
			));
			exit();
		}

		$countries = $this->Helper_model->get_partner_locations_nested($data);
		echo json_encode(array(
			'status' => 1,
			'user_details' => $user_details,
			'countries' => $countries,
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash()
		));
		exit();
	}

	public function update_user_mapping(){
		date_default_timezone_set("UTC");
		$baseurl = base_url();
		$result = array(
			'status' => 0,
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);

		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';

			echo json_encode($result);
			exit();
		}

		$user_id = $this->input->post('user');
		// $agency_id = $this->input->post('agency');
		// if(strlen($user_id) == 0 || strlen($agency_id) == 0) {
		// 	$result['status'] = 1;
		// 	$result['form'] = 'Invalid request. Please refresh the page and try again.';

		// 	echo json_encode($result);
		// 	exit();
		// }

		$villages = $this->input->post('villages');
		if(!$villages || count($villages) == 0) {
			$error['villages'] = 'Location selection is mandatory.';
			$error['status'] = 1;
		}

		if($result['status'] == 1) {
			echo json_encode($result);
			exit();
		}

		// Clear previous maaping
		// Location
		$this->db->where('user_id', $user_id);
		$this->db->delete('tbl_user_unit_location');

		// Get all villages inside the block
		// $villages = $this->db->where_in('block_id', $blocks)->where('village_status', 1)->get('lkp_village')->result_array();
		foreach ($villages as $vkey => $village) {
			$location = $this->db->where('village_id', $village)->get('lkp_village')->row_array();
			// Insert new location mappings
			$this->db->insert('tbl_user_unit_location', array(
				'user_id' => $user_id,
				'country_id' => $location['country_id'],
				'state_id' => $location['state_id'],
				'district_id' => $location['district_id'],
				'block_id' => $location['block_id'],
				'village_id' => $location['village_id'],
				'added_by' => $this->session->userdata('login_id'),
				'added_datetime' => date('Y-m-d H:i:s'),
				'ip_address' => $this->input->ip_address()
			));
		}

		$result['updatestatus'] = 1;
		$result['msg'] = 'User mapping comleted successfully.';

		echo json_encode($result);
		exit();
	}

	public function view()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			//get all user
			
			$users = $this->User_model->all_users();

			$header_result = array('main_menu' => $main_menu);

			$result = array('users' => $users);
			$result = $this->security->xss_clean($result);
			$this->load->view('header', $header_result);
			$this->load->view('user/view', $result);
			$this->load->view('footer');
		}
	}
	//get user details
	public function get_user_details()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'status' => 0
			));
			exit();
		}
		
		$result = array(
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash()
		);
		$result = $this->security->xss_clean($result);
		
		
		$user_details = $this->User_model->get_user_details($_POST['user_id']);
		$result['user_details'] = $user_details;
		// $result['user_details'] = $this->security->xss_clean($user_details);
		echo json_encode($result);
		exit();
	}
		

	public function edit(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			$result = array();
			//get all user
			
			$users = $this->User_model->all_users();
			$result['users'] = $this->security->xss_clean($users);

			
			$all_roles = $this->User_model->all_roles();
			$result['all_roles'] = $this->security->xss_clean($all_roles);

			$this->load->model('Projects_model');
			$projects = $this->Projects_model->all_project();
			$result['projects'] = $this->security->xss_clean($projects);

			$header_result = array('main_menu' => $main_menu);
			$this->load->view('header', $header_result);
			$this->load->view('user/edit', $result);
			$this->load->view('footer');
		}
	}
	//update user details
	public function update_user_details()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'status' => 0
			));
			exit();
		}else{
			$data = array(
				'first_name' => htmlspecialchars($_POST['fname'], ENT_QUOTES),
				'last_name' => htmlspecialchars($_POST['lname'], ENT_QUOTES),
				'mobile_number' => htmlspecialchars($_POST['mobile_number'], ENT_QUOTES),
				'email_id' => htmlspecialchars($_POST['email'], ENT_QUOTES),
				'username' => htmlspecialchars($_POST['username'], ENT_QUOTES),
			);
			$data = $this->security->xss_clean($data);
			$update_user = $this->db->where('user_id', $_POST['user_id'])->update('tbl_users', $data);
			if($update_user){
				$result = array(
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
					'msg' => 'User Updated successfully !', 
					'status' => 1
				);
			} else {
				$result = array(
					'msg' => 'Something went wrong. Please try again later',
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
					'status' => 0
				);
			}
			$result = $this->security->xss_clean($result);
			echo json_encode($result);
			exit();
		}
	}
	//update user details professional
	public function update_user_details_professional()
	{
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'session_err' => 1,
				'msg' => 'Session Expired! Please login again to continue.',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
			));
			exit();
		}

		$error = array(
			'status' => 0,
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);

		$role = $this->input->post('user_role');
		if(empty($role)) {
			$error['user_role'] = 'Role selection is mandatory.';
			$error['status'] = 1;
		}

		$projects = $this->input->post('user_project');
		if(!$projects || count($projects) == 0) {
			$error['user_project'] = 'Project selection is mandatory.';
			$error['status'] = 1;
		}

		$partner = $this->input->post('user_agency');
		if(empty($partner)) {
			$error['user_agency'] = 'Agency selection is mandatory.';
			$error['status'] = 1;
		}

		$villages = $this->input->post('villages');
		if(!$villages || count($villages) == 0) {
			$error['villages'] = 'Location selection is mandatory.';
			$error['status'] = 1;
		}

		if($error['status'] > 0) {
			echo json_encode($error);
			exit();
		}

		date_default_timezone_set("UTC");
		$data = array(
			'role_id' => $_POST['user_role']
		);
		$data = $this->security->xss_clean($data);
		$update_user = $this->db->where('user_id', $_POST['user_id'])->update('tbl_users', $data);
		if($update_user){
			// Delete all the old mappings
			$this->db->where('user_id', $_POST['user_id'])->where('lkp_project_id', 1)->delete('rpt_project_partner_user_location');
			// Insert new mappings
			foreach ($projects as $key => $project) {
				foreach ($villages as $key => $village) {
					$location = $this->db->where('village_id', $village)->get('lkp_village')->row_array();
					$mapuser = array(
						'lkp_project_id' => htmlspecialchars($project, ENT_QUOTES),
						'lkp_partner_id' => htmlspecialchars($this->input->post('user_agency'), ENT_QUOTES),
						'user_id' => $_POST['user_id'],
						'lkp_country_id' => $location['country_id'],
						'lkp_state_id' => $location['state_id'],
						'lkp_district_id' => $location['dist_id'],
						'lkp_block_id' => $location['block_id'],
						'lkp_village_id' => $location['village_id'],
						'added_by' => $this->session->userdata('login_id'),
						'added_datetime' => date('Y-m-d H:i:s'),
						'ip_address' => $this->input->ip_address(),
						'project_user_loc_status' => 1
					);
					$insert = $this->db->insert('rpt_project_partner_user_location', $mapuser);
				}
			}
			
			$result = array(
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'msg' => 'User Details Updated successfully !', 
				'updatestatus' => 1
			);
		} else {
			$result = array(
				'msg' => 'Something went wrong. Please try again later',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'updatestatus' => 0
			);
		}

		echo json_encode($result);
		exit();
	}

	public function delete(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			//get all user
			
			$users = $this->User_model->all_users();

			$header_result = array('main_menu' => $main_menu);

			$result = array('users' => $users);
			$result = $this->security->xss_clean($result);
			$this->load->view('header', $header_result);
			$this->load->view('user/delete', $result);
			$this->load->view('footer');
		}
	}
	//delete User
	public function active_deactive_user()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'status' => 0
			));
			exit();
		}else{
			$active_deactive_user = $this->db->where('user_id', $_POST['user_id'])->update('tbl_users', array('status' => $_POST['status']));
			if($active_deactive_user){
				$result = array(
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
					'msg' => 'User Updated Successfully!',
					'status'=> 1
				);
			} else {
				$result = array(
					'msg' => 'Something went wrong. Please try again later !',
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
					'status'=> 0
				);
			}
			echo json_encode($result);
			exit();
		}
	}

	//reset user password
	public function reset_user_password()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'status' => 0
			));
			exit();
		}

		$password = 'Mpro@123';
		$salt = bin2hex(random_bytes(32));
		$saltedPW = $password.$salt;
		$hashedPW = hash('sha256', $saltedPW);
		$reset_user_password = $this->db->where('user_id', $_POST['user_id'])->update('tbl_users', array(
			'password' => $hashedPW,
			'salt' => $salt
		));

		echo json_encode(array(
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash(),
			'msg' => 'User Password Updated Successfully!',
			'status'=> 1
		));
		exit();
	}
	//Reject user
	public function reject_user()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'status' => 0
			));
			exit();
		}
		$reject_user = $this->db->where('user_id', $_POST['user_id'])->update('tbl_users', array(
			'status' => 2
		));

		echo json_encode(array(
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash(),
			'msg' => 'User Rejected Successfully!',
			'status'=> 1
		));
		exit();
	}
	//Delete user
	public function delete_user()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'status' => 0
			));
			exit();
		}
		$reject_user = $this->db->where('user_id', $_POST['user_id'])->update('tbl_users', array(
			'status' => -1
		));

		echo json_encode(array(
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash(),
			'msg' => 'User Deleted Successfully!',
			'status'=> 1
		));
		exit();
	}

	public function role_capabilities()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			
			$roles_list = $this->User_model->get_rolelist();
			$capability_list = $this->User_model->get_capabilitylist();

			$result = array('roles_list' => $roles_list, 'capability_list' => $capability_list);

			$header_result = array('main_menu' => $main_menu);
			$result = $this->security->xss_clean($result);
			$this->load->view('header', $header_result);
			$this->load->view('user/roles_capabilities', $result);
			$this->load->view('footer');
		}
	}
	public function update_permissions()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'status' => 0
			));
			exit();
		}else{
			
			$update_permissions = $this->User_model->update_permissions();
			
			if(!$update_permissions){
				echo json_encode(array(
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
					'msg'=>'Sorry! Please try after sometime.',
					'status' => 0
				));
				exit();
			}else{
				echo json_encode(array(
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
					'msg'=>'Permission updated successfully.',
					'status' => 1
				));
				exit();
			}
		}
	}

	public function add_role()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			
			$roles_list = $this->User_model->get_rolelist();

			$result = array('roles_list' => $roles_list);

			$header_result = array('main_menu' => $main_menu);
			$result = $this->security->xss_clean($result);
			$this->load->view('header', $header_result);
			$this->load->view('user/add_role', $result);
			$this->load->view('footer');
		}
	}
	public function insert_role()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'status' => 0
			));
			exit();
		}else{
			
			$insert_role = $this->User_model->insert_role();
			
			if(!$insert_role){
				echo json_encode(array(
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
					'msg'=>'Sorry! Please try after sometime.',
					'status' => 0
				));
				exit();
			}else{
				echo json_encode(array(
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
					'msg'=>'Role added successfully.',
					'status' => 1
				));
				exit();
			}
		}
	}

	public function edit_role()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			//get all roles
			
			$roles_list = $this->User_model->get_rolelist();

			$result = array('roles' => $roles_list);			
			$header_result = array('main_menu' => $main_menu);
			$result = $this->security->xss_clean($result);
			$this->load->view('header', $header_result);
			$this->load->view('user/edit_role', $result);
			$this->load->view('footer');
		}
	}
	public function update_role()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'status' => 0
			));
			exit();
		}else{
			//declare vriables
			$role_id = $this->input->post('role_id');
			$role_name = htmlspecialchars($this->input->post('role_name'), ENT_QUOTES);
			$role_description = htmlspecialchars($this->input->post('role_description'), ENT_QUOTES);

			//declare role data array
			$role_data = array(
				'role_name' => $role_name,
				'role_description' => $role_description
			);
			$role_data = $this->security->xss_clean($role_data);
			//update role name and description
			$update_role = $this->db->where('role_id', $role_id)->update('tbl_role', $role_data);
			//check role updated or not
			if($update_role){
				$result = array(
					'status' => 1,
					'msg' => 'Role updated successfully.',
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
				);
			} else {
				$result = array(
					'status' => 0,
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
					'msg' => 'Something went wrong, please try again later',
				);
			}
			echo json_encode($result);
			exit();
		}
	}

	public function delete_role()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			//get all roles
			
			$roles_list = $this->User_model->get_rolelist();
	
			$result = array('roles' => $roles_list);
			$header_result = array('main_menu' => $main_menu);
			$result = $this->security->xss_clean($result);
		    $this->load->view('header', $header_result);
		    $this->load->view('user/delete_role', $result);
		    $this->load->view('footer');
		}
	}
	public function remove_role()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'status' => 0
			));
			exit();
		}else{
			//check this role is assigned to someone or not
			$this->db->select();
			$this->db->from('tbl_users');
			$this->db->where('role_id', $_POST['role_id']);
			$this->db->where('status',1);
			$check = $this->db->get()->num_rows();
			
			if($check == 0) {
				$delete_role = $this->db->where('role_id', $_POST['role_id'])->update('tbl_role', array(
				'status' => 0));
				if($delete_role){
					$result = array(
						'status' => 1,
						'msg' => 'Role Deleted successfully.',
						'csrfName' => $this->security->get_csrf_token_name(),
						'csrfHash' => $this->security->get_csrf_hash(),
					);
				} else {
					$result = array(
						'status' => 0,
						'csrfName' => $this->security->get_csrf_token_name(),
						'csrfHash' => $this->security->get_csrf_hash(),
						'msg' => 'Something went wrong, please try again later'
					);
				}
			} else {
				$result = array(
					'status' => 2,
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
					'msg' => 'This role could not be deleted, role is assigned to some user !'
				);
			}
			echo json_encode($result);
			exit();
		}
	}

	//date august 11 2020, Niranjan

	public function track(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}

		$result = array();
		
		$result['all_users'] = $this->User_model->all_users();

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('user/track', $result);
		$this->load->view('footer');
	}

	public function get_circlebydivision(){
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'status' => 0
			));
			exit();
		}

		$division_ids = $this->input->post('division_ids');

		
		$get_circlebydivision = $this->Helper_model->all_circles($division_ids);

		$result['get_circlebydivision'] = $get_circlebydivision;
		$result['status'] = 1;

		echo json_encode($result);
		exit();
	}

	public function get_user_checkin_checkout_data(){
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'msg' => 'Your session has expired. Please login and try again',
				'status' => 0
			));
			exit();
		}

		$user_ids = $this->input->post('user_ids');
		$date = $this->input->post('date');

		$data = array(
			'user_ids' => $user_ids,
			'date' => $date
		);

		
		$get_user_checkin_checkout_data = $this->User_model->get_user_checkin_checkout_data($data);

		$result['get_user_checkin_checkout_data'] = $get_user_checkin_checkout_data;
		$result['status'] = 1;

		echo json_encode($result);
		exit();
	}
}