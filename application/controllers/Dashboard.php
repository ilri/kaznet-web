<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');

		$baseurl = base_url();
		$this->load->model('Auth_model');
		// $session_allowed = $this->Auth_model->match_account_activity();
		// if(!$session_allowed) redirect($baseurl.'auth/logout');
	}
	
	public function index(){
		/*$this->load->model('Employee_m', 'm');
		$data['posts'] = $this->m->getEmployee();*/
	    $this->load->view('product_admin/index');
	    $this->load->view('product_admin/side_nav');
	    $this->load->view('product_admin/header');
	    $this->load->view('product_admin/footer');	
	}



	public function view_dashboard(){
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

		$result['task_list'] = $this->db->select('id,title')->where('status', 1)->order_by('type')->get('form')->result_array();
		$result['market_list'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('menu',$menu_result);
		$this->load->view('reports/dashboard', $result);
		$this->load->view('footer');
	}

	public function view_dashboard_mobile(){
		$baseurl = base_url();
		// if(($this->session->userdata('login_id') == '')) {
		// 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// 		echo json_encode(array(
		// 			'status' => 0,
		// 			'msg' => 'Session Expired! Please login again to continue.'
		// 		));
		// 		exit();
		// 	} else {
		// 		redirect($baseurl);
		// 	}
		// }
		// $user_id = $this->session->userdata('login_id');
		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		$result =array();

		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();

		$result['task_list'] = $this->db->select('id,title')->where('status', 1)->order_by('type')->get('form')->result_array();
		$result['market_list'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
		
		
		// $this->load->view('header');
		// $this->load->view('sidebar');
		// $this->load->view('menu',$menu_result);
		$this->load->view('reports/dashboard_mobile', $result);
		// $this->load->view('footer');
	}

	public function view_dashboard_mobile_hh(){
		$baseurl = base_url();
		// if(($this->session->userdata('login_id') == '')) {
		// 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// 		echo json_encode(array(
		// 			'status' => 0,
		// 			'msg' => 'Session Expired! Please login again to continue.'
		// 		));
		// 		exit();
		// 	} else {
		// 		redirect($baseurl);
		// 	}
		// }
		// $user_id = $this->session->userdata('login_id');
		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		$result =array();

		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();

		$result['task_list'] = $this->db->select('id,title')->where('status', 1)->order_by('type')->get('form')->result_array();
		$result['market_list'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
		
		
		// $this->load->view('header');
		// $this->load->view('sidebar');
		// $this->load->view('menu',$menu_result);
		$this->load->view('reports/dashboard_mobile_hh', $result);
		// $this->load->view('footer');
	}

	public function view_dashboard_mobile_tfc(){
		$baseurl = base_url();
		// if(($this->session->userdata('login_id') == '')) {
		// 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// 		echo json_encode(array(
		// 			'status' => 0,
		// 			'msg' => 'Session Expired! Please login again to continue.'
		// 		));
		// 		exit();
		// 	} else {
		// 		redirect($baseurl);
		// 	}
		// }
		// $user_id = $this->session->userdata('login_id');
		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		$result =array();

		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		
		$result['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();

		$result['task_list'] = $this->db->select('id,title')->where('status', 1)->order_by('type')->get('form')->result_array();
		$result['market_list'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
		
		
		// $this->load->view('header');
		// $this->load->view('sidebar');
		// $this->load->view('menu',$menu_result);
		$this->load->view('reports/dashboard_mobile_tfc', $result);
		// $this->load->view('footer');
	}

	public function get_users_1()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}else{

			$country_id = $this->input->post('country_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			
			
			$data = array(
				'country_id' => $country_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'start_date' => $start_date,
				'end_date' => $end_date
			);
			// $result['survey_id']=$survey_id;
			$this->load->model('Dashboard_model');

			$result['fielddata_uai_contributor_number'] = $this->Dashboard_model->uai_contributor_number_graph_array($data);
			$result['fielddata_cluster_contributor_number'] = $this->Dashboard_model->cluster_contributor_number_graph_array($data);
			$result['fielddata_contributor_number'] = $this->Dashboard_model->contributor_number_graph_array($data);
			$result['fielddata_gender'] = $this->Dashboard_model->field_option_value_count_gender_graph_array($data);
			$result['fielddata_rejected_reasons'] = $this->Dashboard_model->rejected_reasons_graph_array($data);
			$result['fielddata_account_details_status'] = $this->Dashboard_model->account_details_status_graph_array($data);
			$result['fielddata_highest_education'] = $this->Dashboard_model->highest_education_graph_array($data);
			$result['fielddata_primary_occupation'] = $this->Dashboard_model->primary_occupation_graph_array($data);
			$result['fielddata_uai_respondent_number'] = $this->Dashboard_model->uai_respondent_number_graph_array($data);
			$result['fielddata_cluster_respondent_number'] = $this->Dashboard_model->cluster_respondent_number_graph_array($data);
			$result['fielddata_respondent_dashboard'] = $this->Dashboard_model->respondent_dashboard_graph_array($data);
			$result['fielddata_household_hh_gender'] = $this->Dashboard_model->household_head_gender_graph_array($data);
			$result['fielddata_household_hh_age'] = $this->Dashboard_model->houshold_head_age_graph_array($data);
			$result['fielddata_household_member'] = $this->Dashboard_model->houshold_member_graph_array($data);
			$result['fielddata_houshold_profile'] = $this->Dashboard_model->houshold_profile_graph_array($data);
			$result['fielddata_household_children_gender'] = $this->Dashboard_model->household_children_gender_graph_array($data);
			$result['fielddata_uai_livestock_number'] = $this->Dashboard_model->uai_livestock_number_graph_array($data);
			$result['fielddata_cluster_livestock_number'] = $this->Dashboard_model->cluster_livestock_number_graph_array($data);
			$result['fielddata_household_Livestock'] = $this->Dashboard_model->household_Livestock_graph_array($data);
			// $field_list=array('3063','3064');
			// foreach($field_list as $value)
			// {
			// 	$data['field_id']=$value;
			// 	$result['fielddata_'.$survey_id.'_'.$value] = $this->Survey_details_model->fpf_demo_survey_field_value_count($data);
			// }
			// $data['field_id']='3065';
			// $result['fielddata_'.$survey_id.'_3065'] = $this->Survey_details_model->fpf_groupdata_group_field_id_value_count($data);

			// $data['field_id']='3061';
			// $result['fielddata_'.$survey_id.'_3061'] = $this->Survey_details_model->fpf_survey_bargraph_option_item_array($data);
			// $data['field_id']='3513';
			// $result['fielddata_'.$survey_id.'_3513'] = $this->Survey_details_model->fpf_survey_bargraph_option_item_array_monthwise($data);
		}
		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}
	public function get_taskwise_data()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}else{

			$country_id = $this->input->post('country');
			$uai_id = $this->input->post('uai');
			$sub_location_id = $this->input->post('sub_location');
			$cluster_id = $this->input->post('cluster');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$task_id = $this->input->post('task_id');
			
			
			$data = array(
				'country_id' => $country_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'task_id' => $task_id
			);
			// $result['survey_id']=$survey_id;
			$this->load->model('Dashboard_model');

			$result['task_level'] = $this->Dashboard_model->task_wise_records_array($data);
			$result['rejection_reasons'] = $this->Dashboard_model->task_wise_rejection_reasons_array($data);
			$result['contributor_wise'] = $this->Dashboard_model->contributor_wise_payment_details_array($data);
			$result['uai_wise'] = $this->Dashboard_model->uai_wise_payment_details_array($data);
			$result['cluster_wise'] = $this->Dashboard_model->cluster_wise_payment_details_array($data);
			$result['task_wise'] = $this->Dashboard_model->task_wise_payment_details_array($data);
			
			
		}
		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}

	public function get_users_2()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}else{

			$country_id = $this->input->post('country_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			
			
			$data = array(
				'country_id' => $country_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'start_date' => $start_date,
				'end_date' => $end_date
			);
			// $result['survey_id']=$survey_id;
			$this->load->model('Dashboard_model');

			$result['fielddata_number_of_animals'] = $this->Dashboard_model->number_of_animals_graph_array($data);
			// $result['fielddata_average_liters_milk_per_day'] = $this->Dashboard_model->average_liters_milk_per_day_graph_array($data);
			// $result['bardata_sum_liters_milk_per_day'] = $this->Dashboard_model->sum_liters_milk_per_day_graph_array($data);
			$result['fielddata_milked_sold_data'] = $this->Dashboard_model->milked_sold_data_graph_array($data);
			$result['linedata_sum_liters_selling_price'] = $this->Dashboard_model->sum_liters_selling_price_graph_array($data);
			// $result['fielddata_average_Selling_Price'] = $this->Dashboard_model->average_Selling_Price_graph_array($data);
			// $result['fielddata_production_volume'] = $this->Dashboard_model->average_production_volume_graph_array($data);
			// $result['fielddata_animal_gender'] = $this->Dashboard_model->animal_gender_graph_array($data);
			$result['fielddata_animal_gender_1'] = $this->Dashboard_model->animal_gender_1_graph_array($data);
			$result['fielddata_animal_gender_2'] = $this->Dashboard_model->animal_gender_2_graph_array($data);
			$result['fielddata_animal_age'] = $this->Dashboard_model->animal_age_graph_array($data);
			// $result['fielddata_animal_body_condition'] = $this->Dashboard_model->animal_body_condition_graph_array($data);
			$result['fielddata_animal_body_condition1'] = $this->Dashboard_model->animal_body_condition_1_graph_array($data);
			$result['fielddata_animal_body_condition2'] = $this->Dashboard_model->animal_body_condition_2_graph_array($data);
			$result['fielddata_measurement_color'] = $this->Dashboard_model->measurement_color_graph_array($data);
			$result['fielddata_muac_measurement'] = $this->Dashboard_model->muac_measurement_graph_array($data);
			$result['get_lkp_herd_type_list'] = $this->Dashboard_model->get_lkp_herd_type_list($data);
			$result['fielddata_livestock_animal'] = $this->Dashboard_model->livestock_animal_graph_array($data);
			$result['fielddata_animal_type'] = $this->Dashboard_model->animal_type_graph_array($data);
			// $result['fielddata_animal_births'] = $this->Dashboard_model->animal_births_graph_array($data);
			// $result['fielddata_animal_death'] = $this->Dashboard_model->animal_death_graph_array($data);
			$result['fielddata_animal_births_deaths'] = $this->Dashboard_model->animal_births_deaths_graph_array($data);
			// $result['fielddata_animal_death_cause'] = $this->Dashboard_model->animal_death_cause_graph_array($data);
			$result['fielddata_animal_death_cause'] = $this->Dashboard_model->animal_death_cause_bar_graph_array($data);
			$result['fielddata_animal_sales'] = $this->Dashboard_model->animal_sales_graph_array($data);
			$result['fielddata_animal_purchases'] = $this->Dashboard_model->animal_purchases_graph_array($data);
			$result['fielddata_rcsi'] = $this->Dashboard_model->rcsi_heat_map_graph_array($data);
			$result['fielddata_rcsi_stacked'] = $this->Dashboard_model->rcsi_stacked_bar_graph_array($data);
		}
		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}

	public function get_market_tab_3()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}else{

			$country_id = $this->input->post('country_id');
			$market_id = $this->input->post('market_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			
			
			$data = array(
				'country_id' => $country_id,
				'market_id' => $market_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'start_date' => $start_date,
				'end_date' => $end_date
			);
			// $result['survey_id']=$survey_id;
			$this->load->model('Dashboard_model');

			$result['fielddata_camel_milk_cluster'] = $this->Dashboard_model->camel_milk_cluster_graph_array($data);
			$result['fielddata_camel_milk_uai'] = $this->Dashboard_model->camel_milk_uai_graph_array($data);
			$result['fielddata_cattle_milk_cluster'] = $this->Dashboard_model->cattle_milk_cluster_graph_array($data);
			$result['fielddata_cattle_milk_uai'] = $this->Dashboard_model->cattle_milk_uai_graph_array($data);
			$result['fielddata_maize_grain_cluster'] = $this->Dashboard_model->maize_grain_cluster_graph_array($data);
			$result['fielddata_maize_grain_uai'] = $this->Dashboard_model->maize_grain_uai_graph_array($data);
			$result['fielddata_sorghum_cluster'] = $this->Dashboard_model->sorghum_cluster_graph_array($data);
			$result['fielddata_sorghum_uai'] = $this->Dashboard_model->sorghum_uai_graph_array($data);
			$result['fielddata_wheat_cluster'] = $this->Dashboard_model->wheat_cluster_graph_array($data);
			$result['fielddata_wheat_uai'] = $this->Dashboard_model->wheat_uai_graph_array($data);
			$result['fielddata_sugar_cluster'] = $this->Dashboard_model->sugar_cluster_graph_array($data);
			$result['fielddata_sugar_uai'] = $this->Dashboard_model->sugar_uai_graph_array($data);
			$result['fielddata_rice_cluster'] = $this->Dashboard_model->rice_cluster_graph_array($data);
			$result['fielddata_rice_uai'] = $this->Dashboard_model->rice_uai_graph_array($data);
			$result['fielddata_animal_for_trade_1'] = $this->Dashboard_model->animal_for_trade_1_graph_array($data);
			$result['fielddata_animal_for_trade_2'] = $this->Dashboard_model->animal_for_trade_2_graph_array($data);
			// $result['fielddata_final_selling_price_1'] = $this->Dashboard_model->final_selling_price_1_graph_array($data);
			// $result['fielddata_final_selling_price_2'] = $this->Dashboard_model->final_selling_price_2_graph_array($data);
			// $result['fielddata_final_selling_price'] = $this->Dashboard_model->final_selling_price_graph_array($data);
			$result['fielddata_livestock_animal_gender'] = $this->Dashboard_model->livestock_animal_gender_graph_array($data);
			$result['fielddata_camel_selling_price'] = $this->Dashboard_model->camel_selling_price_graph_array($data);
			$result['fielddata_cattle_selling_price'] = $this->Dashboard_model->cattle_selling_price_graph_array($data);
			$result['fielddata_goats_selling_price'] = $this->Dashboard_model->goats_selling_price_graph_array($data);
			$result['fielddata_sheep_selling_price'] = $this->Dashboard_model->sheep_selling_price_graph_array($data);
			$result['fielddata_camel_volumes'] = $this->Dashboard_model->camel_volumes_graph_array($data);
			$result['fielddata_cattle_volumes'] = $this->Dashboard_model->cattle_volumes_graph_array($data);
			$result['fielddata_goats_volumes'] = $this->Dashboard_model->goats_volumes_graph_array($data);
			$result['fielddata_sheep_volumes'] = $this->Dashboard_model->sheep_volumes_graph_array($data);
		}
		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}

	public function get_market_tab_4()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}else{

			$country_id = $this->input->post('country_id');
			$market_id = $this->input->post('market_id');
			$uai_id = $this->input->post('uai_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			
			
			$data = array(
				'country_id' => $country_id,
				'market_id' => $market_id,
				'uai_id' => $uai_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'start_date' => $start_date,
				'end_date' => $end_date
			);
			// $result['survey_id']=$survey_id;
			$this->load->model('Dashboard_model');

			$result['fielddata_animal_types_are_currently_grazing'] = $this->Dashboard_model->animal_types_are_currently_grazing_graph_array($data);
			$result['fielddata_protected_grazing_area'] = $this->Dashboard_model->protected_grazing_area_graph_array($data);
			$result['fielddata_rangeland_map_kml'] = $this->Dashboard_model->rangeland_map_kml_graph_array($data);
		}
		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}
	public function get_users_1_mobile()
	{
		// if(($this->session->userdata('login_id') == '')) {
		// 	echo json_encode(array(
		// 		'status' => 0,
		// 		'msg' => 'Session Expired! Please login again to continue.'
		// 	));
		// 	exit();
		// }else{

			$country_id = $this->input->post('country_id');
			$timeline_id = $this->input->post('timeline_id');
			$sub_location_id = $this->input->post('sub_location_id');
			$cluster_id = $this->input->post('cluster_id');
			$market_id = $this->input->post('market_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$user_id = $this->input->post('user_id');
			
			$this->db->select('*');
			$this->db->from('lkp_market');
			$this->db->where('status', 1);
			if(!empty($market_id)) {
				$this->db->where_in('map_id', $market_id);
			}
			$formfield_options = $this->db->get()->result_array();
			// print_r($this->db->last_query());exit();
			$market_name_list = array();
			foreach ($formfield_options as $option) {
				$form_filed_id = $option['market_id'];
				$form_filed_name = $option['name'];	
				array_push($market_name_list,$form_filed_id);
			}
			

			$data = array(
				'country_id' => $country_id,
				'timeline_id' => $timeline_id,
				'sub_location_id' => $sub_location_id,
				'cluster_id' => $cluster_id,
				'market_id' => $market_name_list,
				'start_date' => $start_date,
				'end_date' => $end_date
			);
			// $result['survey_id']=$survey_id;
			$this->load->model('Dashboard_model');
			// $market_name_list = array();
			// if(!empty($data['market_id'])){
			// 	$this->db->select('*');
			// 	$this->db->from('lkp_market');
			// 	$this->db->where('status', 1);
			// 	if(!empty($data['market_id'])) {
			// 		$this->db->where_in('market_id', $data['market_id']);
			// 	}
			// 	$formfield_options = $this->db->get()->result_array();
			// 	// print_r($this->db->last_query());exit();
			// 	foreach ($formfield_options as $option) {
			// 		$form_filed_id = $option['market_id'];
			// 		$form_filed_name = $option['name'];	
			// 		array_push($market_name_list,$form_filed_name);
			// 	}
			// }
			$week_name_list = array();
			// Get the current year and month
            $currentYear = date('Y');
            $currentMonth = date('m');

            // Get the first day of the current month
            if(!empty($data['timeline_id'])){
                $firstDayOfMonth = date('Y-m-01', strtotime($data['timeline_id']."-01"));
            }else{
                $firstDayOfMonth = date('Y-m-01', strtotime("$currentYear-$currentMonth-01"));
            }
                
            // Get the last day of the current month
            $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

            // Convert the first and last day of the month to DateTime objects
            $startDate = new DateTime($firstDayOfMonth);
            $endDate = new DateTime($lastDayOfMonth);
            
            $i=1;
            while ($startDate <= $endDate) {
                // Output the week's start and end dates
                $loop_Start_date =$startDate->format('Y-m-d');
                $startDate->modify('+6 days');
                $loop_end_date =$startDate->format('Y-m-d');
                $startDate->modify('+1 day');
                $form_filed_name ='W'.$i.' '.date('M-y', strtotime($loop_Start_date));
                // $weeknumber =date('W',strtotime($loop_Start_date));
				array_push($week_name_list,$form_filed_name);
				$i++;
			}
			$body_conditions = array();
			$this->db->select('*');
			$this->db->from('lkp_lr_body_condition');
			$this->db->where('status', 1);
			$body_conditions_list = $this->db->get()->result_array();
			foreach ($body_conditions_list as $bcvalue) {
				array_push($body_conditions,$bcvalue['name']);
			}
			$body_conditions1 = array();
			$this->db->select('*');
			$this->db->from('lkp_sr_body_condition');
			$this->db->where('status', 1);
			$body_conditions_list1 = $this->db->get()->result_array();
			foreach ($body_conditions_list1 as $bcvalue1) {
				array_push($body_conditions1,$bcvalue1['name']);
			}
			// $result['fielddata_camel_selling_price'] = $this->Dashboard_model->sheep_final_price_date_graph_array($data);
			$result['market_name_list'] = $week_name_list;
			$result['body_conditions'] = $body_conditions;
			$result['body_conditions1'] = $body_conditions1;
			//inserting user search data in feedback table added by sagar on July 3rd 
			$this->db->select('role_id');
			$this->db->from('tbl_users');
			$this->db->where('status', 1);
			$this->db->where('user_id', $user_id);
			$user_id_list = $this->db->get()->row_array();  //checking if role is 9 dessimination role
			if(isset($user_id_list)){
				$user_id_role = $user_id_list['role_id'];
				if($user_id_role==9 && !empty($market_id)){
					$data['category']="Market Task";
					foreach ($market_id as $value) {				
						$insert_data = array(
							'category' => $data['category'],
							'country_id' => $data['country_id'],
							'market_id' =>  $value,
							'user_id' => $user_id,
							'timeline' => $timeline_id,
							'datetime' => date('Y-m-d H:i:s'),
							'status' => 1
						);
						$insert_query = $this->db->insert('dissemination_role_report', $insert_data);
					}
				}
			}
			// $result['feedback_data'] = $this->Dashboard_model->insert_suer_feedback_data($data);
			
			$result['fielddata_camel_selling_price'] = $this->Dashboard_model->camel_final_price_date_graph_array($data);
			$result['fielddata_cattle_selling_price'] = $this->Dashboard_model->cattle_final_price_date_graph_array($data);
			$result['fielddata_goats_selling_price'] = $this->Dashboard_model->goats_final_price_graph_array($data);
			$result['fielddata_sheep_selling_price'] = $this->Dashboard_model->sheep_final_price_graph_array($data);
			$result['fielddata_camel_volumes'] = $this->Dashboard_model->camel_volumes_date_graph_array($data);
			$result['fielddata_cattle_volumes'] = $this->Dashboard_model->cattle_volumes_date_graph_array($data);
			$result['fielddata_goats_volumes'] = $this->Dashboard_model->goats_volumes_date_graph_array($data);
			$result['fielddata_sheep_volumes'] = $this->Dashboard_model->sheep_volumes_date_graph_array($data);
			$result['fielddata_camel_index_price'] = $this->Dashboard_model->camel_index_date_graph_array($data);
			$result['fielddata_cattle_index_price'] = $this->Dashboard_model->cattle_index_date_graph_array($data);
			$result['fielddata_maize_index_price'] = $this->Dashboard_model->maize_index_date_graph_array($data);
			$result['fielddata_sugar_index_price'] = $this->Dashboard_model->sugar_index_date_graph_array($data);
			$result['fielddata_rice_index_price'] = $this->Dashboard_model->rice_index_date_graph_array($data);
			$result['fielddata_camel_animal_trade'] = $this->Dashboard_model->camel_animal_trade_date_graph_array($data);
			$result['fielddata_cattle_animal_trade'] = $this->Dashboard_model->cattle_animal_trade_date_graph_array($data);
			$result['fielddata_goats_animal_trade'] = $this->Dashboard_model->goats_animal_trade_date_graph_array($data);
			$result['fielddata_sheep_animal_trade'] = $this->Dashboard_model->sheep_animal_trade_date_graph_array($data);
		// }
		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}
	public function get_users_1_mobile_hh()
	{
			$country_id = $this->input->post('country_id');
			$timeline_id = $this->input->post('timeline_id');
			$uai_id = $this->input->post('uai_id');
			$user_id = $this->input->post('user_id');
			
			$data = array(
				'country_id' => $country_id,
				'timeline_id' => $timeline_id,
				'uai_id' => $uai_id
			);
			// $result['survey_id']=$survey_id;
			$this->load->model('Dashboard_model');
			
			$uai_names = array();
			$this->db->select('*');
			$this->db->from('lkp_uai');
			if(!empty($data['uai_id'])) {
				$this->db->where_in('uai_id', $data['uai_id']);
			}
			$this->db->where('country_id', $country_id);
			$this->db->where('status', 1);
			$uai_list1 = $this->db->get()->result_array();
			foreach ($uai_list1 as $uvalue1) {
				array_push($uai_names,$uvalue1['uai']);
			}
			//inserting user search data in feedback table added by sagar on July 3rd 
			$this->db->select('role_id');
			$this->db->from('tbl_users');
			$this->db->where('status', 1);
			$this->db->where('user_id', $user_id);
			$user_id_list = $this->db->get()->row_array();  //checking if role is 9 dessimination role
			if(isset($user_id_list)){
				$user_id_role = $user_id_list['role_id'];
				if($user_id_role==9 && !empty($uai_id)){
					$data['category']="Household Task";
					foreach ($uai_id as $value) {				
						$insert_data = array(
							'category' => $data['category'],
							'country_id' => $data['country_id'],
							'uai_id' =>  $value,
							'user_id' => $user_id,
							'timeline' => $timeline_id,
							'datetime' => date('Y-m-d H:i:s'),
							'status' => 1
						);
						$insert_query = $this->db->insert('dissemination_role_report', $insert_data);
					}
				}
			}
			// $result['market_name_list'] = $week_name_list;
			$result['uai_names'] = $uai_names;
			$data['field1'] = 1;
			$result['fielddata_camel_births'] = $this->Dashboard_model->camel_births_date_graph_array($data);
			$data['field1'] = 2;
			$result['fielddata_cattle_births'] = $this->Dashboard_model->camel_births_date_graph_array($data);
			$data['field1'] = 3;
			$result['fielddata_goats_births'] = $this->Dashboard_model->camel_births_date_graph_array($data);
			$data['field1'] = 4;
			$result['fielddata_sheep_births'] = $this->Dashboard_model->camel_births_date_graph_array($data);
			$data['field2'] = 1;
			$result['fielddata_camel_deaths'] = $this->Dashboard_model->camel_deaths_date_graph_array($data);
			$data['field2'] = 2;
			$result['fielddata_cattle_deaths'] = $this->Dashboard_model->camel_deaths_date_graph_array($data);
			$data['field2'] = 3;
			$result['fielddata_goats_deaths'] = $this->Dashboard_model->camel_deaths_date_graph_array($data);
			$data['field2'] = 4;
			$result['fielddata_sheep_deaths'] = $this->Dashboard_model->camel_deaths_date_graph_array($data);
		
		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}

	public function get_users_1_mobile_tfc()
	{
			$country_id = $this->input->post('country_id');
			$timeline_id = $this->input->post('timeline_id');
			$uai_id = $this->input->post('uai_id');
			$user_id = $this->input->post('user_id');
			
			$data = array(
				'country_id' => $country_id,
				'timeline_id' => $timeline_id,
				'uai_id' => $uai_id
			);
			// $result['survey_id']=$survey_id;
			$this->load->model('Dashboard_model');
			
			$uai_names = array();
			$this->db->select('*');
			$this->db->from('lkp_uai');
			if(!empty($data['uai_id'])) {
				$this->db->where_in('uai_id', $data['uai_id']);
			}
			$this->db->where('country_id', $country_id);
			$this->db->where('status', 1);
			$uai_list1 = $this->db->get()->result_array();
			foreach ($uai_list1 as $uvalue1) {
				array_push($uai_names,$uvalue1['uai']);
			}
			$week_name_list = array();
			// Get the current year and month
            $currentYear = date('Y');
            $currentMonth = date('m');

            // Get the first day of the current month
            if(!empty($data['timeline_id'])){
                $firstDayOfMonth = date('Y-m-01', strtotime($data['timeline_id']."-01"));
            }else{
                $firstDayOfMonth = date('Y-m-01', strtotime("$currentYear-$currentMonth-01"));
            }
                
            // Get the last day of the current month
            $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

            // Convert the first and last day of the month to DateTime objects
            $startDate = new DateTime($firstDayOfMonth);
            $endDate = new DateTime($lastDayOfMonth);
            
            $i=1;
            while ($startDate <= $endDate) {
                // Output the week's start and end dates
                $loop_Start_date =$startDate->format('Y-m-d');
                $startDate->modify('+6 days');
                $loop_end_date =$startDate->format('Y-m-d');
                $startDate->modify('+1 day');
                $form_filed_name ='W'.$i.' '.date('M-y', strtotime($loop_Start_date));
                // $weeknumber =date('W',strtotime($loop_Start_date));
				array_push($week_name_list,$form_filed_name);
				$i++;
			}
			$result['week_name_list'] = $week_name_list;
			$result['uai_names'] = $uai_names;
			$data['field2'] = 1;
			$result['fielddata_current_condition'] = $this->Dashboard_model->current_condition_date_graph_array($data);
			$data['field2'] = 2;
			$result['fielddata_current_forage_condition'] = $this->Dashboard_model->current_condition_date_graph_array($data);
			$data['field2'] = 1;
			$result['fielddata_bale_dry_fodder'] = $this->Dashboard_model->bale_dry_fodder_date_graph_array($data);
			//inserting user search data in feedback table added by sagar on July 3rd 
			$this->db->select('role_id');
			$this->db->from('tbl_users');
			$this->db->where('status', 1);
			$this->db->where('user_id', $user_id);
			$user_id_list = $this->db->get()->row_array();  //checking if role is 9 dessimination role
			if(isset($user_id_list)){
				$user_id_role = $user_id_list['role_id'];
				if($user_id_role==9 && !empty($uai_id)){
					$data['category']="Rangeland Task";
					foreach ($uai_id as $value) {				
						$insert_data = array(
							'category' => $data['category'],
							'country_id' => $data['country_id'],
							'uai_id' =>  $value,
							'user_id' => $user_id,
							'timeline' => $timeline_id,
							'datetime' => date('Y-m-d H:i:s'),
							'status' => 1
						);
						$insert_query = $this->db->insert('dissemination_role_report', $insert_data);
					}
				}
			}
			// $data['field1'] = 4;
			// $result['fielddata_sheep_births'] = $this->Dashboard_model->camel_births_date_graph_array($data);
			// $data['field2'] = 1;
			// $result['fielddata_camel_deaths'] = $this->Dashboard_model->camel_deaths_date_graph_array($data);
			// $data['field2'] = 2;
			// $result['fielddata_cattle_deaths'] = $this->Dashboard_model->camel_deaths_date_graph_array($data);
			// $data['field2'] = 3;
			// $result['fielddata_goats_deaths'] = $this->Dashboard_model->camel_deaths_date_graph_array($data);
			// $data['field2'] = 4;
			// $result['fielddata_sheep_deaths'] = $this->Dashboard_model->camel_deaths_date_graph_array($data);
		
		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}
	
	public function view_dashboard_feedback(){
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

		
		$this->db->select('*');
		$this->db->where('role_id', 9);
		$this->db->where('status', 1);
		$this->db->order_by('first_name');
		$result['user_list'] = $this->db->get('tbl_users')->result_array();
		$result['market_list'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('menu',$menu_result);
		$this->load->view('reports/dashboard_feedback', $result);
		$this->load->view('footer');
	}

	public function d_feedback_get_data()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}else{

			$user_id = $this->input->post('user_id');
			// $country_id = $this->input->post('country_id');
			// $uai_id = $this->input->post('uai_id');
			// $sub_location_id = $this->input->post('sub_location_id');
			// $cluster_id = $this->input->post('cluster_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
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
				'user_id' => $user_id,
				// 'country_id' => $country_id,
				// 'uai_id' => $uai_id,
				// 'sub_location_id' => $sub_location_id,
				// 'cluster_id' => $cluster_id,
				'search_input' => $search_input,
				'start_date' => $start_date,
				'end_date' => $end_date,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,				
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"is_pagination" => $this->input->post('pagination') != null
			);
			
			
			$this->db->select('tu.*, drr.user_id, MAX(drr.datetime) AS max_date')->from('tbl_users as tu')->join('dissemination_role_report AS drr', 'drr.user_id = tu.user_id');
			$this->db->join('lkp_market_map AS mp','mp.market_map_id = drr.market_id','left');
			$this->db->join('lkp_uai AS uai','uai.uai_id = drr.uai_id','left');
			if(!empty($user_id)){
				$this->db->where('drr.user_id', $user_id);
			}
			if(!empty($data['start_date']) && !empty($data['end_date'])){
				$this->db->where('DATE(drr.datetime) >=', $data['start_date']);
				$this->db->where('DATE(drr.datetime) <=', $data['end_date']);
			}
			$this->db->group_by('drr.user_id');
			// $this->db->order_by('drr.datetime','ASC');
			if($data['is_search']){
				
				// search filters
				$this->db->group_start();
				$this->db->or_like('tu.first_name',$data['search_input']); //user table first name 
				$this->db->or_like('tu.last_name',$data['search_input']); //user table last name 
				$this->db->or_like('mp.name',$data['search_input']); // market name
				$this->db->or_like('uai.uai',$data['search_input']); // uai name
				$this->db->or_like('drr.category',$data['search_input']); // category 
				$this->db->group_end();
			}
			if($data['is_pagination']){
				$this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
			}
			$user_feedback_data = $this->db->where('tu.status', 1)->get()->result_array();
			// print_r($this->db->last_query());exit();
			foreach ($user_feedback_data as $key => $value) {
				$avg_value=0;
				$column_name="user_id";
				$this->db->select('SUM(feedback) sumvalue,count(user_id) as rcount');
				$this->db->where('status', 1);
				$this->db->where('user_id', $value['user_id']);
				if(!empty($data['start_date']) && !empty($data['end_date'])){
					$this->db->where('DATE(datetime) >=', $data['start_date']);
					$this->db->where('DATE(datetime) <=', $data['end_date']);
				}
				$avg_value1 = $this->db->get('disseminator_feedback')->row_array();
				// print_r($this->db->last_query());exit();
				if(isset($avg_value1['sumvalue'])){
					$avg_value = ($avg_value1['sumvalue']/$avg_value1['rcount']);
					$avg_value = round($avg_value , 0);
				}else{
					$avg_value = "N/A";
				}
				switch ($avg_value) {
					case '1':
						// $avg_value="Very Bad";
						$avg_value="Extremely useful";
						break;
					case '2':
						// $avg_value="Bad";
						$avg_value="Useful";
						break;
					case '3':
						// $avg_value="Average";
						$avg_value="Satisfactory";
						break;
					case '4':
						// $avg_value="Good";
						$avg_value="Somewhat useful";
						break;
					case '5':
						// $avg_value="Very Good";
						$avg_value="Not useful";
						break;
					
					default:
						$avg_value="N/A";
						break;
				}
				$this->db->select('*');
				$this->db->where('status', 1);
				$this->db->where('user_id', $value['user_id']);
				$this->db->where('datetime',  $value['max_date']);
				if(!empty($data['start_date']) && !empty($data['end_date'])){
					$this->db->where('DATE(datetime) >=', $data['start_date']);
					$this->db->where('DATE(datetime) <=', $data['end_date']);
				}
				$lasttime = $this->db->get('dissemination_role_report')->row_array();
				$country_name="N/A";
				$uai_name="N/A";
				$market_name="N/A";
				// print_r($this->db->last_query());exit();
				if($lasttime['country_id'] != NULL || $lasttime['country_id'] !=""){
					$country_name = $this->db->select('name')->where('country_id', $lasttime['country_id'])->where('status', 1)->get('lkp_country')->row_array();
					if(isset($country_name)){
						
						$country_name=$country_name['name'];
					}
				}
				if($lasttime['uai_id'] != NULL || $lasttime['uai_id'] !=""){
					$uai_name1 = $this->db->select('uai')->where('uai_id', $lasttime['uai_id'])->where('status', 1)->get('lkp_uai')->row_array();
					// print_r($this->db->last_query());exit();
					if(!empty($uai_name1)){
						$uai_name=$uai_name1['uai'];
					}
				}
				if($lasttime['market_id'] != NULL || $lasttime['market_id'] !=""){
					$market_name = $this->db->select('name')->where('market_map_id', $lasttime['market_id'])->where('status', 1)->get('lkp_market_map')->row_array();
					// print_r($this->db->last_query());exit();
					if(isset($market_name)){
						$market_name=$market_name['name'];
					}
				}
				$user_feedback_data[$key]['category'] = $lasttime['category'];
				$user_feedback_data[$key]['country_name'] = $country_name;
				$user_feedback_data[$key]['uai_name'] = $uai_name;
				$user_feedback_data[$key]['market_name'] = $market_name;
				$user_feedback_data[$key]['datetime'] = $lasttime['datetime'];
				$user_feedback_data[$key]['avg_value'] = $avg_value;
				// print_r($this->db->last_query());exit();
			}
			// print_r($user_feedback_data);exit();
			$result['user_feedback_data'] = $user_feedback_data;

			$this->db->select('tu.*, drr.user_id, MAX(drr.datetime) AS max_date')->from('tbl_users as tu')->join('dissemination_role_report AS drr', 'drr.user_id = tu.user_id');
			$this->db->join('lkp_market_map AS mp','mp.market_map_id = drr.market_id','left');
			$this->db->join('lkp_uai AS uai','uai.uai_id = drr.uai_id','left');
			if(!empty($user_id)){
				$this->db->where('drr.user_id', $user_id);
			}
			if(!empty($data['start_date']) && !empty($data['end_date'])){
				$this->db->where('DATE(drr.datetime) >=', $data['start_date']);
				$this->db->where('DATE(drr.datetime) <=', $data['end_date']);
			}
			$this->db->group_by('drr.user_id');
			// $this->db->order_by('drr.datetime','ASC');
			if($data['is_search']){
				
				// search filters
				$this->db->group_start();
				$this->db->or_like('tu.first_name',$data['search_input']); //user table first name 
				$this->db->or_like('tu.last_name',$data['search_input']); //user table last name 
				$this->db->or_like('mp.name',$data['search_input']); // market name
				$this->db->or_like('uai.uai',$data['search_input']); // uai name
				$this->db->or_like('drr.category',$data['search_input']); // category 
				$this->db->group_end();
			}
			$user_feedback_data1 = $this->db->where('tu.status', 1)->get()->num_rows();
			$result['total_records'] = $user_feedback_data1;
			
		}
		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}
	public function d_feedback_get_graphs_data()
	{
		if(($this->session->userdata('login_id') == '')) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}else{

			$user_id = $this->input->post('user_id');
			// $country_id = $this->input->post('country_id');
			// $uai_id = $this->input->post('uai_id');
			// $sub_location_id = $this->input->post('sub_location_id');
			// $cluster_id = $this->input->post('cluster_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			
			
			$data = array(
				'user_id' => $user_id,
				// 'country_id' => $country_id,
				// 'uai_id' => $uai_id,
				// 'sub_location_id' => $sub_location_id,
				// 'cluster_id' => $cluster_id,
				'start_date' => $start_date,
				'end_date' => $end_date
			);
			// $result['survey_id']=$survey_id;
			$this->load->model('Dashboard_model');

			$result['fielddata_ethiopia_market_users'] = $this->Dashboard_model->f_m_ethiopia_market_data($data);
			$result['fielddata_kenya_market_users'] = $this->Dashboard_model->f_m_kenya_market_data($data);
			$result['fielddata_ethiopia_hh_users'] = $this->Dashboard_model->f_u_ethiopia_hh_data($data);
			$result['fielddata_ethiopia_tfc_users'] = $this->Dashboard_model->f_u_ethiopia_tfc_data($data);
			$result['fielddata_kenya_hh_users'] = $this->Dashboard_model->f_u_kenya_hh_data($data);
			$result['fielddata_kenya_tfc_users'] = $this->Dashboard_model->f_u_kenya_tfc_data($data);
			
		}
		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}
}
