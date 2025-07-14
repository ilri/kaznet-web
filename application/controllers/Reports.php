<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url');

		$baseurl = base_url();
		$this->load->model('Auth_model');
		// $session_allowed = $this->Auth_model->match_account_activity();
		// if(!$session_allowed) redirect($baseurl.'auth/logout');
		
        $this->load->model('FormModel');
	}
	
	public function index(){
		/*$this->load->model('Employee_m', 'm');
		$data['posts'] = $this->m->getEmployee();*/
	    $this->load->view('product_admin/index');
	    $this->load->view('product_admin/side_nav');
	    $this->load->view('product_admin/header');
	    $this->load->view('product_admin/footer');	
	}

	
	public function view_dashboard1(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$user_id = $this->session->userdata('login_id');
		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		$result =array();

		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();

        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('menu',$menu_result);
		$this->load->view('reports/dashboard1', $result);
		$this->load->view('footer');
	}

	public function payment_report(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$survey_id = $this->uri->segment(3);
		$user_id = $this->session->userdata('login_id');
		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		$result =array();

		$this->db->select('*');
		$this->db->where('status', 1);
		$surveys = $this->db->get('form')->result_array();
		// foreach ($surveys as $key => $surv) {
			
		// 	// Get approved
		// 	$this->db->distinct()->select('*');
		// 	$this->db->where('pa_verified_status',2);
		// 	$approved = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();

		// 	if($approved) $surveys[$key]['approved'] = $approved;
		// 	else $surveys[$key]['approved'] = 0;

		// 	// get submitted
		// 	$this->db->distinct()->select('*');
		// 	$this->db->where('pa_verified_status',1);
		// 	$submitted = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();

		// 	if($submitted) $surveys[$key]['submitted'] = $submitted;
		// 	else $surveys[$key]['submitted'] = 0;

		// 	// get rejected
		// 	$this->db->distinct()->select('*');
		// 	$this->db->where('pa_verified_status',3);
		// 	$rejected = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();

		// 	if($rejected) $surveys[$key]['rejected'] = $rejected;
		// 	else $surveys[$key]['rejected'] = 0;

		// 	$payment_list =$this->db->select('price_per_survey')->where('survey_id', $surv['id'])->where('status', 1)->get('lkp_payment')->row_array();
		// 	if(!empty($payment_list)){
		// 		$surveys[$key]['payment_amount'] = $payment_list['price_per_survey'] * $surveys[$key]['approved'];
		// 	}else{
		// 		$surveys[$key]['payment_amount'] = "";
		// 	}
		// }
		// $result['surveys_tasks'] = $surveys;

		$this->db->select('*');
		$this->db->where('role_id', 8);
		$this->db->where('status', 1);
		$users_list = $this->db->get('tbl_users')->result_array();

		// $contributor_list = $this->db->select('tu.*,tsa.*')->from('tbl_users as tu')->join('tbl_survey_assignee AS tsa', 'tsa.user_id = tu.user_id')->where('tu.role_id',8)->where('tu.status',1)->where('tsa.status',1)->group_by('tsa.user_id')->get()->result_array();
		// foreach ($users_list as $ukey => $user) {
		// 	$payment_amount=0;
		// 	$approved_value=0;
		// 	$submitted_value=0;
		// 	$rejected_value=0;
		// 	$this->db->distinct('survey_id');
		// 	$this->db->select('*');
		// 	$this->db->where('user_id', $user['user_id']);		
		// 	$contributor_list = $this->db->where('status', 1)->get('tbl_survey_assignee')->result_array();

		// 	foreach ($contributor_list as $ckey => $contributor) {
		// 		$payment_list =$this->db->select('price_per_survey')->where('survey_id', $surv['id'])->where('status', 1)->get('lkp_payment')->row_array();
		// 		if(!empty($payment_list)){
		// 			$temp_payment= $payment_list['price_per_survey'];
		// 		}else{
		// 			$temp_payment= 0;
		// 		}
		// 		$payment_amount =$payment_amount+$temp_payment;
				
		// 		// Get approved
		// 		$this->db->distinct()->select('*');
		// 		$this->db->where('pa_verified_status',2);
		// 		$approved = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();				

		// 		$temp_approved= $approved;
		// 		$approved_value =$approved_value+$temp_approved;
	
		// 		// get submitted
		// 		$this->db->distinct()->select('*');
		// 		$this->db->where('pa_verified_status',1);
		// 		$submitted = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();
		// 		$temp_submitted= $submitted;
		// 		$submitted_value =$submitted_value+$temp_submitted;			
	
		// 		// get rejected
		// 		$this->db->distinct()->select('*');
		// 		$this->db->where('pa_verified_status',3);
		// 		$rejected = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();
		// 		$temp_rejected= $rejected;
		// 		$rejected_value =$rejected_value+$temp_rejected;

				

				
		// 	}
		// 	$users_list[$ukey]['payment_amount'] = $payment_amount;
		// 	if($approved_value) $users_list[$ukey]['approved'] = $approved_value;
		// 		else $users_list[$ukey]['approved'] = 0;

		// 	if($submitted_value) $users_list[$ukey]['submitted'] = $submitted_value;
		// 		else $users_list[$ukey]['submitted'] = 0;

		// 	if($rejected_value) $users_list[$ukey]['rejected'] = $rejected_value;
		// 		else $users_list[$ukey]['rejected'] = 0;
		// 	$users_list[$ukey]['contributor_name'] = $user['first_name']." ".$user['last_name'];
			
		// }
		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();

		// Get all tasks types
		$tasks_types = $this->db->distinct()->select('type')->where('status', 1)->get('form')->result_array();
		$result['tasks_types'] = $tasks_types;

		$result['contributor_list'] = $users_list;
		$result['status'] =1;

        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('menu',$menu_result);
		$this->load->view('reports/payment_report', $result);
		$this->load->view('footer');
	}

	public function get_payment_report_tasks(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$survey_id = $this->uri->segment(3);
		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);

		$country_id = $this->input->post('country_id');
		$uai_id = $this->input->post('uai_id');
		$sub_location_id = $this->input->post('sub_location_id');
		$cluster_id = $this->input->post('cluster_id');
		$contributor_id = $this->input->post('contributor_id');
		$respondent_id = $this->input->post('respondent_id');
		$user_id = $this->session->userdata('login_id');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$tasks = $this->input->post('tasks');
		
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
			"page_no" => $page_no,
			"record_per_page" => $record_per_page,
			"start_date" => $start_date,
			"end_date" => $end_date,
			"tasks" => $tasks,
			"is_pagination" => $this->input->post('pagination') != null
		);
		$this->load->model('Reports_model');
		$result =array();
		// if(!empty($data['respondent_id'])) {
		// 	$this->db->select('data_id');
		// 	$this->db->where('data_id', $data['respondent_id']);
		// 	$respondent_list = $this->db->where('status', 1)->get('tbl_respondent_users')->row_array();
		// 	// var_dump($this->db->last_query());exit;
		// }
		$tasks_count=0;
		// $this->db->select('*');
		// $this->db->where('status', 1);
		// $surveys = $this->db->get('form')->result_array();
		// foreach ($surveys as $key => $surv) {
		// 	$tasks_count++;
		// 	// Get approved
		// 	$this->db->distinct()->select('*');
		// 	$this->db->where('pa_verified_status',2);
		// 	if(!empty($data['country_id'])) {
		// 		$this->db->where('country_id', $data['country_id']);
		// 	}
		// 	if(!empty($data['cluster_id'])) {
		// 		$this->db->where('cluster_id', $data['cluster_id']);
		// 	}
		// 	if(!empty($data['uai_id'])) {
		// 		$this->db->where('uai_id', $data['uai_id']);
		// 	}
		// 	if(!empty($data['sub_location_id'])) {
		// 		$this->db->where('sub_location_id', $data['sub_location_id']);
		// 	}
		// 	if(!empty($data['contributor_id'])) {
		// 		$this->db->where('user_id', $data['contributor_id']);
		// 	}
		// 	if(!empty($data['respondent_id'])) {
		// 		$this->db->where('respondent_data_id', $respondent_list['data_id']);
		// 	}
		// 	$approved = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();

		// 	if($approved) $surveys[$key]['approved'] = $approved;
		// 	else $surveys[$key]['approved'] = 0;

		// 	// get submitted
		// 	$this->db->distinct()->select('*');
		// 	$this->db->where('pa_verified_status',1);
		// 	if(!empty($data['country_id'])) {
		// 		$this->db->where('country_id', $data['country_id']);
		// 	}
		// 	if(!empty($data['cluster_id'])) {
		// 		$this->db->where('cluster_id', $data['cluster_id']);
		// 	}
		// 	if(!empty($data['uai_id'])) {
		// 		$this->db->where('uai_id', $data['uai_id']);
		// 	}
		// 	if(!empty($data['sub_location_id'])) {
		// 		$this->db->where('sub_location_id', $data['sub_location_id']);
		// 	}
		// 	if(!empty($data['contributor_id'])) {
		// 		$this->db->where('user_id', $data['contributor_id']);
		// 	}
		// 	if(!empty($data['respondent_id'])) {
		// 		$this->db->where('respondent_data_id', $respondent_list['data_id']);
		// 	}
		// 	$submitted = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();

		// 	if($submitted) $surveys[$key]['submitted'] = $submitted;
		// 	else $surveys[$key]['submitted'] = 0;

		// 	// get rejected
		// 	$this->db->distinct()->select('*');
		// 	$this->db->where('pa_verified_status',3);
		// 	if(!empty($data['country_id'])) {
		// 		$this->db->where('country_id', $data['country_id']);
		// 	}
		// 	if(!empty($data['cluster_id'])) {
		// 		$this->db->where('cluster_id', $data['cluster_id']);
		// 	}
		// 	if(!empty($data['uai_id'])) {
		// 		$this->db->where('uai_id', $data['uai_id']);
		// 	}
		// 	if(!empty($data['sub_location_id'])) {
		// 		$this->db->where('sub_location_id', $data['sub_location_id']);
		// 	}
		// 	if(!empty($data['contributor_id'])) {
		// 		$this->db->where('user_id', $data['contributor_id']);
		// 	}
		// 	if(!empty($data['respondent_id'])) {
		// 		$this->db->where('respondent_data_id', $respondent_list['data_id']);
		// 	}
		// 	$rejected = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();

		// 	if($rejected) $surveys[$key]['rejected'] = $rejected;
		// 	else $surveys[$key]['rejected'] = 0;

		// 	$payment_list =$this->db->select('price_per_survey')->where('survey_id', $surv['id'])->where('status', 1)->get('lkp_payment')->row_array();
		// 	$surveys[$key]['payment_amount'] = $payment_list['price_per_survey'] * $surveys[$key]['approved'];
		// }
		// $result['surveys_tasks'] = $this->security->xss_clean($surveys);

		$result['surveys_tasks'] = $this->Reports_model->payment_tasks_data($data);
		$result['total_records'] = $this->Reports_model->payment_tasks_records($data);

		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();
		// $result['total_records'] = $tasks_count;
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

	public function get_payment_report_contributors(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$survey_id = $this->uri->segment(3);
		$user_id = $this->session->userdata('login_id');
		//user data for profile info
		// $this->load->model('Dynamicmenu_model');
		// $profile_details = $this->Dynamicmenu_model->user_data();
		// $menu_result = array('profile_details' => $profile_details);
		
		$country_id = $this->input->post('country_id');
		$uai_id = $this->input->post('uai_id');
		$sub_location_id = $this->input->post('sub_location_id');
		$cluster_id = $this->input->post('cluster_id');
		$contributor_id = $this->input->post('contributor_id');
		$respondent_id = $this->input->post('respondent_id');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$tasks = $this->input->post('tasks');

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
			"start_date" => $start_date,
			"end_date" => $end_date,
			"tasks" => $tasks,
			'user_id' => $user_id,
			"page_no" => $page_no,
			"record_per_page" => $record_per_page,
			"is_pagination" => $this->input->post('pagination') != null
		);
		$this->load->model('Reports_model');
		$result =array();
		// if(!empty($data['respondent_id'])) {
		// 	$this->db->select('data_id');
		// 	$this->db->where('data_id', $data['respondent_id']);
		// 	$respondent_list = $this->db->where('status', 1)->get('tbl_respondent_users')->row_array();
		// 	// var_dump($this->db->last_query());exit;
		// }
		// $contributors_count=0;
		// $this->db->select('*');
		// $this->db->where('role_id', 8);
		// $this->db->where('status', 1);
		// if(!empty($data['contributor_id'])) {
		// 	$this->db->where('user_id', $data['contributor_id']);
		// }
		// $users_list = $this->db->get('tbl_users')->result_array();

		// // $contributor_list = $this->db->select('tu.*,tsa.*')->from('tbl_users as tu')->join('tbl_survey_assignee AS tsa', 'tsa.user_id = tu.user_id')->where('tu.role_id',8)->where('tu.status',1)->where('tsa.status',1)->group_by('tsa.user_id')->get()->result_array();
		// foreach ($users_list as $ukey => $user) {
		// 	$contributors_count++;
		// 	$payment_amount=0;
		// 	$approved_value=0;
		// 	$submitted_value=0;
		// 	$rejected_value=0;
		// 	$this->db->distinct('survey_id');
		// 	$this->db->select('*');
		// 	$this->db->where('user_id', $user['user_id']);	
		// 	if(!empty($data['country_id'])) {
		// 		$this->db->where('country_id', $data['country_id']);
		// 	}
		// 	if(!empty($data['cluster_id'])) {
		// 		$this->db->where('cluster_id', $data['cluster_id']);
		// 	}
		// 	if(!empty($data['uai_id'])) {
		// 		$this->db->where('uai_id', $data['uai_id']);
		// 	}
		// 	if(!empty($data['sub_location_id'])) {
		// 		$this->db->where('sub_loc_id', $data['sub_location_id']);
		// 	}
		// 	if(!empty($data['contributor_id'])) {
		// 		$this->db->where('user_id', $data['contributor_id']);
		// 	}
		// 	if(!empty($data['respondent_id'])) {
				
		// 		$this->db->where('respondent_id', $respondent_list['data_id']);
		// 	}	
		// 	$this->db->where('respondent_id !=', NULL);
		// 	$contributor_list = $this->db->where('status', 1)->get('tbl_survey_assignee')->result_array();
		// 	// if($user['user_id']==63){
		// 	// 	var_dump($this->db->last_query());exit;
		// 	// }

		// 	foreach ($contributor_list as $ckey => $contributor) {
				
				
		// 		// Get approved
		// 		$this->db->distinct()->select('*');
		// 		$this->db->where('pa_verified_status',2);
		// 		$this->db->where('user_id', $contributor['user_id']);

		// 		if(!empty($data['country_id'])) {
		// 			$this->db->where('country_id', $data['country_id']);
		// 		}
		// 		if(!empty($data['cluster_id'])) {
		// 			$this->db->where('cluster_id', $data['cluster_id']);
		// 		}
		// 		if(!empty($data['uai_id'])) {
		// 			$this->db->where('uai_id', $data['uai_id']);
		// 		}
		// 		if(!empty($data['sub_location_id'])) {
		// 			$this->db->where('sub_location_id', $data['sub_location_id']);
		// 		}
		// 		if(!empty($data['contributor_id'])) {
		// 			$this->db->where('user_id', $data['contributor_id']);
		// 		}
		// 		if(!empty($data['respondent_id'])) {
		// 			$this->db->where('respondent_data_id', $respondent_list['data_id']);
		// 		}
		// 		$approved = $this->db->where('status', 1)->get('survey'.$contributor['survey_id'])->num_rows();
		// 		// if($contributor['user_id']==63){
		// 		// 	var_dump($this->db->last_query());
		// 		// }
		// 		$temp_approved= $approved;
		// 		$approved_value =$approved_value+$temp_approved;
	
		// 		// get submitted
		// 		$this->db->distinct()->select('*');
		// 		$this->db->where('pa_verified_status',1);
		// 		if(!empty($data['country_id'])) {
		// 			$this->db->where('country_id', $data['country_id']);
		// 		}
		// 		if(!empty($data['cluster_id'])) {
		// 			$this->db->where('cluster_id', $data['cluster_id']);
		// 		}
		// 		if(!empty($data['uai_id'])) {
		// 			$this->db->where('uai_id', $data['uai_id']);
		// 		}
		// 		if(!empty($data['sub_location_id'])) {
		// 			$this->db->where('sub_location_id', $data['sub_location_id']);
		// 		}
		// 		if(!empty($data['contributor_id'])) {
		// 			$this->db->where('user_id', $data['contributor_id']);
		// 		}
		// 		if(!empty($data['respondent_id'])) {
		// 			$this->db->where('respondent_data_id', $respondent_list['data_id']);
		// 		}
		// 		$submitted = $this->db->where('status', 1)->get('survey'.$contributor['survey_id'])->num_rows();
		// 		$temp_submitted= $submitted;
		// 		$submitted_value =$submitted_value+$temp_submitted;			
	
		// 		// get rejected
		// 		$this->db->distinct()->select('*');
		// 		$this->db->where('pa_verified_status',3);
		// 		if(!empty($data['country_id'])) {
		// 			$this->db->where('country_id', $data['country_id']);
		// 		}
		// 		if(!empty($data['cluster_id'])) {
		// 			$this->db->where('cluster_id', $data['cluster_id']);
		// 		}
		// 		if(!empty($data['uai_id'])) {
		// 			$this->db->where('uai_id', $data['uai_id']);
		// 		}
		// 		if(!empty($data['sub_location_id'])) {
		// 			$this->db->where('sub_location_id', $data['sub_location_id']);
		// 		}
		// 		if(!empty($data['contributor_id'])) {
		// 			$this->db->where('user_id', $data['contributor_id']);
		// 		}
		// 		if(!empty($data['respondent_id'])) {
		// 			$this->db->where('respondent_data_id', $respondent_list['data_id']);
		// 		}
		// 		$rejected = $this->db->where('status', 1)->get('survey'.$contributor['survey_id'])->num_rows();
		// 		$temp_rejected= $rejected;
		// 		$rejected_value =$rejected_value+$temp_rejected;
				
		// 		$payment_list =$this->db->select('price_per_survey')->where('survey_id', $contributor['survey_id'])->where('status', 1)->get('lkp_payment')->row_array();
		// 		$temp_payment= $payment_list['price_per_survey'];
		// 		// $payment_amount =$payment_amount+$temp_payment;
		// 		$payment_amount1 =$temp_payment * $approved_value;
		// 		$payment_amount =$payment_amount+$payment_amount1;
		// 	}
		// 	$users_list[$ukey]['payment_amount'] = $payment_amount;
		// 	if($approved_value) $users_list[$ukey]['approved'] = $approved_value;
		// 		else $users_list[$ukey]['approved'] = 0;

		// 	if($submitted_value) $users_list[$ukey]['submitted'] = $submitted_value;
		// 		else $users_list[$ukey]['submitted'] = 0;

		// 	if($rejected_value) $users_list[$ukey]['rejected'] = $rejected_value;
		// 		else $users_list[$ukey]['rejected'] = 0;
		// 	$users_list[$ukey]['contributor_name'] = $user['first_name']." ".$user['last_name'];
			
		// }
		// $result['contributor_list'] = $users_list;
		// $result['total_records'] = $contributors_count;
		$result['contributor_list'] = $this->Reports_model->payment_contributors_data($data);
		$result['total_records'] = $this->Reports_model->payment_contributors_records($data);

		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();

		
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


	public function view_survey_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$survey_id = $this->uri->segment(3);
		$user_id = $this->session->userdata('login_id');
		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		$result =array();

		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();
		// $result['lkp_market'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
		$result['survey_type'] = $this->db->select('type')->where('id', $survey_id)->where('status', 1)->get('form')->row_array();
		// $result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();

        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('menu',$menu_result);
		$this->load->view('reports/view_survey_data', $result);
		$this->load->view('footer');
	}
	
	public function task_data_export(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$survey_id = $this->uri->segment(3);
		$user_id = $this->session->userdata('login_id');
		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		$result =array();

		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();
		// $result['lkp_market'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
		$result['survey_type'] = $this->db->select('type')->where('id', $survey_id)->where('status', 1)->get('form')->row_array();
		// $result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();

		
        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('menu',$menu_result);
		$this->load->view('reports/task_data_export', $result);
		$this->load->view('footer');
	}
	
	public function get_submited_data() {
		$baseurl = base_url();
		if (empty($this->session->userdata('login_id'))) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode([
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				]);
				exit;
			}
			redirect($baseurl);
		}

		// Input parameters
		$data = [
			'country_id' => $this->input->post('country_id'),
			'uai_id' => $this->input->post('uai_id'),
			'sub_location_id' => $this->input->post('sub_location_id'),
			'cluster_id' => $this->input->post('cluster_id'),
			'contributor_id' => $this->input->post('contributor_id'),
			'respondent_id' => $this->input->post('respondent_id'),
			'start_date' => $this->input->post('start_date'),
			'end_date' => $this->input->post('end_date'),
			'user_id' => $this->session->userdata('login_id'),
			'survey_id' => $this->input->post('survey_id'),
			'survey_type' => $this->input->post('survey_type'),
			'page_no' => 1,
			'record_per_page' => 100,
			'search_input' => '',
			'is_search' => false,
			'pa_verified_status' => '',
			'is_pa_verified_status' => false,
			'is_pagination' => false
		];

		// Handle pagination
		if ($this->input->post('pagination')) {
			$pagination = $this->input->post('pagination');
			$data['page_no'] = $pagination['pageNo'] ?? 1;
			$data['record_per_page'] = $pagination['recordperpage'] ?? 100;
			$data['is_pagination'] = true;
		}

		// Handle search
		if ($this->input->post('search')) {
			$search = $this->input->post('search');
			$data['search_input'] = $search['search_input'] ?? '';
			$data['is_search'] = !empty($data['search_input']);
		}

		// Handle pa_verified_status
		if ($this->input->post('pa_verified_status')) {
			$data['pa_verified_status'] = $this->input->post('pa_verified_status');
			$data['is_pa_verified_status'] = !empty($data['pa_verified_status']);
		}

		$this->load->model('Reports_model');

		// In-memory cache for lookup tables
		static $lookup_cache = [];
		$lookup_tables = [
			'lkp_country' => ['table' => 'lkp_country', 'select' => '*'],
			'lkp_cluster' => ['table' => 'lkp_cluster', 'select' => '*'],
			'lkp_uai' => ['table' => 'lkp_uai', 'select' => '*'],
			'lkp_sub_location' => ['table' => 'lkp_sub_location', 'select' => '*'],
			'lkp_location_type' => ['table' => 'lkp_location_type', 'select' => '*'],
			'lkp_animal_type_lactating' => ['table' => 'lkp_animal_type_lactating', 'select' => '*'],
			'lkp_market' => ['table' => 'lkp_market', 'select' => '*'],
			'lkp_lr_body_condition' => ['table' => 'lkp_lr_body_condition', 'select' => '*'],
			'lkp_sr_body_condition' => ['table' => 'lkp_sr_body_condition', 'select' => '*'],
			'lkp_animal_type' => ['table' => 'lkp_animal_type', 'select' => '*'],
			'lkp_animal_herd_type' => ['table' => 'lkp_animal_herd_type', 'select' => '*'],
			'lkp_food_groups' => ['table' => 'lkp_food_groups', 'select' => '*'],
			'lkp_transect_pasture' => ['table' => 'lkp_transect_pasture', 'select' => '*'],
			'lkp_dry_wet_pasture' => ['table' => 'lkp_dry_wet_pasture', 'select' => '*'],
			'lkp_transport_means' => ['table' => 'lkp_transport_means', 'select' => '*'],
			'respondent_name' => ['table' => 'tbl_respondent_users', 'select' => 'first_name, last_name, data_id'],
			'cluster_admin' => ['table' => 'tbl_users', 'select' => 'CONCAT(first_name, " ", last_name) as verified_by, user_id', 'where' => ['role_id' => 6]]
		];

		$result = [
			'status' => 1,
			'user_role' => $this->session->userdata('role'),
			'title' => $this->Reports_model->export_survey_title($data['survey_id'])
		];

		// Fetch lookup data from in-memory cache
		foreach ($lookup_tables as $key => $config) {
			if (!isset($lookup_cache[$key])) {
				$query = $this->db->select($config['select'])->where('status', 1);
				if (!empty($config['where'])) {
					foreach ($config['where'] as $field => $value) {
						$query->where($field, $value);
					}
				}
				$lookup_cache[$key] = $query->get($config['table'])->result_array();
			}
			$result[$key] = $lookup_cache[$key];
		}

		// Fetch survey details and submitted data
		$result = array_merge($result, $this->Reports_model->survey_details($data['survey_id']));
		$survey_data = $this->Reports_model->survey_submited_data($data);
		$result['submited_data'] = $survey_data['data'];
		$result['total_records'] = $survey_data['total_records'];

		echo json_encode($result);
		exit;
	}
	public function get_approved_data() {
		$baseurl = base_url();
		if (empty($this->session->userdata('login_id'))) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode([
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				]);
				exit;
			}
			redirect($baseurl);
		}

		// Input parameters
		$data = [
			'country_id' => $this->input->post('country_id'),
			'uai_id' => $this->input->post('uai_id'),
			'sub_location_id' => $this->input->post('sub_location_id'),
			'cluster_id' => $this->input->post('cluster_id'),
			'contributor_id' => $this->input->post('contributor_id'),
			'respondent_id' => $this->input->post('respondent_id'),
			'start_date' => $this->input->post('start_date'),
			'end_date' => $this->input->post('end_date'),
			'user_id' => $this->session->userdata('login_id'),
			'survey_id' => $this->input->post('survey_id'),
			'survey_type' => $this->input->post('survey_type'),
			'page_no' => 1,
			'record_per_page' => 100, // Kept as per original
			'search_input' => '',
			'is_search' => false,
			'is_pagination' => false
		];

		// Handle pagination
		if ($this->input->post('pagination')) {
			$pagination = $this->input->post('pagination');
			$data['page_no'] = $pagination['pageNo'] ?? 1;
			$data['record_per_page'] = $pagination['recordperpage'] ?? 100;
			$data['is_pagination'] = true;
		}

		// Handle search
		if ($this->input->post('search')) {
			$search = $this->input->post('search');
			$data['search_input'] = $search['search_input'] ?? '';
			$data['is_search'] = !empty($data['search_input']);
		}

		$this->load->model('Reports_model');

		// In-memory cache for lookup tables within request scope
		static $lookup_cache = [];
		$lookup_tables = [
			'lkp_country' => ['table' => 'lkp_country', 'select' => '*'],
			'lkp_cluster' => ['table' => 'lkp_cluster', 'select' => '*'],
			'lkp_uai' => ['table' => 'lkp_uai', 'select' => '*'],
			'lkp_sub_location' => ['table' => 'lkp_sub_location', 'select' => '*'],
			'lkp_location_type' => ['table' => 'lkp_location_type', 'select' => '*'],
			'lkp_animal_type_lactating' => ['table' => 'lkp_animal_type_lactating', 'select' => '*'],
			'lkp_market' => ['table' => 'lkp_market', 'select' => '*'],
			'lkp_lr_body_condition' => ['table' => 'lkp_lr_body_condition', 'select' => '*'],
			'lkp_sr_body_condition' => ['table' => 'lkp_sr_body_condition', 'select' => '*'],
			'lkp_animal_type' => ['table' => 'lkp_animal_type', 'select' => '*'],
			'lkp_animal_herd_type' => ['table' => 'lkp_animal_herd_type', 'select' => '*'],
			'lkp_food_groups' => ['table' => 'lkp_food_groups', 'select' => '*'],
			'lkp_transect_pasture' => ['table' => 'lkp_transect_pasture', 'select' => '*'],
			'lkp_dry_wet_pasture' => ['table' => 'lkp_dry_wet_pasture', 'select' => '*'],
			'lkp_transport_means' => ['table' => 'lkp_transport_means', 'select' => '*'],
			'respondent_name' => ['table' => 'tbl_respondent_users', 'select' => 'first_name, last_name, data_id'],
			'cluster_admin' => ['table' => 'tbl_users', 'select' => 'CONCAT(first_name, " ", last_name) as verified_by, user_id', 'where' => ['role_id' => 6]]
		];

		$result = $this->Reports_model->survey_details($data['survey_id']);

		$result['status'] = 1;
		$result['user_role'] = $this->session->userdata('role');
		$result['title'] = $this->Reports_model->export_survey_title($data['survey_id']);

		// Fetch lookup data from in-memory cache or database
		foreach ($lookup_tables as $key => $config) {
			if (!isset($lookup_cache[$key])) {
				$query = $this->db->select($config['select'])->where('status', 1);
				if (!empty($config['where'])) {
					foreach ($config['where'] as $field => $value) {
						$query->where($field, $value);
					}
				}
				$lookup_cache[$key] = $query->get($config['table'])->result_array();
			}
			$result[$key] = $lookup_cache[$key];
		}

		// Fetch approved data
		$survey_data = $this->Reports_model->survey_approved_data($data);
		$result['submited_data'] = $survey_data['data'];
		$result['total_records'] = $survey_data['total_records'];

		echo json_encode($result);
		exit;
	}
	public function get_rejected_data() {
		$baseurl = base_url();
		if (empty($this->session->userdata('login_id'))) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode([
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				]);
				exit;
			}
			redirect($baseurl);
		}

		// Input parameters
		$data = [
			'country_id' => $this->input->post('country_id'),
			'uai_id' => $this->input->post('uai_id'),
			'sub_location_id' => $this->input->post('sub_location_id'),
			'cluster_id' => $this->input->post('cluster_id'),
			'contributor_id' => $this->input->post('contributor_id'),
			'respondent_id' => $this->input->post('respondent_id'),
			'start_date' => $this->input->post('start_date'),
			'end_date' => $this->input->post('end_date'),
			'user_id' => $this->session->userdata('login_id'),
			'survey_id' => $this->input->post('survey_id'),
			'survey_type' => $this->input->post('survey_type'),
			'page_no' => 1,
			'record_per_page' => 100,
			'search_input' => '',
			'is_search' => false,
			'is_pagination' => false
		];

		// Handle pagination
		if ($this->input->post('pagination')) {
			$pagination = $this->input->post('pagination');
			$data['page_no'] = $pagination['pageNo'] ?? 1;
			$data['record_per_page'] = $pagination['recordperpage'] ?? 100;
			$data['is_pagination'] = true;
		}

		// Handle search
		if ($this->input->post('search')) {
			$search = $this->input->post('search');
			$data['search_input'] = $search['search_input'] ?? '';
			$data['is_search'] = !empty($data['search_input']);
		}

		$this->load->model('Reports_model');

		// In-memory cache for lookup tables
		static $lookup_cache = [];
		$lookup_tables = [
			'lkp_country' => ['table' => 'lkp_country', 'select' => '*'],
			'lkp_cluster' => ['table' => 'lkp_cluster', 'select' => '*'],
			'lkp_uai' => ['table' => 'lkp_uai', 'select' => '*'],
			'lkp_sub_location' => ['table' => 'lkp_sub_location', 'select' => '*'],
			'lkp_location_type' => ['table' => 'lkp_location_type', 'select' => '*'],
			'lkp_animal_type_lactating' => ['table' => 'lkp_animal_type_lactating', 'select' => '*'],
			'lkp_market' => ['table' => 'lkp_market', 'select' => '*'],
			'lkp_lr_body_condition' => ['table' => 'lkp_lr_body_condition', 'select' => '*'],
			'lkp_sr_body_condition' => ['table' => 'lkp_sr_body_condition', 'select' => '*'],
			'lkp_animal_type' => ['table' => 'lkp_animal_type', 'select' => '*'],
			'lkp_animal_herd_type' => ['table' => 'lkp_animal_herd_type', 'select' => '*'],
			'lkp_food_groups' => ['table' => 'lkp_food_groups', 'select' => '*'],
			'lkp_transect_pasture' => ['table' => 'lkp_transect_pasture', 'select' => '*'],
			'lkp_dry_wet_pasture' => ['table' => 'lkp_dry_wet_pasture', 'select' => '*'],
			'lkp_transport_means' => ['table' => 'lkp_transport_means', 'select' => '*'],
			'respondent_name' => ['table' => 'tbl_respondent_users', 'select' => 'first_name, last_name, data_id'],
			'cluster_admin' => ['table' => 'tbl_users', 'select' => 'CONCAT(first_name, " ", last_name) as verified_by, user_id', 'where' => ['role_id' => 6]]
		];

		$result = [
			'status' => 1,
			'user_role' => $this->session->userdata('role'),
			'title' => $this->Reports_model->export_survey_title($data['survey_id'])
		];

		// Fetch lookup data from in-memory cache
		foreach ($lookup_tables as $key => $config) {
			if (!isset($lookup_cache[$key])) {
				$query = $this->db->select($config['select'])->where('status', 1);
				if (!empty($config['where'])) {
					foreach ($config['where'] as $field => $value) {
						$query->where($field, $value);
					}
				}
				$lookup_cache[$key] = $query->get($config['table'])->result_array();
			}
			$result[$key] = $lookup_cache[$key];
		}

		// Fetch survey details and rejected data
		$result = array_merge($result, $this->Reports_model->survey_details($data['survey_id']));
		$survey_data = $this->Reports_model->survey_rejected_data($data);
		$result['submited_data'] = $survey_data['data'];
		$result['total_records'] = $survey_data['total_records'];

		echo json_encode($result);
		exit;
	}

	public function get_submited_data_export() {
		$baseurl = base_url();
		if (empty($this->session->userdata('login_id'))) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode([
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				]);
				exit;
			}
			redirect($baseurl);
		}

		// Input parameters
		$data = [
			'country_id' => $this->input->post('country_id'),
			'uai_id' => $this->input->post('uai_id'),
			'sub_location_id' => $this->input->post('sub_location_id'),
			'cluster_id' => $this->input->post('cluster_id'),
			'contributor_id' => $this->input->post('contributor_id'),
			'respondent_id' => $this->input->post('respondent_id'),
			'start_date' => $this->input->post('start_date'),
			'end_date' => $this->input->post('end_date'),
			'user_id' => $this->session->userdata('login_id'),
			'survey_id' => $this->input->post('survey_id'),
			'survey_type' => $this->input->post('survey_type'),
			'page_no' => 1,
			'record_per_page' => 100,
			'search_input' => '',
			'is_search' => false,
			'pa_verified_status' => '',
			'is_pa_verified_status' => false,
			'is_pagination' => false
		];

		// Handle pagination
		if ($this->input->post('pagination') && !empty($this->input->post('pagination'))) {
			$pagination = $this->input->post('pagination');
			$data['page_no'] = $pagination['pageNo'] ?? 1;
			$data['record_per_page'] = $pagination['recordperpage'] ?? 100;
			$data['is_pagination'] = true;
		}

		// Handle search
		if ($this->input->post('search')) {
			$search = $this->input->post('search');
			$data['search_input'] = $search['search_input'] ?? '';
			$data['is_search'] = !empty($data['search_input']);
		}

		// Handle pa_verified_status
		if ($this->input->post('pa_verified_status')) {
			$data['pa_verified_status'] = $this->input->post('pa_verified_status');
			$data['is_pa_verified_status'] = !empty($data['pa_verified_status']);
		}

		$this->load->model('Reports_model');

		// In-memory cache for lookup tables
		static $lookup_cache = [];
		$lookup_tables = [
			'lkp_country' => ['table' => 'lkp_country', 'select' => '*'],
			'lkp_cluster' => ['table' => 'lkp_cluster', 'select' => '*'],
			'lkp_uai' => ['table' => 'lkp_uai', 'select' => '*'],
			'lkp_sub_location' => ['table' => 'lkp_sub_location', 'select' => '*'],
			'lkp_location_type' => ['table' => 'lkp_location_type', 'select' => '*'],
			'lkp_animal_type_lactating' => ['table' => 'lkp_animal_type_lactating', 'select' => '*'],
			'lkp_market' => ['table' => 'lkp_market', 'select' => '*'],
			'lkp_lr_body_condition' => ['table' => 'lkp_lr_body_condition', 'select' => '*'],
			'lkp_sr_body_condition' => ['table' => 'lkp_sr_body_condition', 'select' => '*'],
			'lkp_animal_type' => ['table' => 'lkp_animal_type', 'select' => '*'],
			'lkp_animal_herd_type' => ['table' => 'lkp_animal_herd_type', 'select' => '*'],
			'lkp_food_groups' => ['table' => 'lkp_food_groups', 'select' => '*'],
			'lkp_transect_pasture' => ['table' => 'lkp_transect_pasture', 'select' => '*'],
			'lkp_dry_wet_pasture' => ['table' => 'lkp_dry_wet_pasture', 'select' => '*'],
			'lkp_transport_means' => ['table' => 'lkp_transport_means', 'select' => '*'],
			'respondent_name' => ['table' => 'tbl_respondent_users', 'select' => 'first_name, last_name, data_id'],
			'cluster_admin' => ['table' => 'tbl_users', 'select' => 'CONCAT(first_name, " ", last_name) as verified_by, user_id', 'where' => ['role_id' => 6]]
		];

		$result = [
			'status' => 1,
			'user_role' => $this->session->userdata('role'),
			'title' => $this->Reports_model->export_survey_title($data['survey_id'])
		];

		// Fetch lookup data from in-memory cache
		foreach ($lookup_tables as $key => $config) {
			if (!isset($lookup_cache[$key])) {
				$query = $this->db->select($config['select'])->where('status', 1);
				if (!empty($config['where'])) {
					foreach ($config['where'] as $field => $value) {
						$query->where($field, $value);
					}
				}
				$lookup_cache[$key] = $query->get($config['table'])->result_array();
			}
			$result[$key] = $lookup_cache[$key];
		}

		// Fetch survey details and submitted data
		$result = array_merge($result, $this->Reports_model->survey_details($data['survey_id']));
		$survey_data = $this->Reports_model->survey_submited_data_export($data);
		$result['submited_data'] = $survey_data['data'];
		$result['total_records'] = $survey_data['total_records'];

		echo json_encode($result);
		exit;
	}




	public function verify_data(){
		$baseurl = base_url();
		$result = array();
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';
			echo json_encode($result);
			exit();
		}

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}
		if($this->session->userdata('role') == 1){
			$ids = $this->input->post('check_sub');

		} else{
			$ids = $this->input->post('check_sub');
		}
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}
		
		$survey_id = $this->uri->segment(3);
		// Get task details
        $taskDetails = $this->db->where('id', $survey_id)->get('form')->row_array();

		$survey_table = 'survey'.$survey_id;
		$survey_grouptable = 'survey'.$survey_id.'_groupdata';

		// Get user details
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$verifyingUserDetails = $this->db->get('tbl_users')->row_array();

		define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');

		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$currentDateTime = date('Y-m-d H:i:s');

			// $this->db->select('asc_verified_status, da_verified_status, status');
			$this->db->select('pa_verified_status, status, user_id, respondent_data_id, market_id');
            $approval_status = $this->db->where('id', $id)->get($survey_table)->row_array();

            // Get submitter's details
			$this->db->where('user_id', $approval_status['user_id']);
			$submitterUserDetails = $this->db->get('tbl_users')->row_array();

			$linkedDetails = NULL;
			if($approval_status['respondent_data_id']) {
				// Get respondent's details
				$this->db->where('data_id', $approval_status['respondent_data_id']);
				$respondentDetails = $this->db->get('tbl_respondent_users')->row_array();
				$linkedDetails = 'Respondent Name : '.$respondentDetails['first_name'].' '.$respondentDetails['last_name']."\n";
			}
			if($approval_status['market_id']) {
				// Get market's details
				$this->db->where('market_id', $approval_status['market_id']);
				$marketDetails = $this->db->get('lkp_market')->row_array();
				$linkedDetails = 'Market Name : '.$marketDetails['name']."\n";
			}

            $pushtoken = array();
			// Get submitter's device tokens to send push
			$this->db->distinct()->select('token');
			$this->db->where_in('user_id', $approval_status['user_id']);
			$usertoken = $this->db->where('status', 1)->get('tbl_push_notification')->result_array();
			foreach ($usertoken as $tkey => $utoken) {
				array_push($pushtoken, $utoken['token']);
			}

			if($status == 3) {
				$verification = array(
					'pa_verified_status' => $this->input->post('status'),
					'pa_verified_by' => $this->session->userdata('login_id'),
					'pa_verified_date' => $currentDateTime,
					'rejected_remarks' => $this->input->post('rejected_remarks')
				);

				$linkedDetails .= "Rejection remarks : ".$this->input->post('rejected_remarks')."\n
				Please sync the application and you can see the data in the Rejected list.\n
				Kindly do the needful and reach out to ".$verifyingUserDetails['first_name']." ".$verifyingUserDetails['last_name']." in case of any further questions.";
			} else {
				$verification = array(
					'pa_verified_status' => $this->input->post('status'),
					'pa_verified_by' => $this->session->userdata('login_id'),
					'pa_verified_date' => $currentDateTime
				);

				$linkedDetails .= "Please sync the application and you can see the data in the Approved list";
			}
			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);

			if(count($pushtoken) > 0) {
				$title = "Data submitted by you for ".$taskDetails['title']." has been ";
				$title = ($status == 3) ? "rejected" : "approved";

				if($status == 2) {
					$body = "Dear ".$submitterUserDetails['first_name']." ".$submitterUserDetails['last_name'].",\n
					The data submitted by you for ".$taskDetails['title']." has been approved by ".$verifyingUserDetails['first_name']." ".$verifyingUserDetails['last_name']."\n";
				} else if($status == 3) {
					$body = "Dear ".$submitterUserDetails['first_name']." ".$submitterUserDetails['last_name'].",\n
					The data submitted by you for ".$taskDetails['title']." has been rejected by ".$verifyingUserDetails['first_name']." ".$verifyingUserDetails['last_name']." with below remarks.\n";
				}
				$body = $body.$linkedDetails;
				
				$msg = array(
					'body'		=> $body,
					'title'		=> $title,
					// 'content'	=> json_encode($content),
					'type'		=> "data",
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

			/*if($this->session->userdata('role') == 8){
				if(isset($approval_status)){
					if($approval_status['da_verified_status'] == null){
						if($this->input->post('status') == 0){
							$status = 3;
						}else{
							$status = $approval_status['status'];
						}
					}elseif($approval_status['da_verified_status'] == 0){
						$status = 3;
					}else{
						if($this->input->post('status') == 0){
							$status = 3;
						}else{
							$status = 2;
						}
					}
				}
				$verification = array(
					'asc_verified_status' => $this->input->post('status'),
					'asc_verified_id' => $this->session->userdata('login_id'),
					'asc_verified_date' => $currentDateTime,
					'status' => $status
				);

			}elseif($this->session->userdata('role') == 7){
				if(isset($approval_status)){
					if($approval_status['asc_verified_status'] == null){
						if($this->input->post('status') == 0){
							$status = 3;
						}else{
							$status = $approval_status['status'];
						}
					}elseif($approval_status['asc_verified_status'] == 0){
						$status = 3;
					}else{
						if($this->input->post('status') == 0){
							$status = 3;
						}else{
							$status = 2;
						}
					}
				}
				$verification = array(
					'da_verified_status' => $this->input->post('status'),
					'da_verified_id' => $this->session->userdata('login_id'),
					'da_verified_date' => $currentDateTime,
					'status' => $status
				);
			}elseif($this->session->userdata('role') == 1){
				if(isset($approval_status)){
					if($approval_status['pa_verified_status'] == null){
						if($this->input->post('status') == 0){
							$status = 3;
						}else{
							$status = 2;
						}
					}elseif($approval_status['pa_verified_status'] == 0){
						$status = 3;
					}else{
						if($this->input->post('status') == 0){
							$status = 3;
						}else{
							$status = 2;
						}
					}
				}
				$verification = array(
					'pa_verified_status' => $this->input->post('status'),
					'pa_verified_by' => $this->session->userdata('login_id'),
					'pa_verified_date' => $currentDateTime,
					'status' => $status
				);
			}*/
			
			
			//Update table
			// $query = $this->db->where('id', $id)->update($survey_table, $verification);
			// var_dump($this->db->last_query());exit;
			/*if($query){
				$this->db->select('data_id');
				$this->db->where('id', $id);
				$record_status = $this->db->get($survey_table)->row_array();
				if(!empty($record_status['data_id'])){
					$gverification = array(
						'status' => $status
					);
					if ($this->db->table_exists($survey_grouptable))
					{
						$group_query = $this->db->where('data_id', $record_status['data_id'])->update($survey_grouptable, $gverification);
					}
				}
			}*/
		}

		$result['status'] = 1;
		if($status == 3){
			$result['msg'] = 'Data rejected successfully.';
		}else{
			$result['msg'] = 'Data approved successfully.';
		}
		$result['verified_by'] = $this->session->userdata('name');
		$result['verified_role'] = $this->session->userdata('role');
		echo json_encode($result);
		exit();
	}
	
	public function verify_respondent(){
		$baseurl = base_url();
		// $result = array(
		// 	'csrfHash' => $this->security->get_csrf_hash(),
		// 	'csrfName' => $this->security->get_csrf_token_name()
		// );
		$result = array();
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';
			echo json_encode($result);
			exit();
		}

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}
		if($this->session->userdata('role') == 1){
			$ids = $this->input->post('check_sub');

		} else{
			$ids = $this->input->post('check_sub');
		}
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}

		// Get user details
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$verifyingUserDetails = $this->db->get('tbl_users')->row_array();
		
		$survey_table = 'tbl_respondent_users';
		$survey_grouptable = 'tbl_respondent_hh_detail';

		define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');

		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$currentDateTime = date('Y-m-d H:i:s');

			//respondent details
			$this->db->select('first_name, last_name, added_by');
            $rp_data = $this->db->where('id', $id)->get($survey_table)->row_array();

			$this->db->where('user_id', $rp_data['added_by']);
			$submitterUserDetails = $this->db->get('tbl_users')->row_array();
			
			$pushtoken = array();
			// Get submitter's device tokens to send push
			$this->db->distinct()->select('token');
			$this->db->where_in('user_id', $rp_data['added_by']);
			$usertoken = $this->db->where('status', 1)->get('tbl_push_notification')->result_array();
			foreach ($usertoken as $tkey => $utoken) {
				array_push($pushtoken, $utoken['token']);
			}
			$linkedDetails = NULL;
			if($status == 3){
				$verification = array(
					'pa_verified_status' => $this->input->post('status'),
					'pa_verified_by' => $this->session->userdata('login_id'),
					'pa_verified_date' => $currentDateTime,
					'rejected_remarks' => $this->input->post('rejected_remarks')
				);
				$linkedDetails .= "Rejection remarks : ".$this->input->post('rejected_remarks')."\n
				Please sync the application and you can see the data in the Rejected list.\n
				Kindly do the needful and reach out to ".$verifyingUserDetails['first_name']." ".$verifyingUserDetails['last_name']." in case of any further questions.";
				
			}else{
				$verification = array(
					'pa_verified_status' => $this->input->post('status'),
					'pa_verified_by' => $this->session->userdata('login_id'),
					'pa_verified_date' => $currentDateTime
				);
				$linkedDetails .= "Please sync the application and you can see the data in the Approved list";
				
			}
			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);
			if(count($pushtoken) > 0) {
				$title = "Data submitted by you has been ";
				$title .= ($status == 3) ? "rejected" : "approved";

				if($status == 2) {
					$body = "Dear ".$submitterUserDetails['first_name']." ".$submitterUserDetails['last_name'].",\n
					The data submitted by you has been approved by ".$verifyingUserDetails['first_name']." ".$verifyingUserDetails['last_name']."\n
					Respondent Name : ".$rp_data['first_name']." ".$rp_data['last_name']."\n";
				} else if($status == 3) {
					$body = "Dear ".$submitterUserDetails['first_name']." ".$submitterUserDetails['last_name'].",\n
					The data submitted by you has been rejected by ".$verifyingUserDetails['first_name']." ".$verifyingUserDetails['last_name']." with below remarks.\n
					Respondent Name : ".$rp_data['first_name']." ".$rp_data['last_name']."\n";
				}
				$body = $body.$linkedDetails;
				
				$msg = array(
					'body'		=> $body,
					'title'		=> $title,
					// 'content'	=> json_encode($content),
					'type'		=> "data",
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
		if($status == 3){
			$result['msg'] = 'Data rejected successfully.';
		}else{
			$result['msg'] = 'Data approved successfully.';
		}
		$result['verified_by'] = $this->session->userdata('name');
		$result['verified_role'] = $this->session->userdata('role');
		echo json_encode($result);
		exit();
	}
	public function verify_contributor(){
		$baseurl = base_url();
		// $result = array(
		// 	'csrfHash' => $this->security->get_csrf_hash(),
		// 	'csrfName' => $this->security->get_csrf_token_name()
		// );
		$result = array();
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';
			echo json_encode($result);
			exit();
		}

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}
		
		$ids = $this->input->post('check_sub');
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}
		
		$survey_table = 'tbl_user_profile';

		// Get user details
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$verifyingUserDetails = $this->db->get('tbl_users')->row_array();

		define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');

		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$currentDateTime = date('Y-m-d H:i:s');

			// Get submitter's details
			$this->db->where('user_id', $id);
			$submitterUserDetails = $this->db->get('tbl_users')->row_array();

			$pushtoken = array();
			// Get submitter's device tokens to send push
			$this->db->distinct()->select('token');
			$this->db->where_in('user_id', $id);
			$usertoken = $this->db->where('status', 1)->get('tbl_push_notification')->result_array();
			foreach ($usertoken as $tkey => $utoken) {
				array_push($pushtoken, $utoken['token']);
			}

			$linkedDetails = NULL;

			if($status == 3){//rejected
				$verification = array(
					'pa_verified_status' => $this->input->post('status'),
					'pa_verified_by' => $this->session->userdata('login_id'),
					'pa_verified_date' => $currentDateTime,
					'rejected_remarks' => $this->input->post('rejected_remarks')
				);
				$linkedDetails .= "Rejection remarks : ".$this->input->post('rejected_remarks')."\n
				Kindly reach out to ".$verifyingUserDetails['first_name']." ".$verifyingUserDetails['last_name']." in case of any further questions.";
			}else{
				$verification = array(
					'pa_verified_status' => $this->input->post('status'),
					'pa_verified_by' => $this->session->userdata('login_id'),
					'pa_verified_date' => $currentDateTime
				);
				$linkedDetails .= "Please sync the application to proceed to data submission";
			}
			
			//Update table
			$query = $this->db->where('user_id', $id)->update($survey_table, $verification);

			if(count($pushtoken) > 0) {
				// $title = "Data submitted by you for ".$taskDetails['title']." has been ";
				// $title = ($status == 3) ? "Rejected" : "Approved";

				if($status == 2) { //approved
					$title ="Your profile is approved";
					$body = "Dear ".$submitterUserDetails['first_name']." ".$submitterUserDetails['last_name'].",\n Your profile has been approved by ".$verifyingUserDetails['first_name']." ".$verifyingUserDetails['last_name']."\n";
				} else if($status == 3) {//rejected
					$title ="Your profile is rejected";
					$body = "Dear ".$submitterUserDetails['first_name']." ".$submitterUserDetails['last_name'].",\n
					Your profile has been rejected by ".$verifyingUserDetails['first_name']." ".$verifyingUserDetails['last_name']."\n";
				}
				$body = $body.$linkedDetails;
				
				$msg = array(
					'body'		=> $body,
					'title'		=> $title,
					'type'		=> "data",
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
		if($status == 3){
			$result['msg'] = 'Data rejected successfully.';
		}else{
			$result['msg'] = 'Data approved successfully.';
		}
		$result['verified_by'] = $this->session->userdata('name');
		$result['verified_role'] = $this->session->userdata('role');
		echo json_encode($result);
		exit();
	}

	public function verify_transect_pasture(){
		$baseurl = base_url();
		// $result = array(
		// 	'csrfHash' => $this->security->get_csrf_hash(),
		// 	'csrfName' => $this->security->get_csrf_token_name()
		// );
		$result = array();
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';
			echo json_encode($result);
			exit();
		}

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}
		if($this->session->userdata('role') == 1){
			$ids = $this->input->post('check_sub');

		} else{
			$ids = $this->input->post('check_sub');
		}
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}

		// Get user details
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$verifyingUserDetails = $this->db->get('tbl_users')->row_array();
		
		
		$survey_table = 'tbl_transect_pastures';
		// $survey_grouptable = 'tbl_respondent_hh_detail';

		define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');

		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$currentDateTime = date('Y-m-d H:i:s');

			//respondent details
			// $this->db->select('first_name, last_name, added_by');
			$this->db->select('contributor_name, added_by');
            $rp_data = $this->db->where('id', $id)->get($survey_table)->row_array();

			
			$this->db->where('user_id', $rp_data['added_by']);
			$submitterUserDetails = $this->db->get('tbl_users')->row_array();
			
			$pushtoken = array();
			// Get submitter's device tokens to send push
			$this->db->distinct()->select('token');
			$this->db->where_in('user_id', $rp_data['added_by']);
			$usertoken = $this->db->where('status', 1)->get('tbl_push_notification')->result_array();
			foreach ($usertoken as $tkey => $utoken) {
				array_push($pushtoken, $utoken['token']);
			}
			$linkedDetails = NULL;
			if($status == 3){
				$verification = array(
					'pa_verified_status' => $this->input->post('status'),
					'pa_verified_by' => $this->session->userdata('login_id'),
					'pa_verified_date' => $currentDateTime,
					'rejected_remarks' => $this->input->post('rejected_remarks')
				);
				$linkedDetails .= "Rejection remarks : ".$this->input->post('rejected_remarks')."\n
				Please sync the application and you can see the data in the Rejected list.\n
				Kindly do the needful and reach out to ".$verifyingUserDetails['first_name']." ".$verifyingUserDetails['last_name']." in case of any further questions.";
				
			}else{
				$verification = array(
					'pa_verified_status' => $this->input->post('status'),
					'pa_verified_by' => $this->session->userdata('login_id'),
					'pa_verified_date' => $currentDateTime
				);
				$linkedDetails .= "Please sync the application and you can see the data in the Approved list";
				
			}
			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);
			if(count($pushtoken) > 0) {
				$title = "Data submitted by you has been ";
				$title .= ($status == 3) ? "rejected" : "approved";

				if($status == 2) {
					$body = "Dear ".$submitterUserDetails['first_name']." ".$submitterUserDetails['last_name'].",\n
					The data submitted by you has been approved by ".$verifyingUserDetails['first_name']." ".$verifyingUserDetails['last_name']."\n
					Respondent Name : ".$rp_data['contributor_name']."\n";
				} else if($status == 3) {
					$body = "Dear ".$submitterUserDetails['first_name']." ".$submitterUserDetails['last_name'].",\n
					The data submitted by you has been rejected by ".$verifyingUserDetails['first_name']." ".$verifyingUserDetails['last_name']." with below remarks.\n
					Respondent Name : ".$rp_data['contributor_name']."\n";
				}
				$body = $body.$linkedDetails;
				
				$msg = array(
					'body'		=> $body,
					'title'		=> $title,
					// 'content'	=> json_encode($content),
					'type'		=> "data",
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
		if($status == 3){
			$result['msg'] = 'Data rejected successfully.';
		}else{
			$result['msg'] = 'Data approved successfully.';
		}
		$result['verified_by'] = $this->session->userdata('name');
		$result['verified_role'] = $this->session->userdata('role');
		echo json_encode($result);
		exit();
	}
	
	public function household_profile(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$survey_id = $this->uri->segment(3);
		$user_id = $this->session->userdata('login_id');
		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		$result =array();

		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();

        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('menu',$menu_result);
		$this->load->view('reports/household_profile', $result);
		$this->load->view('footer');
	}
	public function household_details(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$data_id = $this->uri->segment(3);
		$user_id = $this->session->userdata('login_id');
		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		$result =array();

		$this->db->select('hh.*');
		$this->db->where('hh.data_id',$data_id);
		$result['hh_details'] = $this->db->get('tbl_respondent_hh_detail as hh')->result_array();

		$result['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
		$result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();

		
        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('menu',$menu_result);
		$this->load->view('reports/household_details', $result);
		$this->load->view('footer');
	}

	public function transect_pastures(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$survey_id = $this->uri->segment(3);
		$user_id = $this->session->userdata('login_id');
		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		$result =array();

		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();

		
        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('menu',$menu_result);
		$this->load->view('reports/transect_pastures', $result);
		$this->load->view('footer');
	}

	public function contributor_profile(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$survey_id = $this->uri->segment(3);
		$user_id = $this->session->userdata('login_id');
		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		$result =array();

		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();

		
        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('menu',$menu_result);
		$this->load->view('reports/contributor_profile', $result);
		$this->load->view('footer');
	}
	
	public function get_submited_contributor_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$country_id = $this->input->post('country_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$contributor_id = $this->input->post('contributor_id');
			$respondent_id = $this->input->post('respondent_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$user_id = $this->session->userdata('login_id');
			// $survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }
			 $search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}

			$pa_verified_status = "";
			if ($this->input->post('pa_verified_status')) {
				$verified_status = $this->input->post('pa_verified_status');
				$pa_verified_status = $verified_status != null ? $verified_status : "";
			}


			$data = array(
				'country_id' => $country_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'contributor_id' => $contributor_id,
				'respondent_id' => $respondent_id,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'user_id' => $user_id,
				// 'survey_id' => $survey_id,
				"page_no" => $page_no,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"pa_verified_status" => $pa_verified_status,
				"is_pa_verified_status" => $pa_verified_status != null,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = array();
			$result['submited_data'] = $this->Reports_model->survey_submited_contributor_data($data);
			$result['total_records'] = $this->Reports_model->survey_contributor_records($data);
			$result['user_role'] = $this->session->userdata('role');
			$result['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
			$result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();
			$result['lkp_uai'] = $this->db->select('*')->where('status', 1)->get('lkp_uai')->result_array();
			$result['lkp_sub_location'] = $this->db->select('*')->where('status', 1)->get('lkp_sub_location')->result_array();
			
			$result['lkp_location_type'] = $this->db->select('*')->where('status', 1)->get('lkp_location_type')->result_array();
			$result['lkp_animal_type_lactating'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type_lactating')->result_array();
			$result['respondent_name'] = $this->db->select('first_name, last_name,data_id')->where('status', 1)->get('tbl_respondent_users')->result_array();

			$result['lkp_education_level'] = $this->db->select('*')->where('status', 1)->get('lkp_education_level')->result_array();

			$result['lkp_occupation'] = $this->db->select('*')->where('status', 1)->get('lkp_occupation')->result_array();
			$result['lkp_market'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
			$result['lkp_transport_means'] = $this->db->select('*')->where('status', 1)->get('lkp_transport_means')->result_array();
			$result['lkp_group'] = $this->db->select('*')->where('status', 1)->get('lkp_group')->result_array();
	
			
			$result['title'] = "";
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function get_approved_contributor_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$country_id = $this->input->post('country_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$contributor_id = $this->input->post('contributor_id');
			$respondent_id = $this->input->post('respondent_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$user_id = $this->session->userdata('login_id');
			// $survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }
			 $search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}


			$data = array(
				'country_id' => $country_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'contributor_id' => $contributor_id,
				'respondent_id' => $respondent_id,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'user_id' => $user_id,
				// 'survey_id' => $survey_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = array();
			$result['submited_data'] = $this->Reports_model->survey_approved_contributor_data($data);
			$result['total_records'] = $this->Reports_model->survey_approved_contributor_records($data);
			$result['user_role'] = $this->session->userdata('role');
			$result['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
			$result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();
			$result['lkp_uai'] = $this->db->select('*')->where('status', 1)->get('lkp_uai')->result_array();
			$result['lkp_sub_location'] = $this->db->select('*')->where('status', 1)->get('lkp_sub_location')->result_array();
			
			$result['lkp_location_type'] = $this->db->select('*')->where('status', 1)->get('lkp_location_type')->result_array();
			$result['lkp_animal_type_lactating'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type_lactating')->result_array();
			$result['respondent_name'] = $this->db->select('first_name, last_name,data_id')->where('status', 1)->get('tbl_respondent_users')->result_array();
			$result['lkp_education_level'] = $this->db->select('*')->where('status', 1)->get('lkp_education_level')->result_array();

			$result['lkp_occupation'] = $this->db->select('*')->where('status', 1)->get('lkp_occupation')->result_array();
			$result['lkp_market'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
			$result['lkp_transport_means'] = $this->db->select('*')->where('status', 1)->get('lkp_transport_means')->result_array();
			$result['lkp_group'] = $this->db->select('*')->where('status', 1)->get('lkp_group')->result_array();
			$result['cluster_admin'] = $this->db->select('concat(first_name," ", last_name) as verified_by, user_id')->where('status', 1)->where('role_id', 6)->get('tbl_users')->result_array();
			
			$result['title'] = "";
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function get_rejected_contributor_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$country_id = $this->input->post('country_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$contributor_id = $this->input->post('contributor_id');
			$respondent_id = $this->input->post('respondent_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$user_id = $this->session->userdata('login_id');
			// $survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }
			 $search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}


			$data = array(
				'country_id' => $country_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'contributor_id' => $contributor_id,
				'respondent_id' => $respondent_id,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'user_id' => $user_id,
				// 'survey_id' => $survey_id,
				"page_no" => $page_no,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = array();
			$result['submited_data'] = $this->Reports_model->survey_rejected_contributor_data($data);
			$result['total_records'] = $this->Reports_model->survey_rejected_contributor_records($data);
			$result['user_role'] = $this->session->userdata('role');
			$result['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
			$result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();
			$result['lkp_uai'] = $this->db->select('*')->where('status', 1)->get('lkp_uai')->result_array();
			$result['lkp_sub_location'] = $this->db->select('*')->where('status', 1)->get('lkp_sub_location')->result_array();
			
			$result['lkp_location_type'] = $this->db->select('*')->where('status', 1)->get('lkp_location_type')->result_array();
			$result['lkp_animal_type_lactating'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type_lactating')->result_array();
			$result['respondent_name'] = $this->db->select('first_name, last_name,data_id')->where('status', 1)->get('tbl_respondent_users')->result_array();
			$result['lkp_education_level'] = $this->db->select('*')->where('status', 1)->get('lkp_education_level')->result_array();

			$result['lkp_occupation'] = $this->db->select('*')->where('status', 1)->get('lkp_occupation')->result_array();
			$result['lkp_market'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
			$result['lkp_transport_means'] = $this->db->select('*')->where('status', 1)->get('lkp_transport_means')->result_array();
			$result['lkp_group'] = $this->db->select('*')->where('status', 1)->get('lkp_group')->result_array();
			$result['cluster_admin'] = $this->db->select('concat(first_name," ", last_name) as verified_by, user_id')->where('status', 1)->where('role_id', 6)->get('tbl_users')->result_array();
			
			$result['title'] = "";
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function get_submited_household_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$country_id = $this->input->post('country_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$contributor_id = $this->input->post('contributor_id');
			$respondent_id = $this->input->post('respondent_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$user_id = $this->session->userdata('login_id');
			// $survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }

			$search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}

			$pa_verified_status = "";
			if ($this->input->post('pa_verified_status')) {
				$verified_status = $this->input->post('pa_verified_status');
				$pa_verified_status = $verified_status != null ? $verified_status : "";
			}


			$data = array(
				'country_id' => $country_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'contributor_id' => $contributor_id,
				'respondent_id' => $respondent_id,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'user_id' => $user_id,
				// 'survey_id' => $survey_id,
				"page_no" => $page_no,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"pa_verified_status" => $pa_verified_status,
				"is_pa_verified_status" => $pa_verified_status != null,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = array();
			$result['submited_data'] = $this->Reports_model->survey_submited_household_data($data);
			$result['total_records'] = $this->Reports_model->survey_household_records($data);
			$result['user_role'] = $this->session->userdata('role');
			$result['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
			$result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();
			$result['lkp_uai'] = $this->db->select('*')->where('status', 1)->get('lkp_uai')->result_array();
			$result['lkp_sub_location'] = $this->db->select('*')->where('status', 1)->get('lkp_sub_location')->result_array();
			
			$result['lkp_location_type'] = $this->db->select('*')->where('status', 1)->get('lkp_location_type')->result_array();
			$result['lkp_animal_type_lactating'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type_lactating')->result_array();
			$result['respondent_name'] = $this->db->select('first_name, last_name,data_id')->where('status', 1)->get('tbl_respondent_users')->result_array();
			$result['lkp_education_level'] = $this->db->select('*')->where('status', 1)->get('lkp_education_level')->result_array();

			$result['lkp_occupation'] = $this->db->select('*')->where('status', 1)->get('lkp_occupation')->result_array();
			$result['lkp_market'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
			$result['lkp_transport_means'] = $this->db->select('*')->where('status', 1)->get('lkp_transport_means')->result_array();
			$result['lkp_group'] = $this->db->select('*')->where('status', 1)->get('lkp_group')->result_array();
			$result['lkp_issues_imapct_on_household'] = $this->db->select('*')->where('status', 1)->get('lkp_issues_imapct_on_household')->result_array();
	
			
			$result['title'] = "";
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function get_approved_household_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$country_id = $this->input->post('country_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$contributor_id = $this->input->post('contributor_id');
			$respondent_id = $this->input->post('respondent_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$user_id = $this->session->userdata('login_id');
			// $survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }

			$search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}


			$data = array(
				'country_id' => $country_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'contributor_id' => $contributor_id,
				'respondent_id' => $respondent_id,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'user_id' => $user_id,
				// 'survey_id' => $survey_id,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			// $result = $this->Reports_model->survey_details($survey_id);
			$result['submited_data'] = $this->Reports_model->survey_approved_household_data($data);
			$result['total_records'] = $this->Reports_model->survey_approved_household_records($data);
			$result['user_role'] = $this->session->userdata('role');
			$result['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
			$result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();
			$result['lkp_uai'] = $this->db->select('*')->where('status', 1)->get('lkp_uai')->result_array();
			$result['lkp_sub_location'] = $this->db->select('*')->where('status', 1)->get('lkp_sub_location')->result_array();
			
			$result['lkp_location_type'] = $this->db->select('*')->where('status', 1)->get('lkp_location_type')->result_array();
			$result['lkp_animal_type_lactating'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type_lactating')->result_array();
			$result['respondent_name'] = $this->db->select('first_name, last_name,data_id')->where('status', 1)->get('tbl_respondent_users')->result_array();
			$result['lkp_education_level'] = $this->db->select('*')->where('status', 1)->get('lkp_education_level')->result_array();

			$result['lkp_occupation'] = $this->db->select('*')->where('status', 1)->get('lkp_occupation')->result_array();
			$result['lkp_market'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
			$result['lkp_transport_means'] = $this->db->select('*')->where('status', 1)->get('lkp_transport_means')->result_array();
			$result['lkp_group'] = $this->db->select('*')->where('status', 1)->get('lkp_group')->result_array();
			// $result['lkp_group'] = $this->db->select('*')->where('status', 1)->get('lkp_group')->result_array();
			$result['lkp_issues_imapct_on_household'] = $this->db->select('*')->where('status', 1)->get('lkp_issues_imapct_on_household')->result_array();
			$result['cluster_admin'] = $this->db->select('concat(first_name," ", last_name) as verified_by, user_id')->where('status', 1)->where('role_id', 6)->get('tbl_users')->result_array();
			// $result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function get_rejected_household_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$country_id = $this->input->post('country_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$contributor_id = $this->input->post('contributor_id');
			$respondent_id = $this->input->post('respondent_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$user_id = $this->session->userdata('login_id');
			// $survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }
			 $search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}


			$data = array(
				'country_id' => $country_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'contributor_id' => $contributor_id,
				'respondent_id' => $respondent_id,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'user_id' => $user_id,
				// 'survey_id' => $survey_id,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			// $result = $this->Reports_model->survey_details($survey_id);
			$result['submited_data'] = $this->Reports_model->survey_rejected_household_data($data);
			$result['total_records'] = $this->Reports_model->survey_rejected_household_records($data);
			$result['user_role'] = $this->session->userdata('role');
			$result['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
			$result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();
			$result['lkp_uai'] = $this->db->select('*')->where('status', 1)->get('lkp_uai')->result_array();
			$result['lkp_sub_location'] = $this->db->select('*')->where('status', 1)->get('lkp_sub_location')->result_array();
			$result['lkp_location_type'] = $this->db->select('*')->where('status', 1)->get('lkp_location_type')->result_array();
			$result['lkp_animal_type_lactating'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type_lactating')->result_array();
			$result['respondent_name'] = $this->db->select('first_name, last_name,data_id')->where('status', 1)->get('tbl_respondent_users')->result_array();
			$result['lkp_education_level'] = $this->db->select('*')->where('status', 1)->get('lkp_education_level')->result_array();

			$result['lkp_occupation'] = $this->db->select('*')->where('status', 1)->get('lkp_occupation')->result_array();
			$result['lkp_market'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
			$result['lkp_transport_means'] = $this->db->select('*')->where('status', 1)->get('lkp_transport_means')->result_array();
			$result['lkp_group'] = $this->db->select('*')->where('status', 1)->get('lkp_group')->result_array();
			// $result['lkp_group'] = $this->db->select('*')->where('status', 1)->get('lkp_group')->result_array();
			$result['lkp_issues_imapct_on_household'] = $this->db->select('*')->where('status', 1)->get('lkp_issues_imapct_on_household')->result_array();
			$result['cluster_admin'] = $this->db->select('concat(first_name," ", last_name) as verified_by, user_id')->where('status', 1)->where('role_id', 6)->get('tbl_users')->result_array();
			// $result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}

	public function get_submited_transect_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$country_id = $this->input->post('country_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$contributor_id = $this->input->post('contributor_id');
			$pasture_type = $this->input->post('pasture_type');
			$user_id = $this->session->userdata('login_id');
			// $survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }

			$search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}
			$pa_verified_status = "";
			if ($this->input->post('pa_verified_status')) {
				$verified_status = $this->input->post('pa_verified_status');
				$pa_verified_status = $verified_status != null ? $verified_status : "";
			}


			$data = array(
				'country_id' => $country_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'contributor_id' => $contributor_id,
				'pasture_type' => $pasture_type,
				'user_id' => $user_id,
				// 'survey_id' => $survey_id,
				"page_no" => $page_no,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"is_pa_verified_status" => $pa_verified_status != null,
				"pa_verified_status" => $pa_verified_status,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = array();
			$result['submited_data'] = $this->Reports_model->survey_submited_transect_data($data);
			$result['total_records'] = $this->Reports_model->survey_transect_records($data);
			$result['user_role'] = $this->session->userdata('role');
			$result['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
			$result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();
			$result['lkp_uai'] = $this->db->select('*')->where('status', 1)->get('lkp_uai')->result_array();
			$result['lkp_sub_location'] = $this->db->select('*')->where('status', 1)->get('lkp_sub_location')->result_array();
			
			$result['lkp_location_type'] = $this->db->select('*')->where('status', 1)->get('lkp_location_type')->result_array();
			$result['lkp_animal_type_lactating'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type_lactating')->result_array();
			$result['respondent_name'] = $this->db->select('first_name, last_name,data_id')->where('status', 1)->get('tbl_respondent_users')->result_array();
	
			
			$result['title'] = "";
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}

	public function get_approved_transect_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$country_id = $this->input->post('country_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$contributor_id = $this->input->post('contributor_id');
			$pasture_type = $this->input->post('pasture_type');
			$user_id = $this->session->userdata('login_id');
			// $survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }

			$search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}


			$data = array(
				'country_id' => $country_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'contributor_id' => $contributor_id,
				'pasture_type' => $pasture_type,
				'user_id' => $user_id,
				// 'survey_id' => $survey_id,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			// $result = $this->Reports_model->survey_details($survey_id);
			$result['submited_data'] = $this->Reports_model->survey_approved_transect_data($data);
			$result['total_records'] = $this->Reports_model->survey_approved_transect_records($data);
			$result['user_role'] = $this->session->userdata('role');
			$result['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
			$result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();
			$result['lkp_uai'] = $this->db->select('*')->where('status', 1)->get('lkp_uai')->result_array();
			$result['lkp_sub_location'] = $this->db->select('*')->where('status', 1)->get('lkp_sub_location')->result_array();
			
			$result['lkp_location_type'] = $this->db->select('*')->where('status', 1)->get('lkp_location_type')->result_array();
			$result['lkp_animal_type_lactating'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type_lactating')->result_array();
			$result['respondent_name'] = $this->db->select('first_name, last_name,data_id')->where('status', 1)->get('tbl_respondent_users')->result_array();

			
			// $result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}

	public function get_rejected_transect_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$country_id = $this->input->post('country_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$contributor_id = $this->input->post('contributor_id');
			$pasture_type = $this->input->post('pasture_type');
			$user_id = $this->session->userdata('login_id');
			// $survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }
			 $search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}


			$data = array(
				'country_id' => $country_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'contributor_id' => $contributor_id,
				'pasture_type' => $pasture_type,
				'user_id' => $user_id,
				// 'survey_id' => $survey_id,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			// $result = $this->Reports_model->survey_details($survey_id);
			$result['submited_data'] = $this->Reports_model->survey_rejected_transect_data($data);
			$result['total_records'] = $this->Reports_model->survey_rejected_transect_records($data);
			$result['user_role'] = $this->session->userdata('role');
			$result['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
			$result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();
			$result['lkp_uai'] = $this->db->select('*')->where('status', 1)->get('lkp_uai')->result_array();
			$result['lkp_sub_location'] = $this->db->select('*')->where('status', 1)->get('lkp_sub_location')->result_array();
			$result['lkp_location_type'] = $this->db->select('*')->where('status', 1)->get('lkp_location_type')->result_array();
			$result['lkp_animal_type_lactating'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type_lactating')->result_array();
			$result['respondent_name'] = $this->db->select('first_name, last_name,data_id')->where('status', 1)->get('tbl_respondent_users')->result_array();

			
			// $result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	


	public function getClusterByCountry(){

		$cluster_id_ar = array();
		if($this->session->userdata('role') != 1 && $this->session->userdata('role') != 2) {
			$login_user_id = $this->session->userdata('login_id');
			$this->db->select('cluster_id');
			$this->db->where('user_id', $login_user_id)->where('status', 1)->group_by('cluster_id');
			$user_unit_location = $this->db->get('tbl_user_unit_location')->result_array();
			if(!empty($user_unit_location)){
				foreach ($user_unit_location as $key => $value) {
					$cluster_id_ar[] = $value['cluster_id'];
				}
			}
		}

		$country_id = $this->input->post('country_id');
		$options = '';
		$uai_options = '';
		$options .= '<option value="">Select Cluster </option>';
		$uai_options .= '<option value="">Select UAI </option>';
		if(!empty($country_id)){
			if(!empty($cluster_id_ar)){
				$this->db->where_in('cluster_id', $cluster_id_ar);
			}
			$clusters = $this->db->where('country_id', $country_id)->where('status', 1)->get('lkp_cluster')->result_array();
			if(!empty($clusters)){
				$columns = array_column($clusters, "name");
				array_multisort($columns, SORT_ASC, $clusters);
				foreach ($clusters as $key => $value) {
					$options .= '<option value="'.$value['cluster_id'].'">'.$value['name'].'</option>';
				}
			}
			
		}
		echo $options;
		die();
	}
	public function getUaiByCountry(){
		$uai_id_ar = array();
		if($this->session->userdata('role') != 1 && $this->session->userdata('role') != 2) {
			$login_user_id = $this->session->userdata('login_id');
			$this->db->select('uai_id');
			$this->db->where('user_id', $login_user_id)->where('status', 1)->group_by('uai_id');
			$user_unit_location = $this->db->get('tbl_user_unit_location')->result_array();
			if(!empty($user_unit_location)){
				foreach ($user_unit_location as $key => $value) {
					$uai_id_ar[] = $value['uai_id'];
				}
			}
		}
		$country_id = $this->input->post('country_id');
		$options = '';
		$options .= '<option value="">Select UAI </option>';
		if(!empty($country_id)){
			if(!empty($uai_id_ar)){
				$this->db->where_in('uai_id', $uai_id_ar);
			}
			$uais = $this->db->where('country_id', $country_id)->where('status', 1)->get('lkp_uai')->result_array();
			if(!empty($uais)){
				$columns = array_column($uais, "uai");
				array_multisort($columns, SORT_ASC, $uais);
				foreach ($uais as $key => $uvalue) {
					$options .= '<option value="'.$uvalue['uai_id'].'">'.$uvalue['uai'].'</option>';
				}
			}
			
		}
		echo $options;
		die();
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
	public function getContributerByCluster(){
		$user_id_ar = array();
		$cluster_id = $this->input->post('cluster_id');
		$this->db->select('user_id');
		$this->db->where('cluster_id', $cluster_id)->where('status', 1)->group_by('user_id');
		$user_unit_location = $this->db->get('tbl_user_unit_location')->result_array();
		if(!empty($user_unit_location)){
			foreach ($user_unit_location as $key => $value) {
				$user_id_ar[] = $value['user_id'];
			}
		}
		$options = '';
		$options .= '<option value="">Select Contributor </option>';
		// if(!empty($cluster_id)){
			if(!empty($user_id_ar)){
				$this->db->where_in('user_id', $user_id_ar);
			}
			$this->db->where('role_id',8);
			$contributors = $this->db->where('status', 1)->get('tbl_users')->result_array();
			if(!empty($contributors)){
				$columns = array_column($contributors, "username");
				array_multisort($columns, SORT_ASC, $contributors);
				foreach ($contributors as $key => $value) {
					$options .= '<option value="'.$value['user_id'].'">'.$value['first_name'].' '.$value['last_name'].'</option>';
				}
			}
		// }
		echo $options;
		die();
	}
	public function getMarketsByUai(){
		$uai_id = $this->input->post('uai_id');
		$options = '';
		$options .= '<option value="">Select Market </option>';
		if(!empty($uai_id)){
			$sub_locations = $this->db->where('uai_id', $uai_id)->where('status', 1)->get('lkp_market')->result_array();
			if(!empty($sub_locations)){
				$columns = array_column($sub_locations, "name");
				array_multisort($columns, SORT_ASC, $sub_locations);
				foreach ($sub_locations as $key => $uvalue) {
					$options .= '<option value="'.$uvalue['market_id'].'">'.$uvalue['name'].'</option>';
				}
			}
			
		}
		echo $options;
		die();
	}
	public function getMarketsByUaiCountry(){
		$country_id = $this->input->post('country_id');
		$options = '';
		$options .= '<option value="">Select Market </option>';
		if(!empty($country_id)){
			$sub_locations = $this->db->where('country_id', $country_id)->where('status', 1)->get('lkp_market')->result_array();
			if(!empty($sub_locations)){
				$columns = array_column($sub_locations, "name");
				array_multisort($columns, SORT_ASC, $sub_locations);
				foreach ($sub_locations as $key => $uvalue) {
					$options .= '<option value="'.$uvalue['market_id'].'">'.$uvalue['name'].'</option>';
				}
			}
			// print_r($this->db->last_query());exit();
		}
		// print_r($country_id);exit();
		echo $options;
		die();
	}
	public function getMarketsByUaiCountry1(){
		$country_id = $this->input->post('country_id');
		$options = '';
		$options .= '<option value="" >Select Market </option>';
		if(!empty($country_id)){
			// $this->db->where('uai_id !=', null);
			// $sub_locations = $this->db->where('country_id', $country_id)->where('status', 1)->get('lkp_market')->result_array();
			$sub_locations = $this->db->where('country_id', $country_id)->where('status', 1)->get('lkp_market_map')->result_array();
			if(!empty($sub_locations)){
				$columns = array_column($sub_locations, "name");
				array_multisort($columns, SORT_ASC, $sub_locations);
				foreach ($sub_locations as $key => $uvalue) {
					// $options .= '<option value="'.$uvalue['market_id'].'">'.$uvalue['name'].'</option>';
					$options .= '<option value="'.$uvalue['market_map_id'].'">'.$uvalue['name'].'</option>';
				}
			}
			// print_r($this->db->last_query());exit();
		}
		// print_r($country_id);exit();
		echo $options;
		die();
	}
	public function getUaiByCountry1(){
		
		$country_id = $this->input->post('country_id');
		$options = '';
		$options .= '<option value="" >Select UAI </option>';
		if(!empty($country_id)){
			
			$uais = $this->db->where('country_id', $country_id)->where('status', 1)->get('lkp_uai')->result_array();
			if(!empty($uais)){
				$columns = array_column($uais, "uai");
				array_multisort($columns, SORT_ASC, $uais);
				foreach ($uais as $key => $uvalue) {
					$options .= '<option value="'.$uvalue['uai_id'].'">'.$uvalue['uai'].'</option>';
				}
			}
			
		}
		echo $options;
		die();
	}
	public function getMarketsByCountry(){
		$country_id = $this->input->post('country_id');
		$options = '';
		$options .= '<option value="">Select Market </option>';
		if(!empty($country_id)){
			$sub_locations = $this->db->where('country_id', $country_id)->where('status', 1)->get('lkp_market')->result_array();
			if(!empty($sub_locations)){
				$columns = array_column($sub_locations, "name");
				array_multisort($columns, SORT_ASC, $sub_locations);
				foreach ($sub_locations as $key => $uvalue) {
					$options .= '<option value="'.$uvalue['market_id'].'">'.$uvalue['name'].'</option>';
				}
			}
			
		}
		echo $options;
		die();
	}
	public function getMarketsByCluster(){
		$user_id_ar = array();
		$cluster_id = $this->input->post('cluster_id');
		
		$options = '';
		$options .= '<option value="">Select Market </option>';
		if(!empty($cluster_id)){
			$sub_locations = $this->db->where('cluster_id', $cluster_id)->where('status', 1)->get('lkp_market')->result_array();
			if(!empty($sub_locations)){
				$columns = array_column($sub_locations, "location_name");
				array_multisort($columns, SORT_ASC, $sub_locations);
				foreach ($sub_locations as $key => $uvalue) {
					$options .= '<option value="'.$uvalue['market_id'].'">'.$uvalue['name'].'</option>';
				}
			}
		}
		echo $options;
		die();
	}
	public function getContributorBySubLocation(){
		$user_id_ar = array();
		$sub_location_id = $this->input->post('sub_location_id');
		$this->db->select('user_id');
		$this->db->where('sub_loc_id', $sub_location_id)->where('status', 1)->group_by('user_id');
		$user_unit_location = $this->db->get('tbl_user_unit_location')->result_array();
		if(!empty($user_unit_location)){
			foreach ($user_unit_location as $key => $value) {
				$user_id_ar[] = $value['user_id'];
			}
		}
		$options = '';
		$options .= '<option value="">Select Contributor </option>';
		// if(!empty($cluster_id)){
			if(!empty($user_id_ar)){
				$this->db->where_in('user_id', $user_id_ar);
			}
			$this->db->where('role_id',8);
			$contributors = $this->db->where('status', 1)->get('tbl_users')->result_array();
			if(!empty($contributors)){
				$columns = array_column($contributors, "username");
				array_multisort($columns, SORT_ASC, $contributors);
				foreach ($contributors as $key => $value) {
					$options .= '<option value="'.$value['user_id'].'">'.$value['first_name'].' '.$value['last_name'].'</option>';
				}
			}
		// }
		echo $options;
		die();
	}
	public function getContributorByCountry(){
		$user_id_ar = array();
		$country_id = $this->input->post('country_id');
		$this->db->select('user_id');
		$this->db->where('country_id', $country_id)->where('status', 1)->group_by('user_id');
		$user_unit_location = $this->db->get('tbl_user_unit_location')->result_array();
		if(!empty($user_unit_location)){
			foreach ($user_unit_location as $key => $value) {
				$user_id_ar[] = $value['user_id'];
			}
		}
		$options = '';
		$options .= '<option value="">Select Contributor </option>';
		// if(!empty($cluster_id)){
			if(!empty($user_id_ar)){
				$this->db->where_in('user_id', $user_id_ar);
			}
			$this->db->where('role_id',8);
			$contributors = $this->db->where('status', 1)->get('tbl_users')->result_array();
			if(!empty($contributors)){
				$columns = array_column($contributors, "username");
				array_multisort($columns, SORT_ASC, $contributors);
				foreach ($contributors as $key => $value) {
					$options .= '<option value="'.$value['user_id'].'">'.$value['first_name'].' '.$value['last_name'].'</option>';
				}
			}
		// }
		echo $options;
		die();
	}
	public function getContributorByUAI(){
		$user_id_ar = array();
		$uai_id = $this->input->post('uai_id');
		$this->db->select('user_id');
		$this->db->where('uai_id', $uai_id)->where('status', 1)->group_by('user_id');
		$user_unit_location = $this->db->get('tbl_user_unit_location')->result_array();
		if(!empty($user_unit_location)){
			foreach ($user_unit_location as $key => $value) {
				$user_id_ar[] = $value['user_id'];
			}
		}
		$options = '';
		$options .= '<option value="">Select Contributor </option>';
		// if(!empty($cluster_id)){
			if(!empty($user_id_ar)){
				$this->db->where_in('user_id', $user_id_ar);
			}
			$this->db->where('role_id',8);
			$contributors = $this->db->where('status', 1)->get('tbl_users')->result_array();
			if(!empty($contributors)){
				$columns = array_column($contributors, "username");
				array_multisort($columns, SORT_ASC, $contributors);
				foreach ($contributors as $key => $value) {
					$options .= '<option value="'.$value['user_id'].'">'.$value['first_name'].' '.$value['last_name'].'</option>';
				}
			}
		// }
		echo $options;
		die();
	}
	
	public function getRespondentByContributor(){
		$contributor_id = $this->input->post('contributor_id');
		$page_id = $this->input->post('page_id');
		$options = '';
		$options .= '<option value="">Select Respondent </option>';
		if(!empty($contributor_id)){
			if($page_id == 1){
				$this->db->where_in('pa_verified_status', [1,2]);
			}else{
				$this->db->where('pa_verified_status', 2);
			}			
			$respondents = $this->db->where('added_by', $contributor_id)->where('status', 1)->get('tbl_respondent_users')->result_array();
			// print_r($this->db->last_query());exit();
			if(!empty($respondents)){
				$columns = array_column($respondents, "first_name");
				array_multisort($columns, SORT_ASC, $respondents);
				foreach ($respondents as $key => $uvalue) {
					$options .= '<option value="'.$uvalue['data_id'].'">'.$uvalue['first_name'].' '.$uvalue['last_name'].'</option>';
				}
			}
			
		}
		echo $options;
		die();
	}
	public function getDistrictByState(){
		$district_id_ar = array();
		if($this->session->userdata('role') != 1 && $this->session->userdata('role') != 2) {
			$login_user_id = $this->session->userdata('login_id');
			$this->db->select('district_id');
			$this->db->where('user_id', $login_user_id)->where('status', 1)->group_by('district_id');
			$user_unit_location = $this->db->get('tbl_user_unit_location')->result_array();
			if(!empty($user_unit_location)){
				foreach ($user_unit_location as $key => $value) {
					$district_id_ar[] = $value['district_id'];
				}
			}
		}

		$state_id = $this->input->post('state_id');
		$options = '';
		$options .= '<option value="">Select District </option>';
		if(!empty($state_id)){
			if(!empty($district_id_ar)){
				$this->db->where_in('district_id', $district_id_ar);
			}
			$districts = $this->db->where('state_id', $state_id)->where('status', 1)->get('lkp_district')->result_array();
			if(!empty($districts)){
				$columns = array_column($districts, "district_name");
				array_multisort($columns, SORT_ASC, $districts);
				foreach ($districts as $key => $value) {
					$options .= '<option value="'.$value['district_id'].'">'.$value['district_name'].'</option>';
				}
			}
		}
		echo $options;
		die();
	}
	public function getDistrictCode(){
		$district_id = $this->input->post('district_id');
		$options = '';
		if(!empty($district_id)){
			$districts = $this->db->where('district_id', $district_id)->where('status', 1)->get('lkp_district')->row();
			if(!empty($districts)){
				$options = $districts->district_code;
			}
		}
		echo $options;
		die();
	}
	public function getDSByDistrict(){
		$ds_id_ar = array();
		if($this->session->userdata('role') != 1 && $this->session->userdata('role') != 2) {
			$login_user_id = $this->session->userdata('login_id');
			$this->db->select('ds_id');
			$this->db->where('user_id', $login_user_id)->where('status', 1)->group_by('ds_id');
			$user_unit_location = $this->db->get('tbl_user_unit_location')->result_array();
			if(!empty($user_unit_location)){
				foreach ($user_unit_location as $key => $value) {
					$ds_id_ar[] = $value['ds_id'];
				}
				if(!empty($ds_id_ar)){
					$this->db->select('ds_id');
					$this->db->where_in('ds_id', $ds_id_ar)->where('status', 1)->group_by('ds_id');
					$tehsil_res = $this->db->get('lkp_ds')->result_array();
					if(!empty($tehsil_res)){
						foreach ($tehsil_res as $key => $t_val) {
							$ds_id_ar[] = $t_val['ds_id'];
						}
					}
				}
			}
		}

		$district_id = $this->input->post('district_id');
		$options = '';
		$options .= '<option value="">Select DS </option>';
		if(!empty($district_id)){
			if(!empty($ds_id_ar)){
				$this->db->where_in('ds_id', $ds_id_ar);
			}
			$ds = $this->db->where('district_id', $district_id)->where('status', 1)->get('lkp_ds')->result_array();
			if(!empty($ds)){
				$columns = array_column($ds, "ds_name");
				array_multisort($columns, SORT_ASC, $ds);
				foreach ($ds as $key => $value) {
					$options .= '<option value="'.$value['ds_id'].'">'.$value['ds_name'].'</option>';
				}
			}
		}
		echo $options;
		die();
	}
	public function getDSCode(){
		$ds_id = $this->input->post('ds_id');
		$options = '';
		if(!empty($ds_id)){
			$ds = $this->db->where('ds_id', $ds_id)->where('status', 1)->get('lkp_ds')->row();
			if(!empty($ds)){
				$options = $ds->ds_code;
			}
		}
		echo $options;
		die();
	}
	public function getAscByDS(){
		$tehsil_id_ar = array();
		if($this->session->userdata('role') != 1 && $this->session->userdata('role') != 2) {
			$login_user_id = $this->session->userdata('login_id');
			$this->db->select('tehsil_id');
			$this->db->where('user_id', $login_user_id)->where('status', 1)->group_by('tehsil_id');
			$user_unit_location = $this->db->get('tbl_user_unit_location')->result_array();
			if(!empty($user_unit_location)){
				foreach ($user_unit_location as $key => $value) {
					$tehsil_id_ar[] = $value['tehsil_id'];
				}
			}
		}

		// $district_id = $this->input->post('district_id');
		$ds_id = $this->input->post('ds_id');
		$options = '';
		$options .= '<option value="">Select ASC </option>';
		if(!empty($ds_id)){
			if(!empty($tehsil_id_ar)){
				$this->db->where_in('tehsil_id', $tehsil_id_ar);
			}
			$ascs = $this->db->where('ds_id', $ds_id)->where('tehsil_status', 1)->get('lkp_tehsil')->result_array();
			if(!empty($ascs)){
				$columns = array_column($ascs, "tehsil_name");
				array_multisort($columns, SORT_ASC, $ascs);
				foreach ($ascs as $key => $value) {
					$options .= '<option value="'.$value['tehsil_id'].'">'.$value['tehsil_name'].'</option>';
				}
			}
		}
		echo $options;
		die();
	}
	public function getASCCode(){
		$tehsil_id = $this->input->post('asc_id');
		$options = '';
		if(!empty($tehsil_id)){
			$ascs = $this->db->where('tehsil_id', $tehsil_id)->where('tehsil_status', 1)->get('lkp_tehsil')->row();
			if(!empty($ascs)){
				$options = $ascs->tehsil_code;
			}
		}
		echo $options;
		die();
	}
	public function getBlockByAsc(){
		$block_id_ar = array();
		if($this->session->userdata('role') != 1 && $this->session->userdata('role') != 2) {
			$login_user_id = $this->session->userdata('login_id');
			$this->db->select('block_id');
			$this->db->where('user_id', $login_user_id)->where('status', 1)->group_by('block_id');
			$user_unit_location = $this->db->get('tbl_user_unit_location')->result_array();
			if(!empty($user_unit_location)){
				foreach ($user_unit_location as $key => $value) {
					$block_id_ar[] = $value['block_id'];
				}
			}
		}

		$asc_id = $this->input->post('asc_id');
		$options = '';
		$options .= '<option value="">Select ARPA </option>';
		if(!empty($asc_id)){
			if(!empty($block_id_ar)){
				$this->db->where_in('block_id', $block_id_ar);
			}
			$block = $this->db->where('tehsil_id', $asc_id)->where('block_status', 1)->get('lkp_block')->result_array();
			if(!empty($block)){
				$columns = array_column($block, "block_name");
				array_multisort($columns, SORT_ASC, $block);
				foreach ($block as $key => $value) {
					$options .= '<option value="'.$value['block_id'].'">'.$value['block_name'].'</option>';
				}
			}
		}
		echo $options;
		die();
	}
	public function getBlockCode(){
		$block_id = $this->input->post('block_id');
		$options = '';
		if(!empty($block_id)){
			$block = $this->db->where('block_id', $block_id)->where('block_status', 1)->get('lkp_block')->row();
			if(!empty($block)){
				$options = $block->block_code;
			}
		}
		echo $options;
		die();
	}
	public function getGNByBlock(){
		$grampanchayat_id_ar = array();
		if($this->session->userdata('role') != 1 && $this->session->userdata('role') != 2) {
			$login_user_id = $this->session->userdata('login_id');
			$this->db->select('grampanchayat_id');
			$this->db->where('user_id', $login_user_id)->where('status', 1)->group_by('grampanchayat_id');
			$user_unit_location = $this->db->get('tbl_user_unit_location')->result_array();
			if(!empty($user_unit_location)){
				foreach ($user_unit_location as $key => $value) {
					$grampanchayat_id_ar[] = $value['grampanchayat_id'];
				}
			}
		}

		$block_id = $this->input->post('block_id');
		$options = '';
		$options .= '<option value="">Select GND </option>';
		if(!empty($block_id)){			
			if(!empty($grampanchayat_id_ar)){
				$this->db->where_in('grampanchayat_id', $grampanchayat_id_ar);
			}
			$grampanchayat = $this->db->where('block_id', $block_id)->where('grampanchayat_status', 1)->get('lkp_grampanchayat')->result_array();
			if(!empty($grampanchayat)){
				$columns = array_column($grampanchayat, "grampanchayat_name");
				array_multisort($columns, SORT_ASC, $grampanchayat);
				foreach ($grampanchayat as $key => $value) {
					$options .= '<option value="'.$value['grampanchayat_id'].'">'.$value['grampanchayat_name'].'</option>';
				}
			}
		}
		echo $options;
		die();
	}
	public function getGNCode(){
		$grampanchayat_id = $this->input->post('grampanchayat_id');
		$options = '';
		if(!empty($grampanchayat_id)){
			$grampanchayat = $this->db->where('grampanchayat_id', $grampanchayat_id)->where('grampanchayat_status', 1)->get('lkp_grampanchayat')->row();
			if(!empty($grampanchayat)){
				$options = $grampanchayat->grampanchayat_code;
			}
		}
		echo $options;
		die();
	}
	public function view_farm_data_copy()
	{
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$survey_id = $this->uri->segment(3);
		$parent_id = $this->uri->segment(4);
		$user_id = $this->session->userdata('login_id');
		$role = $this->session->userdata('role');

		$this->load->model('Reports_model');
		$result = $this->Reports_model->survey_details_farm($survey_id, $parent_id);
		$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();
		$result['district_list'] = $this->db->select('dt.*, tul.district_id')->from('lkp_district as dt')->join('tbl_user_unit_location AS tul', 'tul.district_id = dt.district_id')->where('tul.user_id', $user_id)->where('dt.status', 1)->group_by('tul.district_id')->get()->result_array();

		$result['ds_list'] = $this->db->select('ds.*, tul.ds_id')->from('lkp_ds as ds')->join('tbl_user_unit_location AS tul', 'tul.ds_id = ds.ds_id')->where('tul.user_id', $user_id)->where('ds.status', 1)->group_by('tul.ds_id')->get()->result_array();

		$result['asc_list'] = $this->db->select('th.*, tul.tehsil_id')->from('lkp_tehsil as th')->join('tbl_user_unit_location AS tul', 'tul.tehsil_id = th.tehsil_id')->where('tul.user_id', $user_id)->where('th.tehsil_status', 1)->group_by('tul.tehsil_id')->get()->result_array();

		$result['block_list'] = $this->db->select('bc.*, tul.block_id')->from('lkp_block as bc')->join('tbl_user_unit_location AS tul', 'tul.block_id = bc.block_id')->where('tul.user_id', $user_id)->where('bc.block_status', 1)->group_by('tul.block_id')->get()->result_array();

		$result['gn_list'] = $this->db->select('gn.*, tul.block_id')->from('lkp_grampanchayat as gn')->join('tbl_user_unit_location AS tul', 'tul.grampanchayat_id = gn.grampanchayat_id')->where('tul.user_id', $user_id)->where('grampanchayat_status', 1)->group_by('tul.grampanchayat_id')->get()->result_array();

		
		$result['survey_locations'] = $this->Reports_model->survey_location($survey_id);

		$user_states = array();
		$user_districts = array();
		$user_ds = array();
		$user_thasils = array();
		$user_block = array();
		$user_gpns = array();

		if($_POST)
		{
			$state_id = array();

			if($this->session->userdata('role') != 1){
				$this->db->select('state_id, district_id, ds_id, tehsil_id, block_id, grampanchayat_id');
				if(!empty($_POST['state_id'])){
					$state_id= $_POST['state_id'];
					$this->session->set_userdata("states",$state_id);
					$this->db->where_in('state_id', $state_id);
				}
				if(!empty($_POST['district_id'])){
					$district_id= $_POST['district_id'];
					$this->session->set_userdata("districts",$district_id);
					$this->db->where_in('district_id', $district_id);
				}
				if(!empty($_POST['ds_id'])){
					$ds_id= $_POST['ds_id'];
					$this->session->set_userdata("ds",$ds_id);
					$this->db->where_in('ds_id', $ds_id);
				}
				if(!empty($_POST['asc_id'])){
					$asc_id= $_POST['asc_id'];
					$this->session->set_userdata("ascs",$asc_id);
					$this->db->where_in('tehsil_id', $asc_id);
				}
				if(!empty($_POST['block_id'])){
					$block_id= $_POST['block_id'];
					$this->session->set_userdata("blocks",$block_id);
					$this->db->where_in('block_id', $block_id);
				}
				if(!empty($_POST['gn_id'])){
					$gn_id= $_POST['gn_id'];
					$this->session->set_userdata("gns",$gn_id);
					$this->db->where_in('grampanchayat_id', $gn_id);
				}
				if($this->session->userdata('role') != 1 || $this->session->userdata('role') != 2){
					$this->db->where('user_id', $user_id)->where('status', 1);
				}else{
					$this->db->where('status', 1);
				}
				$mapingdata = $this->db->get('tbl_user_unit_location')->result_array();
				// print_r($mapingdata); exit;
				if(!empty($mapingdata)){
					foreach($mapingdata as $key => $value){
						$user_states[$key] = $value['state_id'];
						$user_districts[$key] = $value['district_id'];
						$user_ds[$key] = $value['ds_id'];
						$user_thasils[$key] = $value['tehsil_id'];
						$user_block[$key] = $value['block_id'];
						$user_gpns[$key] = $value['grampanchayat_id'];
					}
				}
			}else{
				if(!empty($_POST['state_id'])){
					$state_id= $_POST['state_id'];
					$this->session->set_userdata("states",$state_id);
					$user_states = $state_id;
				}
				if(!empty($_POST['district_id'])){
					$district_id= $_POST['district_id'];
					$this->session->set_userdata("districts",$district_id);
					$user_districts = $district_id;
				}
				if(!empty($_POST['ds_id'])){
					$ds_id= $_POST['ds_id'];
					$this->session->set_userdata("ds",$ds_id);
					$user_ds = $ds_id;
				}
				if(!empty($_POST['asc_id'])){
					$asc_id= $_POST['asc_id'];
					$this->session->set_userdata("ascs",$asc_id);
					$user_thasils = $asc_id;
				}
				if(!empty($_POST['block_id'])){
					$block_id= $_POST['block_id'];
					$this->session->set_userdata("blocks",$block_id);
					$user_block = $block_id;
				}
				if(!empty($_POST['gn_id'])){
					$gn_id= $_POST['gn_id'];
					$this->session->set_userdata("gns",$gn_id);
					$user_gpns = $gn_id;
				}
			}
		}else{
			$this->db->select('state_id, district_id, ds_id, tehsil_id, block_id, grampanchayat_id');
			if($this->session->userdata('role') != 1 || $this->session->userdata('role') != 2){
				$this->db->where('user_id', $user_id)->where('status', 1);
			}else{
				$this->db->where('status', 1);
			}
			$mapingdata = $this->db->get('tbl_user_unit_location')->result_array();
			if(!empty($mapingdata)){
				foreach($mapingdata as $key => $value){
					$user_states[$key] = $value['state_id'];
					$user_districts[$key] = $value['district_id'];
					$user_ds[$key] = $value['ds_id'];
					$user_thasils[$key] = $value['tehsil_id'];
					$user_block[$key] = $value['block_id'];
					$user_gpns[$key] = $value['grampanchayat_id'];
				}
			}

		}
		// print_r($mapingdata);die();

		// Get Survey Data
			$this->db->select('survey.*, tu.first_name, tu.last_name');
			$this->db->from('survey'.$survey_id.' AS survey');
			$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
			if($survey_id == 5){	
				if($parent_id == '196'){
					$this->db->where('survey.field_1968 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1962', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1962', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1963', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1962', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1963', $mapingdata['block_id']);
						$this->db->where_in('survey.field_1964', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1962', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1963', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1968', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_1960', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_1961', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_1962', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_1963', $user_block);
					}
				}
				elseif($parent_id == '262'){
					$this->db->where('survey.field_1969 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
						$this->db->where_in('survey.field_285', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
						$this->db->where_in('survey.field_285', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_287', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
						$this->db->where_in('survey.field_285', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_287', $mapingdata['block_id']);
						$this->db->where_in('survey.field_289', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
						$this->db->where_in('survey.field_285', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_287', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1969', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_281', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_283', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_285', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_287', $user_block);
					}
				}
				elseif($parent_id == '902'){
					$this->db->where('survey.field_1970 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
						$this->db->where_in('survey.field_918', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
						$this->db->where_in('survey.field_918', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_920', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
						$this->db->where_in('survey.field_918', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_920', $mapingdata['block_id']);
						$this->db->where_in('survey.field_922', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
						$this->db->where_in('survey.field_918', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_920', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1970', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_914', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_916', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_918', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_920', $user_block);
					}
				}
				elseif($parent_id == '566'){
					$this->db->where('survey.field_1971 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1974', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1974', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1975', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1974', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1975', $mapingdata['block_id']);
						$this->db->where_in('survey.field_1976', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1974', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1975', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1971', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_1972', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_1973', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_1974', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_1975', $user_block);
					}
				}
				elseif($parent_id == '750'){
					$this->db->where('survey.field_1978 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1981', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1981', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1982', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1981', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1982', $mapingdata['block_id']);
						$this->db->where_in('survey.field_1983', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1981', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1982', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1978', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_1979', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_1980', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_1981', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_1982', $user_block);
					}
				}
				elseif($parent_id == '822'){
					$this->db->where('survey.field_1985 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1988', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1988', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1989', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1988', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1989', $mapingdata['block_id']);
						$this->db->where_in('survey.field_1990', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1988', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1989', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1985', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_1986', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_1987', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_1988', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_1989', $user_block);
					}
				}
			}
			if($this->session->userdata('role') == 10){
				$this->db->where('survey.user_id', $user_id);
			}
			if(isset($start_date) && !is_null($start_date)) {
				$this->db->where('DATE(survey.datetime) >=', $start_date.' 00:00:00');
			} else if(isset($end_date) && !is_null($end_date)) {
				$this->db->where('DATE(survey.datetime) <=', $end_date.' 23:59:59');
			}
			$this->db->where('survey.status', 2);
			$survey_data = $this->db->order_by('survey.id', 'DESC')->get()->result_array();
			foreach ($survey_data as $key => $value) {
				// Get files attached
				$this->db->select('file_name');
	            $this->db->where('data_id', $value['data_id'])->where('status', 1);
	            $this->db->where('form_id', $survey_id);
				if($survey_id == 5){
					$this->db->where('field_id', 1122);
				}
				$survey_images = $this->db->get('ic_data_file')->row_array();

				 $survey_data[$key]['images'] = "N/A";
				if(isset($survey_images)){
	            	 $survey_data[$key]['images'] = $survey_images['file_name'];
				}
	            // $survey_data[$key]['images'] = $this->db->get('ic_data_file')->result_array();
				
				// Convert Upload Time to IST
				$date = new DateTime($survey_data[$key]['datetime'], new DateTimeZone('UTC'));
				$date->setTimezone(new DateTimeZone('Asia/Kolkata'));
				$survey_data[$key]['datetime'] = $date->format('Y-m-d H:i:s');

				if($survey_id == 5){
					$this->db->select('file_name');
					$this->db->where('kml_status', 1)->where('plot_data_id', $value['data_id'])->where('comment', 1104);
					$value_kml_1104 = $this->db->get('tbl_kmlfile')->row_array();
					if(isset($value_kml_1104)){
						$survey_data[$key]['field_1104'] = $value_kml_1104['file_name'];
					}
					$this->db->select('file_name');
					$this->db->where('kml_status', 1)->where('plot_data_id', $value['data_id'])->where('comment', 394);
					$value_kml_394 = $this->db->get('tbl_kmlfile')->row_array();
					if(isset($value_kml_394)){
						$survey_data[$key]['field_394'] = $value_kml_394['file_name'];
					}
					$this->db->select('file_name');
					$this->db->where('kml_status', 1)->where('plot_data_id', $value['data_id'])->where('comment', 1040);
					$value_kml_1040 = $this->db->get('tbl_kmlfile')->row_array();
					if(isset($value_kml_1040)){
						$survey_data[$key]['field_1040'] = $value_kml_1040['file_name'];
					}
				}			
			}
			$result['survey_data'] = $survey_data;

		// Get Survey submited Data
			$this->db->select('survey.*, tu.first_name, tu.last_name');
			$this->db->from('survey'.$survey_id.' AS survey');
			$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
			if($survey_id == 5){	
				if($parent_id == '196'){
					$this->db->where('survey.field_1968 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1962', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1962', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1963', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1962', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1963', $mapingdata['block_id']);
						$this->db->where_in('survey.field_1964', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1962', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1963', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1968', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_1960', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_1961', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_1962', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_1963', $user_block);
					}
				}
				elseif($parent_id == '262'){
					$this->db->where('survey.field_1969 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
						$this->db->where_in('survey.field_285', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
						$this->db->where_in('survey.field_285', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_287', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
						$this->db->where_in('survey.field_285', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_287', $mapingdata['block_id']);
						$this->db->where_in('survey.field_289', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
						$this->db->where_in('survey.field_285', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_287', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1969', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_281', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_283', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_285', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_287', $user_block);
					}
				}
				elseif($parent_id == '902'){
					$this->db->where('survey.field_1970 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
						$this->db->where_in('survey.field_918', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
						$this->db->where_in('survey.field_918', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_920', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
						$this->db->where_in('survey.field_918', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_920', $mapingdata['block_id']);
						$this->db->where_in('survey.field_922', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
						$this->db->where_in('survey.field_918', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_920', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1970', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_914', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_916', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_918', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_920', $user_block);
					}
				}
				elseif($parent_id == '566'){
					$this->db->where('survey.field_1971 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1974', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1974', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1975', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1974', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1975', $mapingdata['block_id']);
						$this->db->where_in('survey.field_1976', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1974', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1975', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1971', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_1972', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_1973', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_1974', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_1975', $user_block);
					}
				}
				elseif($parent_id == '750'){
					$this->db->where('survey.field_1978 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1981', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1981', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1982', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1981', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1982', $mapingdata['block_id']);
						$this->db->where_in('survey.field_1983', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1981', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1982', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1978', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_1979', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_1980', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_1981', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_1982', $user_block);
					}
				}
				elseif($parent_id == '822'){
					$this->db->where('survey.field_1985 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1988', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1988', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1989', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1988', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1989', $mapingdata['block_id']);
						$this->db->where_in('survey.field_1990', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1988', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1989', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1985', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_1986', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_1987', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_1988', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_1989', $user_block);
					}
				}
			}
			if($this->session->userdata('role') == 10){
				$this->db->where('survey.user_id', $user_id);
			}
			if(isset($start_date) && !is_null($start_date)) {
				$this->db->where('DATE(survey.datetime) >=', $start_date.' 00:00:00');
			} else if(isset($end_date) && !is_null($end_date)) {
				$this->db->where('DATE(survey.datetime) <=', $end_date.' 23:59:59');
			}
			$this->db->where('survey.status', 1);
			$submited_data = $this->db->order_by('survey.id', 'DESC')->get()->result_array();
			foreach ($submited_data as $key => $value) {
				// Get files attached
				$this->db->select('file_name');
	            $this->db->where('data_id', $value['data_id'])->where('status', 1);
	            $this->db->where('form_id', $survey_id);
				if($survey_id == 5){
					$this->db->where('field_id', 1122);
				}
	            $submited_images = $this->db->get('ic_data_file')->row_array();

				$submited_data[$key]['images'] = "N/A";
				if(isset($submited_images)){
	            	 $submited_data[$key]['images'] = $submited_images['file_name'];
				}
				
				// Convert Upload Time to IST
				$date = new DateTime($submited_data[$key]['datetime'], new DateTimeZone('UTC'));
				$date->setTimezone(new DateTimeZone('Asia/Kolkata'));
				$submited_data[$key]['datetime'] = $date->format('Y-m-d H:i:s');
				if($survey_id == 5){
					$this->db->select('file_name');
					$this->db->where('kml_status', 1)->where('plot_data_id', $value['data_id'])->where('comment', 1104);
					$value_kml_1104 = $this->db->get('tbl_kmlfile')->row_array();
					if(isset($value_kml_1104)){
						$submited_data[$key]['field_1104'] = $value_kml_1104['file_name'];
					}
					$this->db->select('file_name');
					$this->db->where('kml_status', 1)->where('plot_data_id', $value['data_id'])->where('comment', 394);
					$value_kml_394 = $this->db->get('tbl_kmlfile')->row_array();
					if(isset($value_kml_394)){
						$submited_data[$key]['field_394'] = $value_kml_394['file_name'];
					}
					$this->db->select('file_name');
					$this->db->where('kml_status', 1)->where('plot_data_id', $value['data_id'])->where('comment', 1040);
					$value_kml_1040 = $this->db->get('tbl_kmlfile')->row_array();
					if(isset($value_kml_1040)){
						$rejected_data[$key]['field_1040'] = $value_kml_1040['file_name'];
					}
				}
			}
			$result['submited_data'] = $submited_data;

		// Get Rejected Data
			$this->db->select('survey.*, tu.first_name, tu.last_name');
			$this->db->from('survey'.$survey_id.' AS survey');
			$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
			if($survey_id == 5){	
				if($parent_id == '196'){
					$this->db->where('survey.field_1968 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1962', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1962', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1963', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1962', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1963', $mapingdata['block_id']);
						$this->db->where_in('survey.field_1964', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1968', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1960', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1962', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1963', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1968', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_1960', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_1961', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_1962', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_1963', $user_block);
					}
				}
				elseif($parent_id == '262'){
					$this->db->where('survey.field_1969 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
						$this->db->where_in('survey.field_285', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
						$this->db->where_in('survey.field_285', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_287', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
						$this->db->where_in('survey.field_285', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_287', $mapingdata['block_id']);
						$this->db->where_in('survey.field_289', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1969', $mapingdata['state_id']);
						$this->db->where_in('survey.field_281', $mapingdata['district_id']);
						$this->db->where_in('survey.field_285', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_287', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1969', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_281', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_283', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_285', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_287', $user_block);
					}
				}
				elseif($parent_id == '902'){
					$this->db->where('survey.field_1970 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
						$this->db->where_in('survey.field_918', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
						$this->db->where_in('survey.field_918', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_920', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
						$this->db->where_in('survey.field_918', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_920', $mapingdata['block_id']);
						$this->db->where_in('survey.field_922', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1970', $mapingdata['state_id']);
						$this->db->where_in('survey.field_914', $mapingdata['district_id']);
						$this->db->where_in('survey.field_918', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_920', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1970', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_914', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_916', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_918', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_920', $user_block);
					}
				}
				elseif($parent_id == '566'){
					$this->db->where('survey.field_1971 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1974', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1974', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1975', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1974', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1975', $mapingdata['block_id']);
						$this->db->where_in('survey.field_1976', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1971', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1972', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1974', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1975', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1971', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_1972', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_1973', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_1974', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_1975', $user_block);
					}
				}
				elseif($parent_id == '750'){
					$this->db->where('survey.field_1978 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1981', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1981', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1982', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1981', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1982', $mapingdata['block_id']);
						$this->db->where_in('survey.field_1983', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1978', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1979', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1981', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1982', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1978', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_1979', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_1980', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_1981', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_1982', $user_block);
					}
				}
				elseif($parent_id == '822'){
					$this->db->where('survey.field_1985 !=', null);
					/*if($this->session->userdata('role') == 5){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
					}elseif($this->session->userdata('role') == 7){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
					}elseif($this->session->userdata('role') == 8){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1988', $mapingdata['tehsil_id']);
					}elseif($this->session->userdata('role') == 9){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1988', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1989', $mapingdata['block_id']);
					}elseif($this->session->userdata('role') == 10){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1988', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1989', $mapingdata['block_id']);
						$this->db->where_in('survey.field_1990', $mapingdata['grampanchayat_id']);
						$this->db->where('survey.user_id', $user_id);
					}elseif($this->session->userdata('role') == 11){
						$this->db->where_in('survey.field_1985', $mapingdata['state_id']);
						$this->db->where_in('survey.field_1986', $mapingdata['district_id']);
						$this->db->where_in('survey.field_1988', $mapingdata['tehsil_id']);
						$this->db->where_in('survey.field_1989', $mapingdata['block_id']);
					}*/
					if(!empty($user_states)){
						$this->db->where_in('survey.field_1985', $user_states);
					}
					if(!empty($user_districts)){
						$this->db->where_in('survey.field_1986', $user_districts);
					}
					if(!empty($user_ds)){
						$this->db->where_in('survey.field_1987', $user_ds);
					}
					if(!empty($user_thasils)){
						$this->db->where_in('survey.field_1988', $user_thasils);
					}
					if(!empty($user_block)){
						$this->db->where_in('survey.field_1989', $user_block);
					}
				}
			}
			if($this->session->userdata('role') == 10){
				$this->db->where('survey.user_id', $user_id);
			}
			if(isset($start_date) && !is_null($start_date)) {
				$this->db->where('DATE(survey.datetime) >=', $start_date.' 00:00:00');
			} else if(isset($end_date) && !is_null($end_date)) {
				$this->db->where('DATE(survey.datetime) <=', $end_date.' 23:59:59');
			}
			$this->db->where('survey.status', 3);
			$rejected_data = $this->db->order_by('survey.id', 'DESC')->get()->result_array();
			foreach ($rejected_data as $key => $value) {
				// Get files attached
				$this->db->select('file_name');
	            $this->db->where('data_id', $value['data_id'])->where('status', 1);
	            $this->db->where('form_id', $survey_id);
				if($survey_id == 5){
					$this->db->where('field_id', 1122);
				}
	            $rejected_images = $this->db->get('ic_data_file')->row_array();

				$rejected_data[$key]['images'] = "N/A";
				if(isset($rejected_images)){
	            	$rejected_data[$key]['images'] = $rejected_images['file_name'];
				}
				
				// Convert Upload Time to IST
				$date = new DateTime($rejected_data[$key]['datetime'], new DateTimeZone('UTC'));
				$date->setTimezone(new DateTimeZone('Asia/Kolkata'));
				$rejected_data[$key]['datetime'] = $date->format('Y-m-d H:i:s');
				if($survey_id == 5){
					$this->db->select('file_name');
					$this->db->where('kml_status', 1)->where('plot_data_id', $value['data_id'])->where('comment', 1104);
					$value_kml_1104 = $this->db->get('tbl_kmlfile')->row_array();
					if(isset($value_kml_1104)){
						$rejected_data[$key]['field_1104'] = $value_kml_1104['file_name'];
					}
					$this->db->select('file_name');
					$this->db->where('kml_status', 1)->where('plot_data_id', $value['data_id'])->where('comment', 394);
					$value_kml_394 = $this->db->get('tbl_kmlfile')->row_array();
					if(isset($value_kml_394)){
						$rejected_data[$key]['field_394'] = $value_kml_394['file_name'];
					}
					$this->db->select('file_name');
					$this->db->where('kml_status', 1)->where('plot_data_id', $value['data_id'])->where('comment', 1040);
					$value_kml_1040 = $this->db->get('tbl_kmlfile')->row_array();
					if(isset($value_kml_1040)){
						$rejected_data[$key]['field_1040'] = $value_kml_1040['file_name'];
					}
				}
			}
			$result['rejected_data'] = $rejected_data;

		
			$postData_ = array(
				"page_no" => 1,
				"status" => 1,
				"record_per_page" => 100,
				"is_pagination" => false
			);
			$customData = $this->FormModel->get_all_forms_p($postData_);
			$this->load->view('header');
			$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('reports/view_farm_surveydata', $result);
		$this->load->view('footer');
	}

	public function view_farm_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$survey_id = $this->uri->segment(3);
		$user_id = $this->session->userdata('login_id');

		$this->load->model('Reports_model');
		// $result['survey_locations'] = $this->Reports_model->survey_location($survey_id);

		$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();

		
        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('reports/view_farm_surveydata', $result);
		$this->load->view('footer');
	}

	public function get_submited_farm_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$block_id = $this->input->post('block_id');
			$gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');
			$parent_id = $this->uri->segment(4);

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }


			$data = array(
				'state_id' => $state_id,
				'district_id' => $district_id,
				'ds_id' => $ds_id,
				'asc_id' => $asc_id,
				'block_id' => $block_id,
				'gn_id' => $gn_id,
				'user_id' => $user_id,
				'survey_id' => $survey_id,
				'parent_id' => $parent_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details_farm($survey_id, $parent_id);
			$result['submited_data'] = $this->Reports_model->survey_submited_farm_data($data);
			$result['total_records'] = $this->Reports_model->survey_submited_farm_data_count($data);
			$result['user_role'] = $this->session->userdata('role');
			

			$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('dist.*, tul.district_id')->from('lkp_district as dist')->join('tbl_user_unit_location AS tul', 'tul.district_id = dist.district_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['district_list'] = $this->db->where('dist.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('ds.*, tul.ds_id')->from('lkp_ds as ds')->join('tbl_user_unit_location AS tul', 'tul.ds_id = ds.ds_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['ds_list'] = $this->db->where('ds.status', 1)->group_by('tul.ds_id')->get()->result_array();
			
			$this->db->select('asc.*, tul.tehsil_id')->from('lkp_tehsil as asc')->join('tbl_user_unit_location AS tul', 'tul.tehsil_id = asc.tehsil_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['asc_list'] = $this->db->where('asc.tehsil_status', 1)->group_by('tul.tehsil_id')->get()->result_array();
			
			$this->db->select('blk.*, tul.block_id')->from('lkp_block as blk')->join('tbl_user_unit_location AS tul', 'tul.block_id = blk.block_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['block_list'] = $this->db->where('blk.block_status', 1)->group_by('tul.block_id')->get()->result_array();
			
			$this->db->select('gn.*, tul.grampanchayat_id')->from('lkp_grampanchayat as gn')->join('tbl_user_unit_location AS tul', 'tul.grampanchayat_id = gn.grampanchayat_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['gn_list'] = $this->db->where('gn.grampanchayat_status', 1)->group_by('gn.grampanchayat_id')->get()->result_array();
			
			$result['crop_list'] = $this->db->where('status', 1)->get('lkp_crop')->result_array();
			$result['branch_list'] = $this->db->where('branch_status', 1)->get('lkp_branch_details')->result_array();
			$result['bank_list'] = $this->db->where('bank_status', 1)->get('lkp_farmer_bank_details')->result_array();
			// $result['village_list'] = $this->db->where('village_status', 1)->get('lkp_village')->result_array();
			$result['village_list'] = array();
			if($parent_id == '196'){
				$result['title'] = "Residence & HG";
			}elseif($parent_id == '262'){
				$result['title'] = "Paddy Lands";
			}elseif($parent_id == '902'){
				$result['title'] = "High Lands";
			}elseif($parent_id == '566'){
				$result['title'] = "Commercial Animal Management";
			}elseif($parent_id == '750'){
				$result['title'] = "Argo-enterprises & Technology";
			}elseif($parent_id == '822'){
				$result['title'] = "Information and Financial Affairs";
			}
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}

	public function get_approved_farm_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$block_id = $this->input->post('block_id');
			$gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');
			$parent_id = $this->uri->segment(4);

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }


			$data = array(
				'state_id' => $state_id,
				'district_id' => $district_id,
				'ds_id' => $ds_id,
				'asc_id' => $asc_id,
				'block_id' => $block_id,
				'gn_id' => $gn_id,
				'user_id' => $user_id,
				'survey_id' => $survey_id,
				'parent_id' => $parent_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details_farm($survey_id, $parent_id);
			// $result['submited_data'] = $this->Reports_model->survey_submited_farm_data($data);
			$result['submited_data'] = $this->Reports_model->survey_approved_farm_data($data);
			$result['total_records'] = $this->Reports_model->survey_approved_farm_data_count($data);
			$result['user_role'] = $this->session->userdata('role');


			$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('dist.*, tul.district_id')->from('lkp_district as dist')->join('tbl_user_unit_location AS tul', 'tul.district_id = dist.district_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['district_list'] = $this->db->where('dist.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('ds.*, tul.ds_id')->from('lkp_ds as ds')->join('tbl_user_unit_location AS tul', 'tul.ds_id = ds.ds_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['ds_list'] = $this->db->where('ds.status', 1)->group_by('tul.ds_id')->get()->result_array();
			
			$this->db->select('asc.*, tul.tehsil_id')->from('lkp_tehsil as asc')->join('tbl_user_unit_location AS tul', 'tul.tehsil_id = asc.tehsil_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['asc_list'] = $this->db->where('asc.tehsil_status', 1)->group_by('tul.tehsil_id')->get()->result_array();
			
			$this->db->select('blk.*, tul.block_id')->from('lkp_block as blk')->join('tbl_user_unit_location AS tul', 'tul.block_id = blk.block_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['block_list'] = $this->db->where('blk.block_status', 1)->group_by('tul.block_id')->get()->result_array();
			
			$this->db->select('gn.*, tul.grampanchayat_id')->from('lkp_grampanchayat as gn')->join('tbl_user_unit_location AS tul', 'tul.grampanchayat_id = gn.grampanchayat_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['gn_list'] = $this->db->where('gn.grampanchayat_status', 1)->group_by('gn.grampanchayat_id')->get()->result_array();
			
			$result['crop_list'] = $this->db->where('status', 1)->get('lkp_crop')->result_array();
			$result['branch_list'] = $this->db->where('branch_status', 1)->get('lkp_branch_details')->result_array();
			$result['bank_list'] = $this->db->where('bank_status', 1)->get('lkp_farmer_bank_details')->result_array();
			// $result['village_list'] = $this->db->where('village_status', 1)->get('lkp_village')->result_array();
			$result['village_list'] = array();
			if($parent_id == '196'){
				$result['title'] = "Residence & HG";
			}elseif($parent_id == '262'){
				$result['title'] = "Paddy Lands";
			}elseif($parent_id == '902'){
				$result['title'] = "High Lands";
			}elseif($parent_id == '566'){
				$result['title'] = "Commercial Animal Management";
			}elseif($parent_id == '750'){
				$result['title'] = "Argo-enterprises & Technology";
			}elseif($parent_id == '822'){
				$result['title'] = "Information and Financial Affairs";
			}
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}

	public function get_rejected_farm_data_view(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$block_id = $this->input->post('block_id');
			$gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');
			$parent_id = $this->uri->segment(4);

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }


			$data = array(
				'state_id' => $state_id,
				'district_id' => $district_id,
				'ds_id' => $ds_id,
				'asc_id' => $asc_id,
				'block_id' => $block_id,
				'gn_id' => $gn_id,
				'user_id' => $user_id,
				'survey_id' => $survey_id,
				'parent_id' => $parent_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			// $result = $this->Reports_model->survey_details($survey_id);
			$result = $this->Reports_model->survey_details_farm($survey_id, $parent_id);
			$result['submited_data'] = $this->Reports_model->survey_rejected_farm_data($data);
			$result['total_records'] = $this->Reports_model->survey_rejected_farm_data_count($data);
			$result['user_role'] = $this->session->userdata('role');


			$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('dist.*, tul.district_id')->from('lkp_district as dist')->join('tbl_user_unit_location AS tul', 'tul.district_id = dist.district_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['district_list'] = $this->db->where('dist.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('ds.*, tul.ds_id')->from('lkp_ds as ds')->join('tbl_user_unit_location AS tul', 'tul.ds_id = ds.ds_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['ds_list'] = $this->db->where('ds.status', 1)->group_by('tul.ds_id')->get()->result_array();
			
			$this->db->select('asc.*, tul.tehsil_id')->from('lkp_tehsil as asc')->join('tbl_user_unit_location AS tul', 'tul.tehsil_id = asc.tehsil_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['asc_list'] = $this->db->where('asc.tehsil_status', 1)->group_by('tul.tehsil_id')->get()->result_array();
			
			$this->db->select('blk.*, tul.block_id')->from('lkp_block as blk')->join('tbl_user_unit_location AS tul', 'tul.block_id = blk.block_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['block_list'] = $this->db->where('blk.block_status', 1)->group_by('tul.block_id')->get()->result_array();
			
			$this->db->select('gn.*, tul.grampanchayat_id')->from('lkp_grampanchayat as gn')->join('tbl_user_unit_location AS tul', 'tul.grampanchayat_id = gn.grampanchayat_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['gn_list'] = $this->db->where('gn.grampanchayat_status', 1)->group_by('gn.grampanchayat_id')->get()->result_array();
			
			$result['crop_list'] = $this->db->where('status', 1)->get('lkp_crop')->result_array();
			$result['branch_list'] = $this->db->where('branch_status', 1)->get('lkp_branch_details')->result_array();
			$result['bank_list'] = $this->db->where('bank_status', 1)->get('lkp_farmer_bank_details')->result_array();
			// $result['village_list'] = $this->db->where('village_status', 1)->get('lkp_village')->result_array();
			$result['village_list'] = array();
			if($parent_id == '196'){
				$result['title'] = "Residence & HG";
			}elseif($parent_id == '262'){
				$result['title'] = "Paddy Lands";
			}elseif($parent_id == '902'){
				$result['title'] = "High Lands";
			}elseif($parent_id == '566'){
				$result['title'] = "Commercial Animal Management";
			}elseif($parent_id == '750'){
				$result['title'] = "Argo-enterprises & Technology";
			}elseif($parent_id == '822'){
				$result['title'] = "Information and Financial Affairs";
			}
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}

	public function groupData()
	{
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		$survey_id = $this->uri->segment(3);
		$groupfield_id = $this->uri->segment(4);
		$data_id = $this->uri->segment(5);
		$user_id = $this->session->userdata('login_id');

		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);

		$table_name = 'survey'.$survey_id.'_groupdata';
		$this->load->model('Reports_model');
		$result = array();
		$result['fields'] = $this->db->where('parent_id', $groupfield_id)->where('status', 1)->order_by('slno', 'ASC')->get('form_field')->result_array();
		
		$result['group_data'] = $this->db->where('data_id', $data_id)->where('groupfield_id', $groupfield_id)->where('status', 1)->get($table_name)->result_array();

		
        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('menu',$menu_result);
		$this->load->view('reports/view_surveygroupdata', $result);
		$this->load->view('footer');
	}

	public function inv_verify_data(){
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

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}

			$ids = $this->input->post('check_sub_inv');

		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}
		$survey_id = $this->uri->segment(3);
		$survey_table = 'survey'.$survey_id;
		$survey_grouptable = 'survey'.$survey_id.'_groupdata';
		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$currentDateTime = date('Y-m-d H:i:s');

			$this->db->select('asc_verified_status, da_verified_status, status');
            $this->db->where('id', $id);
            $approval_status = $this->db->get($survey_table)->row_array();

			if($this->session->userdata('role') == 8){
				if(isset($approval_status)){
					if($approval_status['da_verified_status'] == null){
						if($this->input->post('status') == 0){
							$status = 3;
						}else{
							$status = $approval_status['status'];
						}
					}elseif($approval_status['da_verified_status'] == 0){
						$status = 3;
					}else{
						if($this->input->post('status') == 0){
							$status = 3;
						}else{
							$status = 2;
						}
					}
				}
				$verification = array(
					'asc_verified_status' => $this->input->post('status'),
					'asc_verified_id' => $this->session->userdata('login_id'),
					'asc_verified_date' => $currentDateTime,
					'status' => $status
				);

			}elseif($this->session->userdata('role') == 7){
				if(isset($approval_status)){
					if($approval_status['asc_verified_status'] == null){
						if($this->input->post('status') == 0){
							$status = 3;
						}else{
							$status = $approval_status['status'];
						}
					}elseif($approval_status['asc_verified_status'] == 0){
						$status = 3;
					}else{
						if($this->input->post('status') == 0){
							$status = 3;
						}else{
							$status = 2;
						}
					}
				}
				$verification = array(
					'da_verified_status' => $this->input->post('status'),
					'da_verified_id' => $this->session->userdata('login_id'),
					'da_verified_date' => $currentDateTime,
					'status' => $status
				);
			}elseif($this->session->userdata('role') == 1){
				$status = 3;
				$verification = array(
					'status' => $status
				);
			}
			
			
			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);
			// var_dump($this->db->last_query());exit;
			if($query){
				$this->db->select('data_id');
				$this->db->where('id', $id);
				$record_status = $this->db->get($survey_table)->row_array();
				// var_dump($record_status);exit;
				if(!empty($record_status['data_id'])){
					$gverification = array(
						'status' => $status
					);
					if ($this->db->table_exists($survey_grouptable))
					{
						$group_query = $this->db->where('data_id', $record_status['data_id'])->update($survey_grouptable, $gverification);
					}
				}
				
				
			}
			
		}

		$result['status'] = 1;
		$result['msg'] = 'Data verified successfully.';
		$result['verified_by'] = $this->session->userdata('name');
		$result['verified_role'] = $this->session->userdata('role');
		echo json_encode($result);
		exit();
	}

	public function generate_slip_data(){
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

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}

		$ids = $this->input->post('check_sub_ap');
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}
		$survey_id = $this->uri->segment(3);
		$survey_table = 'survey'.$survey_id;
		$survey_grouptable = 'survey'.$survey_id.'_groupdata';
		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$currentDateTime = date('Y-m-d H:i:s');

			$this->db->select('asc_verified_status, da_verified_status, status');
            $this->db->where('id', $id);
            $approval_status = $this->db->get($survey_table)->row_array();

			if($this->session->userdata('role') == 1){
				if(isset($approval_status)){
					if($approval_status['da_verified_status'] == null){
						if($this->input->post('status') == 0){
							$status = 4;
						}else{
							$status = $approval_status['status'];
						}
					}elseif($approval_status['da_verified_status'] == 0){
						$status = 4;
					}else{
						if($this->input->post('status') == 0){
							$status = 4;
						}else{
							$status = 4;
						}
					}
				}
				$verification = array(
					'bank_slip' => 1,
					'bs_generated_by' => $this->session->userdata('login_id'),
					'bs_generated_date' => $currentDateTime,
					'status' => $status
				);

			}
			
			
			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);
			// var_dump($this->db->last_query());exit;
			if($query){
				// $this->db->select('data_id');
				// $this->db->where('id', $id);
				// $record_status = $this->db->get($survey_table)->row_array();
				// // var_dump($record_status);exit;
				// if(!empty($record_status['data_id'])){
				// 	$gverification = array(
				// 		'status' => $status
				// 	);
				// 	if ($this->db->table_exists($survey_grouptable))
				// 	{
				// 		$group_query = $this->db->where('data_id', $record_status['data_id'])->update($survey_grouptable, $gverification);
				// 	}
				// }
				
				
			}
			
		}

		$result['status'] = 1;
		$result['msg'] = 'Slip generated successfully.';
		$result['verified_by'] = $this->session->userdata('name');
		$result['verified_role'] = $this->session->userdata('role');
		echo json_encode($result);
		exit();
	}

	public function bulk_data_delete(){
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);
		// print_r($result); exit;
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';
			echo json_encode($result);
			exit();
		}

		$status = 0;
		$ids = $this->input->post('check_sub');
		$fname = $this->uri->segment(3);
		if($fname == "ap"){
			$ids = $this->input->post('check_sub_ap');
		}else if($fname == "rj"){
			$ids = $this->input->post('check_sub_rj');
		}
		$remarks = $this->input->post('delete_remarks');
		// print_r($remarks);exit;
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}
		
		$survey_id = 15;
		$survey_table = 'survey'.$survey_id;
		$survey_grouptable = 'survey'.$survey_id.'_groupdata';
		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$verification = array(
				'delete_remarks' => $remarks,
				'status' => 0
			);
			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);
			// print_r($this->db->last_query());exit;
			if($query){
				$this->db->select('data_id');
				$this->db->where('id', $id);
				$record_status = $this->db->get($survey_table)->row_array();
				// var_dump($record_status);exit;
				if(!empty($record_status['data_id'])){
					$gverification = array(
						'status' => $status
					);
					if ($this->db->table_exists($survey_grouptable))
					{
						$group_query = $this->db->where('data_id', $record_status['data_id'])->update($survey_grouptable, $gverification);
					}
				}
				
				
			}
			
		}

		$result['status'] = 1;
		$result['msg'] = 'Data Deleted successfully.';
		echo json_encode($result);
		exit();
	}

	public function record_wise_delete(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{

			$status = 0;
			$id = $this->input->post('record_id');
			$remarks = $this->input->post('delete_remarks');
			
			$survey_id = 4;
			$survey_table = 'survey'.$survey_id;
			$survey_grouptable = 'survey'.$survey_id.'_groupdata';

			$verification = array(
				'delete_remarks' => $remarks,
				'status' => 0
			);
			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);
			// print_r($this->db->last_query()); exit;
			if($query){
				$this->db->select('data_id');
				$this->db->where('id', $id);
				$record_status = $this->db->get($survey_table)->row_array();
				// var_dump($record_status);exit;
				if(!empty($record_status['data_id'])){
					$gverification = array(
						'status' => $status
					);
					if ($this->db->table_exists($survey_grouptable))
					{
						$group_query = $this->db->where('data_id', $record_status['data_id'])->update($survey_grouptable, $gverification);
					}
				}
				$result['status'] = 1;
				$result['msg'] = 'Data Deleted successfully.';
				echo json_encode($result);
				exit();
				
				
			}
		}	
	}

	public function duplicate_bulk_data_delete(){
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);
		// print_r($result); exit;
		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';
			echo json_encode($result);
			exit();
		}

		$status = 0;
		$ids = $this->input->post('check_sub');
		$fname = $this->uri->segment(3);
		// if($fname == "ap"){
		// 	$ids = $this->input->post('check_sub_ap');
		// }else if($fname == "rj"){
		// 	$ids = $this->input->post('check_sub_rj');
		// }
		$remarks = $this->input->post('delete_remarks');
		// print_r($remarks);exit;
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again';
			echo json_encode($result);
			exit();
		}
		
		$survey_id = $this->uri->segment(3);
		$survey_table = 'survey'.$survey_id;
		$survey_grouptable = 'survey'.$survey_id.'_groupdata';
		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$verification = array(
				'delete_remarks' => $remarks,
				'status' => 0
			);
			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);
			if($query){
				if($survey_id == 15){
					$this->db->select('data_id, field_2093, field_2188');
					$this->db->where('id', $id);
					$record_status = $this->db->get($survey_table)->row_array();
					if(!empty($record_status['data_id'])){
						$gverification = array(
							'status' => $status
						);
						if ($this->db->table_exists($survey_grouptable))
						{
							$group_query = $this->db->where('data_id', $record_status['data_id'])->update($survey_grouptable, $gverification);
						}
					}
					if(!empty($record_status['field_2093'])){
						$update_fields = array(
							'duplicate_nic' => ""
						);
						$nic_query = $this->db->where('field_2093', $record_status['field_2093'])->update($survey_table, $update_fields);
					}
					if(!empty($record_status['field_2188'])){
						$update_fields = array(
							'duplicate_baccount' => ""
						);
						$bac_query = $this->db->where('field_2188', $record_status['field_2188'])->update($survey_table, $update_fields);
					}
				}
				
				
			}
			
		}

		$result['status'] = 1;
		$result['msg'] = 'Data Deleted successfully.';
		echo json_encode($result);
		exit();
	}
	public function duplicate_record_wise_delete(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{

			$status = 0;
			$id = $this->input->post('record_id');
			$remarks = $this->input->post('delete_remarks');
			
			$survey_id = $this->uri->segment(3);

			$survey_table = 'survey'.$survey_id;
			$survey_grouptable = 'survey'.$survey_id.'_groupdata';

			$verification = array(
				'delete_remarks' => $remarks,
				'status' => 0
			);
			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);
			// print_r($this->db->last_query()); exit;
			if($query){
				if($survey_id == 15){
					$this->db->select('data_id, field_2093, field_2188');
					$this->db->where('id', $id);
					$record_status = $this->db->get($survey_table)->row_array();
					// var_dump($record_status);exit;
					if(!empty($record_status['data_id'])){
						$gverification = array(
							'status' => $status
						);
						if ($this->db->table_exists($survey_grouptable))
						{
							$group_query = $this->db->where('data_id', $record_status['data_id'])->update($survey_grouptable, $gverification);
						}
					}
					if(!empty($record_status['field_2093'])){
						$update_fields = array(
							'duplicate_nic' => ""
						);
						$nic_query = $this->db->where('field_2093', $record_status['field_2093'])->update($survey_table, $update_fields);
					}
					if(!empty($record_status['field_2188'])){
						$update_fields = array(
							'duplicate_baccount' => ""
						);
						$bac_query = $this->db->where('field_2188', $record_status['field_2188'])->update($survey_table, $update_fields);
					}
				}
				$result['status'] = 1 ;
				$result['msg'] = 'Data Deleted successfully.';
				echo json_encode($result);
				exit();
				
				
			}
		}	
	}

	public function verify_farm_data(){
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

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}

		$ids = $this->input->post('check_sub');
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}
		$survey_id = $this->uri->segment(3);
		$parent_id = $this->uri->segment(4);
		$survey_table = 'survey'.$survey_id;
		$survey_grouptable = 'survey'.$survey_id.'_groupdata';
		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$currentDateTime = date('Y-m-d H:i:s');

			if($parent_id == 196){
				$this->db->select('rhg_asc_verified_status, rhg_da_verified_status, asc_verified_status, da_verified_status, status');
	            $this->db->where('id', $id);
	            $approval_status = $this->db->get($survey_table)->row_array();

				// var_dump($approval_status);exit;

				if($this->session->userdata('role') == 8){
					if(isset($approval_status)){
						if($approval_status['rhg_da_verified_status'] == null){
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = $approval_status['status'];
							}
						}elseif($approval_status['rhg_da_verified_status'] == 0){
							$status = 3;
						}else{
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = 2;
							}
						}
					}
					$verification = array(
						'rhg_asc_verified_status' => $this->input->post('status'),
						'rhg_asc_verified_id' => $this->session->userdata('login_id'),
						'rhg_asc_verified_date' => $currentDateTime,
						'asc_verified_status' => $this->input->post('status'),
						'asc_verified_id' => $this->session->userdata('login_id'),
						'asc_verified_date' => $currentDateTime,
						'status' => $status
					);

				}elseif($this->session->userdata('role') == 7){
					if(isset($approval_status)){
						// if($approval_status['rhg_asc_verified_status'] == null){
						if($approval_status['asc_verified_status'] == null){
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = $approval_status['status'];
							}
						// }elseif($approval_status['rhg_asc_verified_status'] == 0){
						}elseif($approval_status['asc_verified_status'] == 0){
							$status = 3;
						}else{
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = 2;
							}
						}
					}
					$verification = array(
						'rhg_da_verified_status' => $this->input->post('status'),
						'rhg_da_verified_id' => $this->session->userdata('login_id'),
						'rhg_da_verified_date' => $currentDateTime,
						'da_verified_status' => $this->input->post('status'),
						'da_verified_id' => $this->session->userdata('login_id'),
						'da_verified_date' => $currentDateTime,
						'status' => $status
					);
				}				
			}
			elseif($parent_id == 262){
				$this->db->select('pl_asc_verified_status, pl_da_verified_status, asc_verified_status, da_verified_status, status');
	            $this->db->where('id', $id);
	            $approval_status = $this->db->get($survey_table)->row_array();

				if($this->session->userdata('role') == 8){
					if(isset($approval_status)){
						if($approval_status['pl_da_verified_status'] == null){
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = $approval_status['status'];
							}
						}elseif($approval_status['pl_da_verified_status'] == 0){
							$status = 3;
						}else{
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = 2;
							}
						}
					}
					$verification = array(
						'pl_asc_verified_status' => $this->input->post('status'),
						'pl_asc_verified_id' => $this->session->userdata('login_id'),
						'pl_asc_verified_date' => $currentDateTime,
						'asc_verified_status' => $this->input->post('status'),
						'asc_verified_id' => $this->session->userdata('login_id'),
						'asc_verified_date' => $currentDateTime,
						'status' => $status
					);

				}elseif($this->session->userdata('role') == 7){
					if(isset($approval_status)){
						// if($approval_status['pl_asc_verified_status'] == null){
						if($approval_status['asc_verified_status'] == null){
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = $approval_status['status'];
							}
						}elseif($approval_status['asc_verified_status'] == 0){
						// }elseif($approval_status['pl_asc_verified_status'] == 0){
							$status = 3;
						}else{
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = 2;
							}
						}
					}
					$verification = array(
						'pl_da_verified_status' => $this->input->post('status'),
						'pl_da_verified_id' => $this->session->userdata('login_id'),
						'pl_da_verified_date' => $currentDateTime,
						'da_verified_status' => $this->input->post('status'),
						'da_verified_id' => $this->session->userdata('login_id'),
						'da_verified_date' => $currentDateTime,
						'status' => $status
					);
				}	
			}
			elseif($parent_id == 902){
				$this->db->select('hl_asc_verified_status, hl_da_verified_status, asc_verified_status, da_verified_status, status');
	            $this->db->where('id', $id);
	            $approval_status = $this->db->get($survey_table)->row_array();

				if($this->session->userdata('role') == 8){
					if(isset($approval_status)){
						if($approval_status['hl_da_verified_status'] == null){
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = $approval_status['status'];
							}
						}elseif($approval_status['hl_da_verified_status'] == 0){
							$status = 3;
						}else{
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = 2;
							}
						}
					}
					$verification = array(
						'hl_asc_verified_status' => $this->input->post('status'),
						'hl_asc_verified_id' => $this->session->userdata('login_id'),
						'hl_asc_verified_date' => $currentDateTime,
						'asc_verified_status' => $this->input->post('status'),
						'asc_verified_id' => $this->session->userdata('login_id'),
						'asc_verified_date' => $currentDateTime,
						'status' => $status
					);

				}elseif($this->session->userdata('role') == 7){
					if(isset($approval_status)){
						// if($approval_status['hl_asc_verified_status'] == null){
						if($approval_status['asc_verified_status'] == null){
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = $approval_status['status'];
							}
						}elseif($approval_status['asc_verified_status'] == 0){
						// }elseif($approval_status['hl_asc_verified_status'] == 0){
							$status = 3;
						}else{
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = 2;
							}
						}
					}
					$verification = array(
						'hl_da_verified_status' => $this->input->post('status'),
						'hl_da_verified_id' => $this->session->userdata('login_id'),
						'hl_da_verified_date' => $currentDateTime,
						'da_verified_status' => $this->input->post('status'),
						'da_verified_id' => $this->session->userdata('login_id'),
						'da_verified_date' => $currentDateTime,
						'status' => $status
					);
				}	
			}
			elseif($parent_id == 566){
				$this->db->select('cam_asc_verified_status, cam_da_verified_status, asc_verified_status, da_verified_status, status');
	            $this->db->where('id', $id);
	            $approval_status = $this->db->get($survey_table)->row_array();

				if($this->session->userdata('role') == 8){
					if(isset($approval_status)){
						if($approval_status['cam_da_verified_status'] == null){
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = $approval_status['status'];
							}
						}elseif($approval_status['cam_da_verified_status'] == 0){
							$status = 3;
						}else{
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = 2;
							}
						}
					}
					$verification = array(
						'cam_asc_verified_status' => $this->input->post('status'),
						'cam_asc_verified_id' => $this->session->userdata('login_id'),
						'cam_asc_verified_date' => $currentDateTime,
						'asc_verified_status' => $this->input->post('status'),
						'asc_verified_id' => $this->session->userdata('login_id'),
						'asc_verified_date' => $currentDateTime,
						'status' => $status
					);

				}elseif($this->session->userdata('role') == 7){
					if(isset($approval_status)){
						// if($approval_status['cam_asc_verified_status'] == null){
						if($approval_status['asc_verified_status'] == null){
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = $approval_status['status'];
							}
						}elseif($approval_status['asc_verified_status'] == 0){
						// }elseif($approval_status['cam_asc_verified_status'] == 0){
							$status = 3;
						}else{
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = 2;
							}
						}
					}
					$verification = array(
						'cam_da_verified_status' => $this->input->post('status'),
						'cam_da_verified_id' => $this->session->userdata('login_id'),
						'cam_da_verified_date' => $currentDateTime,
						'da_verified_status' => $this->input->post('status'),
						'da_verified_id' => $this->session->userdata('login_id'),
						'da_verified_date' => $currentDateTime,
						'status' => $status
					);
				}	
			}
			elseif($parent_id == 750){
				$this->db->select('aet_asc_verified_status, aet_da_verified_status, asc_verified_status, da_verified_status, status');
	            $this->db->where('id', $id);
	            $approval_status = $this->db->get($survey_table)->row_array();

				if($this->session->userdata('role') == 8){
					if(isset($approval_status)){
						if($approval_status['aet_da_verified_status'] == null){
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = $approval_status['status'];
							}
						}elseif($approval_status['aet_da_verified_status'] == 0){
							$status = 3;
						}else{
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = 2;
							}
						}
					}
					$verification = array(
						'aet_asc_verified_status' => $this->input->post('status'),
						'aet_asc_verified_id' => $this->session->userdata('login_id'),
						'aet_asc_verified_date' => $currentDateTime,
						'asc_verified_status' => $this->input->post('status'),
						'asc_verified_id' => $this->session->userdata('login_id'),
						'asc_verified_date' => $currentDateTime,
						'status' => $status
					);

				}elseif($this->session->userdata('role') == 7){
					if(isset($approval_status)){
						// if($approval_status['aet_asc_verified_status'] == null){
						if($approval_status['asc_verified_status'] == null){
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = $approval_status['status'];
							}
						}elseif($approval_status['asc_verified_status'] == 0){
						// }elseif($approval_status['aet_asc_verified_status'] == 0){
							$status = 3;
						}else{
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = 2;
							}
						}
					}
					$verification = array(
						'aet_da_verified_status' => $this->input->post('status'),
						'aet_da_verified_id' => $this->session->userdata('login_id'),
						'aet_da_verified_date' => $currentDateTime,
						'da_verified_status' => $this->input->post('status'),
						'da_verified_id' => $this->session->userdata('login_id'),
						'da_verified_date' => $currentDateTime,
						'status' => $status
					);
				}	
			}
			elseif($parent_id == 822){
				$this->db->select('ifa_asc_verified_status, ifa_da_verified_status, asc_verified_status, da_verified_status, status');
	            $this->db->where('id', $id);
	            $approval_status = $this->db->get($survey_table)->row_array();

				if($this->session->userdata('role') == 8){
					if(isset($approval_status)){
						if($approval_status['ifa_da_verified_status'] == null){
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = $approval_status['status'];
							}
						}elseif($approval_status['ifa_da_verified_status'] == 0){
							$status = 3;
						}else{
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = 2;
							}
						}
					}
					$verification = array(
						'ifa_asc_verified_status' => $this->input->post('status'),
						'ifa_asc_verified_id' => $this->session->userdata('login_id'),
						'ifa_asc_verified_date' => $currentDateTime,
						'asc_verified_status' => $this->input->post('status'),
						'asc_verified_id' => $this->session->userdata('login_id'),
						'asc_verified_date' => $currentDateTime,
						'status' => $status
					);

				}elseif($this->session->userdata('role') == 7){
					if(isset($approval_status)){
						// if($approval_status['ifa_asc_verified_status'] == null){
						if($approval_status['asc_verified_status'] == null){
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = $approval_status['status'];
							}
						}elseif($approval_status['asc_verified_status'] == 0){
						// }elseif($approval_status['ifa_asc_verified_status'] == 0){
							$status = 3;
						}else{
							if($this->input->post('status') == 0){
								$status = 3;
							}else{
								$status = 2;
							}
						}
					}
					$verification = array(
						'ifa_da_verified_status' => $this->input->post('status'),
						'ifa_da_verified_id' => $this->session->userdata('login_id'),
						'ifa_da_verified_date' => $currentDateTime,
						'da_verified_status' => $this->input->post('status'),
						'da_verified_id' => $this->session->userdata('login_id'),
						'da_verified_date' => $currentDateTime,
						'status' => $status
					);
				}	
			}

			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);
			// var_dump($this->db->last_query());exit;
			if($query){
				$this->db->select('data_id');
				$this->db->where('id', $id);
				$record_status = $this->db->get($survey_table)->row_array();
				$gverification = array(
					'status' => $status
				);
				if ($this->db->table_exists($survey_grouptable))
				{
					$group_query = $this->db->where('data_id', $record_status['data_id'])->update($survey_grouptable, $gverification);
				}
				
			}
			
		}

		$result['status'] = 1;
		$result['msg'] = 'Data verified successfully.';
		$result['verified_by'] = $this->session->userdata('name');
		$result['verified_role'] = $this->session->userdata('role');
		echo json_encode($result);
		exit();
	}

	public function verify_back(){
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

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}

		$ids = $this->input->post('check');
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}
		$survey_id = $this->uri->segment(3);
		$survey_table = 'survey'.$survey_id;
		$survey_grouptable = 'survey'.$survey_id.'_groupdata';
		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$currentDateTime = date('Y-m-d H:i:s');
			if($this->input->post('status') == 0){
				$status = 3;
			}else{
				$status = 1;
				
			}
			//Prepare verification data
			$verification = array(
				'status' => $status
			);
			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);
			if($query){
				$this->db->select('data_id');
				$this->db->where('id', $id);
				$record_status = $this->db->get($survey_table)->row_array();
				$gverification = array(
					'status' => $status
				);
				if ($this->db->table_exists($survey_grouptable))
				{
					$group_query = $this->db->where('data_id', $record_status['data_id'])->update($survey_grouptable, $gverification);
				}
				
			}
			
		}

		$result['status'] = 1;
		$result['msg'] = 'Data moved to submited successfully.';
		echo json_encode($result);
		exit();
	}

	public function verify_farm_back(){
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

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}

		$ids = $this->input->post('check');
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}
		$survey_id = $this->uri->segment(3);
		$survey_table = 'survey'.$survey_id;
		$survey_grouptable = 'survey'.$survey_id.'_groupdata';
		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$currentDateTime = date('Y-m-d H:i:s');
			if($this->input->post('status') == 0){
				$status = 3;
			}else{
				$status = 1;
				
			}
			//Prepare verification data
			$verification = array(
				'status' => $status
			);
			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);
			if($query){
				$this->db->select('data_id');
				$this->db->where('id', $id);
				$record_status = $this->db->get($survey_table)->row_array();
				$gverification = array(
					'status' => $status
				);
				if ($this->db->table_exists($survey_grouptable))
				{
					$group_query = $this->db->where('data_id', $record_status['data_id'])->update($survey_grouptable, $gverification);
				}
				
			}
			
		}

		$result['status'] = 1;
		$result['msg'] = 'Data moved to submited successfully.';
		echo json_encode($result);
		exit();
	}

	public function registration()
	{
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		
		$survey_id = 4;

		$this->load->model('Reports_model');
		$result = $this->Reports_model->survey_details($survey_id);
		$result['survey_locations'] = $this->Reports_model->survey_location($survey_id);
		$this->load->model('Helper_model');
		// $result['divisions'] = $this->Helper_model->all_divisions();
		// echo '<pre>';print_r($result);exit;
		// $lookup_tables = array(
		// 	'lkp_circle', 'lkp_division', 'lkp_gender', 'lkp_title', 'lkp_village'
		// );
		// $result['survey_data'] = $this->Reports_model->registration_data($survey_id);
		// Get Survey Data
		$this->db->select('survey.*, tu.first_name, tu.last_name');
		$this->db->from('survey'.$survey_id.' AS survey');
		$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
		if(isset($start_date) && !is_null($start_date)) {
			$this->db->where('DATE(survey.datetime) >=', $start_date.' 00:00:00');
		} else if(isset($end_date) && !is_null($end_date)) {
			$this->db->where('DATE(survey.datetime) <=', $end_date.' 23:59:59');
		}
		$this->db->where('survey.status', 1);
		$survey_data = $this->db->order_by('survey.id', 'DESC')->get()->result_array();
		foreach ($survey_data as $key => $value) {
			// Get files attached
			$this->db->select('file_name');
            $this->db->where('data_id', $value['data_id'])->where('status', 1);
            $this->db->where('form_id', 4);
            $survey_data[$key]['images'] = $this->db->get('ic_data_file')->result_array();
			
			// Convert Upload Time to IST
			$date = new DateTime($survey_data[$key]['datetime'], new DateTimeZone('UTC'));
			$date->setTimezone(new DateTimeZone('Asia/Kolkata'));
			$survey_data[$key]['datetime'] = $date->format('Y-m-d H:i:s');
		}
		$result['survey_data'] = $survey_data;
		// foreach ($lookup_tables as $key => $table) {
		// 	$result[$table] = $this->Reports_model->get_lookup_data($table);
		// }
		// $result['status'] = 1;
		// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// 	$result['survey_data'] = $this->Reports_model->registration_data();
		// 	foreach ($lookup_tables as $key => $table) {
		// 		$result[$table] = $this->Reports_model->get_lookup_data($table);
		// 	}
		// 	$result['status'] = 1;
			
		// 	echo json_encode($result);
		// 	exit();
		// }
		// echo '<pre>';print_r($result['survey_data']);exit;
		
        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('reports/view_registration', $result);
		$this->load->view('footer');
	}

	public function plot()
	{
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		
		$survey_id = 2;

		$this->load->model('Reports_model');
		$result = $this->Reports_model->survey_details($survey_id);
		$result['survey_locations'] = $this->Reports_model->survey_location($survey_id);
		$this->load->model('Helper_model');
		// $result['divisions'] = $this->Helper_model->all_divisions();
		// echo '<pre>';print_r($result);exit;
		$lookup_tables = array(
			'lkp_circle', 'lkp_division', 'lkp_gender', 'lkp_title', 'lkp_village'
		);
		$result['survey_data'] = $this->Reports_model->registration_data2($survey_id);
		
		// echo '<pre>';print_r($result['survey_data']);exit;
		
        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('reports/view_registration2', $result);
		$this->load->view('footer');
	}

	public function agreement()
	{
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		
		$survey_id = 3;

		$this->load->model('Reports_model');
		$result = $this->Reports_model->survey_details($survey_id);
		$result['survey_locations'] = $this->Reports_model->survey_location($survey_id);
		$this->load->model('Helper_model');
		// $result['divisions'] = $this->Helper_model->all_divisions();
		// echo '<pre>';print_r($result);exit;
		$lookup_tables = array(
			'lkp_circle', 'lkp_division', 'lkp_gender', 'lkp_title', 'lkp_village'
		);
		$result['survey_data'] = $this->Reports_model->registration_data3($survey_id);
		
		// echo '<pre>';print_r($result['survey_data']);exit;
		
        $postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('reports/view_registration3', $result);
		$this->load->view('footer');
	}

	public function get_map_locations()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		$survey_id = $this->uri->segment(3);
		$this->load->model('Reports_model');
		$result['survey_locations'] = $this->Reports_model->survey_location($survey_id);

		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}

	public function survey(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			$this->load->model('Reports_model');
			$all_surveys = $this->Reports_model->all_surveys();

			$result = array('all_surveys' => $all_surveys);

			$header_result = array('main_menu' => $main_menu);
			$result = $this->security->xss_clean($result);
			$this->load->view('header', $header_result);
			$this->load->view('reports/survey', $result);
			$this->load->view('footer');
		}
	}

	public function view_surveydata(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);

			if($survey_id == '' || $survey_id == NULL){
				show_404();
			}

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);

			$result['survey_data'] = $this->Reports_model->survey_data($survey_id);
			$result['state_list'] = $this->Reports_model->state_list();
			$result['district_list'] = $this->Reports_model->district_list();
			$result['block_list'] = $this->Reports_model->block_list();
			$result['village_list'] = $this->Reports_model->village_list();
			$result['user_list'] = $this->Reports_model->user_list();
			$result['survey_locations'] = $this->Reports_model->survey_location($survey_id);
			$result['crop_types'] = $this->Reports_model->lkp_crop_types();
			$result['crops'] = $this->Reports_model->lkp_crops();
			$result['crop_intervention'] = $this->Reports_model->lkp_crop_intervention();
			$result['crop_inputname'] = $this->Reports_model->lkp_crop_inputname();
			$result['crop_varieties'] = $this->Reports_model->lkp_crop_varieties();

			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			$header_result = array('main_menu' => $main_menu);
			$result = $this->security->xss_clean($result);
			$this->load->view('header', $header_result);
			$this->load->view('reports/view_surveydata', $result);
			$this->load->view('footer');
		}
	}

	public function view_activitydata()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			$village_id = $this->uri->segment(4);

			if($survey_id == '' || $survey_id == NULL || $village_id == '' || $village_id == NULL){
				show_404();
			}

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);

			$result['survey_data'] = $this->Reports_model->activity_data($survey_id, $village_id);
			$result['state_list'] = $this->Reports_model->state_list();
			$result['district_list'] = $this->Reports_model->district_list();
			$result['block_list'] = $this->Reports_model->block_list();
			$result['village_list'] = $this->Reports_model->village_list();
			$result['user_list'] = $this->Reports_model->user_list();
			$result['survey_locations'] = $this->Reports_model->activity_location($survey_id, $village_id);
			$result['crop_types'] = $this->Reports_model->lkp_crop_types();
			$result['crops'] = $this->Reports_model->lkp_crops();
			$result['crop_intervention'] = $this->Reports_model->lkp_crop_intervention();
			$result['crop_inputname'] = $this->Reports_model->lkp_crop_inputname();
			$result['crop_varieties'] = $this->Reports_model->lkp_crop_varieties();

			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			$header_result = array('main_menu' => $main_menu);
			$result = $this->security->xss_clean($result);
			$this->load->view('header', $header_result);
			$this->load->view('reports/view_activitydata', $result);
			$this->load->view('footer');
		}
	}

	public function view_surveydata_filter()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}else{
			$survey_id = $this->uri->segment(3);

			if($survey_id == '' || $survey_id == NULL){
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Some error occured! Please refresh and try again.'
				));
				exit();
			}

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);

			$result['survey_data'] = $this->Reports_model->survey_data($survey_id);

			$result['partners_list'] = $this->Reports_model->partners_list();
			$result['age_list'] = $this->Reports_model->age_list();
			$result['state_list'] = $this->Reports_model->state_list();
			$result['district_list'] = $this->Reports_model->district_list();
			$result['block_list'] = $this->Reports_model->block_list();
			$result['village_list'] = $this->Reports_model->village_list();
			$result['survey_locations'] = $this->Reports_model->survey_location($survey_id);

			$result['status'] = 1;
			echo json_encode($result);
			exit();
		}
	}

	public function get_survey_locations()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		$survey_id = $this->uri->segment(3);
		$this->load->model('Reports_model');
		$result['survey_locations'] = $this->Reports_model->survey_location($survey_id);

		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}

	public function get_activity_locations()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		$survey_id = $this->uri->segment(3);
		$village_id = $this->uri->segment(3);

		$this->load->model('Reports_model');
		$result['survey_locations'] = $this->Reports_model->activity_location($survey_id, $village_id);

		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}

	public function beneficiary(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			$this->load->model('Reports_model');
			$all_beneficiary = $this->Reports_model->all_beneficiary();

			$result = array('all_beneficiary' => $all_beneficiary);

			$header_result = array('main_menu' => $main_menu);
			$result = $this->security->xss_clean($result);
			$this->load->view('header', $header_result);
			$this->load->view('reports/beneficiary', $result);
			$this->load->view('footer');
		}
	}
	
	public function view_beneficiarydata(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);

			if($survey_id == '' || $survey_id == NULL){
				show_404();
			}

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);

			$result['survey_data'] = $this->Reports_model->survey_data($survey_id);

			$result['partners_list'] = $this->Reports_model->partners_list();
			$result['age_list'] = $this->Reports_model->age_list();
			$result['state_list'] = $this->Reports_model->state_list();
			$result['district_list'] = $this->Reports_model->district_list_with_survey_data($survey_id);
			$result['block_list'] = $this->Reports_model->block_list();
			$result['village_list'] = $this->Reports_model->village_list();
			$result['user_list'] = $this->Reports_model->user_list();
			$result['survey_locations'] = $this->Reports_model->survey_location($survey_id);
			$result['date_wise_data'] = $this->Reports_model->date_wise_data($survey_id);

			$subsidies_list_graph = array();
			$subsidieslist = array();
			$this->db->select('value')->where('form_id', 1)->where('field_id', 1752)->where('status', 1);
			$subsidies_list = $this->db->get('form_field_multiple')->result_array();			
			foreach ($subsidies_list as $key => $value) {
				$subsidies_list_graph[$key]['name'] = $value['value'];
				$subsidies_list_graph[$key]['count'] = 0;

				$subsidieslist[$value['value']] = array();
			}

			$blocklist = array();

			$this->db->select('form_data');
			$this->db->where('form_id', 1);
			$this->db->where('data_status', 1);
			$formdata = $this->db->get('ic_form_data')->result_array();

			$agriculture = 0;
			$agroprocessingindustry = 0;
			$animalhusbandry = 0;
			$nonfarmlabor = 0;
			$fishing = 0;
			$plantationcrops = 0;
			$pension = 0;
			$service = 0;
			$business = 0;
			$handicraft = 0;
			foreach ($formdata as $key => $value) {
				$jsondata = json_decode($value['form_data'], true);

				if(isset($jsondata['field_1682'])){
					$agriculture = $agriculture + $jsondata['field_1682'];
				}
				if(isset($jsondata['field_1683'])){
					$agroprocessingindustry = $agroprocessingindustry + $jsondata['field_1683'];
				}
				if(isset($jsondata['field_1684'])){
					$animalhusbandry = $animalhusbandry + $jsondata['field_1684'];
				}
				if(isset($jsondata['field_1685'])){
					$nonfarmlabor = $nonfarmlabor + $jsondata['field_1685'];
				}
				if(isset($jsondata['field_1686'])){
					$fishing = $fishing + $jsondata['field_1686'];
				}
				if(isset($jsondata['field_1687'])){
					$plantationcrops = $plantationcrops + $jsondata['field_1687'];
				}
				if(isset($jsondata['field_1688'])){
					$pension = $pension + $jsondata['field_1688'];
				}
				if(isset($jsondata['field_1689'])){
					$service = $service + $jsondata['field_1689'];
				}
				if(isset($jsondata['field_1690'])){
					$business = $business + $jsondata['field_1690'];
				}
				if(isset($jsondata['field_1691'])){
					$handicraft = $handicraft + $jsondata['field_1691'];
				}

				if(isset($jsondata['field_1752'])){
					$subsidies_data = explode("&#44;", $jsondata['field_1752']);

					foreach ($subsidies_data as $sub) {
						array_push($subsidieslist[$sub], 1);
					}
				}

				if(isset($jsondata['field_1668'])){
					if(!in_array($jsondata['field_1668'], $blocklist)){
						array_push($blocklist, $jsondata['field_1668']);
					}
				}			
			}

			$blocklist_data = array();

			foreach ($blocklist as $key => $value) {
				$blocklist_data[$value] = array();
			}

			foreach ($formdata as $key => $value) {
				$jsondata = json_decode($value['form_data'], true);

				if (isset($jsondata['field_1668'])) {
					array_push($blocklist_data[$jsondata['field_1668']], 1);
				}
			}

			$blocklist_graphdata = array();
			$i = 0;
			foreach ($blocklist_data as $key => $value) {
				$blockname = $this->db->select('block_name')->where('block_id', $key)->get('lkp_block')->row_array();

				$blocklist_graphdata[$i]['name'] = $blockname['block_name'];
				$blocklist_graphdata[$i]['count'] = count($value);

				$i++;
			}

			$occupation_list_graph = array();
			array_push($occupation_list_graph, array('name' => 'Agriculture', 'count' => $agriculture));
			array_push($occupation_list_graph, array('name' => 'Agro-processing industry', 'count' => $agroprocessingindustry));
			array_push($occupation_list_graph, array('name' => 'Animal husbandry', 'count' => $animalhusbandry));
			array_push($occupation_list_graph, array('name' => 'Non-farm labor', 'count' => $nonfarmlabor));
			array_push($occupation_list_graph, array('name' => 'Fishing', 'count' => $fishing));
			array_push($occupation_list_graph, array('name' => 'Plantation crops', 'count' => $plantationcrops));
			array_push($occupation_list_graph, array('name' => 'Pension', 'count' => $pension));
			array_push($occupation_list_graph, array('name' => 'Service', 'count' => $service));
			array_push($occupation_list_graph, array('name' => 'Business', 'count' => $business));
			array_push($occupation_list_graph, array('name' => 'Handicraft', 'count' => $handicraft));

			foreach ($subsidies_list_graph as $key => $val) {
				$subsidies_list_graph[$key]['count'] = count($subsidieslist[$val['name']]);
			}

			$result['occupation_list_graph'] = $occupation_list_graph;
			$result['subsidies_list_graph'] = $subsidies_list_graph;
			$result['blocklist_graphdata'] = $blocklist_graphdata;

			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			$header_result = array('main_menu' => $main_menu);

			$this->load->view('header', $header_result);
			$this->load->view('reports/view_beneficiarydata', $result);
			$this->load->view('footer');
		}
	}

	public function district_data()
	{
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}

		$district_id = $this->uri->segment(3);
		if($district_id == '' || $district_id == NULL){
			show_404();
		}

		$survey_id = $this->uri->segment(4);
		if($survey_id == '' || $survey_id == NULL){
			show_404();
		}

		$this->load->model('Reports_model');
		$result = $this->Reports_model->survey_details($survey_id);
		
		$districts = $this->Reports_model->district_list($district_id);
		$result['district'] = $districts[0];
		
		$result['survey_data'] = $this->Reports_model->survey_data($survey_id, $district_id);
		$result['partners_list'] = $this->Reports_model->partners_list();
		$result['age_list'] = $this->Reports_model->age_list();
		$result['state_list'] = $this->Reports_model->state_list();
		$result['district_list'] = $this->Reports_model->district_list();
		$result['block_list'] = $this->Reports_model->block_list();
		$result['village_list'] = $this->Reports_model->village_list_with_survey_data($survey_id, $district_id);
		$result['user_list'] = $this->Reports_model->user_list($district_id);
		$result['survey_locations'] = $this->Reports_model->survey_location($survey_id, $district_id);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$result['status'] = 1;
			echo json_encode($result);
			exit();
		}

		$this->load->model('Dynamicmenu_model');
		$main_menu = $this->Dynamicmenu_model->menu_details();

		$header_result = array('main_menu' => $main_menu);
		$result = $this->security->xss_clean($result);
		$this->load->view('header', $header_result);
		$this->load->view('reports/view_district_data', $result);
		$this->load->view('footer');
	}

	public function edit_beneficiarydata(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);

			if($survey_id == '' || $survey_id == NULL){
				show_404();
			}

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);

			$result['survey_data'] = $this->Reports_model->survey_data($survey_id);

			$result['partners_list'] = $this->Reports_model->partners_list();
			// $result['centre_list'] = $this->Reports_model->centre_list();
			// $result['batch_list'] = $this->Reports_model->batch_list();
			// $result['trainee_list'] = $this->Reports_model->trainee_list();
			$result['age_list'] = $this->Reports_model->age_list();
			$result['state_list'] = $this->Reports_model->state_list();
			$result['district_list'] = $this->Reports_model->district_list();
			$result['block_list'] = $this->Reports_model->block_list();
			$result['village_list'] = $this->Reports_model->village_list();
			$result['user_list'] = $this->Reports_model->user_list();
			$result['survey_locations'] = $this->Reports_model->survey_location($survey_id);

			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			$header_result = array('main_menu' => $main_menu);
			$result = $this->security->xss_clean($result);
			$this->load->view('header', $header_result);
			$this->load->view('reports/edit_beneficiarydata', $result);
			$this->load->view('footer');
		}
	}

	public function verify_beneficiarydata(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);

			if($survey_id == '' || $survey_id == NULL){
				show_404();
			}

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);

			$result['survey_data'] = $this->Reports_model->survey_data($survey_id);

			$result['partners_list'] = $this->Reports_model->partners_list();
			// $result['centre_list'] = $this->Reports_model->centre_list();
			// $result['batch_list'] = $this->Reports_model->batch_list();
			// $result['trainee_list'] = $this->Reports_model->trainee_list();
			$result['age_list'] = $this->Reports_model->age_list();
			$result['state_list'] = $this->Reports_model->state_list();
			$result['district_list'] = $this->Reports_model->district_list();
			$result['block_list'] = $this->Reports_model->block_list();
			$result['village_list'] = $this->Reports_model->village_list();
			$result['user_list'] = $this->Reports_model->user_list();
			$result['survey_locations'] = $this->Reports_model->survey_location($survey_id);

			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			$header_result = array('main_menu' => $main_menu);
			$result = $this->security->xss_clean($result);
			$this->load->view('header', $header_result);
			$this->load->view('reports/verify_beneficiarydata', $result);
			$this->load->view('footer');
		}
	}

	public function groupdata_info(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			$data_id = $this->uri->segment(4);

			$data = array(
				'survey_id' => $survey_id,
				'data_id' => $data_id
			);

			$this->load->model('Reports_model');
			$check_record = $this->Reports_model->check_record($data);

			if($check_record == 0){
				show_404();
			}

			$group_info = $this->Reports_model->group_info($data);

			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			$header_result = array('main_menu' => $main_menu);

			$result = array('group_info' => $group_info);

			$result['crop_types'] = $this->Reports_model->lkp_crop_types();
			$result['crops'] = $this->Reports_model->lkp_crops();
			$result['crop_intervention'] = $this->Reports_model->lkp_crop_intervention();
			$result['crop_inputname'] = $this->Reports_model->lkp_crop_inputname();
			$result['crop_varieties'] = $this->Reports_model->lkp_crop_varieties();

			$this->load->view('header', $header_result);
			$this->load->view('reports/groupdata_info', $result);
			$this->load->view('footer');
		}
	}

	public function edit_groupdata_info(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			$data_id = $this->uri->segment(4);

			$data = array(
				'survey_id' => $survey_id,
				'data_id' => $data_id
			);

			$this->load->model('Reports_model');
			$check_record = $this->Reports_model->check_record($data);

			if($check_record == 0){
				show_404();
			}

			$group_info = $this->Reports_model->group_info($data);

			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			$header_result = array('main_menu' => $main_menu);

			$result = array('group_info' => $group_info);

			$this->load->view('header', $header_result);
			$this->load->view('reports/edit_groupdata_info', $result);
			$this->load->view('footer');
		}
	}

	public function get_details_for_edit()
	{
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

		if(!$this->input->post('id')
		|| !$this->input->post('field_id')) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';
			echo json_encode($result);
			exit();
		}

		$this->load->model('Reports_model');
		$result['survey_data'] = $this->Reports_model->survey_data_details($this->input->post('id'));
		$result['field_details'] = $this->Reports_model->field_details($this->input->post('field_id'));

		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}

	public function get_group_details_for_edit()
	{
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

		if(!$this->input->post('group_id')
		|| !$this->input->post('field_id')) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';
			echo json_encode($result);
			exit();
		}

		$this->load->model('Reports_model');
		$result['group_data'] = $this->Reports_model->group_info_details($this->input->post('group_id'));
		$result['field_details'] = $this->Reports_model->field_details($this->input->post('field_id'));

		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}

	public function edit_beneficiary()
	{
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

		if(!$this->input->post('id')
		|| !$this->input->post('field')) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';
			echo json_encode($result);
			exit();
		}

		$this->load->model('Reports_model');
		$survey_data = $this->Reports_model->survey_data_details($this->input->post('id'));
		$field_details = $this->Reports_model->field_details($this->input->post('field'));
		if(!$survey_data || !$field_details) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';
			echo json_encode($result);
			exit();
		}

		$newKey = 'field_'.$field_details['field_id'];
		$newValue = $this->input->post($newKey);
		if(is_array($newValue)) {
			$newValue = implode('&#44;', $newValue);
		}

		//Convert string data to array
		$form_data = (array)json_decode($survey_data['form_data']);
		$log = array();
		
		//If newValue is not empty Modify form_data accordingly
		if(strlen($newValue) > 0) {
			$form_data[$newKey] = $newValue;
			$log['new_value'] = json_encode(array($newKey => $newValue));
		}
		//Check if element exist in form_data array
		if(in_array(array($newKey => $newValue), $form_data)) {
			//If newValue is empty
			if(strlen($newValue) == 0) {
				unset($form_data[$newKey]);
				$log['new_value'] = json_encode($form_data);
			}
		}

		date_default_timezone_set('UTC');
		$currentDateTime = date('Y-m-d H:i:s');

		//Check if log has new value then prepare complete log
		if(isset($log['new_value'])) {
			$log['editedby'] = $this->session->userdata('login_id');
			$log['editedfor'] = $survey_data['user_id'];
			$log['table_name'] = 'ic_form_data';
			$log['table_row_id'] = $survey_data['id'];
			$log['table_field_name'] = 'form_data';
			$log['old_value'] = $survey_data['form_data'];
			$log['edited_reason'] = $this->input->post('reason');
			$log['updated_date'] = $currentDateTime;
			$log['ip_address'] = $this->input->ip_address();
			$log['log_status'] = 1;

			//Update ic_form_data
			$this->db->where('id', $survey_data['id'])->update('ic_form_data', array(
				'form_data' => json_encode($form_data)
			));

			//Insert log
			$this->db->insert('ic_log', $log);
		}

		$result['status'] = 1;
		$result['msg'] = 'Data updated successfully.';
		$result['field_value'] = strlen($newValue) == 0 ? 'N/A' : $newValue;
		echo json_encode($result);
		exit();
	}

	public function edit_groupdata()
	{
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

		if(!$this->input->post('group')
		|| !$this->input->post('field')) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';
			echo json_encode($result);
			exit();
		}

		$this->load->model('Reports_model');
		$group_data = $this->Reports_model->group_info_details($this->input->post('group'));
		$field_details = $this->Reports_model->field_details($this->input->post('field'));
		if(!$group_data || !$field_details) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';
			echo json_encode($result);
			exit();
		}

		$newKey = 'field_'.$field_details['field_id'];
		$newValue = $this->input->post($newKey);
		if(is_array($newValue)) {
			$newValue = implode(',', $newValue);
		}

		//Convert string data to array
		$form_data = (array)json_decode($group_data['formgroup_data']);
		$log = array();

		//Cehck if newValue is empty or not
		//Modify form_data accordingly
		if(strlen($newValue) > 0) {
			$form_data[$newKey] = $newValue;
			$log['new_value'] = json_encode(array($newKey => $newValue));
		} else if(strlen($newValue) == 0) {
			$form_data[$newKey] = NULL;
			$log['new_value'] = json_encode(array($newKey => NULL));
		}

		date_default_timezone_set('UTC');
		$currentDateTime = date('Y-m-d H:i:s');

		//Check if log has new value then prepare complete log
		if(isset($log['new_value'])) {
			$log['editedby'] = $this->session->userdata('login_id');
			$log['editedfor'] = $group_data['user_id'];
			$log['table_name'] = 'ic_form_group_data';
			$log['table_row_id'] = $group_data['group_id'];
			$log['table_field_name'] = 'formgroup_data';
			$log['old_value'] = $group_data['formgroup_data'];
			$log['edited_reason'] = $this->input->post('reason');
			$log['updated_date'] = $currentDateTime;
			$log['ip_address'] = $this->input->ip_address();
			$log['log_status'] = 1;

			//Update ic_form_group_data
			$this->db->where('group_id', $group_data['group_id'])->update('ic_form_group_data', array(
				'formgroup_data' => json_encode($form_data)
			));

			//Insert log
			$this->db->insert('ic_log', $log);
		}

		$result['status'] = 1;
		$result['msg'] = 'Data updated successfully.';
		$result['field_value'] = strlen($newValue) == 0 ? 'N/A' : $newValue;
		echo json_encode($result);
		exit();
	}

	public function verify_beneficiary()
	{
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

		if($this->session->userdata('role') != 3 && $this->session->userdata('role') != 4) {
			$result['status'] = 0;
			$result['msg'] = 'You are not authorized to use this feature.';
			echo json_encode($result);
			exit();
		}

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}

		$ids = $this->input->post('check');
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}

		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$currentDateTime = date('Y-m-d H:i:s');

			if($this->session->userdata('role') == 3) {
				$verification = array(
					'pm_verified' => $this->input->post('status'),
					'pm_verified_id' => $this->session->userdata('login_id'),
					'pm_verified_date' => $currentDateTime
				);
			} else if($this->session->userdata('role') == 4) {
				$verification = array(
					'am_verified' => $this->input->post('status'),
					'am_verified_id' => $this->session->userdata('login_id'),
					'am_verified_date' => $currentDateTime
				);
			}
			
			//Prepare verification data
			$this->db->where('id', $id)->update('ic_form_data', $verification);
		}

		$result['status'] = 1;
		$result['msg'] = 'Data verified successfully.';
		echo json_encode($result);
		exit();
	}

	public function delete_formdata()
	{
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

		if($this->session->userdata('role') != 1) {
			$result['status'] = 0;
			$result['msg'] = 'You are not authorized to use this feature.';
			echo json_encode($result);
			exit();
		}

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}

		$ids = $this->input->post('check');
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}

		foreach ($ids as $id) {
			//Get data_id
			$data = $this->db->where('id', $id)->get('ic_form_data')->row_array();
			if($status == 'delete') {
				//Delete from ic_form_data table
				$this->db->where('id', $id)->update('ic_form_data', array('data_status' => 0));
				//Delete from ic_data_file table
				$this->db->where('data_id', $data['data_id'])->update('ic_data_file', array('status' => 0));
				//Delete from ic_data_location table
				$this->db->where('data_id', $data['data_id'])->update('ic_data_location', array('status' => 0));
				//Delete from ic_form_group_data table
				$this->db->where('data_id', $data['data_id'])->update('ic_form_group_data', array('data_status' => 0));
			} else if($status == 'erase') {
				//Delete from ic_form_data table
				$this->db->where('id', $id)->delete('ic_form_data');
				//Delete from ic_data_file table
				$this->db->where('data_id', $data['data_id'])->delete('ic_data_file');
				//Delete from ic_data_location table
				$this->db->where('data_id', $data['data_id'])->delete('ic_data_location');
				//Delete from ic_form_group_data table
				$this->db->where('data_id', $data['data_id'])->delete('ic_form_group_data');
			}
		}

		$result['status'] = 1;
		$result['msg'] = 'Data deleted successfully.';
		echo json_encode($result);
		exit();
	}
	public function delete_formgroupdata()
	{
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

		if($this->session->userdata('role') != 1) {
			$result['status'] = 0;
			$result['msg'] = 'You are not authorized to use this feature.';
			echo json_encode($result);
			exit();
		}

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}

		$ids = $this->input->post('check');
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}

		foreach ($ids as $id) {
			if($status == 'delete') {
				//Delete from ic_form_group_data table
				$this->db->where('group_id', $id)->update('ic_form_group_data', array('data_status' => 0));
			} else if($status == 'erase') {
				//Delete from ic_form_group_data table
				$this->db->where('group_id', $id)->delete('ic_form_group_data');
			}
		}

		$result['status'] = 1;
		$result['msg'] = 'Data deleted successfully.';
		echo json_encode($result);
		exit();
	}

	public function coconutplantation_info(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			$data_id = $this->uri->segment(4);

			$data = array(
				'survey_id' => $survey_id,
				'data_id' => $data_id
			);

			$this->load->model('Reports_model');
			$check_record = $this->Reports_model->check_record($data);

			if($check_record == 0){
				show_404();
			}

			$coconutplantation_info = $this->Reports_model->coconutplantation_info($data);

			$this->load->model('Dynamicmenu_model');
			$main_menu = $this->Dynamicmenu_model->menu_details();

			$header_result = array('main_menu' => $main_menu);

			$result = array('coconutplantation_info' => $coconutplantation_info);

			$this->load->view('header', $header_result);
			$this->load->view('reports/coconutplantation_info', $result);
			$this->load->view('footer');
		}
	}

	public function update_kml(){

		// $this->db->select('tk.kml_id, tk.file_name, tk.measured_area, tk.state_id, tk.dist_id, tk.tehsil_id, tk.block_id, tk.gp_id, tk.village_id');
		$this->db->select('tk.kml_id, tk.plot_data_id, tk.comment');
		$this->db->where('tk.kml_status', 1);
		$this->db->where_in('tk.comment', [394,1040,1104]);
		$all_kmls = $this->db->get('tbl_kmlfile AS tk')->result_array();
		foreach($all_kmls as $key => $kml){
			$data_id = $kml['plot_data_id'];
			$kml_id = $kml['comment'];
			$farm_data = $this->db->where('data_id', $data_id)->get('survey5')->row_array();
			if(isset($farm_data)){
				$update_array = array();
				$update_array['state_id'] = 1;
				$update_array['dist_id'] = rand(1,10);
				$update_array['tehsil_id'] = rand(1,50);
				$update_array['block_id'] = rand(1,50);
				$update_array['gp_id'] = rand(1,50);
				$update_array['village_id'] = rand(1,50);

				// if($kml_id == 394){
				// 	$update_array[$key]['state_id'] = 1;
				// 	$update_array[$key]['dist_id'] = $farm_data['field_1960'];
				// 	$update_array[$key]['tehsil_id'] = $farm_data['field_1962'];
				// 	$update_array[$key]['block_id'] = $farm_data['field_1963'];
				// 	$update_array[$key]['gp_id'] = $farm_data['field_1964'];
				// 	$update_array[$key]['village_id'] = $farm_data['field_1965'];
				// }
				// elseif($kml_id == 1040){
				// 	$update_array[$key]['state_id'] = 2;
				// 	$update_array[$key]['dist_id'] = $farm_data['field_281'];
				// 	$update_array[$key]['tehsil_id'] = $farm_data['field_286'];
				// 	$update_array[$key]['block_id'] = $farm_data['field_288'];
				// 	$update_array[$key]['gp_id'] = $farm_data['field_290'];
				// 	$update_array[$key]['village_id'] = $farm_data['field_292'];
				// }elseif($kml_id == 1104){
				// 	$update_array[$key]['state_id'] = 2;
				// 	$update_array[$key]['dist_id'] = $farm_data['field_915'];
				// 	$update_array[$key]['tehsil_id'] = $farm_data['field_919'];
				// 	$update_array[$key]['block_id'] = $farm_data['field_921'];
				// 	$update_array[$key]['gp_id'] = $farm_data['field_923'];
				// 	$update_array[$key]['village_id'] = $farm_data['field_925'];
				// }
				
				$this->db->where('kml_id', $kml['kml_id'])->update("tbl_kmlfile", $update_array);
			}
			echo "kml table Updated";
		}
		
	}

	public function deleteData()
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
			$delete_data = $this->db->where('id', $_POST['id'])->update('survey'.$_POST['survey_id'], array('status' => '-1'));
			if($delete_data){
				$msg = 'Data deleted Successfully!';
				$result = array(
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
					'msg' => $msg,
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

	public function baselineSummary(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			redirect($baseurl);
		}
		
		$result = array();
		$this->load->model('Reports_model');
		$result['baseline_data'] = $this->Reports_model->baseline_data();
		$result['state_list'] = $this->db->where('status', 1)->order_by('state_name', 'ASC')->get('lkp_state')->result_array();
		
		$postData_ = array(
            "page_no" => 1,
            "status" => 1,
            "record_per_page" => 100,
            "is_pagination" => false
        );
        $customData = $this->FormModel->get_all_forms_p($postData_);
		$this->load->view('header');
		$this->load->view('sidebar', ['customData' => $customData]);
		$this->load->view('reports/baselineDataSummary', $result);
		$this->load->view('footer');
	} 

	public function baselineSummaryData(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			redirect($baseurl);
		}
		$id = $_POST['id'];
		$fetch_type = $_POST['fetch_type'];
		$data = array(
			'id' => $id,
			'fetch_type' => $fetch_type
		);
		$result = array();
		$this->load->model('Reports_model');
		if($fetch_type == "state"){
			$result['district_wise_baseline_data'] = $this->Reports_model->baseline_dist_data($data);
		}elseif($fetch_type == "district"){
			$result['ds_wise_baseline_data'] = $this->Reports_model->baseline_ds_data($data);
		}elseif($fetch_type == "ds"){
			$result['asc_wise_baseline_data'] = $this->Reports_model->baseline_asc_data($data);
		}elseif($fetch_type == "tehsil"){
			$result['arpa_wise_baseline_data'] = $this->Reports_model->baseline_arpa_data($data);
		}elseif($fetch_type == "block"){
			$result['gn_wise_baseline_data'] = $this->Reports_model->baseline_gn_data($data);
		}
		$result['id'] = $id;
		$result['fetch_type'] = $fetch_type;
		
		$this->load->view('reports/baselinesummary_tbl', $result);
	}
	
	public function baselineSummaryExportData(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			redirect($baseurl);
		}
		$result = array();

		/* Farmers */
		$this->db->select('field_1966,field_1959,field_178,field_179,status');
		$this->db->from('survey4');
		$farmers = $this->db->get()->result_array();

		/* Residence */
		$this->db->select('field_199, field_265, field_904, field_1960, field_281,field_914,field_1970,field_1969,field_1968,field_1961,field_283,field_916,field_1962,field_285,field_918,status');
		$this->db->from('survey5');
		$survey_data = $this->db->get()->result_array();

		

		$state_list = $this->db->where('status', 1)->order_by('state_name', 'ASC')->get('lkp_state')->result_array();
		$dist_list = $this->db->where('status', 1)->order_by('district_name', 'ASC')->get('lkp_district')->result_array();
		$ds_list = $this->db->where('status', 1)->order_by('ds_name', 'ASC')->get('lkp_ds')->result_array();
		$asc_list = $this->db->where('tehsil_status', 1)->order_by('tehsil_name', 'ASC')->get('lkp_tehsil')->result_array();
		$asrp_list = $this->db->where('block_status', 1)->order_by('block_name', 'ASC')->get('lkp_block')->result_array();
		$provins_list = array();
		$state_district = array();
		$state_district_ds = array();
		$state_district_ds_asc = array();
		$state_district_ds_asc_asrp = array();
		if(!empty($state_list)){
			foreach ($state_list as $skey => $value) {
				$state_name = $value['state_name'];
				
				$total_farmers = 0;
				$submited_farmers = 0;
				$approved_farmers = 0;
				$rejected_farmers = 0;
				foreach($farmers as $farmer){
					if($farmer['field_1966'] == $value['state_id']){
						if($farmer['status'] == 1){
							$submited_farmers++;
						}elseif($farmer['status'] == 2){
							$approved_farmers++;
						}elseif($farmer['status'] == 3){
							$rejected_farmers++;
						}
					}
				}
				$total_farmers = $submited_farmers+$approved_farmers+$rejected_farmers;
				$total_residence = 0;
				$submited_residence = 0;
				$approved_residence = 0;
				$rejected_residence = 0;
				$total_pady = 0;
				$submited_pady = 0;
				$approved_pady = 0;
				$rejected_pady = 0;
				$total_high = 0;
				$submited_high = 0;
				$approved_high = 0;
				$rejected_high = 0;
				foreach($survey_data as $key => $rdata){
					if(!empty($rdata['field_1968']) && $rdata['field_1968'] == $value['state_id']){
						if(!empty($rdata['field_199'])){
							if($rdata['status'] == 1){
								$submited_residence++;
							}elseif($rdata['status'] == 2){
								$approved_residence++;
							}elseif($rdata['status'] == 3){
								$rejected_residence++;
							}
						}
					}
					if(!empty($rdata['field_1969']) && $rdata['field_1969'] == $value['state_id']){
						if(!empty($rdata['field_265'])){
							if($rdata['status'] == 1){
								$submited_pady++;
							}elseif($rdata['status'] == 2){
								$approved_pady++;
							}elseif($rdata['status'] == 3){
								$rejected_pady++;
							}
						}
					}
					if(!empty($rdata['field_1970']) && $rdata['field_1970'] == $value['state_id']){
						if(!empty($rdata['field_904'])){
							if($rdata['status'] == 1){
								$submited_high++;
							}elseif($rdata['status'] == 2){
								$approved_high++;
							}elseif($rdata['status'] == 3){
								$rejected_high++;
							}
						}
					}
				}
				$total_residence = $submited_residence+$approved_residence+$rejected_residence;
				$total_pady = $submited_pady+$approved_pady+$rejected_pady;
				$total_high = $submited_high+$approved_high+$rejected_high;
				
				
				$final_array = array();
				$final_array =[$state_name,$total_farmers,$submited_farmers,$approved_farmers,$rejected_farmers,$total_residence,$submited_residence,$approved_residence,$rejected_residence,$total_pady,$submited_pady,$approved_pady,$rejected_pady,$total_high,$submited_high,$approved_high,$rejected_high];

				$provins_list[$skey] = $final_array;

				if(!empty($dist_list)){
					$district_list = array();
					foreach ($dist_list as $dkey => $dvalue) {
						if($dvalue['state_id'] == $value['state_id']){
							$district_name = $dvalue['district_name'];

							$dtotal_farmers = 0;
							$dsubmited_farmers = 0;
							$dapproved_farmers = 0;
							$drejected_farmers = 0;
							foreach($farmers as $farmer){
								if($farmer['field_1959'] == $dvalue['district_id']){
									if($farmer['status'] == 1){
										$dsubmited_farmers++;
									}elseif($farmer['status'] == 2){
										$dapproved_farmers++;
									}elseif($farmer['status'] == 3){
										$drejected_farmers++;
									}
								}
							}
							$dtotal_farmers = $dsubmited_farmers+$dapproved_farmers+$drejected_farmers;
							$dtotal_residence = 0;
							$dsubmited_residence = 0;
							$dapproved_residence = 0;
							$drejected_residence = 0;
							$dtotal_pady = 0;
							$dsubmited_pady = 0;
							$dapproved_pady = 0;
							$drejected_pady = 0;
							$dtotal_high = 0;
							$dsubmited_high = 0;
							$dapproved_high = 0;
							$drejected_high = 0;
							foreach($survey_data as $key => $rdata){
								if($rdata['field_1960'] == $dvalue['district_id']){
									if(!empty($rdata['field_199'])){
										if($rdata['status'] == 1){
											$dsubmited_residence++;
										}elseif($rdata['status'] == 2){
											$dapproved_residence++;
										}elseif($rdata['status'] == 3){
											$drejected_residence++;
										}
									}
								}
								if(!empty($rdata['field_281']) && $rdata['field_281'] == $dvalue['district_id']){
									if(!empty($rdata['field_265'])){
										if($rdata['status'] == 1){
											$dsubmited_pady++;
										}elseif($rdata['status'] == 2){
											$dapproved_pady++;
										}elseif($rdata['status'] == 3){
											$drejected_pady++;
										}
									}
								}
								if(!empty($rdata['field_914']) && $rdata['field_914'] == $dvalue['district_id']){
									if(!empty($rdata['field_904'])){
										if($rdata['status'] == 1){
											$dsubmited_high++;
										}elseif($rdata['status'] == 2){
											$dapproved_high++;
										}elseif($rdata['status'] == 3){
											$drejected_high++;
										}
									}
								}
							}
							$dtotal_residence = $dsubmited_residence+$dapproved_residence+$drejected_residence;
							$dtotal_pady = $dsubmited_pady+$dapproved_pady+$drejected_pady;
							$dtotal_high = $dsubmited_high+$dapproved_high+$drejected_high;
							
							
							$final_district_array = array();
							$final_district_array =[$state_name,$district_name,$dtotal_farmers,$dsubmited_farmers,$dapproved_farmers,$drejected_farmers,$dtotal_residence,$dsubmited_residence,$dapproved_residence,$drejected_residence,$dtotal_pady,$dsubmited_pady,$dapproved_pady,$drejected_pady,$dtotal_high,$dsubmited_high,$dapproved_high,$drejected_high];

							$district_list = $final_district_array;
							array_push($state_district, $district_list);

							/*if(!empty($asc_list)){
								$asc_data_list = array();
								foreach ($asc_list as $dkey => $ascvalue) {
									if($ascvalue['district_id'] == $dvalue['district_id']){
										$asc_name = $ascvalue['tehsil_name'];
			
										$teh_total_farmers = 0;
										$teh_submited_farmers = 0;
										$teh_approved_farmers = 0;
										$teh_rejected_farmers = 0;
										foreach($farmers as $farmer){
											if($farmer['field_179'] == $ascvalue['tehsil_id']){
												if($farmer['status'] == 1){
													$teh_submited_farmers++;
												}elseif($farmer['status'] == 2){
													$teh_approved_farmers++;
												}elseif($farmer['status'] == 3){
													$teh_rejected_farmers++;
												}
											}
										}
										$teh_total_farmers = $teh_submited_farmers+$teh_approved_farmers+$teh_rejected_farmers;
										$teh_total_residence = 0;
										$teh_submited_residence = 0;
										$teh_approved_residence = 0;
										$teh_rejected_residence = 0;
										$teh_total_pady = 0;
										$teh_submited_pady = 0;
										$teh_approved_pady = 0;
										$teh_rejected_pady = 0;
										$teh_total_high = 0;
										$teh_submited_high = 0;
										$teh_approved_high = 0;
										$teh_rejected_high = 0;
										foreach($survey_data as $key => $rdata){
											if(!empty($rdata['field_1962']) && $rdata['field_1962'] == $ascvalue['tehsil_id']){
												if(!empty($rdata['field_199'])){
													if($rdata['status'] == 1){
														$teh_submited_residence++;
													}elseif($rdata['status'] == 2){
														$teh_approved_residence++;
													}elseif($rdata['status'] == 3){
														$teh_rejected_residence++;
													}
												}
											}
											if(!empty($rdata['field_285']) && $rdata['field_285'] == $ascvalue['tehsil_id']){
												if(!empty($rdata['field_265'])){
													if($rdata['status'] == 1){
														$teh_submited_pady++;
													}elseif($rdata['status'] == 2){
														$teh_approved_pady++;
													}elseif($rdata['status'] == 3){
														$teh_rejected_pady++;
													}
												}
											}
											if(!empty($rdata['field_918']) && $rdata['field_918'] == $ascvalue['tehsil_id']){
												if(!empty($rdata['field_904'])){
													if($rdata['status'] == 1){
														$teh_submited_high++;
													}elseif($rdata['status'] == 2){
														$teh_approved_high++;
													}elseif($rdata['status'] == 3){
														$teh_rejected_high++;
													}
												}
											}
										}
										$teh_total_residence = $teh_submited_residence+$teh_approved_residence+$teh_rejected_residence;
										$teh_total_pady = $teh_submited_pady+$teh_approved_pady+$teh_rejected_pady;
										$teh_total_high = $teh_submited_high+$teh_approved_high+$teh_rejected_high;
										
										
										$final_asc_array = array();
										$final_asc_array =[$state_name,$district_name,$asc_name,$teh_total_farmers,$teh_submited_farmers,$teh_approved_farmers,$teh_rejected_farmers,$teh_total_residence,$teh_submited_residence,$teh_approved_residence,$teh_rejected_residence,$teh_total_pady,$teh_submited_pady,$teh_approved_pady,$teh_rejected_pady,$teh_total_high,$teh_submited_high,$teh_approved_high,$teh_rejected_high];

										$asc_data_list = $final_asc_array;
										array_push($state_district_ds_asc, $asc_data_list);


										if(!empty($asrp_list)){
											$asrp_data_list = array();
											foreach ($asrp_list as $asrpkey => $asrpvalue) {
												if($asrpvalue['tehsil_id'] == $ascvalue['tehsil_id']){
													$asrp_name = $asrpvalue['block_name'];
						
													$asrp_total_farmers = 0;
													$asrp_submited_farmers = 0;
													$asrp_approved_farmers = 0;
													$asrp_rejected_farmers = 0;
													foreach($farmers as $farmer){
														if($farmer['field_180'] == $asrpvalue['block_id']){
															if($farmer['status'] == 1){
																$asrp_submited_farmers++;
															}elseif($farmer['status'] == 2){
																$asrp_approved_farmers++;
															}elseif($farmer['status'] == 3){
																$asrp_rejected_farmers++;
															}
														}
													}
													$asrp_total_farmers = $asrp_submited_farmers+$asrp_approved_farmers+$asrp_rejected_farmers;
													$asrp_total_residence = 0;
													$asrp_submited_residence = 0;
													$asrp_approved_residence = 0;
													$asrp_rejected_residence = 0;
													$asrp_total_pady = 0;
													$asrp_submited_pady = 0;
													$asrp_approved_pady = 0;
													$asrp_rejected_pady = 0;
													$asrp_total_high = 0;
													$asrp_submited_high = 0;
													$asrp_approved_high = 0;
													$asrp_rejected_high = 0;
													foreach($survey_data as $key => $rdata){
														if(!empty($rdata['field_1963']) && $rdata['field_1963'] == $asrpvalue['block_id']){
															if(!empty($rdata['field_199'])){
																if($rdata['status'] == 1){
																	$asrp_submited_residence++;
																}elseif($rdata['status'] == 2){
																	$asrp_approved_residence++;
																}elseif($rdata['status'] == 3){
																	$asrp_rejected_residence++;
																}
															}
														}
														if(!empty($rdata['field_287']) && $rdata['field_287'] == $asrpvalue['block_id']){
															if(!empty($rdata['field_265'])){
																if($rdata['status'] == 1){
																	$asrp_submited_pady++;
																}elseif($rdata['status'] == 2){
																	$asrp_approved_pady++;
																}elseif($rdata['status'] == 3){
																	$asrp_rejected_pady++;
																}
															}
														}
														if(!empty($rdata['field_920']) && $rdata['field_920'] == $asrpvalue['block_id']){
															if(!empty($rdata['field_904'])){
																if($rdata['status'] == 1){
																	$asrp_submited_high++;
																}elseif($rdata['status'] == 2){
																	$asrp_approved_high++;
																}elseif($rdata['status'] == 3){
																	$asrp_rejected_high++;
																}
															}
														}
													}
													$asrp_total_residence = $asrp_submited_residence+$asrp_approved_residence+$asrp_rejected_residence;
													$asrp_total_pady = $asrp_submited_pady+$asrp_approved_pady+$asrp_rejected_pady;
													$asrp_total_high = $asrp_submited_high+$asrp_approved_high+$asrp_rejected_high;
													
													
													$final_asrp_array = array();
													$final_asrp_array =[$state_name,$district_name,$ds_name,$asc_name,$asrp_name,$asrp_total_farmers,$asrp_submited_farmers,$asrp_approved_farmers,$asrp_rejected_farmers,$asrp_total_residence,$asrp_submited_residence,$asrp_approved_residence,$asrp_rejected_residence,$asrp_total_pady,$asrp_submited_pady,$asrp_approved_pady,$asrp_rejected_pady,$asrp_total_high,$asrp_submited_high,$asrp_approved_high,$asrp_rejected_high];

													$asrp_data_list = $final_asrp_array;
													array_push($state_district_ds_asc_asrp, $asrp_data_list);



						
												}
											}
										}



			
									}
								}
							}*/
						}
					}
				}
					
			}
		}  
		// echo(json_encode($state_district_ds_asc));exit;
		$result = array("province" => $provins_list, "district" =>$state_district);                                 
		// $result = array("province" => $provins_list, "district" =>$state_district, "ds" =>$state_district_ds, "asc" =>$state_district_ds_asc, "asrp" => $state_district_ds_asc_asrp, "gn" => $state_district_ds_asc_asrp_gn);                                 
		echo(json_encode($result));
		exit();
                                                
	}

	public function get_submited_ofcg_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$block_id = $this->input->post('block_id');
			$gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }

			$search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}


			$data = array(
				'state_id' => $state_id,
				'district_id' => $district_id,
				'ds_id' => $ds_id,
				'asc_id' => $asc_id,
				'block_id' => $block_id,
				'gn_id' => $gn_id,
				'user_id' => $user_id,
				'survey_id' => $survey_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details_15($survey_id);
			$result['submited_data'] = $this->Reports_model->survey_submited_ofcg_data($data);
			$result['total_records'] = $this->Reports_model->survey_submited_ofcg_count($data);
			$result['user_role'] = $this->session->userdata('role');
			

			$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('dist.*, tul.district_id')->from('lkp_district as dist')->join('tbl_user_unit_location AS tul', 'tul.district_id = dist.district_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['district_list'] = $this->db->where('dist.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('ds.*, tul.ds_id')->from('lkp_ds as ds')->join('tbl_user_unit_location AS tul', 'tul.ds_id = ds.ds_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['ds_list'] = $this->db->where('ds.status', 1)->group_by('tul.ds_id')->get()->result_array();
			
			$this->db->select('asc.*, tul.tehsil_id')->from('lkp_tehsil as asc')->join('tbl_user_unit_location AS tul', 'tul.tehsil_id = asc.tehsil_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['asc_list'] = $this->db->where('asc.tehsil_status', 1)->group_by('tul.tehsil_id')->get()->result_array();
			
			$this->db->select('blk.*, tul.block_id')->from('lkp_block as blk')->join('tbl_user_unit_location AS tul', 'tul.block_id = blk.block_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['block_list'] = $this->db->where('blk.block_status', 1)->group_by('tul.block_id')->get()->result_array();
			
			$this->db->select('gn.*, tul.grampanchayat_id')->from('lkp_grampanchayat as gn')->join('tbl_user_unit_location AS tul', 'tul.grampanchayat_id = gn.grampanchayat_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['gn_list'] = $this->db->where('gn.grampanchayat_status', 1)->group_by('gn.grampanchayat_id')->get()->result_array();
			
			$result['crop_list'] = $this->db->where('status', 1)->get('lkp_crop')->result_array();
			$result['branch_list'] = $this->db->where('branch_status', 1)->get('lkp_branch_details')->result_array();
			$result['bank_list'] = $this->db->where('bank_status', 1)->get('lkp_farmer_bank_details')->result_array();
			$result['village_list'] = array();
			$result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function get_approved_ofcg_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$block_id = $this->input->post('block_id');
			$gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }
			 $search_input = "";
			 if ($this->input->post('search')) {
				 $search = $this->input->post('search');
				 $search_input = $search['search_input'] != null ? $search['search_input'] : "";
			 }

			$data = array(
				'state_id' => $state_id,
				'district_id' => $district_id,
				'ds_id' => $ds_id,
				'asc_id' => $asc_id,
				'block_id' => $block_id,
				'gn_id' => $gn_id,
				'user_id' => $user_id,
				'survey_id' => $survey_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);
			$result['submited_data'] = $this->Reports_model->survey_approved_ofcg_data($data);
			$result['total_records'] = $this->Reports_model->survey_approved_ofcg_count($data);
			$result['user_role'] = $this->session->userdata('role');
			

			$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('dist.*, tul.district_id')->from('lkp_district as dist')->join('tbl_user_unit_location AS tul', 'tul.district_id = dist.district_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['district_list'] = $this->db->where('dist.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('ds.*, tul.ds_id')->from('lkp_ds as ds')->join('tbl_user_unit_location AS tul', 'tul.ds_id = ds.ds_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['ds_list'] = $this->db->where('ds.status', 1)->group_by('tul.ds_id')->get()->result_array();
			
			$this->db->select('asc.*, tul.tehsil_id')->from('lkp_tehsil as asc')->join('tbl_user_unit_location AS tul', 'tul.tehsil_id = asc.tehsil_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['asc_list'] = $this->db->where('asc.tehsil_status', 1)->group_by('tul.tehsil_id')->get()->result_array();
			
			$this->db->select('blk.*, tul.block_id')->from('lkp_block as blk')->join('tbl_user_unit_location AS tul', 'tul.block_id = blk.block_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['block_list'] = $this->db->where('blk.block_status', 1)->group_by('tul.block_id')->get()->result_array();
			
			$this->db->select('gn.*, tul.grampanchayat_id')->from('lkp_grampanchayat as gn')->join('tbl_user_unit_location AS tul', 'tul.grampanchayat_id = gn.grampanchayat_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['gn_list'] = $this->db->where('gn.grampanchayat_status', 1)->group_by('gn.grampanchayat_id')->get()->result_array();
			
			$result['crop_list'] = $this->db->where('status', 1)->get('lkp_crop')->result_array();
			$result['branch_list'] = $this->db->where('branch_status', 1)->get('lkp_branch_details')->result_array();
			$result['bank_list'] = $this->db->where('bank_status', 1)->get('lkp_farmer_bank_details')->result_array();
			// $result['village_list'] = $this->db->where('village_status', 1)->get('lkp_village')->result_array();
			$result['village_list'] = array();
			$result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}

	public function get_generated_slip_ofcg_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$batch_id = $this->input->post('batch_id');
			// $gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }

			 $search_input = "";
			 if ($this->input->post('search')) {
				 $search = $this->input->post('search');
				 $search_input = $search['search_input'] != null ? $search['search_input'] : "";
			 }

			$data = array(
				'state_id' => $state_id,
				'district_id' => $district_id,
				'ds_id' => $ds_id,
				'asc_id' => $asc_id,
				'batch_id' => $batch_id,
				'user_id' => $user_id,
				'survey_id' => $survey_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);
			$result['submited_data'] = $this->Reports_model->survey_generated_slip_ofcg_data($data);
			$result['total_records'] = $this->Reports_model->survey_generated_slip_ofcg_count($data);
			$result['user_role'] = $this->session->userdata('role');
			

			$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('dist.*, tul.district_id')->from('lkp_district as dist')->join('tbl_user_unit_location AS tul', 'tul.district_id = dist.district_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['district_list'] = $this->db->where('dist.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('ds.*, tul.ds_id')->from('lkp_ds as ds')->join('tbl_user_unit_location AS tul', 'tul.ds_id = ds.ds_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['ds_list'] = $this->db->where('ds.status', 1)->group_by('tul.ds_id')->get()->result_array();
			
			$this->db->select('asc.*, tul.tehsil_id')->from('lkp_tehsil as asc')->join('tbl_user_unit_location AS tul', 'tul.tehsil_id = asc.tehsil_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['asc_list'] = $this->db->where('asc.tehsil_status', 1)->group_by('tul.tehsil_id')->get()->result_array();
			
			$this->db->select('blk.*, tul.block_id')->from('lkp_block as blk')->join('tbl_user_unit_location AS tul', 'tul.block_id = blk.block_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['block_list'] = $this->db->where('blk.block_status', 1)->group_by('tul.block_id')->get()->result_array();
			
			$this->db->select('gn.*, tul.grampanchayat_id')->from('lkp_grampanchayat as gn')->join('tbl_user_unit_location AS tul', 'tul.grampanchayat_id = gn.grampanchayat_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['gn_list'] = $this->db->where('gn.grampanchayat_status', 1)->group_by('gn.grampanchayat_id')->get()->result_array();
			
			$result['crop_list'] = $this->db->where('status', 1)->get('lkp_crop')->result_array();
			$result['branch_list'] = $this->db->where('branch_status', 1)->get('lkp_branch_details')->result_array();
			$result['bank_list'] = $this->db->where('bank_status', 1)->get('lkp_farmer_bank_details')->result_array();
			// $result['village_list'] = $this->db->where('village_status', 1)->get('lkp_village')->result_array();
			$result['village_list'] = array();
			$result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function get_after_generated_slip_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$bank_code = $this->input->post('bank_code');
			$date_id = $this->input->post('date_id');
			$batch_id = $this->input->post('batch_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }
			 $search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}


			$data = array(
				'state_id' => $state_id,
				'district_id' => $district_id,
				'ds_id' => $ds_id,
				'asc_id' => $asc_id,
				'bank_code' => $bank_code,
				'date_id' => $date_id,
				'batch_id' => $batch_id,
				'user_id' => $user_id,
				'survey_id' => $survey_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);
			$result['submited_data'] = $this->Reports_model->survey_after_generated_slip_ofcg_data($data);
			$result['total_records'] = $this->Reports_model->survey_after_generated_slip_ofcg_count($data);
			$result['user_role'] = $this->session->userdata('role');
			

			$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('dist.*, tul.district_id')->from('lkp_district as dist')->join('tbl_user_unit_location AS tul', 'tul.district_id = dist.district_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['district_list'] = $this->db->where('dist.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('ds.*, tul.ds_id')->from('lkp_ds as ds')->join('tbl_user_unit_location AS tul', 'tul.ds_id = ds.ds_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['ds_list'] = $this->db->where('ds.status', 1)->group_by('tul.ds_id')->get()->result_array();
			
			$this->db->select('asc.*, tul.tehsil_id')->from('lkp_tehsil as asc')->join('tbl_user_unit_location AS tul', 'tul.tehsil_id = asc.tehsil_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['asc_list'] = $this->db->where('asc.tehsil_status', 1)->group_by('tul.tehsil_id')->get()->result_array();
			
			$this->db->select('blk.*, tul.block_id')->from('lkp_block as blk')->join('tbl_user_unit_location AS tul', 'tul.block_id = blk.block_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['block_list'] = $this->db->where('blk.block_status', 1)->group_by('tul.block_id')->get()->result_array();
			
			$this->db->select('gn.*, tul.grampanchayat_id')->from('lkp_grampanchayat as gn')->join('tbl_user_unit_location AS tul', 'tul.grampanchayat_id = gn.grampanchayat_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['gn_list'] = $this->db->where('gn.grampanchayat_status', 1)->group_by('gn.grampanchayat_id')->get()->result_array();
			
			$result['crop_list'] = $this->db->where('status', 1)->get('lkp_crop')->result_array();
			$result['branch_list'] = $this->db->where('branch_status', 1)->get('lkp_branch_details')->result_array();
			$result['bank_list'] = $this->db->where('bank_status', 1)->get('lkp_farmer_bank_details')->result_array();
			// $result['village_list'] = $this->db->where('village_status', 1)->get('lkp_village')->result_array();
			$result['village_list'] = array();
			$result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}

	public function get_bank_slip_ofcg_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$batch_id = $this->input->post('batch_id');
			// $gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }


			$data = array(
				'state_id' => $state_id,
				'district_id' => $district_id,
				'ds_id' => $ds_id,
				'asc_id' => $asc_id,
				'batch_id' => $batch_id,
				// 'gn_id' => $gn_id,
				'user_id' => $user_id,
				'survey_id' => $survey_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);
			$result['submited_data'] = $this->Reports_model->survey_bank_slip($data);
			
			
			$result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function get_generated_bank_slip_ofcg_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$batch_id = $this->input->post('batch_id');
			$date_id = $this->input->post('date_id');
			$bank_code = $this->input->post('bank_code');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');

			$data = array(
				'state_id' => $state_id,
				'district_id' => $district_id,
				'ds_id' => $ds_id,
				'asc_id' => $asc_id,
				'batch_id' => $batch_id,
				'date_id' => $date_id,
				'bank_code' => $bank_code,
				'user_id' => $user_id,
				'survey_id' => $survey_id
			);

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);
			$result['submited_data'] = $this->Reports_model->generated_bank_slip($data);
			
			
			$result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function move_all_to_curent_slip_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$block_id = $this->input->post('block_id');
			$gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');

			$curent_slip_array = array(
				'bank_slip' => 1,
				'status' =>4
			);
			$survey_table='survey'.$survey_id;

			$this->db->select('survey.*, tu.first_name, tu.last_name');
			$this->db->from('survey'.$survey_id.' AS survey');
			$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
			if(!empty($state_id)){
				$this->db->where_in('survey.state_id', $state_id);
			}
			if(!empty($district_id)){
				$this->db->where_in('survey.dist_id', $district_id);
			}
			if(!empty($ds_id)){
				$this->db->where_in('survey.ds_id', $ds_id);
			}
			if(!empty($asc_id)){
				$this->db->where_in('survey.tehsil_id', $asc_id);
			}
			if(!empty($block_id)){
				$this->db->where_in('survey.block_id', $block_id);
			}
			if(!empty($gn_id)){
				$this->db->where_in('survey.gp_id', $gn_id);
			}

			$this->db->where('survey.status', 2);
			$this->db->where('survey.bank_slip', NULL);
			$this->db->group_start();
			$this->db->where('survey.invalid_nic_code', NULL);
			// $this->db->or_where('survey.invalid_nic_code', 0);
			$this->db->where('survey.invalid_branch_name', NULL);
			$this->db->where('survey.invalid_branch_code', NULL);
			$this->db->where('survey.invalid_account_number', NULL);
			$this->db->where('survey.invalid_land_extent', NULL);
			$this->db->where('survey.duplicate_nic', NULL);
			$this->db->where('survey.duplicate_baccount', NULL);
			$this->db->group_end();
			$approved_data_list = $this->db->order_by('survey.id', 'DESC')->get()->result_array();
			// var_dump($approved_data_list);exit;
			foreach($approved_data_list as $key => $value){
				$query = $this->db->where('id', $value['id'])->update($survey_table, $curent_slip_array);
			}
			// $str = $this->db->query('UPDATE survey15 as surv SET surv.bank_slip = 1 WHERE surv.state_id = '.$state_id.' and surv.dist_id = '.$district_id.' and surv.invalid_nic_code = '.NULL.' and surv.invalid_branch_name = '.NULL.' and surv.invalid_branch_code = '.NULL.' and surv.invalid_account_number = '.NULL.' and surv.invalid_land_extent = '.NULL.' and surv.duplicate_nic = '.NULL.' and surv.duplicate_baccount = '.NULL.'and surv.status = 2');

			

			$result['status'] = 1;
			$result['msg'] = 'All Data Moved successfully.';
			$result['verified_by'] = $this->session->userdata('name');
			$result['verified_role'] = $this->session->userdata('role');
			echo json_encode($result);
			exit();

		}

	}

	public function approve_all_ds_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$block_id = $this->input->post('block_id');
			$gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');

			$curent_slip_array = array(
				'da_verified_status' => 1,
				'status' => 2
			);
			$survey_table='survey'.$survey_id;

			$this->db->select('survey.*, tu.first_name, tu.last_name');
			$this->db->from('survey'.$survey_id.' AS survey');
			$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
			if(!empty($state_id)){
				$this->db->where_in('survey.state_id', $state_id);
			}
			if(!empty($district_id)){
				$this->db->where_in('survey.dist_id', $district_id);
			}
			if(!empty($ds_id)){
				$this->db->where_in('survey.ds_id', $ds_id);
			}
			if(!empty($asc_id)){
				$this->db->where_in('survey.tehsil_id', $asc_id);
			}
			if(!empty($block_id)){
				$this->db->where_in('survey.block_id', $block_id);
			}
			if(!empty($gn_id)){
				$this->db->where_in('survey.gp_id', $gn_id);
			}

			$this->db->where('survey.status', 1);
			$this->db->where('survey.asc_verified_status', 1);
			$approved_data_list = $this->db->order_by('survey.id', 'DESC')->get()->result_array();
			// var_dump($approved_data_list);exit;
			foreach($approved_data_list as $key => $value){
				$query = $this->db->where('id', $value['id'])->update($survey_table, $curent_slip_array);
			}
			// $str = $this->db->query('UPDATE survey15 as surv SET surv.bank_slip = 1 WHERE surv.state_id = '.$state_id.' and surv.dist_id = '.$district_id.' and surv.invalid_nic_code = '.NULL.' and surv.invalid_branch_name = '.NULL.' and surv.invalid_branch_code = '.NULL.' and surv.invalid_account_number = '.NULL.' and surv.invalid_land_extent = '.NULL.' and surv.duplicate_nic = '.NULL.' and surv.duplicate_baccount = '.NULL.'and surv.status = 2');

			

			$result['status'] = 1;
			$result['msg'] = 'All data Approved successfully.';
			$result['verified_by'] = $this->session->userdata('name');
			$result['verified_role'] = $this->session->userdata('role');
			echo json_encode($result);
			exit();

		}

	}


	public function get_invalid_ofcg_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$block_id = $this->input->post('block_id');
			$gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }
			 $search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}

			$data = array(
				'state_id' => $state_id,
				'district_id' => $district_id,
				'ds_id' => $ds_id,
				'asc_id' => $asc_id,
				'block_id' => $block_id,
				'gn_id' => $gn_id,
				'user_id' => $user_id,
				'survey_id' => $survey_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);
			$result['submited_data'] = $this->Reports_model->survey_invalid_ofcg_data($data);
			$result['total_records'] = $this->Reports_model->survey_invalid_ofcg_count($data);
			$result['user_role'] = $this->session->userdata('role');
			

			$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('dist.*, tul.district_id')->from('lkp_district as dist')->join('tbl_user_unit_location AS tul', 'tul.district_id = dist.district_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['district_list'] = $this->db->where('dist.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('ds.*, tul.ds_id')->from('lkp_ds as ds')->join('tbl_user_unit_location AS tul', 'tul.ds_id = ds.ds_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['ds_list'] = $this->db->where('ds.status', 1)->group_by('tul.ds_id')->get()->result_array();
			
			$this->db->select('asc.*, tul.tehsil_id')->from('lkp_tehsil as asc')->join('tbl_user_unit_location AS tul', 'tul.tehsil_id = asc.tehsil_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['asc_list'] = $this->db->where('asc.tehsil_status', 1)->group_by('tul.tehsil_id')->get()->result_array();
			
			$this->db->select('blk.*, tul.block_id')->from('lkp_block as blk')->join('tbl_user_unit_location AS tul', 'tul.block_id = blk.block_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['block_list'] = $this->db->where('blk.block_status', 1)->group_by('tul.block_id')->get()->result_array();
			
			$this->db->select('gn.*, tul.grampanchayat_id')->from('lkp_grampanchayat as gn')->join('tbl_user_unit_location AS tul', 'tul.grampanchayat_id = gn.grampanchayat_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['gn_list'] = $this->db->where('gn.grampanchayat_status', 1)->group_by('gn.grampanchayat_id')->get()->result_array();
			
			$result['crop_list'] = $this->db->where('status', 1)->get('lkp_crop')->result_array();
			$result['branch_list'] = $this->db->where('branch_status', 1)->get('lkp_branch_details')->result_array();
			$result['bank_list'] = $this->db->where('bank_status', 1)->get('lkp_farmer_bank_details')->result_array();
			// $result['village_list'] = $this->db->where('village_status', 1)->get('lkp_village')->result_array();
			$result['village_list'] = array();
			$result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function get_deleted_ofcg_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$block_id = $this->input->post('block_id');
			$gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }
			 $search_input = "";
			 if ($this->input->post('search')) {
				 $search = $this->input->post('search');
				 $search_input = $search['search_input'] != null ? $search['search_input'] : "";
			 }

			$data = array(
				'state_id' => $state_id,
				'district_id' => $district_id,
				'ds_id' => $ds_id,
				'asc_id' => $asc_id,
				'block_id' => $block_id,
				'gn_id' => $gn_id,
				'user_id' => $user_id,
				'survey_id' => $survey_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);
			$result['submited_data'] = $this->Reports_model->survey_deleted_ofcg_data($data);
			$result['total_records'] = $this->Reports_model->survey_deleted_ofcg_count($data);
			$result['user_role'] = $this->session->userdata('role');
			

			$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('dist.*, tul.district_id')->from('lkp_district as dist')->join('tbl_user_unit_location AS tul', 'tul.district_id = dist.district_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['district_list'] = $this->db->where('dist.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('ds.*, tul.ds_id')->from('lkp_ds as ds')->join('tbl_user_unit_location AS tul', 'tul.ds_id = ds.ds_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['ds_list'] = $this->db->where('ds.status', 1)->group_by('tul.ds_id')->get()->result_array();
			
			$this->db->select('asc.*, tul.tehsil_id')->from('lkp_tehsil as asc')->join('tbl_user_unit_location AS tul', 'tul.tehsil_id = asc.tehsil_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['asc_list'] = $this->db->where('asc.tehsil_status', 1)->group_by('tul.tehsil_id')->get()->result_array();
			
			$this->db->select('blk.*, tul.block_id')->from('lkp_block as blk')->join('tbl_user_unit_location AS tul', 'tul.block_id = blk.block_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['block_list'] = $this->db->where('blk.block_status', 1)->group_by('tul.block_id')->get()->result_array();
			
			$this->db->select('gn.*, tul.grampanchayat_id')->from('lkp_grampanchayat as gn')->join('tbl_user_unit_location AS tul', 'tul.grampanchayat_id = gn.grampanchayat_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['gn_list'] = $this->db->where('gn.grampanchayat_status', 1)->group_by('gn.grampanchayat_id')->get()->result_array();
			
			$result['crop_list'] = $this->db->where('status', 1)->get('lkp_crop')->result_array();
			$result['branch_list'] = $this->db->where('branch_status', 1)->get('lkp_branch_details')->result_array();
			$result['bank_list'] = $this->db->where('bank_status', 1)->get('lkp_farmer_bank_details')->result_array();
			// $result['village_list'] = $this->db->where('village_status', 1)->get('lkp_village')->result_array();
			$result['village_list'] = array();
			$result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function get_rejected_ofcg_data_view(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$state_id = $this->input->post('state_id');
			$district_id = $this->input->post('district_id');
			$ds_id = $this->input->post('ds_id');
			$asc_id = $this->input->post('asc_id');
			$block_id = $this->input->post('block_id');
			$gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }
			$search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}


			$data = array(
				'state_id' => $state_id,
				'district_id' => $district_id,
				'ds_id' => $ds_id,
				'asc_id' => $asc_id,
				'block_id' => $block_id,
				'gn_id' => $gn_id,
				'user_id' => $user_id,
				'survey_id' => $survey_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);
			$result['submited_data'] = $this->Reports_model->survey_rejected_ofcg_data($data);
			$result['total_records'] = $this->Reports_model->survey_rejected_ofcg_count($data);
			$result['user_role'] = $this->session->userdata('role');
			

			$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('dist.*, tul.district_id')->from('lkp_district as dist')->join('tbl_user_unit_location AS tul', 'tul.district_id = dist.district_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['district_list'] = $this->db->where('dist.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('ds.*, tul.ds_id')->from('lkp_ds as ds')->join('tbl_user_unit_location AS tul', 'tul.ds_id = ds.ds_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['ds_list'] = $this->db->where('ds.status', 1)->group_by('tul.ds_id')->get()->result_array();
			
			$this->db->select('asc.*, tul.tehsil_id')->from('lkp_tehsil as asc')->join('tbl_user_unit_location AS tul', 'tul.tehsil_id = asc.tehsil_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['asc_list'] = $this->db->where('asc.tehsil_status', 1)->group_by('tul.tehsil_id')->get()->result_array();
			
			$this->db->select('blk.*, tul.block_id')->from('lkp_block as blk')->join('tbl_user_unit_location AS tul', 'tul.block_id = blk.block_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['block_list'] = $this->db->where('blk.block_status', 1)->group_by('tul.block_id')->get()->result_array();
			
			$this->db->select('gn.*, tul.grampanchayat_id')->from('lkp_grampanchayat as gn')->join('tbl_user_unit_location AS tul', 'tul.grampanchayat_id = gn.grampanchayat_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['gn_list'] = $this->db->where('gn.grampanchayat_status', 1)->group_by('gn.grampanchayat_id')->get()->result_array();
			
			$result['crop_list'] = $this->db->where('status', 1)->get('lkp_crop')->result_array();
			$result['branch_list'] = $this->db->where('branch_status', 1)->get('lkp_branch_details')->result_array();
			$result['bank_list'] = $this->db->where('bank_status', 1)->get('lkp_farmer_bank_details')->result_array();
			// $result['village_list'] = $this->db->where('village_status', 1)->get('lkp_village')->result_array();
			$result['village_list'] = array();
			$result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function get_ofcg_duplicate_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$duplicate_type = $this->input->post('duplicate_type');
			$data_type = $this->input->post('data_type');
			// $ds_id = $this->input->post('ds_id');
			// $asc_id = $this->input->post('asc_id');
			// $block_id = $this->input->post('block_id');
			// $gn_id = $this->input->post('gn_id');
			$user_id = $this->session->userdata('login_id');
			$survey_id = $this->input->post('survey_id');

			$page_no =  1;
			$record_per_page = 100;
			 if($this->input->post('pagination')){
				$pagination = $this->input->post('pagination');
				$page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
				$record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
			 }

			$search_input = "";
			if ($this->input->post('search')) {
				$search = $this->input->post('search');
				$search_input = $search['search_input'] != null ? $search['search_input'] : "";
			}


			$data = array(
				'duplicate_type' => $duplicate_type,
				'data_type' => $data_type,
				// 'ds_id' => $ds_id,
				// 'asc_id' => $asc_id,
				// 'block_id' => $block_id,
				// 'gn_id' => $gn_id,
				'user_id' => $user_id,
				'survey_id' => $survey_id,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);
			// print_r($result);exit();
			$result['submited_data'] = $this->Reports_model->survey_ofcg_duplicate_data($data);
			$result['total_records'] = $this->Reports_model->survey_ofcg_duplicate_records($data);
			$result['user_role'] = $this->session->userdata('role');
			

			$this->db->select('st.*, tul.state_id')->from('lkp_state as st')->join('tbl_user_unit_location AS tul', 'tul.state_id = st.state_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['state_list'] = $this->db->where('st.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('dist.*, tul.district_id')->from('lkp_district as dist')->join('tbl_user_unit_location AS tul', 'tul.district_id = dist.district_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['district_list'] = $this->db->where('dist.status', 1)->group_by('tul.state_id')->get()->result_array();
			
			$this->db->select('ds.*, tul.ds_id')->from('lkp_ds as ds')->join('tbl_user_unit_location AS tul', 'tul.ds_id = ds.ds_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['ds_list'] = $this->db->where('ds.status', 1)->group_by('tul.ds_id')->get()->result_array();
			
			$this->db->select('asc.*, tul.tehsil_id')->from('lkp_tehsil as asc')->join('tbl_user_unit_location AS tul', 'tul.tehsil_id = asc.tehsil_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['asc_list'] = $this->db->where('asc.tehsil_status', 1)->group_by('tul.tehsil_id')->get()->result_array();
			
			$this->db->select('blk.*, tul.block_id')->from('lkp_block as blk')->join('tbl_user_unit_location AS tul', 'tul.block_id = blk.block_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['block_list'] = $this->db->where('blk.block_status', 1)->group_by('tul.block_id')->get()->result_array();
			
			$this->db->select('gn.*, tul.grampanchayat_id')->from('lkp_grampanchayat as gn')->join('tbl_user_unit_location AS tul', 'tul.grampanchayat_id = gn.grampanchayat_id');
			if($this->session->userdata('role') != 1){
				$this->db->where('tul.user_id', $user_id);
			}
			$result['gn_list'] = $this->db->where('gn.grampanchayat_status', 1)->group_by('gn.grampanchayat_id')->get()->result_array();
			
			$result['crop_list'] = $this->db->where('status', 1)->get('lkp_crop')->result_array();
			$result['branch_list'] = $this->db->where('branch_status', 1)->get('lkp_branch_details')->result_array();
			$result['bank_list'] = $this->db->where('bank_status', 1)->get('lkp_farmer_bank_details')->result_array();
			// $result['village_list'] = $this->db->where('village_status', 1)->get('lkp_village')->result_array();
			$result['village_list'] = array();
			$result['title'] = $this->Reports_model->export_survey_title($survey_id);
			$result['status'] = 1;
			echo json_encode($result);
			exit();

		}

	}
	public function get_data_to_export_server(){
		

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$name = $_POST['name'];
			// Check if the file is uploaded
			if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
				// Temporary file path
				$tmp_name = $_FILES['file']['tmp_name'];
		
				// Target path to save the file
				// $target_path = 'path/to/save/result.xlsx';
				$target_path = $baseurl.'uploads/surveydata/'.$name.'.xlsx';
		
				// Move the uploaded file to the target path
				if (move_uploaded_file($tmp_name, $target_path)) {
					echo 'File saved successfully.';
				} else {
					echo 'Failed to save the file.';
				}
			} else {
				echo 'No file uploaded or file upload error.';
			}
		}
	}
	public function exportExcel_all() {
		
		
		// Set initial response and variables
		// $response = [
		// 	'status' => 0,
		// 	'msg' => 'No data found',
		// 	'submited_data' => [],
		// 	'user_role' => 'user_role_example',
		// 	'fields' => [
		// 		// Example fields structure
		// 		0 => ['field_id' => 1, 'label' => 'Country', 'type' => 'lkp_country'],
		// 		// Add more fields as necessary
		// 	],
		// 	'lkp_country' => [
		// 		// Example lookup structure
		// 		0 => ['country_id' => 1, 'name' => 'Country1'],
		// 		// Add more countries as necessary
		// 	],
		// 	// Add more lookup arrays as necessary
		// ];
		
		// Assuming $this->uri->segment(3) is a method to get URI segment
		$survey_id = $_POST['survey_id'];
		$survey_type = $_POST['survey_type'];
		$respondent_id = '';
	
		if ($survey_type == "Market Task") {
			$respondent_id = '';
		} else if ($survey_type == "Rangeland Task") {
			$respondent_id = '';
		} else {
			$respondent_id = '';
		}
		$user_id = null;
		$data = [
			'country_id' => $_POST['country_id'] ?? '',
			'uai_id' => $_POST['uai_id'] ?? '',
			'sub_location_id' => $_POST['sub_location_id'] ?? '',
			'cluster_id' => $_POST['cluster_id'] ?? '',
			'contributor_id' => $_POST['contributor_id'] ?? '',
			'respondent_id' => $respondent_id,
			'start_date' => $_POST['start_date'] ?? '',
			'end_date' => $_POST['end_date'] ?? '',
			'survey_id' => $_POST['survey_id'] ?? '',
			'user_id' => $user_id,
			'survey_type' => $survey_type,
			'pa_verified_status' => null,
			'pagination' => null,
		];
		
		// print_r($data);exit();
		// Perform your database query here to get the data

		$this->load->model('Reports_model');
		$result = $this->Reports_model->survey_details($survey_id);
		$result['submited_data'] = $this->Reports_model->survey_submited_data_export_all($data);
		// print_r($result['submited_data']);exit();
		// $result['total_records'] = $this->Reports_model->survey_records($data);
		$result['user_role'] = $this->session->userdata('role');
		$result['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
		$result['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();
		$result['lkp_uai'] = $this->db->select('*')->where('status', 1)->get('lkp_uai')->result_array();
		$result['lkp_sub_location'] = $this->db->select('*')->where('status', 1)->get('lkp_sub_location')->result_array();
		
		$result['lkp_location_type'] = $this->db->select('*')->where('status', 1)->get('lkp_location_type')->result_array();
		$result['lkp_animal_type_lactating'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type_lactating')->result_array();
		$result['respondent_name'] = $this->db->select('first_name, last_name,data_id')->where('status', 1)->get('tbl_respondent_users')->result_array();
		$result['lkp_market'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
		$result['lkp_lr_body_condition'] = $this->db->select('*')->where('status', 1)->get('lkp_lr_body_condition')->result_array();
		$result['lkp_sr_body_condition'] = $this->db->select('*')->where('status', 1)->get('lkp_sr_body_condition')->result_array();
		$result['lkp_animal_type'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type')->result_array();
		$result['lkp_animal_herd_type'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_herd_type')->result_array();
		$result['lkp_food_groups'] = $this->db->select('*')->where('status', 1)->get('lkp_food_groups')->result_array();
		$result['lkp_transect_pasture'] = $this->db->select('*')->where('status', 1)->get('lkp_transect_pasture')->result_array();
		$result['lkp_dry_wet_pasture'] = $this->db->select('*')->where('status', 1)->get('lkp_dry_wet_pasture')->result_array();
		$result['lkp_transport_means'] = $this->db->select('*')->where('status', 1)->get('lkp_transport_means')->result_array();

		
		$result['title'] = $this->Reports_model->export_survey_title($survey_id);
		
	
		// echo $output;
		$result['msg'] = "downloaded";
		$result['status'] = 1;
			echo json_encode($result);
			exit();
	}
	
	function exportToExcel($title, $data) {
		// Load PHPExcel library or similar
		require_once 'PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setTitle($title);
	
		foreach ($data as $rowIndex => $row) {
			foreach ($row as $colIndex => $cell) {
				$sheet->setCellValueByColumnAndRow($colIndex, $rowIndex + 1, $cell);
			}
		}
	
		$filename = $title . '.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
	
		$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$writer->save('php://output');
	}
	
	public function generate_forage_percentage() {
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
			exit;
		}
		// if (strpos($baseurl, 'localhost') !== false) {
			$baseurl = "https://kaznet.ilri.org/";
		// }
	
		// Define the field mappings
		$field_mappings = array(
			772 => ['type' => 1022, 'area' => 1023],  // North
			773 => ['type' => 1024, 'area' => 1025],  // East
			774 => ['type' => 1026, 'area' => 1027],  // South
			775 => ['type' => 1028, 'area' => 1029],  // West
			790 => ['type' => 1010, 'area' => 1011],  // Point0
			794 => ['type' => 1012, 'area' => 1013],  // Point1
			798 => ['type' => 1014, 'area' => 1015],  // Point2
			802 => ['type' => 1016, 'area' => 1017],  // Point3
			806 => ['type' => 1018, 'area' => 1019],  // Point4
			810 => ['type' => 1020, 'area' => 1021],  // Point5
			815 => ['type' => 1030, 'area' => 1031],  // Point6
			819 => ['type' => 1032, 'area' => 1033],  // Point7
			823 => ['type' => 1034, 'area' => 1035],  // Point8
			827 => ['type' => 1036, 'area' => 1037],  // Point9
			831 => ['type' => 1038, 'area' => 1039]   // Point10
		);
	
		$this->db->select('field_id, label');
		$this->db->from('form_field'); // form_field_1203_backup
		$this->db->group_start();
		$this->db->like('label', 'forage');
		$this->db->or_like('label', 'vegetation');
		$this->db->group_end();
		$this->db->where('form_id', 9);
		$this->db->where('status', 1);
		$this->db->where('type', 'file');
		$query = $this->db->get();
		print_r($this->db->last_query());
		echo '<br/>';
	
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$field_ids = array();
			foreach ($result as $row) {
				$field_ids[] = $row->field_id;
			}
	
			if (!empty($field_ids)) {
				$country_id = $this->input->get('country_id');
				$uai_id = $this->input->get('uai_id');

				$this->db->select('data_id');
				if (!empty($country_id)) {
					$this->db->where('country_id', $country_id);
				} elseif (!empty($uai_id)) {
					$this->db->where('uai_id', $uai_id);
				}
				$this->db->from('survey9'); // survey9_1203_backup
				$this->db->limit(500);
				
				$this->db->group_start(); // Start outer group for ORs

				foreach ($field_mappings as $map) {
					// $this->db->or_group_start(); // Start OR group for each pair
					$this->db->group_start(); // Each pair wrapped in AND
					$this->db->where("field_{$map['type']}", null);
					$this->db->where("field_{$map['area']}", null);
					$this->db->group_end(); // End OR group
				}
		
				$this->db->group_end(); // End outer group
				
				$survey_query = $this->db->get();
				print_r($this->db->last_query());
				echo '<br/>';
	
				if ($survey_query->num_rows() > 0) {
					$survey_9_result = $survey_query->result();
					print_r($survey_9_result);
					echo '<br/>';
	
					foreach ($survey_9_result as $survey9) {
						$this->db->select('*');
						$this->db->from('ic_data_file');
						$this->db->where('form_id', 9);
						$this->db->where('data_id', $survey9->data_id);
						$this->db->where('status', 1);
						$this->db->where_in('field_id', $field_ids);
						$survey_query = $this->db->get();
	
						if ($survey_query->num_rows() > 0) {
							$survey_result = $survey_query->result();
							// print_r($survey_result);
							echo '<br/>';
							foreach ($survey_result as $survey_image) {
								$fileName = $survey_image->file_name;
								if (empty($fileName)) {
									continue;
								}
								if (strpos($fileName, 'api.ona.io') !== false || strpos($fileName, 'classic.ona.io') !== false) {
									$imageUrl = $fileName;
								} else {
									$imageUrl = $baseurl . 'uploads/survey/' . $fileName;
								}
								print_r($imageUrl);
	
								if ($imageUrl) {
									$url = 'http://54.159.212.248/forage/process_image';
									$data = json_encode(['url' => $imageUrl]);
									$ch = curl_init($url);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									curl_setopt($ch, CURLOPT_POST, true);
									curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
									curl_setopt($ch, CURLOPT_HTTPHEADER, [
										'Content-Type: application/json',
										'Content-Length: ' . strlen($data)
									]);
									$response = curl_exec($ch);
									print_r($response);
	
									if ($response === false) {
										$error = curl_error($ch);
										echo "cURL Error: " . $error;
									} else {
										$response_data = json_decode($response, true);
										
										if ($response_data && isset($response_data['predictions'])) {
											$predictions = $response_data['predictions'];
											$field_id = $survey_image->field_id;
	
											// Check if this field_id has a mapping
											if (array_key_exists($field_id, $field_mappings)) {
												$mapping = $field_mappings[$field_id];
	
												// Fetch existing row
												$this->db->select("field_{$mapping['type']}, field_{$mapping['area']}");
												$this->db->from('survey9');
												$this->db->where('data_id', $survey9->data_id);
												$existing_data_query = $this->db->get();
	
												if ($existing_data_query->num_rows() > 0) {
													$existing_data = $existing_data_query->row_array();
	
													// Prepare update data
													$update_data = [
														"field_{$mapping['type']}" => $predictions['forage_label'],
														"field_{$mapping['area']}" => $predictions['forage_area']
													];
	
													// Merge only updated fields with existing data
													$merged_data = array_merge($existing_data, $update_data);
													print_r($merged_data);
													echo '<br/><br/>';
	
													$this->db->where('data_id', $survey9->data_id);
													$this->db->update('survey9', $merged_data); // survey9_1203_backup
	
													print_r($this->db->last_query());
													echo '<br/>';
													echo '<br/>';
	
													echo "Updated survey9 for field_id: $field_id with forage type: " . 
														$predictions['forage_label'] . 
														" and area: " . $predictions['forage_area'] . 
														" for data_id: " . $survey9->data_id . "<br/>";
												}
											}
										}
									}
									curl_close($ch);
								}
							}
						} else {
							echo "No survey data found for the given field_ids.";
						}
					}
				}
			} else {
				echo "No field_ids found.";
			}
		} else {
			echo "No matching rows found in form_field_1203_backup.";
		}
		exit();
	}

	public function generate_forage_percentage_for_null() {
		// Check if user is logged in
		if (empty($this->session->userdata('login_id'))) {
			$baseurl = base_url();
			redirect($baseurl);
			exit;
		}
	
		$baseurl = "https://kaznet.ilri.org/";
	
		// Define the field mappings
		$field_mappings = [
			772 => ['type' => 1022, 'area' => 1023], // North
			773 => ['type' => 1024, 'area' => 1025], // East
			774 => ['type' => 1026, 'area' => 1027], // South
			775 => ['type' => 1028, 'area' => 1029], // West
			790 => ['type' => 1010, 'area' => 1011], // Point0
			794 => ['type' => 1012, 'area' => 1013], // Point1
			798 => ['type' => 1014, 'area' => 1015], // Point2
			802 => ['type' => 1016, 'area' => 1017], // Point3
			806 => ['type' => 1018, 'area' => 1019], // Point4
			810 => ['type' => 1020, 'area' => 1021], // Point5
			815 => ['type' => 1030, 'area' => 1031], // Point6
			819 => ['type' => 1032, 'area' => 1033], // Point7
			823 => ['type' => 1034, 'area' => 1035], // Point8
			827 => ['type' => 1036, 'area' => 1037], // Point9
			831 => ['type' => 1038, 'area' => 1039]  // Point10
		];
	
		// Step 1: Fetch field_ids from form_field where label contains 'forage' or 'vegetation'
		$this->db->select('field_id, label');
		$this->db->from('form_field');
		$this->db->group_start();
		$this->db->like('label', 'forage');
		$this->db->or_like('label', 'vegetation');
		$this->db->group_end();
		$this->db->where('form_id', 9);
		$this->db->where('status', 1);
		$this->db->where('type', 'file');
		$query = $this->db->get();
		echo $this->db->last_query() . '<br/>';
	
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$field_ids = array_column((array)$result, 'field_id');
	
			if (!empty($field_ids)) {
				// Step 2: Fetch data_ids from survey9 and check for NULL fields
				$type_columns = array_map(function($map) { return "field_{$map['type']}"; }, $field_mappings);
				$this->db->select(array_merge(['data_id'], $type_columns));
				$this->db->from('survey9');
				$this->db->where('country_id', $this->input->get('country_id'));
				$this->db->limit(1000);
				$this->db->group_start();
				foreach ($field_mappings as $map) {
					$this->db->or_where("field_{$map['type']}", NULL);
				}
				$this->db->group_end();
				$survey_query = $this->db->get();
				echo $this->db->last_query() . '<br/>';
	
				if ($survey_query->num_rows() > 0) {
					$survey_9_result = $survey_query->result();
	
					foreach ($survey_9_result as $survey9) {
						// Step 3: Identify which field_{type} is NULL
						$null_field_ids = [];
						foreach ($field_mappings as $field_id => $map) {
							$type_column = "field_{$map['type']}";
							if (is_null($survey9->$type_column)) {
								$null_field_ids[] = $field_id;
							}
						}
	
						if (!empty($null_field_ids)) {
							// Step 4: Fetch file_name, field_id, and data_id from ic_data_file for NULL field_ids
							$this->db->select('file_name, field_id, data_id');
							$this->db->from('ic_data_file');
							$this->db->where('form_id', 9);
							$this->db->where('data_id', $survey9->data_id);
							$this->db->where('status', 1);
							$this->db->where_in('field_id', $null_field_ids);
							$file_query = $this->db->get();
	
							if ($file_query->num_rows() > 0) {
								$survey_result = $file_query->result();
								foreach ($survey_result as $survey_image) {
									// Output file_name, field_id, data_id, and URL
									echo "---------------------------<br/>";
									echo "File Name: " . $survey_image->file_name . "<br/>";
									echo "Field ID: " . $survey_image->field_id . "<br/>";
									echo "Data ID: " . $survey_image->data_id . "<br/>";
									$fileName = $survey_image->file_name;
									if (empty($fileName)) {
										continue;
									}
									if (strpos($fileName, 'api.ona.io') !== false || strpos($fileName, 'classic.ona.io') !== false) {
										$imageUrl = $fileName;
									} else {
										$imageUrl = $baseurl . 'uploads/survey/' . $fileName;
									}
									echo "File URL: " . $imageUrl . '<br/>';
	
									// Step 5: Process image via cURL
									$url = 'http://54.159.212.248/forage/process_image';
									$data = json_encode(['url' => $imageUrl]);
									$ch = curl_init($url);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									curl_setopt($ch, CURLOPT_POST, true);
									curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
									curl_setopt($ch, CURLOPT_HTTPHEADER, [
										'Content-Type: application/json',
										'Content-Length: ' . strlen($data)
									]);
									$response = curl_exec($ch);
									echo "cURL Response: " . $response . '<br/>';
									echo "---------------------------<br/>";
	
									if ($response === false) {
										$error = curl_error($ch);
										echo "cURL Error: " . $error . '<br/>';
									} else {
										$response_data = json_decode($response, true);
	
										if ($response_data && isset($response_data['predictions'])) {
											$predictions = $response_data['predictions'];
											$field_id = $survey_image->field_id;
	
											// Check if this field_id has a mapping
											if (array_key_exists($field_id, $field_mappings)) {
												$mapping = $field_mappings[$field_id];
	
												// Fetch existing row
												$this->db->select("field_{$mapping['type']}, field_{$mapping['area']}");
												$this->db->from('survey9');
												$this->db->where('data_id', $survey9->data_id);
												$existing_data_query = $this->db->get();
	
												if ($existing_data_query->num_rows() > 0) {
													$existing_data = $existing_data_query->row_array();
	
													// Prepare update data
													$update_data = [
														"field_{$mapping['type']}" => $predictions['forage_label'],
														"field_{$mapping['area']}" => $predictions['forage_area']
													];
	
													// Merge only updated fields with existing data
													$merged_data = array_merge($existing_data, $update_data);
													echo "Merged Data: ";
													print_r($merged_data);
													echo '<br/><br/>';
	
													$this->db->where('data_id', $survey9->data_id);
													$this->db->update('survey9', $merged_data);
													echo $this->db->last_query() . '<br/><br/>';
	
													echo "Updated survey9 for field_id: $field_id with forage type: " .
														$predictions['forage_label'] .
														" and area: " . $predictions['forage_area'] .
														" for data_id: " . $survey9->data_id . "<br/>";
												}
											}
										}
									}
									curl_close($ch);
								}
							} else {
								echo "No survey data found for data_id: " . $survey9->data_id . " with NULL field_ids: " . implode(', ', $null_field_ids) . "<br/>";
							}
						} else {
							echo "No NULL type fields found for data_id: " . $survey9->data_id . "<br/>";
						}
					}
				} else {
					echo "No survey9 records found with NULL type fields.";
				}
			} else {
				echo "No field_ids found.";
			}
		} else {
			echo "No matching rows found in form_field.";
		}
		exit();
	}

}