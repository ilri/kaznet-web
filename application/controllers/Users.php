<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url');

		$baseurl = base_url();
		$this->load->model('Auth_model');
		$this->load->model('User_model');
		$this->load->model('Helper_model');
		// $session_allowed = $this->Auth_model->match_account_activity();
		// if(!$session_allowed) redirect($baseurl.'auth/logout');
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
		$result['all_roles'] = $all_roles;

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
		$mobile_code = $this->input->post('mobile_code');
		$mobile_number = $mobile_code.$this->input->post('mobile_number');
		if(empty($mobile_number)) {
			$error['mobile_number'] = 'Mobile number is mandatory.';
			$error['status'] = 1;
		}else{
			$check_mobile_number = $this->User_model->check_mobile_number($mobile_number);
			if($check_mobile_number) {
				if($check_mobile_number['status'] == 0) {
					$error['mobile_number'] = 'Mobile Number has been blocked. Please contact admin for more details.';
					$error['status'] = 1;
				} else {
					$error['mobile_number'] = 'Mobile Number is already registered with another user..';
					$error['status'] = 1;
				}
			}
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
					$error['email'] = 'Email Id is already registered with another user..';
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

	public function manage(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}

		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);

		$data = array();
		$user_id = $this->session->userdata('login_id');
		// $this->db->select('users.user_id, tul.country_id,tul.uai_id,tul.sub_loc_id,tul.cluster_id');
		// $this->db->from('tbl_users as users');
		// $this->db->join('tbl_user_unit_location as tul', 'tul.user_id = users.user_id');
		// $this->db->where('users.user_id', $user_id);
		// $this->db->where('tul.status', 1);
		// $loggedin_user_locations_list = $this->db->get()->result_array();
		

		// foreach ($loggedin_user_locations_list as $key => $value) 
		// {
		// 	$data['country_id'][$key]=$value['country_id'];
		// 	$data['uai_id'][$key]=$value['uai_id'];
		// 	$data['sub_loc_id'][$key]=$value['sub_loc_id'];
		// 	$data['cluster_id'][$key]=$value['cluster_id'];
		// }
		
		$this->db->select('users.user_id');
		$this->db->from('tbl_users as users');
		$this->db->where('users.user_id', $user_id);
		$this->db->where('users.status', 1);
		$loggedin_user_locations_list = $this->db->get()->result_array();

		$result = array();
		// print_r($this->db->last_query());exit();
		// print_r($data);exit();
		$this->load->model('User_model');
		
		$contributers = $this->User_model->all_users_without_status(array(), array(8));
		// $contributers = $this->User_model->get_users_location_based(array(), array(8), $data);
		$result['contributers'] = $contributers;

		$cluster_admins = $this->User_model->all_users_without_status(array(), array(6));
		// $cluster_admins = $this->User_model->get_users_location_based(array(), array(6), $data);
		$result['cluster_admins'] = $cluster_admins;

		$disseminations = $this->User_model->all_users_without_status(array(), array(9));
		$result['disseminations'] = $disseminations;

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('menu',$menu_result);
		$this->load->view('user/manage', $result);
		$this->load->view('footer');
	}

	function get_user_data(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}
		// $user_ids = $this->input->post('user_ids');
		$roles = $this->input->post('roles');
		$roles_array = array();
		$roles_array[0]=$roles;
		$result = array();
		// print_r($this->db->last_query());exit();
		// print_r($data);exit();
		$this->load->model('User_model');
		
		// $contributers = $this->User_model->all_users_without_status(array(), array(8));
		$contributers = $this->User_model->all_users_without_status(array(), array());
		$result['contributers'] = $contributers;

		$result['status'] = 1;

		echo json_encode($result);
		exit();

	}

	public function manage_respondent(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}

		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		
		$result = array();

		$user_id = $this->uri->segment(3);
		$result['user_id'] = ($user_id && strlen($user_id) > 0) ? $user_id : null;
		
		$this->load->model('User_model');
		$all_users = $this->User_model->all_users(($user_id ? array($user_id) : array()), array(8));
		$result['contributers'] = $all_users;

		$tasks = $this->db->where('status', 1)->get('form')->result_array();
		$result['tasks'] = $tasks;

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('menu',$menu_result);
		$this->load->view('user/manage_respondent', $result);
		$this->load->view('footer');
	}
	public function get_assigned_location(){
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

		if(!$this->input->post('contributer') || $this->input->post('contributer') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}
		if(!$this->input->post('loc_type') || $this->input->post('loc_type') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}

		$loc_type = $this->input->post('loc_type');
		$contributer = $this->input->post('contributer');

		// Get contributer's current location
		if($loc_type == 'uai') {
			if($this->input->post('uai') && $this->input->post('uai') != '') {
				$uai = $this->input->post('uai');
				
				$this->db->distinct()->select('ls.sub_loc_id AS id, ls.location_name AS name')->from('lkp_sub_location AS ls');
				$this->db->join('tbl_user_unit_location AS tuul', 'tuul.sub_loc_id = ls.sub_loc_id');
				$this->db->where('tuul.user_id', $contributer)->where('tuul.uai_id', $uai)->where('tuul.status', 1);
				$locations = $this->db->where('ls.status', 1)->get()->result_array();
			} else {
				$this->db->distinct()->select('lu.uai_id AS id, lu.uai AS name')->from('lkp_uai AS lu');
				$this->db->join('tbl_user_unit_location AS tuul', 'tuul.uai_id = lu.uai_id');
				$this->db->where('tuul.user_id', $contributer)->where('tuul.status', 1);
				$locations = $this->db->where('lu.status', 1)->get()->result_array();
			}
		} else if($loc_type == 'cluster') {
			$this->db->distinct()->select('lc.cluster_id AS id, lc.name AS name')->from('lkp_cluster AS lc');
			$this->db->join('tbl_user_unit_location AS tuul', 'tuul.cluster_id = lc.cluster_id');
			$this->db->where('tuul.user_id', $contributer)->where('tuul.status', 1);
			$locations = $this->db->where('lc.status', 1)->get()->result_array();
		}

		$result['status'] = 1;
		$result['locations'] = $locations;

		echo json_encode($result);
		exit();
	}
	public function get_assigned_repondent(){
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

		if(!$this->input->post('contributer') || $this->input->post('contributer') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

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

		$contributer = $this->input->post('contributer');
		$loc_type = $this->input->post('loc_type');
		$location = $this->input->post('location');

		// Get all respondent acc to contributer and location
		$this->db->where(array(
			'status' => 1,
			'added_by' => $contributer
		));
		if($loc_type == 'cluster') $this->db->where('cluster_id', $location);
		else if($loc_type == 'uai') $this->db->where('sub_location_id', $location);
		$respondents = $this->db->get('tbl_respondent_users')->result_array();

		$result['status'] = 1;
		$result['respondents'] = $respondents;

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

		$survey = $this->input->post('task');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$respondents = $this->input->post('respondents');
		if((!isset($survey) || strlen($survey) === 0)
		|| (!isset($start_date) || strlen($start_date) === 0)
		|| (!isset($end_date) || strlen($end_date) === 0)
		|| (!isset($respondents) || count($respondents) === 0)) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}

		// Get survey details
		$survDetails = $this->db->where('id', $survey)->get('form')->row_array();

		// Get contributer details
		$contriDetails = $this->db->where('user_id', $this->input->post('contributer'))->get('tbl_users')->row_array();
		
		$succResps = array();
		$errorResps = array();

		$insertArray = array();
		foreach ($respondents as $key => $resp) {
			// Get respondent details
			$respDetails = $this->db->where('data_id', $resp)->get('tbl_respondent_users')->row_array();
			
			// Check if repondent is already assigned to this task
			$assignment = $this->db->where(array(
				'status' => 1,
				'survey_id' => $survey,
				'respondent_id' => $resp
			))->get('tbl_survey_assignee');
			if($assignment->num_rows() > 0) {
				array_push($errorResps, ($respDetails['first_name'].' '.$respDetails['last_name']));
			} else {
				array_push($succResps, ($respDetails['first_name'].' '.$respDetails['last_name']));

				array_push($insertArray, array(
					'survey_id' => $survey,
					'user_id' => $this->input->post('contributer'),
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
			$this->db->where('user_id', $this->input->post('contributer'))->where('status', 1);
			$usertoken = $this->db->get('tbl_push_notification')->result_array();
			foreach ($usertoken as $tkey => $utoken) {
				array_push($pushtoken, $utoken['token']);
			}

			define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');

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

		$result['status'] = 1;
		$msg = '';
		if(count($succResps) > 0) {
			$msg .= 'Task has been successfully assigned to '.implode(', ', $succResps);
		}
		if(count($errorResps) > 0) {
			if(count($errorResps) == count($respondents)) $result['status'] = 0;
			$msg .= 'Unable to assign '.implode(', ', $errorResps).' to the task. Because they are already assigned.';
		}
		$result['msg'] = $msg;

		echo json_encode($result);
		exit();
	}
	
	public function manage_location(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}

		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		
		$result = array();

		$user_id = $this->uri->segment(3);
		$result['user_id'] = ($user_id && strlen($user_id) > 0) ? $user_id : null;
		
		$this->load->model('User_model');
		
		$contributers = $this->User_model->all_users(($user_id ? array($user_id) : array()), array(8));
		$result['contributers'] = $contributers;

		$cluster_admins = $this->User_model->all_users(($user_id ? array($user_id) : array()), array(6));
		$result['cluster_admins'] = $cluster_admins;

		// Get all countries
		$countries = $this->db->where('status', 1)->get('lkp_country')->result_array();
		$result['countries'] = $countries;

		// if user id is not empty get user locations for display if already assign locations
		if($user_id && strlen($user_id) > 0){
			$this->db->distinct()->select('*');
			$this->db->where('user_id',$user_id);
			$locations = $this->db->where('status', 1)->get('tbl_user_unit_location')->result_array();
			$result['locations'] = $locations;
			// echo"<pre>";print_r($locations);echo"</pre>";exit;
		}

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('menu',$menu_result);
		$this->load->view('user/manage_location', $result);
		$this->load->view('footer');
	}

	public function manage_contributer_location(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}

		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		
		$result = array();

		$user_id = $this->uri->segment(3);
		$logged_in_user_id = $this->session->userdata('login_id');
		$result['user_id'] = ($user_id && strlen($user_id) > 0) ? $user_id : null;
		
		$this->load->model('User_model');
		
		$contributers = $this->User_model->all_users(($user_id ? array($user_id) : array()), array(8));
		$result['contributers'] = $contributers;

		// $cluster_admins = $this->User_model->all_users(($user_id ? array($user_id) : array()), array(6));
		// $result['cluster_admins'] = $this->security->xss_clean($cluster_admins);

		// Get all countries
		$countries = $this->db->where('status', 1)->get('lkp_country')->result_array();
		$result['countries'] = $countries;

		// if user id is not empty get user locations for display if already assign 
		$locations = array();
		if($user_id && strlen($user_id) > 0){
			$this->db->distinct()->select('*');
			$this->db->where('user_id',$user_id);
			$locations = $this->db->where('status', 1)->get('tbl_user_unit_location')->result_array();
			$result['locations'] = $locations;
		}else{
			// $this->db->distinct()->select('*');
			// $this->db->where('user_id',$logged_in_user_id);
			// $locations = $this->db->where('status', 1)->get('tbl_user_unit_location')->result_array();
			// $result['locations'] = $this->security->xss_clean($locations);
			$locations = array();
		}

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('menu',$menu_result);
		$this->load->view('user/manage_contributer_location', $result);
		$this->load->view('footer');
	}
	public function manage_cluster_location(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}

		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		
		$result = array();

		$user_id='';
		if(($this->uri->segment(3)) != NULL){
			$user_id = $this->uri->segment(3);
		}
		$logged_in_user_id = $this->session->userdata('login_id');
		$result['user_id'] = ($user_id && strlen($user_id) > 0) ? $user_id : null;
		
		$this->load->model('User_model');
		
		// $contributers = $this->User_model->all_users(($user_id ? array($user_id) : array()), array(8));
		// $result['contributers'] = $this->security->xss_clean($contributers);

		$cluster_admins = $this->User_model->all_users(($user_id ? array($user_id) : array()), array(6));
		$result['cluster_admins'] = $cluster_admins;

		// Get all countries
		$countries = $this->db->where('status', 1)->get('lkp_country')->result_array();
		$result['countries'] = $countries;
		
		// if user id is not empty get user locations for display if already assign locations
		if($user_id && strlen($user_id) > 0){
			$this->db->distinct()->select('*');
			$this->db->where('user_id',$user_id);
			$locations = $this->db->where('status', 1)->get('tbl_user_unit_location')->result_array();
			$result['locations'] = $locations;
		}else{
			if($logged_in_user_id==1){
				$this->db->distinct()->select('*');
				$locations = $this->db->where('status', 1)->get('tbl_user_unit_location')->result_array();
				$result['locations'] = $locations;
			}else{
				$this->db->distinct()->select('*');
				$this->db->where('user_id',$logged_in_user_id);
				$locations = $this->db->where('status', 1)->get('tbl_user_unit_location')->result_array();
				$result['locations'] = $locations;
			}		
		}

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('menu',$menu_result);
		$this->load->view('user/manage_cluster_location', $result);
		$this->load->view('footer');
	}

	public function get_location_by_user(){
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
		$user_id = $this->input->post('user_id');
		$this->db->distinct()->select('*');
		$this->db->where('user_id',$user_id);
		$locations = $this->db->where('status', 1)->get('tbl_user_unit_location')->result_array();
		$unique_uai_id = array();
		$unique_sub_loc_id = array();
		$unique_cluster_id = array();
		$unique_country_id = array();
		if(isset($locations)){
			$unique_uai_id = array_unique(array_column($locations, 'uai_id'));
			$unique_sub_loc_id = array_unique(array_column($locations, 'sub_loc_id'));
			$unique_cluster_id = array_unique(array_column($locations, 'cluster_id'));
			$unique_country_id = array_unique(array_column($locations, 'country_id'));
		}
		$result['country'] = $unique_country_id;
		$result['uais'] = $unique_uai_id;
		$result['sub_locs'] = $unique_sub_loc_id;
		$result['clusters'] = $unique_cluster_id;

		// Get all countries
		$countries = $this->db->where('status', 1)->get('lkp_country')->result_array();
		$result['countries'] = $countries;
		// Get all uais
		$uai_list = $this->db->where('status', 1)->get('lkp_uai')->result_array();
		$result['uai_list'] = $uai_list;
		// Get all uais
		$sub_loc_list = $this->db->where('status', 1)->get('lkp_sub_location')->result_array();
		$result['sub_loc_list'] = $sub_loc_list;
		// Get all uais
		$cluster_list = $this->db->where('status', 1)->get('lkp_cluster')->result_array();
		$result['cluster_list'] = $cluster_list;

		echo json_encode($result);
		exit();
	}

	public function get_user_role(){
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

		if(!$this->input->post('contributer') || $this->input->post('contributer') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}

		$contributer = $this->input->post('contributer');

		// Get user role
		$userDetails = $this->db->where('user_id', $contributer)->get('tbl_users');
		if($userDetails->num_rows() === 0) {
			$result['status'] = 0;
			$result['msg'] = 'Unable to get user details. Please refresh the page and try again.';
		} else {
			$userDetails = $userDetails->row_array();
			
			$result['status'] = 1;
			$result['role'] = $userDetails['role_id'];
		}

		echo json_encode($result);
		exit();
	}
	public function get_location_for_mapping(){
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
		if(!$this->input->post('contributer') || $this->input->post('contributer') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}

		$loc_type = $this->input->post('loc_type');
		$country = $this->input->post('country');
		$contributer = $this->input->post('contributer');

		$assigned = array(
			'clusters' => array(),
			'sub_locs' => array()
		);
		// Get contributer's current location
		if($loc_type == 'uai') {
			$this->db->distinct()->select('sub_loc_id')->from('tbl_user_unit_location');
			$this->db->where('user_id', $contributer)->where('country_id', $country);
			$this->db->where('sub_loc_id IS NOT NULL')->where('status', 1);
			$sub_locs = $this->db->get()->result_array();
			foreach ($sub_locs as $key => $loc) {
				array_push($assigned['sub_locs'], $loc['sub_loc_id']);
			}
		} else if($loc_type == 'cluster') {
			$this->db->distinct()->select('cluster_id')->from('tbl_user_unit_location');
			$this->db->where('user_id', $contributer)->where('country_id', $country);
			$this->db->where('cluster_id IS NOT NULL')->where('status', 1);
			$clusters = $this->db->get()->result_array();
			foreach ($clusters as $key => $loc) {
				array_push($assigned['clusters'], $loc['cluster_id']);
			}
		}

		// Get all clusters
		$clusters = $this->db->where('country_id', $country)->where('status', 1)->get('lkp_cluster')->result_array();
		// Get all uais
		$uais = $this->db->where('country_id', $country)->where('status', 1)->get('lkp_uai')->result_array();
		for ($uaiIndex=0; $uaiIndex < count($uais); $uaiIndex++) { 
			$uai = $uais[$uaiIndex];

			// Get all sub_location
			$slocs = $this->db->where('uai_id', $uai['uai_id'])->where('status', 1)->get('lkp_sub_location')->result_array();
			$uais[$uaiIndex]['sub_locs'] = $slocs;
		}

		$result['status'] = 1;
		$result['uais'] = $uais;
		$result['clusters'] = $clusters;
		$result['assigned'] = $assigned;

		echo json_encode($result);
		exit();
	}
	public function get_location_for_cluster(){
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

		if(!$this->input->post('contributer') || $this->input->post('contributer') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}

		// $loc_type = $this->input->post('loc_type');
		$country = $this->input->post('country');
		$contributer = $this->input->post('contributer');

		$assigned = array(
			'clusters' => array(),
			'sub_locs' => array()
		);
		// Get contributer's current location
		// if($loc_type == 'uai') {
			$this->db->distinct()->select('sub_loc_id')->from('tbl_user_unit_location');
			$this->db->where('user_id', $contributer)->where('country_id', $country);
			$this->db->where('sub_loc_id IS NOT NULL')->where('status', 1);
			$sub_locs = $this->db->get()->result_array();
			foreach ($sub_locs as $key => $loc) {
				array_push($assigned['sub_locs'], $loc['sub_loc_id']);
			}
		// } else if($loc_type == 'cluster') {
			$this->db->distinct()->select('cluster_id')->from('tbl_user_unit_location');
			$this->db->where('user_id', $contributer)->where('country_id', $country);
			$this->db->where('cluster_id IS NOT NULL')->where('status', 1);
			$clusters = $this->db->get()->result_array();
			foreach ($clusters as $key => $loc) {
				array_push($assigned['clusters'], $loc['cluster_id']);
			}
		// }

		// Get all clusters
		$clusters = $this->db->where('country_id', $country)->where('status', 1)->get('lkp_cluster')->result_array();
		// Get all uais
		$uais = $this->db->where('country_id', $country)->where('status', 1)->get('lkp_uai')->result_array();
		for ($uaiIndex=0; $uaiIndex < count($uais); $uaiIndex++) { 
			$uai = $uais[$uaiIndex];

			// Get all sub_location
			$slocs = $this->db->where('uai_id', $uai['uai_id'])->where('status', 1)->get('lkp_sub_location')->result_array();
			$uais[$uaiIndex]['sub_locs'] = $slocs;
		}

		$result['status'] = 1;
		$result['uais'] = $uais;
		$result['clusters'] = $clusters;
		$result['assigned'] = $assigned;

		echo json_encode($result);
		exit();
	}
	public function get_location_by_country(){
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
		if(!$this->input->post('country') || $this->input->post('country') == '') {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';

			echo json_encode($result);
			exit();
		}
		

		$loc_type = $this->input->post('loc_type');
		$country = $this->input->post('country');
		// $contributer = $this->input->post('contributer');

		// Get all clusters
		$clusters = $this->db->where('country_id', $country)->where('status', 1)->get('lkp_cluster')->result_array();
		// Get all uais
		$uais = $this->db->where('country_id', $country)->where('status', 1)->get('lkp_uai')->result_array();
		// Get all sub_location
		$slocs = $this->db->where('country_id', $country)->where('status', 1)->get('lkp_sub_location')->result_array();

		$result['status'] = 1;
		$result['uais'] = $uais;
		$result['clusters'] = $clusters;
		$result['slocs'] = $slocs;

		echo json_encode($result);
		exit();
	}

	public function getSubLocationByUai(){
		$uai_id = $this->input->post('uai_id');
		$options = '';
		$options .= '<option value="">Select Sub Location </option>';
		if(!empty($uai_id)){
			$sub_locations = $this->db->where('uai_id', $uai_id)->where('status', 1)->get('lkp_sub_location')->result_array();
			if(!empty($sub_locations)){
				$columns = array_column($sub_locations, "location_name");
				array_multisort($columns, SORT_ASC, $sub_locations);
				foreach ($sub_locations as $key => $uvalue) {
					$options .= '<option value="'.$uvalue['sub_loc_id'].'">'.$uvalue['location_name'].'</option>';
				}
			}
			
		}
		echo $options;
		die();
	}

	public function map_contributer_location(){
		try{
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

			$loc_type = $this->input->post('loc_type');
			$country = $this->input->post('country');
			$contributer = $this->input->post('contributer');
			$uai = $this->input->post('uai');
			$sub_loc_id = $this->input->post('sub_loc');
			$cluster = $this->input->post('cluster');
			// $locatios = $this->input->post('location');
			if(!empty($uai)){
				if((!$uai)) {
					$result['status'] = 0;
					$result['msg'] = 'Please select some Uai location.';
		
					echo json_encode($result);
					exit();
				}
			}
			if(!empty($cluster)){
				// echo json_encode($cluster);
				// exit();
				if(!$cluster){
					$result['status'] = 0;
					$result['msg'] = 'Please select cluster.';
		
					echo json_encode($result);
					exit();
				}
			}
			// Delete all previously assigned locations
			if($loc_type == 'uai') {
				$this->db->where('user_id', $contributer)->where('country_id', $country);
				$this->db->where('sub_loc_id IS NOT NULL')->delete('tbl_user_unit_location');

				$this->db->where('user_id', $contributer)->where('country_id', $country);
				$this->db->where('cluster_id IS NOT NULL')->delete('tbl_user_unit_location');
			} else if($loc_type == 'cluster') {

				$this->db->where('user_id', $contributer)->where('country_id', $country);
				$this->db->where('cluster_id IS NOT NULL')->delete('tbl_user_unit_location');

				$this->db->where('user_id', $contributer)->where('country_id', $country);
				$this->db->where('sub_loc_id IS NOT NULL')->delete('tbl_user_unit_location');
			}

			$locInsertArray = array();
			$locNamesArray = array();
			// foreach ($locatios as $key => $loc) {
				// Insert new location
				if($loc_type == 'uai') {
					// Get uai id of sub location
					// $locDetail = $this->db->where('sub_loc_id', $loc)->where('status', 1)->get('lkp_sub_location')->row_array();
					// Get uai name
					$uaiDetail = $this->db->where('uai_id', $uai)->get('lkp_uai')->row_array();
					array_push($locNamesArray, $uaiDetail['uai']);

					array_push($locInsertArray, array(
						'user_id' => $contributer,
						'country_id' => $country,
						'uai_id' => $uai,
						'sub_loc_id' => $sub_loc_id,
						'added_by' => $this->session->userdata('login_id'),
						'added_datetime' => date('Y-m-d H:i:s'),
						'ip_address' => $this->input->ip_address()
					));
				} else if($loc_type == 'cluster') {
					// print_r("test");exit();
					// Get cluster name
					$clusterDetail = $this->db->where('cluster_id', $cluster)->get('lkp_cluster')->row_array();
					array_push($locNamesArray, $clusterDetail['name']);
					
					array_push($locInsertArray, array(
						'user_id' => $contributer,
						'country_id' => $country,
						'cluster_id' => $cluster,
						'added_by' => $this->session->userdata('login_id'),
						'added_datetime' => date('Y-m-d H:i:s'),
						'ip_address' => $this->input->ip_address()
					));
				}
			// }
			if(count($locNamesArray) > 0) {
				$this->db->insert_batch('tbl_user_unit_location', $locInsertArray);

				// Send Push to Contributer
				$pushtoken = array();
				// Get user's device tokens to send push
				$this->db->distinct()->select('token');
				$this->db->where('user_id', $this->input->post('contributer'))->where('status', 1);
				$usertoken = $this->db->get('tbl_push_notification')->result_array();
				foreach ($usertoken as $tkey => $utoken) {
					array_push($pushtoken, $utoken['token']);
				}

				// Get contributer details
				$contriDetails = $this->db->where('user_id', $contributer)->get('tbl_users')->row_array();

				define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');

				if(count($pushtoken) > 0) {
					$msg = array(
						'body'		=> "Dear ".$contriDetails['first_name']." ".$contriDetails['last_name'].",\n
									".implode(', ', $locNamesArray)." has been mapped to your account by the Administrator. Please sync the application and you can submit the data for the new location(s).\n
									Kindly reach out to the administrator adminkaznet@ilri.org in case of any further questions or assistance",
						'title'		=> "Location ".implode(', ', $locNamesArray)." have been assigned to you.",
						// 'content'	=> json_encode($content),
						'type'		=> "general",
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
					if ($ch === false) {
						die('Failed to initialize cURL');
					}
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

			$result['status'] = 1;
			$result['msg'] = 'Location assigned successfully.';

			echo json_encode($result);
			exit();
		}catch (Exception $e) {
			// Handle the exception
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	public function map_cluster_location(){
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

		// $loc_type = $this->input->post('loc_type');
		$country = $this->input->post('country');
		$contributer = $this->input->post('contributer');
		$cluster_location = $this->input->post('cluster_location');
		$uai_location = $this->input->post('uai_location');

		$uailocInsertArray = array();
		$locInsertArray = array();
		$locNamesArray = array();
		if(!empty($cluster_location)){
			if(!$cluster_location || count($cluster_location) == 0) {
				$result['status'] = 0;
				$result['msg'] = 'Please select some cluster.';
	
				echo json_encode($result);
				exit();
			}
			
			// Delete all previously assigned locations
			$this->db->where('user_id', $contributer)->where('country_id', $country);
			$this->db->where('cluster_id IS NOT NULL')->delete('tbl_user_unit_location');

			foreach($cluster_location as $key => $loc){
				// Get cluster name
				$clusterDetail = $this->db->where('cluster_id', $loc)->get('lkp_cluster')->row_array();
				array_push($locNamesArray, $clusterDetail['name']);
				
				array_push($locInsertArray, array(
					'user_id' => $contributer,
					'country_id' => $country,
					'cluster_id' => $loc,
					'added_by' => $this->session->userdata('login_id'),
					'added_datetime' => date('Y-m-d H:i:s'),
					'ip_address' => $this->input->ip_address()
				));
			}
			$this->db->insert_batch('tbl_user_unit_location', $locInsertArray);
		}
			
		
		if(!empty($uai_location)){
			if(!$uai_location || count($uai_location) == 0) {
				$result['status'] = 0;
				$result['msg'] = 'Please select some uai.';
	
				echo json_encode($result);
				exit();
			}
			// Delete all previously assigned locations
			$this->db->where('user_id', $contributer)->where('country_id', $country);
			$this->db->where('sub_loc_id IS NOT NULL')->delete('tbl_user_unit_location');
			
			foreach ($uai_location as $key => $loc) {
				// Insert new UAI location
				// Get uai id of sub location
				$locDetail = $this->db->where('sub_loc_id', $loc)->where('status', 1)->get('lkp_sub_location')->row_array();
				// Get uai name
				$uaiDetail = $this->db->where('uai_id', $locDetail['uai_id'])->get('lkp_uai')->row_array();
				array_push($locNamesArray, $uaiDetail['uai']);

				array_push($uailocInsertArray, array(
					'user_id' => $contributer,
					'country_id' => $country,
					'uai_id' => $locDetail['uai_id'],
					'sub_loc_id' => $loc,
					'added_by' => $this->session->userdata('login_id'),
					'added_datetime' => date('Y-m-d H:i:s'),
					'ip_address' => $this->input->ip_address()
				));
			}
			$this->db->insert_batch('tbl_user_unit_location', $uailocInsertArray);
		}
		
		if(count($locNamesArray) > 0) {
			// Send Push to Contributer
			$pushtoken = array();
			// Get user's device tokens to send push
			$this->db->distinct()->select('token');
			$this->db->where('user_id', $this->input->post('contributer'))->where('status', 1);
			$usertoken = $this->db->get('tbl_push_notification')->result_array();
			foreach ($usertoken as $tkey => $utoken) {
				array_push($pushtoken, $utoken['token']);
			}

			// Get contributer details
			$contriDetails = $this->db->where('user_id', $contributer)->get('tbl_users')->row_array();

			define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');

			if(count($pushtoken) > 0) {
				$msg = array(
					'body'		=> "Dear ".$contriDetails['first_name']." ".$contriDetails['last_name'].",\n
								".implode(', ', $locNamesArray)." has been mapped to your account by the Administrator. Please sync the application and you can submit the data for the new location(s).\n
								Kindly reach out to the administrator adminkaznet@ilri.org in case of any further questions or assistance",
					'title'		=> "Location ".implode(', ', $locNamesArray)." have been assigned to you.",
					// 'content'	=> json_encode($content),
					'type'		=> "general",
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

			$result['status'] = 1;
			$result['msg'] = 'Location assigned successfully.';
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
		$result['users'] = $all_users;

		$this->load->model('Helper_model');
		$all_units = $this->Helper_model->all_units();
		$result['units'] = $all_units;

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
			$result = $result;
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
		$result = $result;
		
		
		$user_details = $this->User_model->get_user_details($_POST['user_id']);
		$result['user_details'] = $user_details;
		// if($user_details['status']==1){

		// }
		// $result['user_details'] = $this->security->xss_clean($user_details);
		echo json_encode($result);
		exit();
	}

	//get user phone number already exists
	public function check_user_number()
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
		$result = $result;
		$usernumber = $this->input->post('usernumber');
		$this->db->select('users.user_id, users.username, users.email_id, users.first_name, users.last_name, users.mobile_number');
		$this->db->from('tbl_users as users');
		// $this->db->join('tbl_role as role', 'role.role_id = users.role_id');
		$this->db->where('users.mobile_number', $_POST['usernumber']);
		$this->db->where('users.status', 1);
		// $this->db->where('role.status', 1);
		$user_details = $this->db->get()->row_array();
		print($this->db->last_query());exit();
		
		// $user_details = $this->User_model->get_user_details($_POST['usernumber']);
		$result['user_details'] = $user_details;
		// if($user_details['status']==1){

		// }
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
			$result['users'] = $users;

			
			$all_roles = $this->User_model->all_roles();
			$result['all_roles'] = $all_roles;

			$this->load->model('Projects_model');
			$projects = $this->Projects_model->all_project();
			$result['projects'] = $projects;

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
			$data = $data;
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
			$result = $result;
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
		$data = $data;
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
			$result = $result;
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
			$result = $result;
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
			$result = $result;
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
			$result = $result;
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
			$role_data = $role_data;
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
			$result = $result;
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

	public function termsandconditions()
	{
		$result = array();
		
		$this->load->view('header');
		// $this->load->view('menu');
		// $this->load->view('sidebar');
		$this->load->view('user/terms_conditions', $result);
		$this->load->view('footer');
		
	}
}