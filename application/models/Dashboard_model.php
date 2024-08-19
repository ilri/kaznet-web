<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();  
    }

    public function farmer_registered(){
        $this->db->select('data_id');        
        $this->db->where('farmer_status', 1);
        if(isset($_POST['start_date']) && isset($_POST['end_date'])){
            $this->db->where('DATE(added_date) >=', $_POST['start_date']);
            $this->db->where('DATE(added_date) <=', $_POST['end_date']);
        }
        if(isset($_POST['division']) && !is_null($_POST['division'])){
            if(isset($_POST['division'])) $division = $this->input->post('division');
            $this->db->where_in('division_id', $division);
        }
        if(isset($_POST['circle']) && !is_null($_POST['circle'])){
            if(isset($_POST['circle'])) $circle = $this->input->post('circle');
            $this->db->where_in('circle_id', $circle);
        }
        $farmer_registered = $this->db->get('tbl_farmers')->num_rows();

        return $farmer_registered;
    }

    public function total_plot(){
        $this->db->select('tblp.*, concat(tu.first_name, " ", tu.last_name) as username');
        $this->db->join('tbl_users AS tu', 'tu.user_id = tblp.added_by');
        $this->db->where('tblp.plot_status', 1);
        if(isset($_POST['start_date']) && isset($_POST['end_date'])){
            $this->db->where('DATE(tblp.added_date) >=', $_POST['start_date']);
            $this->db->where('DATE(tblp.added_date) <=', $_POST['end_date']);
        }
        if(isset($_POST['division']) && !is_null($_POST['division'])){
            if(isset($_POST['division'])) $division = $this->input->post('division');
            $this->db->where_in('tblp.field_1031', $division);
        }
        if(isset($_POST['circle']) && !is_null($_POST['circle'])){
            if(isset($_POST['circle'])) $circle = $this->input->post('circle');
            $this->db->where_in('tblp.field_1032', $circle);
        }
        $data = $this->db->order_by('tblp.plot_id', 'DESC')->get('tbl_plot AS tblp');

        // foreach ($data as $key => $value) {
        //     $date = new DateTime($value['added_date'], new DateTimeZone('UTC'));
        //     $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
        //     $data[$key]['added_date'] = $date->format('Y-m-d H:i:s');
        // }

        return $data->num_rows();
    } 

    public function plot_databyid($plot_id){
        $this->db->select('tblp.*, concat(tu.first_name, " ", tu.last_name) as username');
        $this->db->join('tbl_users AS tu', 'tu.user_id = tblp.added_by');
        $this->db->where('tblp.plot_status', 1);
        $this->db->where('plot_id', $plot_id);
        $data = $this->db->get('tbl_plot AS tblp')->row_array();

        if($data == NULL){
            return false;
        }

        $date = new DateTime($data['added_date'], new DateTimeZone('UTC'));
        $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $data['added_date'] = $date->format('Y-m-d H:i:s');

        $kml = $this->db->where('plot_data_id', $data['data_id'])->where('kml_status', 1)->get('tbl_kmlfile');
        if($kml->num_rows() > 0) $data['kml'] = $kml->row_array();
        else $data['kml'] = NULL;

        return $data;
    } 

    public function famers_byvillage()
    {
        // Disable strict mode
        $this->db->query('SET SESSION sql_mode = ""');
        
        $this->db->distinct();
        $this->db->select('lv.VNAME AS name, COUNT(tf.data_id) AS count');
        $this->db->join('lkp_village AS lv', 'lv.VILLAGE_CODE = tf.village_id');
        $this->db->where('tf.farmer_status', 1)->where('lv.VILLAGE_STATUS', 1);
        if(isset($_POST['division']) && !is_null($_POST['division'])){
            if(isset($_POST['division'])) $division = $this->input->post('division');
            $this->db->where_in('tf.division_id', $division);
        }
        if(isset($_POST['circle']) && !is_null($_POST['circle'])){
            if(isset($_POST['circle'])) $circle = $this->input->post('circle');
            $this->db->where_in('tf.circle_id', $circle);
        }
        if(isset($_POST['start_date']) && isset($_POST['end_date'])){
            $this->db->where('DATE(tf.added_date) >=', $_POST['start_date']);
            $this->db->where('DATE(tf.added_date) <=', $_POST['end_date']);
        }
        $this->db->group_by('tf.village_id')->order_by('lv.VNAME', 'ASC');
        $distinct_village_list = $this->db->get('tbl_farmers AS tf')->result_array();

        return $distinct_village_list;
    }

    public function location_data()
    {
        $baseurl = base_url();

        $this->db->select('loc.data_id, loc.form_id, loc.lat, loc.lng, loc.address, loc.created_date, f.title, concat(tu.first_name, " ", tu.last_name) as username');
        $this->db->from('ic_data_location as loc');
        $this->db->join('tbl_users AS tu', 'tu.user_id = loc.user_id');
        $this->db->join('form as f', 'f.id = loc.form_id');
        $this->db->where('loc.status', 1);
        if(isset($_POST['start_date']) && isset($_POST['end_date'])){
            $this->db->where('DATE(loc.created_date) >=', $_POST['start_date']);
            $this->db->where('DATE(loc.created_date) <=', $_POST['end_date']);
        }
        if(isset($_POST['division']) && !is_null($_POST['division'])){
            if(isset($_POST['division'])) $division = $this->input->post('division');
            $this->db->where_in('loc.division_id', $division);
        }
        if(isset($_POST['circle']) && !is_null($_POST['circle'])){
            if(isset($_POST['circle'])) $circle = $this->input->post('circle');
            $this->db->where_in('loc.circle_id', $circle);
        }
        $location_data = $this->db->get()->result_array();
        
        
        $location_array = array();
        foreach ($location_data as $key => $location) {

            $date = new DateTime($location['created_date'], new DateTimeZone('UTC'));
            $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
            $new_date = $date->format('Y-m-d H:i:s');

            $this->db->select('file_name');
            $this->db->where('file_type', 'image')->where('form_id', $location['form_id'])->where('data_id', $location['data_id']);
            $images = $this->db->get('ic_data_file')->result_array();

            if(count($images) > 0){
                $imgData = '';
                foreach ($images as $ikey => $img) {
                    $imgData .= '<img src="'.$baseurl.'uploads/survey/'.$img['file_name'].'" style="width:120px;height:120px;margin-left:5px;">';
                }
            }else{
                $imgData = '';
            }

            switch ($location['form_id']) {
                case 1:
                    $get_data = $this->db->select('farmer_number, field_1000, field_1001')->where('data_id', $location['data_id'])->get('tbl_farmers')->row_array();
                    if($get_data == NULL){
                       $farmer_number = "N/A";
                       $farmer_name = "N/A";
                    }else{
                        $farmer_number = $get_data['farmer_number'];
                        $farmer_name = $get_data['field_1000']." ".$get_data['field_1001'];
                    }               
                    $data = $imgData."<h6>".$location['title']."</h6><h6>Uploaded by: ".$location['username']."</h6><h6> Uploaded date: ".$new_date."</h6><h6>Farmer name: ".$farmer_name."</h6><h6>Farmer number: ".$farmer_number."</h6>";
                    break;

                case 2:
                    $get_data = $this->db->select('plot_number')->where('data_id', $location['data_id'])->get('tbl_plot')->row_array();
                    if($get_data == NULL){
                       $plot_number = "N/A";
                    }else{
                        $plot_number = $get_data['plot_number'];
                    }
                    $data = $imgData."<h6>".$location['title']."</h6><h6>Uploaded by: ".$location['username']."</h6><h6> Uploaded date: ".$new_date."</h6><h6>Plot number: ".$plot_number."</h6>";
                    break;
                
                default:
                    $data = $imgData."<h6>".$location['title']."</h6><h6>Uploaded by: ".$location['username']."</h6><h6> Uploaded date: ".$new_date."</h6>";
                    break;
            }

            

            array_push($location_array, array($location['lat'], $location['lng'], $data));
        }

        return $location_array;
    }

    public function total_res()
    {   
        $this->db->distinct();
        $this->db->select('unit.user_id');
        $this->db->from('tbl_users as user');
        $this->db->join('tbl_user_unit_location as unit', 'unit.user_id = user.user_id');
        $this->db->where('user.status', 1)->where('unit.status', 1)->where('role_id', 5);
        if(isset($_POST['division']) && !is_null($_POST['division'])){
            if(isset($_POST['division'])) $division = $this->input->post('division');
            $this->db->where_in('DIV_CODE', $division);
        }
        if(isset($_POST['circle']) && !is_null($_POST['circle'])){
            if(isset($_POST['circle'])) $circle = $this->input->post('circle');
            $this->db->where_in('CIR_CODE', $circle);
        }
        $total_res = $this->db->get()->num_rows();

        return $total_res;
    }

    public function total_area(){        
        $this->db->select('sum(field_1037) as area');        
        $this->db->where('plot_status', 1);
        if(isset($_POST['start_date']) && isset($_POST['end_date'])){
            $this->db->where('DATE(added_date) >=', $_POST['start_date']);
            $this->db->where('DATE(added_date) <=', $_POST['end_date']);
        }
        if(isset($_POST['division']) && !is_null($_POST['division'])){
            if(isset($_POST['division'])) $division = $this->input->post('division');
            $this->db->where_in('field_1031', $division);
        }
        if(isset($_POST['circle']) && !is_null($_POST['circle'])){
            if(isset($_POST['circle'])) $circle = $this->input->post('circle');
            $this->db->where_in('field_1032', $circle);
        }
        if(isset($_POST['village']) && !is_null($_POST['village'])){
            if(isset($_POST['village'])) $village = $this->input->post('village');
            $this->db->where_in('field_1033', $village);
        }
        $total_area = $this->db->get('tbl_plot')->row_array();

        return round($total_area['area'], 2);
    }

    public function plotsregisterd_agrementdone()
    {
        // Disable strict mode
        $this->db->query('SET SESSION sql_mode = ""');
        
        $this->db->distinct();
        $this->db->select('village_id');
        if(isset($_POST['division']) && !is_null($_POST['division'])){
            if(isset($_POST['division'])) $division = $this->input->post('division');
            $this->db->where_in('field_1031', $division);
        }
        if(isset($_POST['circle']) && !is_null($_POST['circle'])){
            if(isset($_POST['circle'])) $circle = $this->input->post('circle');
            $this->db->where_in('field_1032', $circle);
        }
        $this->db->where('plot_status', 1);
        $distinct_village_list_plotsregistered = $this->db->get('tbl_plot')->result_array();

        $this->db->distinct();
        $this->db->select('lv.VNAME, tp.village_id, COUNT(tp.data_id) AS plot_registered');
        $this->db->join('lkp_village AS lv', 'lv.VILLAGE_CODE = tp.village_id');
        if(isset($_POST['division']) && !is_null($_POST['division'])){
            if(isset($_POST['division'])) $division = $this->input->post('division');
            $this->db->where_in('tp.field_1031', $division);
        }
        if(isset($_POST['circle']) && !is_null($_POST['circle'])){
            if(isset($_POST['circle'])) $circle = $this->input->post('circle');
            $this->db->where_in('tp.field_1032', $circle);
        }
        if(isset($_POST['start_date']) && isset($_POST['end_date'])){
            $this->db->where('DATE(tp.added_date) >=', $_POST['start_date']);
            $this->db->where('DATE(tp.added_date) <=', $_POST['end_date']);
        }
        $this->db->where('tp.plot_status', 1)->group_by('tp.village_id')->order_by('lv.VNAME', 'ASC');
        $distinct_village_list_plotsregistered = $this->db->get('tbl_plot AS tp')->result_array();

        $plot_info = array();
        foreach ($distinct_village_list_plotsregistered as $key => $value) {
            $plot_info[$key]['name'] = $value['VNAME'];
            $plot_info[$key]['plot_registered'] = $value['plot_registered'];

            $this->db->select('agg.agreement_data_id')->from('tbl_plot as reg');
            $this->db->join('tbl_agreement as agg', 'reg.data_id = agg.plot_data_id');
            $this->db->where('reg.plot_status', 1)->where('agg.agreement_status', 1);
            if(isset($_POST['start_date']) && isset($_POST['end_date'])){
                $this->db->where('DATE(agg.added_date) >=', $_POST['start_date']);
                $this->db->where('DATE(agg.added_date) <=', $_POST['end_date']);
            }
            $this->db->where('reg.village_id', $value['village_id']);
            $plot_aggrement = $this->db->get()->num_rows();
            $plot_info[$key]['plot_aggrement'] = $plot_aggrement;
        }

        return $plot_info;
    }

    public function fpf_survey_bargraph_option_item_array($data){
		$participant_ids_array=array();
		if(isset($data['participant_ids']) && count($data['participant_ids']) > 0){
			$participant_ids_array = $data['participant_ids'];
		}else{
			$this->db->select('GROUP_CONCAT(value) as list');
			$this->db->where('field_id', 3061)->where('form_id', $data['survey_id']);
			$category_fields = $this->db->where('status', 1)->get('form_field_multiple')->row_array();
			$participant_ids_array=explode(',',$category_fields['list']); 
		}
		$survey_details_bargraph_option_item_array = array();
		$this->db->where('field_id', $data['field_id'])->where('form_id', $data['survey_id']);
		$survey_details_bargraph_option_item_list = $this->db->where('status', 1)->get('form_field_multiple')->result_array();
		foreach ($survey_details_bargraph_option_item_list as $value) {
			$form_filed_option_name = $value['label'];
			$form_filed_option_id = $value['multi_id'];

			$this->db->select('ifd.id, ifd.form_data');
			if(isset($data['district_ids']) && count($data['district_ids']) > 0){
				$this->db->where_in('district_id', $data['district_ids']);
			}
			if(isset($data['block_ids']) && count($data['block_ids']) > 0){
				$this->db->where_in('block_id', $data['block_ids']);
			}
			if(isset($data['village_ids']) && count($data['village_ids']) > 0){
				$this->db->where_in('village_id', $data['village_ids']);
			}	
			if(isset($data['user_ids']) && count($data['user_ids']) > 0){
				$this->db->where_in('user_id', $data['user_ids']);
			}
			if(isset($data['input_ids']) && count($data['input_ids']) > 0){
				$this->db->like('form_data', '"field_3439":'.$data['input_ids']);
			}
			if(isset($data['start_date'])){
				$this->db->where('DATE(ifd.reg_date_time) >=', $data['start_date'].' 00:00');
			}
			if(isset($data['end_date'])){
				$this->db->where('DATE(ifd.reg_date_time) <=', $data['end_date'].' 23:59');
			}            
			$this->db->where('ifd.form_id', $data['survey_id'])->where('ifd.data_status', 1);
			$survey_details_icformdata_list = $this->db->get('ic_form_data AS ifd')->result_array();
			$survey_details_bargraph_option_field = 'field_'.$data['field_id'];
			$survey_female_field = 'field_3063';
			$survey_male_field = 'field_3064';
			$category_field_id = 'field_3061';
			$totalUpload = 0;
			foreach ($survey_details_icformdata_list as $value) {
				$form_data = (array)json_decode($value['form_data']);
				$category_field_value=$form_data[$category_field_id];
				if(isset($form_data[$survey_details_bargraph_option_field]) && $form_data[$survey_details_bargraph_option_field] == $form_filed_option_name) {
					if(in_array($category_field_value,$participant_ids_array)){
						$temp_value=0;
						$temp_value=($form_data[$survey_female_field] + $form_data[$survey_male_field]);
						$totalUpload=$totalUpload+$temp_value;
					}
				}
				
			}
			array_push($survey_details_bargraph_option_item_array, array(
					'name' => $form_filed_option_name,
					'count' => $totalUpload
				));
		}
			return $survey_details_bargraph_option_item_array;
	}
    
    // from here dashboard users tab starts
    public function rejected_reasons_graph_array($data){
		$survey_details_bargraph_option_item_array = array();
		for ($i=1; $i < 4; $i++) { 
			$form_filed_id = $i;
			//, , Variety, IPM 
			switch ($form_filed_id) {
				case '1':
					$form_filed_name = "Incorrect data";
                    $color='#6FA1E7';
					break;
				case '2':
					$form_filed_name = "Inadequate data";
                    $color='#FFB6BA';
					break;
				case '3':
					$form_filed_name = "Others";
                    $color='#6A9F58';
					break;
				// case '4':
				// 	$form_filed_name = "IPM";
				// 	break;
				default:
					# code...
					break;
			}
				 // Get Survey submited Data
                $this->db->select('tu.*, tup.*, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
                $this->db->from('tbl_users as tu');
                $this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
                $this->db->join('tbl_user_unit_location AS tul', 'tul.user_id = tu.user_id');
                if(!empty($data['country_id'])) {
                    $this->db->where('tul.country_id', $data['country_id']);
                }
                if(!empty($data['cluster_id'])) {
                    $this->db->where('tul.cluster_id', $data['cluster_id']);
                }
                if(!empty($data['uai_id'])) {
                    $this->db->where('tul.uai_id', $data['uai_id']);
                }
                if(!empty($data['sub_location_id'])) {
                    $this->db->where('tul.sub_loc_id', $data['sub_location_id']);
                }
                if(!empty($data['contributor_id'])) {
                    $this->db->where('tu.user_id', $data['contributor_id']);
                }
                $this->db->where_in('tup.pa_verified_status', [1,2]);
                $this->db->where('tu.status', 1);
                $this->db->where('tu.role_id', 8);
                // $this->db->where('tup.pa_verified_status', 1);
                
                $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();
                // print_r($this->db->last_query());
                // exit();
				$totalUpload = 0;
				
				foreach ($submited_data as $value) {
                        if($value['rejected_remarks'] == $form_filed_name)
                        {
                            $totalUpload++;
                        } 					
				}
				array_push($survey_details_bargraph_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $survey_details_bargraph_option_item_array;
	}
    
    public function field_option_value_count_gender_graph_array($data){
		$survey_details_bargraph_option_item_array = array();
		for ($i=1; $i < 5; $i++) { 
			$form_filed_id = $i;
			//, , Variety, IPM 
			switch ($form_filed_id) {
				case '1':
					$form_filed_name = "Female";
					$form_filed_value = 1;
                    $color='#6FA1E7';
					break;
				case '2':
					$form_filed_name = "Male";
                    $form_filed_value = 2;
                    $color='#FFB6BA';
					break;
				case '3':
					$form_filed_name = "Other";
                    $form_filed_value = 3;
                    $color='#C8E76F';
					break;
				case '4':
					$form_filed_name = "N/A";
                    $form_filed_value = 4;
                    $color='#CDCDCD';
					break;
				// case '4':
				// 	$form_filed_name = "IPM";
				// 	break;
				default:
					# code...
					break;
			}
				 // Get Survey submited Data
                $this->db->select('tu.*, tup.*, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
                $this->db->from('tbl_users as tu');
                $this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
                $this->db->join('tbl_user_unit_location AS tul', 'tul.user_id = tu.user_id');
                if(!empty($data['country_id'])) {
                    $this->db->where('tul.country_id', $data['country_id']);
                }
                if(!empty($data['cluster_id'])) {
                    $this->db->where('tul.cluster_id', $data['cluster_id']);
                }
                if(!empty($data['uai_id'])) {
                    $this->db->where('tul.uai_id', $data['uai_id']);
                }
                if(!empty($data['sub_location_id'])) {
                    $this->db->where('tul.sub_loc_id', $data['sub_location_id']);
                }
                if(!empty($data['contributor_id'])) {
                    $this->db->where('tu.user_id', $data['contributor_id']);
                }
                $this->db->where_in('tup.pa_verified_status', [1,2]);
                $this->db->where('tu.status', 1);
                $this->db->where('tul.status', 1);
                $this->db->where('tu.role_id', 8);
                
                $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();
                // print_r($this->db->last_query());exit();
				$totalUpload = 0;
				
				foreach ($submited_data as $value) {
					
                    if($form_filed_value==1 || $form_filed_value==2 || $form_filed_value==3){
                        if($value['gender_id'] == $form_filed_value)
                        {
                            $totalUpload++;
                        } 
                    }else{
                        if($value['gender_id'] == NULL || $value['gender_id']==0)
                        {
                            $totalUpload++;
                        } 
                    }
					
					
				}
				array_push($survey_details_bargraph_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $survey_details_bargraph_option_item_array;
	}

    public function uai_contributor_number_graph_array($data){
		$uai_contributor_number_graph_array = array();
        // Get Survey submited Data
        $this->db->select('tu.*, tup.*, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
        $this->db->from('tbl_users as tu');
        $this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
        $this->db->join('tbl_user_unit_location AS tul', 'tul.user_id = tu.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('tul.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('tul.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('tul.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('tul.sub_loc_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('tu.user_id', $data['contributor_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(tu.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(tu.added_datetime) <=', $data['end_date']);
        }
        $this->db->where('tu.status', 1);
        $this->db->where('tul.status', 1);
        $this->db->where_in('tup.pa_verified_status', [1,2]);
        $this->db->where('tu.role_id', 8);
        
        $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();

        // $this->db->select('*');
        // $this->db->from('lkp_education_level');
        // $this->db->where('status', 1);
        // $formfield_options = $this->db->get()->result_array();
        if(!empty($data['country_id'])) {
            $this->db->where_in('country_id', $data['country_id']);
        }
        $formfield_options = $this->db->where('status', 1)->get('lkp_uai')->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['uai_id'];
            $form_filed_name = $option['uai'];
			//Available, Not Available(NULL)
				 
				$totalUpload = 0;
				
				foreach ($submited_data as $value) {
					if(isset($value['uai_id'])){
                        if($form_filed_id==$value['uai_id']){                        
                            $totalUpload++;
                        } 
                    }					
				}
                
				array_push($uai_contributor_number_graph_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $uai_contributor_number_graph_array;
	}

    public function cluster_contributor_number_graph_array($data){
		$cluster_contributor_number_graph_array = array();
        // Get Survey submited Data
        $this->db->select('tu.*, tup.*, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
        $this->db->from('tbl_users as tu');
        $this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
        $this->db->join('tbl_user_unit_location AS tul', 'tul.user_id = tu.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('tul.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('tul.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('tul.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('tul.sub_loc_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('tu.user_id', $data['contributor_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(tu.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(tu.added_datetime) <=', $data['end_date']);
        }
        $this->db->where('tu.status', 1);
        $this->db->where('tul.status', 1);
        $this->db->where_in('tup.pa_verified_status', [1,2]);
        $this->db->where('tu.role_id', 8);
        
        $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        // $this->db->select('*');
        // $this->db->from('lkp_education_level');
        // $this->db->where('status', 1);
        // $formfield_options = $this->db->get()->result_array();
        if(!empty($data['country_id'])) {
            $this->db->where_in('country_id', $data['country_id']);
        }
        $formfield_options = $this->db->where('status', 1)->get('lkp_cluster')->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['cluster_id'];
            $form_filed_name = $option['name'];
			//Available, Not Available(NULL)
				 
				$totalUpload = 0;
				
				foreach ($submited_data as $value) {
					if(isset($value['cluster_id'])){
                        if($form_filed_id==$value['cluster_id']){                        
                            $totalUpload++;
                        } 
                    }					
				}
				array_push($cluster_contributor_number_graph_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $cluster_contributor_number_graph_array;
	}

    public function contributor_number_graph_array($data){
		$contributor_number_graph_array = array();
        // Get Survey submited Data
        $this->db->select('tu.*,tu.status as tblstatus, tup.*,tup.pa_verified_status, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
        $this->db->from('tbl_users as tu');
        $this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
        $this->db->join('tbl_user_unit_location AS tul', 'tul.user_id = tu.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('tul.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('tul.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('tul.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('tul.sub_loc_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('tu.user_id', $data['contributor_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(tu.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(tu.added_datetime) <=', $data['end_date']);
        }
        $this->db->where('tu.status', 1);
        $this->db->where('tul.status', 1);
        $this->db->where_in('tup.pa_verified_status', [1,2]);
        $this->db->where('tu.role_id', 8);
        
        $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();

		for ($i=1; $i < 7; $i++) { 
			$form_filed_id = $i;
			//Approved,Rejected,Agreed to Terms,Pending Terms Agreement,Inactive,Deleted
			switch ($form_filed_id) {
				case '1':
					$form_filed_name = "Approved";
                    $form_filed_value = 1;
                    $color='#6FA1E7';
					break;
				case '2':
					$form_filed_name = "Rejected";
                    $form_filed_value = 2;
                    $color='#FFB6BA';
					break;
				case '3':
					$form_filed_name = "Agreed to Terms";
                    $form_filed_value = 3;
                    $color='#C8E76F';
					break;
				case '4':
					$form_filed_name = "Pending Terms Agreement";
                    $form_filed_value = 4;
                    $color='#FFB6BA';
					break;
				case '5':
					$form_filed_name = "Inactive";
                    $form_filed_value = 5;
                    $color='#CDCDCD';
					break;
				case '6':
					$form_filed_name = "Deleted";
                    $form_filed_value = 6;
                    $color='#E49443';
					break;
				default:
					# code...
					break;
			}
				 
				$totalUpload = 0;
				// print_r($this->db->last_query());
                // exit();
				foreach ($submited_data as $value) {

                    switch ($form_filed_value) {
                        case 1:
                            if($value['pa_verified_status'] == 2 && $value['tblstatus'] == 1){ //Approved
                                $totalUpload++;
                            }
                            break;
                        case 2:
                            if($value['pa_verified_status'] == 3 && $value['tblstatus'] == 1){ //Rejected
                                $totalUpload++;
                            }
                            break;
                        case 3:
                            if($value['pa_verified_status'] == 1 && $value['terms_conditions'] == 1 && $value['tblstatus'] == 1){ //Agreed to Terms
                                $totalUpload++;
                            }
                            break;
                        case 4:
                            if($value['pa_verified_status'] == 1 && $value['terms_conditions'] == NULL && $value['tblstatus'] == 1){ //Pending Terms Agreement
                                $totalUpload++;
                            }
                            break;
                        case 5:
                            if($value['pa_verified_status'] == 1 && $value['tblstatus'] == 0){ //Inactive
                                $totalUpload++;
                            }
                            break;
                        case 5:
                            if($value['pa_verified_status'] == 1 && $value['tblstatus'] == -1){ //Deleted
                                $totalUpload++;
                            }
                            break;
                        
                        default:
                            # code...
                            break;
                    }
					
				}
				array_push($contributor_number_graph_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $contributor_number_graph_array;
	}

    public function account_details_status_graph_array($data){
		$account_details_status_graph_array = array();
        // Get Survey submited Data
        $this->db->select('tu.*, tup.*, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
        $this->db->from('tbl_users as tu');
        $this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
        $this->db->join('tbl_user_unit_location AS tul', 'tul.user_id = tu.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('tul.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('tul.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('tul.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('tul.sub_loc_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('tu.user_id', $data['contributor_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(tu.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(tu.added_datetime) <=', $data['end_date']);
        }
        $this->db->where('tu.status', 1);
        // $this->db->where('tul.status', 1);
        $this->db->where_in('tup.pa_verified_status', [1,2]);
        $this->db->where('tu.role_id', 8);
        // print_r($this->db->last_query());
        // exit();
        $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();
		for ($i=1; $i < 3; $i++) { 
			$form_filed_id = $i;
			//Available, Not Available(NULL)
			switch ($form_filed_id) {
				case '1':
					$form_filed_name = "Available";
					$form_filed_value = 1;
                    $color='#6FA1E7';
					break;
				case '2':
					$form_filed_name = "Not Available";
                    $form_filed_value = 2;
                    $color='#FFB6BA';
					break;
				
				default:
					# code...
					break;
			}
				 
				$totalUpload = 0;
				
				foreach ($submited_data as $value) {
					switch ($form_filed_value) {
                        case '1':
                            if(isset($value['account_number']) && $value['account_number'] != NULL)
                            {
                                $totalUpload++;
                            }
                            break;
                        case '2':
                            if($value['account_number'] == NULL || $value['account_number'] =="")
                            {
                                $totalUpload++;
                            }
                            break;
                        
                        default:
                            # code...
                            break;
                    }					
				}
				array_push($account_details_status_graph_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $account_details_status_graph_array;
	}
    public function highest_education_graph_array($data){
		$highest_education_graph_array = array();
         // Get Survey submited Data
         $this->db->select('tu.*, tup.*, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
         $this->db->from('tbl_users as tu');
         $this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
         $this->db->join('tbl_user_unit_location AS tul', 'tul.user_id = tu.user_id');
         if(!empty($data['country_id'])) {
             $this->db->where('tul.country_id', $data['country_id']);
         }
         if(!empty($data['cluster_id'])) {
             $this->db->where('tul.cluster_id', $data['cluster_id']);
         }
         if(!empty($data['uai_id'])) {
             $this->db->where('tul.uai_id', $data['uai_id']);
         }
         if(!empty($data['sub_location_id'])) {
             $this->db->where('tul.sub_loc_id', $data['sub_location_id']);
         }
         if(!empty($data['contributor_id'])) {
             $this->db->where('tu.user_id', $data['contributor_id']);
         }
         if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(tu.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(tu.added_datetime) <=', $data['end_date']);
        }
         $this->db->where('tu.status', 1);
         $this->db->where('tul.status', 1);
         $this->db->where_in('tup.pa_verified_status', [1,2]);
         $this->db->where('tu.role_id', 8);
         
         $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();

        $this->db->select('*');
        $this->db->from('lkp_education_level');
        $this->db->where('status', 1);
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['edu_id'];
            $form_filed_name = $option['name'];
			//Available, Not Available(NULL)
			switch ($form_filed_id) {
				case '1':
                    $color='#6FA1E7';
					break;
				case '2':
                    $color='#FFB6BA';
					break;
				case '3':
                    $color='#C8E76F';
					break;
				case '4':
                    $color='#6A9F58';
					break;
				case '5':
                    $color='#CDCDCD';
					break;
				case '6':
                    $color='#E49443';
					break;
				default:
					# code...
					break;
			}
				
				$totalUpload = 0;
				
				foreach ($submited_data as $value) {
					if(isset($value['highest_education'])){
                        if($form_filed_id==$value['highest_education']){                        
                            $totalUpload++;
                        } 
                    }					
				}
				array_push($highest_education_graph_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $highest_education_graph_array;
	}
    public function primary_occupation_graph_array($data){
		$primary_occupation_graph_array = array();
        // Get Survey submited Data
        $this->db->select('tu.*, tup.*, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
        $this->db->from('tbl_users as tu');
        $this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
        $this->db->join('tbl_user_unit_location AS tul', 'tul.user_id = tu.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('tul.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('tul.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('tul.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('tul.sub_loc_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('tu.user_id', $data['contributor_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(tu.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(tu.added_datetime) <=', $data['end_date']);
        }
        $this->db->where('tu.status', 1);
        $this->db->where('tul.status', 1);
        $this->db->where_in('tup.pa_verified_status', [1,2]);
        $this->db->where('tu.role_id', 8);
        
        $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();
        $this->db->select('*');
        $this->db->from('lkp_occupation');
        $this->db->where('status', 1);
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['occu_id'];
            $form_filed_name = $option['name'];
			//Available, Not Available(NULL)
			switch ($form_filed_id) {
				case '1':
                    $color='#5877A3';
					break;
				case '2':
                    $color='#E49443';
					break;
				case '3':
                    $color='#6A9F58';
					break;
				case '4':
                    $color='#F1A2A7';
					break;
				case '5':
                    $color='#6FA1E7';
					break;
				case '6':
                    $color='#FFB6BA';
					break;
				case '7':
                    $color='#C8E76F';
					break;
				case '8':
                    $color='#CDCDCD';
					break;
				default:
					# code...
					break;
			}
                
            $totalUpload = 0;
            
            foreach ($submited_data as $value) {
                if(isset($value['primary_occupation'])){
                    if($form_filed_id==$value['primary_occupation']){                        
                        $totalUpload++;
                    } 
                }					
            }
            array_push($primary_occupation_graph_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'y' => $totalUpload
                ));
		}
		return $primary_occupation_graph_array;
	}
    public function uai_respondent_number_graph_array($data){
		$uai_respondent_number_graph_array = array();
        // Get Survey submited Data
        $this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by');
        $this->db->from('tbl_respondent_users as rp');
        $this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
        if(!empty($data['country_id'])) {
            $this->db->where('rp.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('rp.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('rp.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('rp.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('rp.added_by', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            $this->db->where('rp.id', $data['respondent_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(tu.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(tu.added_datetime) <=', $data['end_date']);
        }
        $this->db->where_in('rp.pa_verified_status', [1,2]);
        $this->db->where('rp.status', 1);        
        $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();

        // $this->db->select('*');
        // $this->db->from('lkp_education_level');
        // $this->db->where('status', 1);
        // $formfield_options = $this->db->get()->result_array();
        if(!empty($data['country_id'])) {
            $this->db->where_in('country_id', $data['country_id']);
        }
        $formfield_options = $this->db->where('status', 1)->get('lkp_uai')->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['uai_id'];
            $form_filed_name = $option['uai'];
			//Available, Not Available(NULL)
				 
				$totalUpload = 0;
				
				foreach ($submited_data as $value) {
					if(isset($value['uai_id'])){
                        if($form_filed_id==$value['uai_id']){                        
                            $totalUpload++;
                        } 
                    }					
				}
				array_push($uai_respondent_number_graph_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $uai_respondent_number_graph_array;
	}

    public function cluster_respondent_number_graph_array($data){
		$cluster_respondent_number_graph_array = array();
       // Get Survey submited Data
       $this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by');
       $this->db->from('tbl_respondent_users as rp');
       $this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
       if(!empty($data['country_id'])) {
           $this->db->where('rp.country_id', $data['country_id']);
       }
       if(!empty($data['cluster_id'])) {
           $this->db->where('rp.cluster_id', $data['cluster_id']);
       }
       if(!empty($data['uai_id'])) {
           $this->db->where('rp.uai_id', $data['uai_id']);
       }
       if(!empty($data['sub_location_id'])) {
           $this->db->where('rp.sub_location_id', $data['sub_location_id']);
       }
       if(!empty($data['contributor_id'])) {
           $this->db->where('rp.added_by', $data['contributor_id']);
       }
       if(!empty($data['respondent_id'])) {
           $this->db->where('rp.id', $data['respondent_id']);
       }
       if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(rp.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(rp.added_datetime) <=', $data['end_date']);
        }
        $this->db->where_in('rp.pa_verified_status', [1,2]);
       $this->db->where('rp.status', 1);        
       $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();

        // $this->db->select('*');
        // $this->db->from('lkp_education_level');
        // $this->db->where('status', 1);
        // $formfield_options = $this->db->get()->result_array();
        if(!empty($data['country_id'])) {
            $this->db->where_in('country_id', $data['country_id']);
        }
        $formfield_options = $this->db->where('status', 1)->get('lkp_cluster')->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['cluster_id'];
            $form_filed_name = $option['name'];
			//Available, Not Available(NULL)				 
				$totalUpload = 0;				
				foreach ($submited_data as $value) {
					if(isset($value['cluster_id'])){
                        if($form_filed_id==$value['cluster_id']){                        
                            $totalUpload++;
                        } 
                    }					
				}
				array_push($cluster_respondent_number_graph_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $cluster_respondent_number_graph_array;
	}

    public function respondent_dashboard_graph_array($data){
		$respondent_dashboard_graph_array = array();
        
		for ($i=1; $i < 5; $i++) { 
			$form_filed_id = $i;
			//, , Variety, IPM 
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Submitted";
                    $color='#5877A3';
					break;
				case '2':
                    $form_filed_name = "Profile Pending";
                    $color='#E49443';
					break;
				case '3':
                    $form_filed_name = "Approved";
                    $color='#6A9F58';
					break;
				case '4':
                    $form_filed_name = "Rejected";
                    $color='#F1A2A7';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				 
                switch ($form_filed_id) {
                    case '1':
                        $this->db->where('rp.pa_verified_status', 1);
                        $this->db->where('rp.head_name !=', NULL);
                        break;
                    case '2':
                        $this->db->where('rp.pa_verified_status', 1);
                        $this->db->where('rp.head_name', NULL);
                        break;
                    case '3':
                        $this->db->where('rp.pa_verified_status', 2);
                        break;
                    case '4':
                        $this->db->where('rp.pa_verified_status',3);
                        break;
                    default:
                        # code...
                        break;
                }
                // Get Survey submited Data
                $this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by');
                $this->db->from('tbl_respondent_users as rp');
                $this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
                if(!empty($data['country_id'])) {
                    $this->db->where('rp.country_id', $data['country_id']);
                }
                if(!empty($data['cluster_id'])) {
                    $this->db->where('rp.cluster_id', $data['cluster_id']);
                }
                if(!empty($data['uai_id'])) {
                    $this->db->where('rp.uai_id', $data['uai_id']);
                }
                if(!empty($data['sub_location_id'])) {
                    $this->db->where('rp.sub_location_id', $data['sub_location_id']);
                }
                if(!empty($data['contributor_id'])) {
                    $this->db->where('rp.added_by', $data['contributor_id']);
                }
                if(!empty($data['respondent_id'])) {
                    $this->db->where('rp.id', $data['respondent_id']);
                }
                if(!empty($data['start_date']) && !empty($data['end_date'])){
                    $this->db->where('DATE(rp.added_datetime) >=', $data['start_date']);
                    $this->db->where('DATE(rp.added_datetime) <=', $data['end_date']);
                }
                $this->db->where_in('rp.pa_verified_status', [1,2]);
                $this->db->where('rp.status', 1);
                // $submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();
                $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
                // print_r($this->db->last_query());
                // exit();
				
				
				// foreach ($submited_data as $value) {
                //         if($value['rejected_remarks'] == $form_filed_name)
                //         {
                //             $totalUpload++;
                //         } 					
				// }
				array_push($respondent_dashboard_graph_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $respondent_dashboard_graph_array;
	}

    public function household_head_gender_graph_array($data){
		$household_head_gender_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by');
        $this->db->from('tbl_respondent_users as rp');
        $this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
        if(!empty($data['country_id'])) {
            $this->db->where('rp.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('rp.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('rp.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('rp.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('rp.added_by', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            $this->db->where('rp.id', $data['respondent_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
           $this->db->where('DATE(rp.added_datetime) >=', $data['start_date']);
           $this->db->where('DATE(rp.added_datetime) <=', $data['end_date']);
       }
       $this->db->where_in('rp.pa_verified_status', [1,2]);
        $this->db->where('rp.status', 1);
       
       $submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();
		for ($i=1; $i < 3; $i++) { 
			$form_filed_id = $i;
			//, , Variety, IPM 
			switch ($form_filed_id) {
				case '1':
					$form_filed_name = "Male";
					$form_filed_value = 1;
                    $color='#6FA1E7';
					break;
				case '2':
					$form_filed_name = "Female";
                    $form_filed_value = 2;
                    $color='#FFB6BA';
					break;
				case '3':
					$form_filed_name = "N/A";
                    $form_filed_value = 0;
                    $color='#C8E76F';
					break;
				// case '4':
				// 	$form_filed_name = "IPM";
				// 	break;
				default:
					# code...
					break;
			}
				 
				$totalUpload = 0;
				
				foreach ($submited_data as $value) {
					
                    if($form_filed_value!=0){
                        if($value['head_gender'] == $form_filed_name)
                        {
                            $totalUpload++;
                        } 
                    }else{
                        if($value['head_gender'] == NULL)
                        {
                            // $totalUpload++;
                        } 
                    }
					
					
				}
				array_push($household_head_gender_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $household_head_gender_option_item_array;
	}

    public function houshold_head_age_graph_array($data){
		$houshold_head_age_option_item_array = array();
         // Get Survey submited Data
         $this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by');
         $this->db->from('tbl_respondent_users as rp');
         $this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
         if(!empty($data['country_id'])) {
             $this->db->where('rp.country_id', $data['country_id']);
         }
         if(!empty($data['cluster_id'])) {
             $this->db->where('rp.cluster_id', $data['cluster_id']);
         }
         if(!empty($data['uai_id'])) {
             $this->db->where('rp.uai_id', $data['uai_id']);
         }
         if(!empty($data['sub_location_id'])) {
             $this->db->where('rp.sub_location_id', $data['sub_location_id']);
         }
         if(!empty($data['contributor_id'])) {
             $this->db->where('rp.added_by', $data['contributor_id']);
         }
         if(!empty($data['respondent_id'])) {
             $this->db->where('rp.id', $data['respondent_id']);
         }
         if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(rp.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(rp.added_datetime) <=', $data['end_date']);
        }
         $this->db->where_in('rp.pa_verified_status', [1,2]);
         $this->db->where('rp.status', 1);
         $submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();
         // print_r($this->db->last_query());
         // exit();
		for ($i=1; $i < 6; $i++) { 
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Age 0-5";
                    $color='#5877A3';
					break;
				case '2':
                    $form_filed_name = "Age 6-17";
                    $color='#E49443';
					break;
				case '3':
                    $form_filed_name = "Age 18-65";
                    $color='#6A9F58';
					break;
				case '4':
                    $form_filed_name = "Age 66 and above";
                    $color='#F1A2A7';
					break;
				case '5':
                    $form_filed_name = "Age not known";
                    $color='#6FA1E7';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
            foreach ($submited_data as $value) {                    
                if($value['head_age']!=NULL && !empty($value['head_age'])){
                    switch ($form_filed_id) {
                        case '1':
                            if($value['head_age']>0 && $value['head_age']<=5){
                                $totalUpload++;
                            }
                            break;
                        case '2':
                            if($value['head_age']>5 && $value['head_age']<=17){
                                $totalUpload++;
                            }
                            break;
                        case '3':
                            if($value['head_age']>=18 && $value['head_age']<=65){
                                $totalUpload++;
                            }
                            break;
                        case '4':
                            if($value['head_age']>66 ){
                                $totalUpload++;
                            }
                            break;
                        case '5':
                            if($value['head_age']==-99 ){
                                $totalUpload++;
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                }
                                    
            }
            array_push($houshold_head_age_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'y' => $totalUpload
                ));
		}
		return $houshold_head_age_option_item_array;
	}

    public function houshold_member_graph_array($data){
		$houshold_profile_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by');
        $this->db->from('tbl_respondent_users as rp');
        $this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
        if(!empty($data['country_id'])) {
            $this->db->where('rp.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('rp.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('rp.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('rp.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('rp.added_by', $data['contributor_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(rp.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(rp.added_datetime) <=', $data['end_date']);
        }
        if(!empty($data['respondent_id'])) {
            $this->db->where('rp.id', $data['respondent_id']);
        }
        $this->db->where('rp.status', 1);
        // switch ($form_filed_id) {
        //     case '1':
        //         $this->db->where('rp.member_below_5 !=', NULL);
        //         break;
        //     case '2':
        //         $this->db->where('rp.member_5_17 !=', NULL);
        //         break;
        //     case '3':
        //         $this->db->where('rp.member_18_65 !=', NULL);
        //         break;
        //     case '4':
        //         $this->db->where('rp.member_above_65 !=', NULL);
        //         break;
        //     default:
        //         # code...
        //         break;
        // }
        $this->db->where_in('rp.pa_verified_status', [1,2]);
        $submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();

		for ($i=1; $i < 5; $i++) { 
			$form_filed_id = $i;
			//, , Variety, IPM 
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Age 0-5";
                    $color='#5877A3';
					break;
				case '2':
                    $form_filed_name = "Age 5-17";
                    $color='#E49443';
					break;
				case '3':
                    $form_filed_name = "Age 18-65";
                    $color='#6A9F58';
					break;
				case '4':
                    $form_filed_name = "Age 66 and above";
                    $color='#F1A2A7';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				 
                // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
                // print_r($this->db->last_query());
                // exit();
				
				$temp = 0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    switch ($form_filed_id) {
                        case '1':
                            if($value['member_below_5'] != NULL)
                            {
                                $temp = $value['member_below_5'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            break;
                        case '2':
                            if($value['member_5_17'] != NULL)
                            {
                                $temp = $value['member_5_17'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            break;
                        case '3':
                            // $this->db->where('rp.member_18_65 !=', NULL);
                            if($value['member_18_65'] != NULL)
                            {
                                $temp = $value['member_18_65'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            break;
                        case '4':
                            // $this->db->where('rp.member_above_65 !=', NULL);
                            if($value['member_above_65'] != NULL)
                            {
                                $temp = $value['member_above_65'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            break;
                        default:
                            # code...
                            break;
                    }
                        				
				}
				array_push($houshold_profile_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $houshold_profile_option_item_array;
	}

    public function houshold_profile_graph_array($data){
		$houshold_profile_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by');
        $this->db->from('tbl_respondent_users as rp');
        $this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
        if(!empty($data['country_id'])) {
            $this->db->where('rp.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('rp.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('rp.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('rp.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('rp.added_by', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            $this->db->where('rp.id', $data['respondent_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(rp.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(rp.added_datetime) <=', $data['end_date']);
        }
        $this->db->where('rp.status', 1);
        $this->db->where_in('rp.pa_verified_status', [1,2]);
        
        $submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        
		for ($i=1; $i < 4; $i++) { 
			$form_filed_id = $i;
			$yes_count=0;
			$child_count=0;
            $no_count=0;
            $data_array= array();
			switch ($form_filed_id) {
				case '1':
                    // $form_filed_name = "Age 5-17 Disable";
                    $form_filed_name = "Disable";
                    $color='#5877A3';
					break;
				case '2':
                    // $form_filed_name = "Age 5-17 Chronic";
                    $form_filed_name = "Chronic";
                    $color='#E49443';
					break;
				case '3':
                    // $form_filed_name = "Age 5-17 Both";
                    $form_filed_name = "Both";
                    $color='#6FA1E7';
					break;
				// case '4':
                //     $form_filed_name = "Age 18-65 Disable";
                //     $color='#6A9F58';
				// 	break;
				// case '5':
                //     $form_filed_name = "Age 18-65 Chronic";
                //     $color='#F1A2A7';
				// 	break;
                // case '6':
                //     $form_filed_name = "Age 18-65 Both";
                //     $color='#C8E76F';
                //     break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				 
				
				foreach ($submited_data as $value) {
                    switch ($form_filed_id) {
                        case '1':
                            // if($value['member_5_17_disable'] == "Yes" && ($value['member_5_17_chronic'] == NULL || $value['member_5_17_chronic'] == "No"))  {
                            //     $yes_count++;
                            // } 	
                            // if($value['member_5_17_disable'] == "No" && ($value['member_5_17_chronic'] == NULL || $value['member_5_17_chronic'] == "Yes"))  {
                            //     $no_count++;
                            // } 
                            if($value['member_5_17_disable'] == "Yes" )  {
                                    $yes_count++;
                                }	
                            if($value['member_18_65_disable'] == "Yes" )  {
                                    $no_count++;
                                }	
                            if($value['is_child_disable'] == "Yes" )  {
                                    $child_count++;
                                }	
                            break;
                        case '2':
                            // if($value['member_5_17_chronic'] == "Yes" && ($value['member_5_17_disable'] == NULL || $value['member_5_17_disable'] == "No"))  {
                            //     $yes_count++;
                            // } 	
                            // if($value['member_5_17_chronic'] == "No" && ($value['member_5_17_disable'] == NULL || $value['member_5_17_disable'] == "Yes"))  {
                            //     $no_count++;
                            // } 	
                            if($value['member_5_17_chronic'] == "Yes"  )  {
                                $yes_count++;
                            }	
                            if($value['member_18_65_chronic'] == "Yes" )  {
                                $no_count++;
                            }
                            if($value['child_chronically_ill'] == "Yes" )  {
                                $child_count++;
                            }
                            break;
                        case '3':
                            if($value['member_5_17_chronic'] == "Yes" && $value['member_5_17_disable'] == "Yes" ) {
                                $yes_count++;
                            } 	
                            if($value['member_18_65_chronic'] == "Yes" && $value['member_18_65_disable'] == "Yes" ) {
                                $no_count++;
                            } 	
                            if($value['child_chronically_ill'] == "Yes" && $value['is_child_disable'] == "Yes" ) {
                                $child_count++;
                            } 	
                            break;
                        case '4':
                            if($value['member_18_65_disable'] == "Yes" && ($value['member_18_65_chronic'] == NULL || $value['member_18_65_chronic'] == "No")) {
                                $yes_count++;
                            } 	
                            if($value['member_18_65_disable'] == "No" && ($value['member_18_65_chronic'] == NULL || $value['member_18_65_chronic'] == "Yes")) {
                                $no_count++;
                            } 	
                            break;
                        case '5':
                            if($value['member_18_65_chronic'] == "Yes" && ($value['member_18_65_disable'] == NULL || $value['member_18_65_disable'] == "No")) {
                                $yes_count++;
                            } 	
                            if($value['member_18_65_chronic'] == "No" && ($value['member_18_65_disable'] == NULL || $value['member_18_65_disable'] == "Yes")) {
                                $no_count++;
                            } 	
                            break;
                        case '6':
                            if($value['member_18_65_disable'] == "Yes"  && $value['member_18_65_chronic'] == "Yes" ) {
                                $yes_count++;
                            } 	
                            if($value['member_18_65_disable'] == "No"  && $value['member_18_65_chronic'] == "No" ) {
                                $no_count++;
                            } 	
                            break;
                        default:
                            # code...
                            break;
                    }
                        				
				}
                array_push($data_array,$child_count,$yes_count,$no_count);
				array_push($houshold_profile_option_item_array, array(
                        'name' => $form_filed_name,
                        'color' => $color,
                        'data' => $data_array
					));
		}
		return $houshold_profile_option_item_array;
	}

    public function household_children_gender_graph_array($data){
		$household_children_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('rp.*,rp.gender as ch_gender ,concat(tu.first_name," ", tu.last_name) as added_by');
        //  $this->db->select('rp.*');
         $this->db->from('tbl_respondent_users as rp');
         $this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
         if(!empty($data['country_id'])) {
             $this->db->where('rp.country_id', $data['country_id']);
         }
         if(!empty($data['cluster_id'])) {
             $this->db->where('rp.cluster_id', $data['cluster_id']);
         }
         if(!empty($data['uai_id'])) {
             $this->db->where('rp.uai_id', $data['uai_id']);
         }
         if(!empty($data['sub_location_id'])) {
             $this->db->where('rp.sub_location_id', $data['sub_location_id']);
         }
         if(!empty($data['contributor_id'])) {
             $this->db->where('rp.added_by', $data['contributor_id']);
         }
         if(!empty($data['respondent_id'])) {
             $this->db->where('rp.id', $data['respondent_id']);
         }
         if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(rp.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(rp.added_datetime) <=', $data['end_date']);
        }
         $this->db->where_in('rp.pa_verified_status', [1,2]);
         $this->db->where('rp.status', 1);
         $this->db->where('rp.child_name !=', NULL);
        
         $submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();
        //  print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 3; $i++) { 
			$form_filed_id = $i;
			//, , Variety, IPM 
			switch ($form_filed_id) {
				case '1':
					$form_filed_name = "Boy";
					$form_filed_value = "Male";
                    $color='#6FA1E7';
					break;
				case '2':
					$form_filed_name = "Girl";
                    $form_filed_value = "Female";
                    $color='#FFB6BA';
					break;
				case '3':
					$form_filed_name = "N/A";
                    $form_filed_value = "N/A";
                    $color='#C8E76F';
					break;
				// case '4':
				// 	$form_filed_name = "IPM";
				// 	break;
				default:
					# code...
					break;
			}
				 
				$totalUpload = 0;
				
				foreach ($submited_data as $value) {
					
                    if($form_filed_value!= "N/A"){
                            if($value['ch_gender'] == $form_filed_value)
                            {
                                $totalUpload++;
                            } 
                    }else{
                            if($value['ch_gender'] == NULL)
                            {
                                // $totalUpload++;
                            }                        
                    }
					
					
				}
				array_push($household_children_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $household_children_option_item_array;
	}
    
   

    public function uai_livestock_number_graph_array($data){
		$uai_livestock_number_graph_array = array();
        // Get Survey submited Data
        $this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by');
        $this->db->from('tbl_respondent_users as rp');
        $this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
        if(!empty($data['country_id'])) {
            $this->db->where('rp.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('rp.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('rp.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('rp.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('rp.added_by', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            $this->db->where('rp.id', $data['respondent_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(rp.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(rp.added_datetime) <=', $data['end_date']);
        }
        $this->db->where_in('rp.pa_verified_status', [1,2]);
        $this->db->where('rp.status', 1);        
        $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();

        // $this->db->select('*');
        // $this->db->from('lkp_education_level');
        // $this->db->where('status', 1);
        // $formfield_options = $this->db->get()->result_array();
        if(!empty($data['country_id'])) {
            $this->db->where_in('country_id', $data['country_id']);
        }
        $formfield_options = $this->db->where('status', 1)->get('lkp_uai')->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['uai_id'];
            $form_filed_name = $option['uai'];
			//Available, Not Available(NULL)
				 
				$totalUpload = 0;
				
				foreach ($submited_data as $value) {
					if(isset($value['uai_id'])){
                        if($form_filed_id==$value['uai_id']){    
                            if($value['total_camel'] != NULL)
                            {
                                $temp =0;
                                $temp = $value['total_camel'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            if($value['total_cattle'] != NULL)
                            {
                                $temp =0;
                                $temp = $value['total_cattle'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            if($value['total_goat'] != NULL)
                            {
                                $temp =0;
                                $temp = $value['total_goat'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            if($value['total_sheep'] != NULL)
                            {
                                $temp =0;
                                $temp = $value['total_sheep'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                        } 
                    }					
				}
				array_push($uai_livestock_number_graph_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $uai_livestock_number_graph_array;
	}

    public function cluster_livestock_number_graph_array1($data){
		$cluster_livestock_number_graph_array = array();
       // Get Survey submited Data
       $this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by');
       $this->db->from('tbl_respondent_users as rp');
       $this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
       if(!empty($data['country_id'])) {
           $this->db->where('rp.country_id', $data['country_id']);
       }
       if(!empty($data['cluster_id'])) {
           $this->db->where('rp.cluster_id', $data['cluster_id']);
       }
       if(!empty($data['uai_id'])) {
           $this->db->where('rp.uai_id', $data['uai_id']);
       }
       if(!empty($data['sub_location_id'])) {
           $this->db->where('rp.sub_location_id', $data['sub_location_id']);
       }
       if(!empty($data['contributor_id'])) {
           $this->db->where('rp.added_by', $data['contributor_id']);
       }
       if(!empty($data['respondent_id'])) {
           $this->db->where('rp.id', $data['respondent_id']);
       }
       if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(rp.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(rp.added_datetime) <=', $data['end_date']);
        }
        $this->db->where_in('rp.pa_verified_status', [1,2]);
       $this->db->where('rp.status', 1);        
       $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();

        // $this->db->select('*');
        // $this->db->from('lkp_education_level');
        // $this->db->where('status', 1);
        // $formfield_options = $this->db->get()->result_array();
        if(!empty($data['country_id'])) {
            $this->db->where_in('country_id', $data['country_id']);
        }
        $formfield_options = $this->db->where('status', 1)->get('lkp_cluster')->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['cluster_id'];
            $form_filed_name = $option['name'];
			//Available, Not Available(NULL)				 
				$totalUpload = 0;				
				foreach ($submited_data as $value) {
					if(isset($value['cluster_id'])){
                        if($form_filed_id==$value['cluster_id']){                        
                            if($value['total_camel'] != NULL)
                            {
                                $temp = $value['total_camel'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            if($value['total_cattle'] != NULL)
                            {
                                $temp = $value['total_cattle'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            if($value['total_goat'] != NULL)
                            {
                                $temp = $value['total_goat'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            if($value['total_sheep'] != NULL)
                            {
                                $temp = $value['total_sheep'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                        } 
                    }					
				}
				array_push($cluster_livestock_number_graph_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $cluster_livestock_number_graph_array;
	}
    public function cluster_livestock_number_graph_array($data){
		$cluster_livestock_number_graph_array = array();
       // Get Survey submited Data
       $this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by');
       $this->db->from('tbl_respondent_users as rp');
       $this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
       if(!empty($data['country_id'])) {
           $this->db->where('rp.country_id', $data['country_id']);
       }
       if(!empty($data['cluster_id'])) {
           $this->db->where('rp.cluster_id', $data['cluster_id']);
       }
       if(!empty($data['uai_id'])) {
           $this->db->where('rp.uai_id', $data['uai_id']);
       }
       if(!empty($data['sub_location_id'])) {
           $this->db->where('rp.sub_location_id', $data['sub_location_id']);
       }
       if(!empty($data['contributor_id'])) {
           $this->db->where('rp.added_by', $data['contributor_id']);
       }
       if(!empty($data['respondent_id'])) {
           $this->db->where('rp.id', $data['respondent_id']);
       }
       if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(rp.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(rp.added_datetime) <=', $data['end_date']);
        }
        $this->db->where_in('rp.pa_verified_status', [1,2]);
       $this->db->where('rp.status', 1);        
       $submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		if(!empty($data['country_id'])) {
            $this->db->where_in('country_id', $data['country_id']);
        }
        $formfield_options = $this->db->where('status', 1)->get('lkp_cluster')->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['cluster_id'];
            $form_filed_name = $option['name'];
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			// switch ($form_filed_id) {
			// 	case '1':
            //         // $form_filed_name = "Fat (Grade 1)";
            //         $color='#165DFF';
			// 		break;
			// 	case '2':
            //         // $form_filed_name = "Moderate (Grade 2)";
            //         $color='#FFB6BA';
			// 		break;
			// 	case '3':
            //         // $form_filed_name = "Thin (Grade 3)";
            //         $color='#14C9C9';
			// 		break;
			// 	case '4':
            //         // $form_filed_name = "Emaciated (Grade 4)";
            //         $color='#F7BA1E';
			// 		break;
			// 	default:
			// 		# code...
			// 		break;
			// }
				
            foreach ($submited_data as $value) {
                if(isset($value['cluster_id'])){
                    if($form_filed_id==$value['cluster_id']){    
                        if($value['total_camel'] != NULL)
                        {
                            $temp = $value['total_camel'];
                            $camel_age = $camel_age + $temp ;
                        } 	
                        if($value['total_cattle'] != NULL)
                        {
                            $temp = $value['total_cattle'];
                            $cattel_age = $cattel_age + $temp ;
                        } 
                        if($value['total_goat'] != NULL)
                        {
                            $temp = $value['total_goat'];
                            $goat_age = $goat_age + $temp ;
                        } 
                        if($value['total_sheep'] != NULL)
                        {
                            $temp = $value['total_sheep'];
                            $sheep_age = $sheep_age + $temp ;
                        } 
                    }
                }                
            }
            array_push($data_array,$camel_age,$goat_age,$sheep_age,$cattel_age);
            array_push($cluster_livestock_number_graph_array, array(
                    'name' => $form_filed_name,
                    'data' => $data_array
                ));
		}
		return $cluster_livestock_number_graph_array;
	}

    public function household_Livestock_graph_array($data){
		$houshold_profile_option_item_array = array();

        // Get Survey submited Data
        $this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by');
        $this->db->from('tbl_respondent_users as rp');
        $this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
        if(!empty($data['country_id'])) {
            $this->db->where('rp.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('rp.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('rp.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('rp.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('rp.added_by', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            $this->db->where('rp.id', $data['respondent_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(rp.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(rp.added_datetime) <=', $data['end_date']);
        }
        $this->db->where_in('rp.pa_verified_status', [1,2]);
        $this->db->where('rp.status', 1);
        
        
        $submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 5; $i++) { 
			$form_filed_id = $i;
			//, , Variety, IPM 
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Camel";
                    $color='#5877A3';
					break;
				case '2':
                    $form_filed_name = "Cattle";
                    $color='#E49443';
					break;
				case '3':
                    $form_filed_name = "Goat";
                    $color='#6A9F58';
					break;
				case '4':
                    $form_filed_name = "Sheep";
                    $color='#F1A2A7';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				 
				
				$temp=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    switch ($form_filed_id) {
                        case '1':
                            if($value['total_camel'] != NULL)
                            {
                                $temp = $value['total_camel'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            break;
                        case '2':
                            if($value['total_cattle'] != NULL)
                            {
                                $temp = $value['total_cattle'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            break;
                        case '3':
                            // $this->db->where('rp.member_18_65 !=', NULL);
                            if($value['total_goat'] != NULL)
                            {
                                $temp = $value['total_goat'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            break;
                        case '4':
                            // $this->db->where('rp.member_above_65 !=', NULL);
                            if($value['total_sheep'] != NULL)
                            {
                                $temp = $value['total_sheep'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            break;
                        default:
                            # code...
                            break;
                    }
                        				
				}
				array_push($houshold_profile_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $houshold_profile_option_item_array;
	}

    /*task && payment grsphs start */
    public function task_wise_records_array($data){
		$task_wise_records_array = array();

        $this->db->select('id');
        if(!empty($data['task_id'])){
            $this->db->where('id', $data['task_id']);   
        }
        $forms = $this->db->where('status', 1)->order_by('type')->get('form')->result_array();
        
            for ($i=1; $i < 4; $i++) { 
                $form_filed_id = $i;
                //Submitted,Approved,Rejected
                switch ($form_filed_id) {
                    case '1':
                        $status_name = "Submitted";
                        $status_value = 1;
                        $color='#F7BA1E';
                        break;
                    case '2':
                        $status_name = "Approved";
                        $status_value = 2;
                        $color='#14C9C9';
                        break;
                    case '3':
                        $status_name = "Rejected";
                        $status_value = 3;
                        $color='#FFB6BA';
                        break;
                    default:
                        # code...
                        break;
                }
                $submited_data = 0;
                if(!empty($data['task_id']) && $data['task_id'] == 99){
                    $this->db->select('*');
                    if(!empty($data['country_id'])) {
                        $this->db->where('country_id', $data['country_id']);
                    }
                    if(!empty($data['cluster_id'])) {
                        $this->db->where('cluster_id', $data['cluster_id']);
                    }
                    if(!empty($data['uai_id'])) {
                        $this->db->where('uai_id', $data['uai_id']);
                    }
                    if(!empty($data['sub_location_id'])) {
                        $this->db->where('sub_location_id', $data['sub_location_id']);
                    }
                    $this->db->where('status', 1);
                    if(!empty($status_value)) {
                        $this->db->where('pa_verified_status', $status_value);
                    }
                    if(!empty($data['start_date']) && !empty($data['end_date'])){
                        $this->db->where('DATE(added_datetime) >=', $data['start_date']);
                        $this->db->where('DATE(added_datetime) <=', $data['end_date']);
                    }
                    $submited_data += $this->db->get('tbl_respondent_users')->num_rows();
                    
                }else{
                    $this->db->select('*');
                    if(!empty($data['country_id'])) {
                        $this->db->where('country_id', $data['country_id']);
                    }
                    if(!empty($data['cluster_id'])) {
                        $this->db->where('cluster_id', $data['cluster_id']);
                    }
                    if(!empty($data['uai_id'])) {
                        $this->db->where('uai_id', $data['uai_id']);
                    }
                    if(!empty($data['sub_location_id'])) {
                        $this->db->where('sub_location_id', $data['sub_location_id']);
                    }
                    $this->db->where('status', 1);
                    if(!empty($status_value)) {
                        $this->db->where('pa_verified_status', $status_value);
                    }
                    if(!empty($data['start_date']) && !empty($data['end_date'])){
                        $this->db->where('DATE(added_datetime) >=', $data['start_date']);
                        $this->db->where('DATE(added_datetime) <=', $data['end_date']);
                    }
                    $submited_data += $this->db->get('tbl_respondent_users')->num_rows();
                    foreach($forms as $key => $fid){
                        $survey_table = 'survey'.$fid['id'];
                        // Get Survey submited Data
    
                        $this->db->select('*');
                        if(!empty($data['country_id'])) {
                            $this->db->where('country_id', $data['country_id']);
                        }
                        if(!empty($data['cluster_id'])) {
                            $this->db->where('cluster_id', $data['cluster_id']);
                        }
                        if(!empty($data['uai_id'])) {
                            $this->db->where('uai_id', $data['uai_id']);
                        }
                        if(!empty($data['sub_location_id'])) {
                            $this->db->where('sub_location_id', $data['sub_location_id']);
                        }
                        $this->db->where('status', 1);
                        if(!empty($status_value)) {
                            $this->db->where('pa_verified_status', $status_value);
                        }
                        $submited_data += $this->db->get($survey_table)->num_rows();
                    }
                }
                
                array_push($task_wise_records_array, array(
                    'name' => $status_name,
                    'color' => $color,
                    'y' => $submited_data
                ));
            }

         
		
		return $task_wise_records_array;
	}
    public function task_wise_rejection_reasons_array($data){
		$task_wise_rejection_reasons_array = array();

        $this->db->select('id');
        if(!empty($data['task_id'])){
            $this->db->where('id', $data['task_id']);   
        }
        $forms = $this->db->where('status', 1)->order_by('type')->get('form')->result_array();
        
            for ($i=1; $i < 5; $i++) { 
                $form_filed_id = $i;
                //Submitted,Approved,Rejected
                switch ($form_filed_id) {
                    case '1':
                        $status_name = "Poor Picture Quality";
                        $status_value = 1;
                        $color='#F7BA1E';
                        break;
                    case '2':
                        $status_name = "Wrong location";
                        $status_value = 2;
                        $color='#14C9C9';
                        break;
                    case '3':
                        $status_name = "Value out of range";
                        $status_value = 3;
                        $color='#FFB6BA';
                        break;
                    case '4':
                        $status_name = "Others";
                        $status_value = 4;
                        $color='#6A9F58';
                        break;
                    default:
                        # code...
                        break;
                }
                $submited_data = 0;
                if(!empty($data['task_id']) && $data['task_id'] == 99){
                    $this->db->select('*');
                    if(!empty($data['country_id'])) {
                        $this->db->where('country_id', $data['country_id']);
                    }
                    if(!empty($data['cluster_id'])) {
                        $this->db->where('cluster_id', $data['cluster_id']);
                    }
                    if(!empty($data['uai_id'])) {
                        $this->db->where('uai_id', $data['uai_id']);
                    }
                    if(!empty($data['sub_location_id'])) {
                        $this->db->where('sub_location_id', $data['sub_location_id']);
                    }
                    $this->db->where('status', 1);
                    $this->db->where('pa_verified_status', 3);
                    if(!empty($status_name)) {
                        $this->db->where('rejected_remarks', $status_name);
                    }
                    if(!empty($data['start_date']) && !empty($data['end_date'])){
                        $this->db->where('DATE(added_datetime) >=', $data['start_date']);
                        $this->db->where('DATE(added_datetime) <=', $data['end_date']);
                    }
                    $submited_data += $this->db->get('tbl_respondent_users')->num_rows();
                    
                }else{
                    $this->db->select('*');
                    if(!empty($data['country_id'])) {
                        $this->db->where('country_id', $data['country_id']);
                    }
                    if(!empty($data['cluster_id'])) {
                        $this->db->where('cluster_id', $data['cluster_id']);
                    }
                    if(!empty($data['uai_id'])) {
                        $this->db->where('uai_id', $data['uai_id']);
                    }
                    if(!empty($data['sub_location_id'])) {
                        $this->db->where('sub_location_id', $data['sub_location_id']);
                    }
                    $this->db->where('status', 1);
                    $this->db->where('pa_verified_status', 3);
                    if(!empty($status_name)) {
                        $this->db->where('rejected_remarks', $status_name);
                    }
                    if(!empty($data['start_date']) && !empty($data['end_date'])){
                        $this->db->where('DATE(added_datetime) >=', $data['start_date']);
                        $this->db->where('DATE(added_datetime) <=', $data['end_date']);
                    }
                    $submited_data += $this->db->get('tbl_respondent_users')->num_rows();
                    foreach($forms as $key => $fid){
                        $survey_table = 'survey'.$fid['id'];
                        // Get Survey submited Data
    
                        $this->db->select('*');
                        if(!empty($data['country_id'])) {
                            $this->db->where('country_id', $data['country_id']);
                        }
                        if(!empty($data['cluster_id'])) {
                            $this->db->where('cluster_id', $data['cluster_id']);
                        }
                        if(!empty($data['uai_id'])) {
                            $this->db->where('uai_id', $data['uai_id']);
                        }
                        if(!empty($data['sub_location_id'])) {
                            $this->db->where('sub_location_id', $data['sub_location_id']);
                        }
                        $this->db->where('status', 1);
                        $this->db->where('pa_verified_status', 3);
                        if(!empty($status_name)) {
                            $this->db->where('rejected_remarks', $status_name);
                        }
                        if(!empty($data['start_date']) && !empty($data['end_date'])){
                            $this->db->where('DATE(datetime) >=', $data['start_date']);
                            $this->db->where('DATE(datetime) <=', $data['end_date']);
                        }
                        $submited_data += $this->db->get($survey_table)->num_rows();
                    }
                }
                
                array_push($task_wise_rejection_reasons_array, array(
                    'name' => $status_name,
                    'color' => $color,
                    'y' => $submited_data
                ));
            }

         
		
		return $task_wise_rejection_reasons_array;
	}

    public function contributor_wise_payment_details_array($data){
		$contributor_wise_payment_details_array = array();

        // geting form(tasks) Ids
        $this->db->select('id');
        if(!empty($data['task_id'])){
            $this->db->where('id', $data['task_id']);   
        }
        $forms = $this->db->where('status', 1)->order_by('type')->get('form')->result_array();
        
        // geting contributors only approved
        $this->db->select('tu.user_id, concat(tu.first_name, " ", tu.last_name) as username');
        $this->db->from('tbl_users as tu');
        $this->db->join('tbl_user_profile as tup', 'tup.user_id = tu.user_id');
        $this->db->join('tbl_user_unit_location AS tul', 'tul.user_id = tu.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('tul.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('tul.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('tul.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('tul.sub_loc_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('tu.user_id', $data['contributor_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(tu.added_datetime) >=', $data['start_date']);
            $this->db->where('DATE(tu.added_datetime) <=', $data['end_date']);
        }
        $this->db->where('tup.pa_verified_status', 2);
        $contributors = $this->db->where('tu.status', 1)->get()->result_array();

        
        foreach($contributors as $ckey => $cvalue){
            $contributor_name = $cvalue['username'];
            $total_pay = 0;
            foreach($forms as $key => $fid){
                $survey_table = 'survey'.$fid['id'];
                
                // Get Survey approved Data
                $this->db->select('*');
                if(!empty($data['country_id'])) {
                    $this->db->where('country_id', $data['country_id']);
                }
                if(!empty($data['cluster_id'])) {
                    $this->db->where('cluster_id', $data['cluster_id']);
                }
                if(!empty($data['uai_id'])) {
                    $this->db->where('uai_id', $data['uai_id']);
                }
                if(!empty($data['sub_location_id'])) {
                    $this->db->where('sub_location_id', $data['sub_location_id']);
                }
                $this->db->where('status', 1);
                $this->db->where('pa_verified_status', 2);
                if(!empty($data['start_date']) && !empty($data['end_date'])){
                    $this->db->where('DATE(datetime) >=', $data['start_date']);
                    $this->db->where('DATE(datetime) <=', $data['end_date']);
                }
                $this->db->where('user_id', $cvalue['user_id']);
                $submited_data = $this->db->get($survey_table)->num_rows();
                
                //get payment for survey wise
                $this->db->select('price_per_survey');
                $this->db->where('survey_id', $fid['id']);
                $payment = $this->db->get('lkp_payment')->row_array();

                if(!empty($payment['price_per_survey']) && $payment['price_per_survey'] != null){
                    $total_pay += $submited_data* $payment['price_per_survey'];
                }
                
            }  
            $hh_payment_amount =0;
            if(empty($data['task_id']) ||  $data['task_id']==1){
                // Get House hold survey approved Data
                $this->db->select('rp.*');
                $this->db->from('tbl_respondent_users as rp');
                $this->db->where('rp.added_by', $cvalue['user_id']);
                if(!empty($data['country_id'])) {
                    $this->db->where('rp.country_id', $data['country_id']);
                }
                if(!empty($data['uai_id'])) {
                    $this->db->where('uai_id', $data['uai_id']);
                }
                if(!empty($data['cluster_id'])) {
                    $this->db->where('cluster_id', $data['cluster_id']);
                }
                
                if(!empty($data['sub_location_id'])) {
                    $this->db->where('rp.sub_location_id', $data['sub_location_id']);
                }
                if(!empty($data['contributor_id'])) {
                    $this->db->where('rp.added_by', $data['contributor_id']);
                }
                if(!empty($data['respondent_id'])) {
                    $this->db->where('rp.id', $data['respondent_id']);
                }
                if(!empty($data['start_date']) && !empty($data['end_date'])){
                    $this->db->where('DATE(rp.pa_verified_date) >=', $data['start_date']);
                    $this->db->where('DATE(rp.pa_verified_date) <=', $data['end_date']);
                }
                $this->db->where('rp.status', 1);
                $this->db->where('rp.pa_verified_status', 2);
                
                $hh_approved_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows(); 
                $payment_list1 =$this->db->select('price_per_survey')->where('survey_id', 1)->where('status', 1)->get('lkp_payment')->row_array();
                $hh_payment_amount = $payment_list1['price_per_survey'] * $hh_approved_data;  
            }
            $total_pay = $total_pay + $hh_payment_amount;   
            array_push($contributor_wise_payment_details_array, array(
                'name' => $contributor_name,
                'y' => $total_pay
            ));
        }
		return $contributor_wise_payment_details_array;
	}

    public function task_wise_payment_details_array($data){
		$task_wise_payment_details_array = array();

        // geting form(tasks) Ids
        $this->db->select('id,title');
        if(!empty($data['task_id'])){
            $this->db->where('id', $data['task_id']);   
        }
        $forms = $this->db->where('status', 1)->order_by('type')->get('form')->result_array();
        
        
        foreach($forms as $key => $fid){
            $task_name = $fid['title'];
            $total_pay = 0;
            $survey_table = 'survey'.$fid['id'];
            
            // Get Survey submited Data
            $this->db->select('*');
            if(!empty($data['country_id'])) {
                $this->db->where('country_id', $data['country_id']);
            }
            if(!empty($data['cluster_id'])) {
                $this->db->where('cluster_id', $data['cluster_id']);
            }
            if(!empty($data['uai_id'])) {
                $this->db->where('uai_id', $data['uai_id']);
            }
            if(!empty($data['sub_location_id'])) {
                $this->db->where('sub_location_id', $data['sub_location_id']);
            }
            $this->db->where('status', 1);
            $this->db->where('pa_verified_status', 2);
            if(!empty($data['start_date']) && !empty($data['end_date'])){
                $this->db->where('DATE(datetime) >=', $data['start_date']);
                $this->db->where('DATE(datetime) <=', $data['end_date']);
            }
            $submited_data = $this->db->get($survey_table)->num_rows();
            
            //get payment for survey wise
            $this->db->select('price_per_survey');
            $this->db->where('survey_id', $fid['id']);
            $payment = $this->db->get('lkp_payment')->row_array();

            if(!empty($payment['price_per_survey']) && $payment['price_per_survey'] != null){
                $total_pay += $submited_data* $payment['price_per_survey'];
            }
            array_push($task_wise_payment_details_array, array(
                'name' => $task_name,
                'y' => $total_pay
            ));
        } 
        $hh_payment_amount =0;
        if(empty($data['task_id']) ||  $data['task_id']==1){
            // Get House hold survey approved Data
            $this->db->select('rp.*');
            $this->db->from('tbl_respondent_users as rp');
            // $this->db->where('rp.added_by', $cvalue['user_id']);
            if(!empty($data['country_id'])) {
                $this->db->where('rp.country_id', $data['country_id']);
            }
            if(!empty($data['uai_id'])) {
                $this->db->where('uai_id', $data['uai_id']);
            }
            if(!empty($data['cluster_id'])) {
                $this->db->where('cluster_id', $data['cluster_id']);
            }
            
            if(!empty($data['sub_location_id'])) {
                $this->db->where('rp.sub_location_id', $data['sub_location_id']);
            }
            if(!empty($data['contributor_id'])) {
                $this->db->where('rp.added_by', $data['contributor_id']);
            }
            if(!empty($data['respondent_id'])) {
                $this->db->where('rp.id', $data['respondent_id']);
            }
            if(!empty($data['start_date']) && !empty($data['end_date'])){
                $this->db->where('DATE(rp.pa_verified_date) >=', $data['start_date']);
                $this->db->where('DATE(rp.pa_verified_date) <=', $data['end_date']);
            }
            $this->db->where('rp.status', 1);
            $this->db->where('rp.pa_verified_status', 2);
            
            $hh_approved_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows(); 
            $payment_list1 =$this->db->select('price_per_survey')->where('survey_id', 1)->where('status', 1)->get('lkp_payment')->row_array();
            $hh_payment_amount = $payment_list1['price_per_survey'] * $hh_approved_data;  

            array_push($task_wise_payment_details_array, array(
                'name' => 'Household profile',
                'y' => $hh_payment_amount
            ));
        }
		return $task_wise_payment_details_array;
	}

    public function uai_wise_payment_details_array($data){
		$uai_wise_payment_details_array = array();

        // geting form(tasks) Ids
        $this->db->select('id');
        if(!empty($data['task_id'])){
            $this->db->where('id', $data['task_id']);   
        }
        $forms = $this->db->where('status', 1)->order_by('type')->get('form')->result_array();
        
        // geting uais
        $this->db->select('uai_id, uai');
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('uai_id', $data['uai_id']);
        }
        $this->db->where('status', 1);
        $uais = $this->db->where('status', 1)->get('lkp_uai')->result_array();

        
        foreach($uais as $ckey => $cvalue){
            $uai_name = $cvalue['uai'];
            
            $total_pay = 0;
            if((!empty($data['uai_id']) && empty($data['cluster_id'])) || (empty($data['uai_id']) && empty($data['cluster_id']))) {
                foreach($forms as $key => $fid){
                    $survey_table = 'survey'.$fid['id'];
                    $total_pay_temp = 0;
                    // Get Survey aproved Data
                    $this->db->select('*');
                    $this->db->where('uai_id', $cvalue['uai_id']);
                    if(!empty($data['sub_location_id'])) {
                        $this->db->where('sub_location_id', $data['sub_location_id']);
                    }
                    $this->db->where('status', 1);
                    $this->db->where('pa_verified_status', 2);
                    if(!empty($data['country_id'])) {
                        $this->db->where('country_id', $data['country_id']);
                    }
                    if(!empty($data['cluster_id'])) {
                        $this->db->where('cluster_id', $data['cluster_id']);
                    }
                    
                    if(!empty($data['sub_location_id'])) {
                        $this->db->where('sub_location_id', $data['sub_location_id']);
                    }
                    if(!empty($data['start_date']) && !empty($data['end_date'])){
                        $this->db->where('DATE(datetime) >=', $data['start_date']);
                        $this->db->where('DATE(datetime) <=', $data['end_date']);
                    }
                    $submited_data = $this->db->get($survey_table)->num_rows();
                    
                    //get payment for survey wise
                    $this->db->select('price_per_survey');
                    $this->db->where('survey_id', $fid['id']);
                    $this->db->where('status', 1);
                    $payment = $this->db->get('lkp_payment')->row_array();

                    if(!empty($payment['price_per_survey']) && $payment['price_per_survey'] != null){
                        // $total_pay_temp=12;
                        $total_pay_temp = $submited_data* $payment['price_per_survey'];
                        $total_pay = $total_pay + $total_pay_temp ;
                        // $total_pay =12;
                    }
                }   
                $hh_payment_amount =0;
                if(empty($data['task_id']) ||  $data['task_id']==1){
                   // Get House hold survey approved Data
                    $this->db->select('rp.*');
                    $this->db->from('tbl_respondent_users as rp');
                    $this->db->where('rp.uai_id', $cvalue['uai_id']);
                    if(!empty($data['country_id'])) {
                        $this->db->where('rp.country_id', $data['country_id']);
                    }
                    if(!empty($data['cluster_id'])) {
                        $this->db->where('rp.cluster_id', $data['cluster_id']);
                    }
                    
                    if(!empty($data['sub_location_id'])) {
                        $this->db->where('rp.sub_location_id', $data['sub_location_id']);
                    }
                    if(!empty($data['contributor_id'])) {
                        $this->db->where('rp.added_by', $data['contributor_id']);
                    }
                    if(!empty($data['respondent_id'])) {
                        $this->db->where('rp.id', $data['respondent_id']);
                    }
                    if(!empty($data['start_date']) && !empty($data['end_date'])){
                        $this->db->where('DATE(rp.pa_verified_date) >=', $data['start_date']);
                        $this->db->where('DATE(rp.pa_verified_date) <=', $data['end_date']);
                    }
                    $this->db->where('rp.status', 1);
                    $this->db->where('rp.pa_verified_status', 2);
                    
                    $hh_approved_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows(); 
                    $payment_list1 =$this->db->select('price_per_survey')->where('survey_id', 1)->where('status', 1)->get('lkp_payment')->row_array();
                    $hh_payment_amount = $payment_list1['price_per_survey'] * $hh_approved_data;  
                }
                $total_pay = $total_pay + $hh_payment_amount;
            } 
            array_push($uai_wise_payment_details_array, array(
                'name' => $uai_name,
                'y' => $total_pay 
            ));
        }
		return $uai_wise_payment_details_array;
	}
    public function cluster_wise_payment_details_array($data){
		$cluster_wise_payment_details_array = array();

        // geting form(tasks) Ids
        $this->db->select('id');
        if(!empty($data['task_id'])){
            $this->db->where('id', $data['task_id']);   
        }
        $forms = $this->db->where('status', 1)->order_by('type')->get('form')->result_array();
        
        // geting uais
        $this->db->select('cluster_id, name');
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('cluster_id', $data['cluster_id']);
        }
        $this->db->where('status', 1);
        $clusters = $this->db->where('status', 1)->get('lkp_cluster')->result_array();

        
        foreach($clusters as $ckey => $cvalue){
            $cluster_name = $cvalue['name'];
            $total_pay = 0;
            if((empty($data['uai_id']) && !empty($data['cluster_id'])) || (empty($data['uai_id']) && empty($data['cluster_id']))) {
                foreach($forms as $key => $fid){
                    $survey_table = 'survey'.$fid['id'];
                    
                    // Get Survey aproved Data
                    $this->db->select('*');
                    $this->db->where('cluster_id', $cvalue['cluster_id']);
                    $this->db->where('status', 1);
                    $this->db->where('pa_verified_status', 2);
                    if(!empty($data['country_id'])) {
                        $this->db->where('country_id', $data['country_id']);
                    }
                    
                    if(!empty($data['uai_id'])) {
                        $this->db->where('uai_id', $data['uai_id']);
                    }
                    if(!empty($data['sub_location_id'])) {
                        $this->db->where('sub_location_id', $data['sub_location_id']);
                    }
                    if(!empty($data['start_date']) && !empty($data['end_date'])){
                        $this->db->where('DATE(datetime) >=', $data['start_date']);
                        $this->db->where('DATE(datetime) <=', $data['end_date']);
                    }
                    $submited_data = $this->db->get($survey_table)->num_rows();
                    // print_r($this->db->last_query());
                    //get payment for survey wise
                    $this->db->select('price_per_survey');
                    $this->db->where('survey_id', $fid['id']);
                    $payment = $this->db->get('lkp_payment')->row_array();

                    if(!empty($payment['price_per_survey']) && $payment['price_per_survey'] != null){
                        $total_pay += $submited_data* $payment['price_per_survey'];
                    }
                }  
                $hh_payment_amount =0;
                if(empty($data['task_id']) ||  $data['task_id']==1){
                   // Get House hold survey approved Data
                    $this->db->select('rp.*');
                    $this->db->from('tbl_respondent_users as rp');
                    $this->db->where('rp.cluster_id', $cvalue['cluster_id']);
                    if(!empty($data['country_id'])) {
                        $this->db->where('rp.country_id', $data['country_id']);
                    }
                    if(!empty($data['uai_id'])) {
                        $this->db->where('uai_id', $data['uai_id']);
                    }
                    
                    if(!empty($data['sub_location_id'])) {
                        $this->db->where('rp.sub_location_id', $data['sub_location_id']);
                    }
                    if(!empty($data['contributor_id'])) {
                        $this->db->where('rp.added_by', $data['contributor_id']);
                    }
                    if(!empty($data['respondent_id'])) {
                        $this->db->where('rp.id', $data['respondent_id']);
                    }
                    if(!empty($data['start_date']) && !empty($data['end_date'])){
                        $this->db->where('DATE(rp.pa_verified_date) >=', $data['start_date']);
                        $this->db->where('DATE(rp.pa_verified_date) <=', $data['end_date']);
                    }
                    $this->db->where('rp.status', 1);
                    $this->db->where('rp.pa_verified_status', 2);
                   
                    $hh_approved_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows(); 
                    $payment_list1 =$this->db->select('price_per_survey')->where('survey_id', 1)->where('status', 1)->get('lkp_payment')->row_array();
                    $hh_payment_amount = $payment_list1['price_per_survey'] * $hh_approved_data;  
                }
                $total_pay = $total_pay + $hh_payment_amount; 
            } 
            array_push($cluster_wise_payment_details_array, array(
                'name' => $cluster_name,
                'y' => $total_pay
            ));
        }
		return $cluster_wise_payment_details_array;
	}
    /*task && payment grsphs end */

    public function number_of_animals_graph_array($data){
		$houshold_profile_option_item_array = array();
		for ($i=1; $i < 5; $i++) { 
			$form_filed_id = $i;
			
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Camel";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Cattle";
                    $color='#FFB6BA';
					break;
				case '3':
                    $form_filed_name = "Goat";
                    $color='#14C9C9';
					break;
				case '4':
                    $form_filed_name = "Sheep";
                    $color='#F7BA1E';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				 // Get Survey submited Data
                $this->db->select('s3.*');
                $this->db->from('survey3 as s3');
                // $this->db->join('tbl_users AS tu', 'tu.user_id = s3.user_id');
                if(!empty($data['country_id'])) {
                    $this->db->where('s3.country_id', $data['country_id']);
                }
                if(!empty($data['cluster_id'])) {
                    $this->db->where('s3.cluster_id', $data['cluster_id']);
                }
                if(!empty($data['uai_id'])) {
                    $this->db->where('s3.uai_id', $data['uai_id']);
                }
                if(!empty($data['sub_location_id'])) {
                    $this->db->where('s3.sub_location_id', $data['sub_location_id']);
                }
                if(!empty($data['start_date']) && !empty($data['end_date'])){
                    $this->db->where('DATE(s3.datetime) >=', $data['start_date']);
                    $this->db->where('DATE(s3.datetime) <=', $data['end_date']);
                }
                $this->db->where_in('s3.pa_verified_status', [1,2]);
                $this->db->where('s3.status', 1);             
                
                $submited_data = $this->db->order_by('s3.id', 'DESC')->get()->result_array();
                // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
                // print_r($this->db->last_query());
                // exit();
				
				$temp=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    switch ($form_filed_id) {
                        case '1':
                            if($value['field_511'] != NULL)
                            {
                                $temp = $value['field_511'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            break;
                        case '2':
                            if($value['field_833'] != NULL)
                            {
                                $temp = $value['field_833'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            break;
                        case '3':
                            // $this->db->where('rp.member_18_65 !=', NULL);
                            if($value['field_838'] != NULL)
                            {
                                $temp = $value['field_838'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            break;
                        case '4':
                            // $this->db->where('rp.member_above_65 !=', NULL);
                            if($value['field_843'] != NULL)
                            {
                                $temp = $value['field_843'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            break;
                        default:
                            # code...
                            break;
                    }
                        				
				}
				array_push($houshold_profile_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $houshold_profile_option_item_array;
	}

    public function milked_sold_data_graph_array($data){
		$milked_sold_data_bargraph_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s3.*');
        $this->db->from('survey3 as s3');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s3.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s3.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s3.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s3.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s3.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s3.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s3.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s3.pa_verified_status', [1,2]);
        $this->db->where('s3.status', 1);
        $submited_data = $this->db->order_by('s3.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 3; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Production volumes";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "No.of litres of milk do you sell per day";
                    $color='#14C9C9';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {
                if($value['field_510'] != NULL){
                    $field_data = explode("&#44;", $value['field_510']);
                    foreach ($field_data as $fvalue) {
                        switch ($fvalue) {
                            case '1':
                                if($form_filed_id==1){
                                    $loop_id1=$value['field_513'];
                                }else{
                                    $loop_id1=$value['field_514'];
                                }                                
                                if($loop_id1 != NULL)
                                {
                                    $temp = $loop_id1;
                                    $camel_age = $camel_age + $temp ;
                                } 	
                                break;
                            case '3':
                                if($form_filed_id==1){
                                    $loop_id2=$value['field_840'];
                                }else{
                                    $loop_id2=$value['field_841'];
                                }
                                if($loop_id2 != NULL)
                                {
                                    $temp = $loop_id2;
                                    $goat_age = $goat_age + $temp ;
                                } 	
                                break;
                            case '4':
                                if($form_filed_id==1){
                                    $loop_id3=$value['field_845'];
                                }else{
                                    $loop_id3=$value['field_846'];
                                }
                                if($loop_id3 != NULL)
                                {
                                    $temp = $loop_id3;
                                    $sheep_age = $sheep_age + $temp ;
                                } 
                                break;
                            case '2':
                                if($form_filed_id==1){
                                    $loop_id4=$value['field_835'];
                                }else{
                                    $loop_id4=$value['field_836'];
                                }
                                if($loop_id4 != NULL)
                                {
                                    $temp = $loop_id4;
                                    $cattel_age = $cattel_age + $temp ;
                                } 
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                }                                 	
                // if($value['field_545'] == $form_filed_name){
                //     $cattel_age++ ;
                // }                 
            }
            array_push($data_array,round($camel_age,2),round($goat_age,2),round($sheep_age,2),round($cattel_age,2));
            // array_push($data_array,$cattel_age,$camel_age,$goat_age,$sheep_age);
            array_push($milked_sold_data_bargraph_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $milked_sold_data_bargraph_option_item_array;
	}


    public function sum_liters_milk_per_day_graph_array($data){
		$sum_liters_milk_per_day_option_item_array = array();
         // Get Survey submited Data
         $this->db->select('s3.*');
         $this->db->from('survey3 as s3');
         // $this->db->join('tbl_users AS tu', 'tu.user_id = s3.user_id');
         if(!empty($data['country_id'])) {
             $this->db->where('s3.country_id', $data['country_id']);
         }
         if(!empty($data['cluster_id'])) {
             $this->db->where('s3.cluster_id', $data['cluster_id']);
         }
         if(!empty($data['uai_id'])) {
             $this->db->where('s3.uai_id', $data['uai_id']);
         }
         if(!empty($data['sub_location_id'])) {
             $this->db->where('s3.sub_location_id', $data['sub_location_id']);
         }
         if(!empty($data['start_date']) && !empty($data['end_date'])){
             $this->db->where('DATE(s3.datetime) >=', $data['start_date']);
             $this->db->where('DATE(s3.datetime) <=', $data['end_date']);
         }         
         $this->db->where_in('s3.pa_verified_status', [1,2]);
         $this->db->where('s3.status', 1); 
         $submited_data = $this->db->order_by('s3.id', 'DESC')->get()->result_array();
         // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
         // print_r($this->db->last_query());
         // exit();
		// for ($i=1; $i < 5; $i++) { 
		// 	$form_filed_id = $i;
        $this->db->select('*');
        $this->db->from('lkp_animal_type_lactating');
        $this->db->where('status', 1);
        $formfield_data = $this->db->get()->result_array();
        foreach ($formfield_data as $fvalue) { 
            $form_filed_id = $fvalue['animal_type_lactating_id'];
            $form_filed_name = $fvalue['name'];
			switch ($form_filed_id) {
				case '1':
                    // $form_filed_name = "Camel";
                    $color='#165DFF';
					break;
				case '2':
                    // $form_filed_name = "Cattle";
                    $color='#FFB6BA';
					break;
				case '3':
                    // $form_filed_name = "Goat";
                    $color='#14C9C9';
					break;
				case '4':
                    // $form_filed_name = "Sheep";
                    $color='#F7BA1E';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				$temp=0;
				$record_count=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    $record_count++;
                    switch ($form_filed_id) {
                        case '1':
                            if($value['field_514'] != NULL)
                            {
                                $temp = $value['field_514'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            break;
                        case '2':
                            if($value['field_836'] != NULL)
                            {
                                $temp = $value['field_836'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            break;
                        case '3':
                            if($value['field_841'] != NULL)
                            {
                                $temp = $value['field_841'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            break;
                        case '4':
                            if($value['field_846'] != NULL)
                            {
                                $temp = $value['field_846'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            break;
                        default:
                            # code...
                            break;
                    }
                        				
				}
                // if($record_count!=0){
                //     $totalUpload = round($totalUpload/$record_count,2);
                // }else{
                //     $totalUpload=0;
                // }
				// array_push($sum_liters_milk_per_day_option_item_array, array(
				// 		'name' => $form_filed_name,
                //         'color' => $color,
				// 		'y' => $totalUpload
				// 	));
                array_push($sum_liters_milk_per_day_option_item_array,$totalUpload);
		}
		return $sum_liters_milk_per_day_option_item_array;
	}
    public function sum_liters_selling_price_graph_array($data){
		$sum_liters_selling_price_option_item_array = array();
         // Get Survey submited Data
         $this->db->select('s3.*');
         $this->db->from('survey3 as s3');
         // $this->db->join('tbl_users AS tu', 'tu.user_id = s3.user_id');
         if(!empty($data['country_id'])) {
             $this->db->where('s3.country_id', $data['country_id']);
         }
         if(!empty($data['cluster_id'])) {
             $this->db->where('s3.cluster_id', $data['cluster_id']);
         }
         if(!empty($data['uai_id'])) {
             $this->db->where('s3.uai_id', $data['uai_id']);
         }
         if(!empty($data['sub_location_id'])) {
             $this->db->where('s3.sub_location_id', $data['sub_location_id']);
         }
         if(!empty($data['start_date']) && !empty($data['end_date'])){
             $this->db->where('DATE(s3.datetime) >=', $data['start_date']);
             $this->db->where('DATE(s3.datetime) <=', $data['end_date']);
         }         
         $this->db->where_in('s3.pa_verified_status', [1,2]);
         $this->db->where('s3.status', 1); 
         $submited_data = $this->db->order_by('s3.id', 'DESC')->get()->result_array();
         // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
         // print_r($this->db->last_query());
         // exit();
		// for ($i=1; $i < 5; $i++) { 
		// 	$form_filed_id = $i;
        $this->db->select('*');
        $this->db->from('lkp_animal_type_lactating');
        $this->db->where('status', 1);
        $this->db->where('animal_type_lactating_id !=', 5);
        $formfield_data = $this->db->get()->result_array();
        foreach ($formfield_data as $fvalue) { 
            $form_filed_id = $fvalue['animal_type_lactating_id'];
            $form_filed_name = $fvalue['name'];
			switch ($form_filed_id) {
				case '1':
                    // $form_filed_name = "Camel";
                    $color='#165DFF';
					break;
				case '2':
                    // $form_filed_name = "Cattle";
                    $color='#FFB6BA';
					break;
				case '3':
                    // $form_filed_name = "Goat";
                    $color='#14C9C9';
					break;
				case '4':
                    // $form_filed_name = "Sheep";
                    $color='#F7BA1E';
					break;
				case '5':
                    // $form_filed_name = "Sheep";
                    $color='#F7BA1E';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				$temp=0;
				$record_count=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    $record_count++;
                    $field_data = explode("&#44;", $value['field_510']);
                    foreach ($field_data as $fvalue) {
                        if($form_filed_id == $fvalue){
                            
                            switch ($form_filed_id) {
                                case '1':
                                    if($value['field_515'] != NULL)
                                    {
                                        $temp = $value['field_515'];
                                        $totalUpload = $totalUpload + $temp ;
                                    } 	
                                    break;
                                case '2':
                                    if($value['field_837'] != NULL)
                                    {
                                        $temp = $value['field_837'];
                                        $totalUpload = $totalUpload + $temp ;
                                    } 	
                                    break;
                                case '3':
                                    if($value['field_842'] != NULL)
                                    {
                                        $temp = $value['field_842'];
                                        $totalUpload = $totalUpload + $temp ;
                                    } 
                                    break;
                                case '4':
                                    if($value['field_847'] != NULL)
                                    {
                                        $temp = $value['field_847'];
                                        $totalUpload = $totalUpload + $temp ;
                                    } 
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                        }
                    }
                        				
				}
                if($record_count!=0){
                    $totalUpload = $totalUpload;
                    $totalUpload = round($totalUpload/$record_count,2);
                }else{
                    $totalUpload=0;
                }
				// array_push($sum_liters_selling_price_option_item_array, array(
				// 		'name' => $form_filed_name,
                //         'color' => $color,
				// 		'y' => $totalUpload
				// 	));
                array_push($sum_liters_selling_price_option_item_array,$totalUpload);
		}
		return $sum_liters_selling_price_option_item_array;
	}

    public function average_Selling_Price_graph_array($data){
		$average_Selling_Price_option_item_array = array();
         // Get Survey submited Data
         $this->db->select('s3.*');
         $this->db->from('survey3 as s3');
         // $this->db->join('tbl_users AS tu', 'tu.user_id = s3.user_id');
         if(!empty($data['country_id'])) {
             $this->db->where('s3.country_id', $data['country_id']);
         }
         if(!empty($data['cluster_id'])) {
             $this->db->where('s3.cluster_id', $data['cluster_id']);
         }
         if(!empty($data['uai_id'])) {
             $this->db->where('s3.uai_id', $data['uai_id']);
         }
         if(!empty($data['sub_location_id'])) {
             $this->db->where('s3.sub_location_id', $data['sub_location_id']);
         }
         if(!empty($data['start_date']) && !empty($data['end_date'])){
             $this->db->where('DATE(s3.datetime) >=', $data['start_date']);
             $this->db->where('DATE(s3.datetime) <=', $data['end_date']);
         }
         $this->db->where_in('s3.pa_verified_status', [1,2]);
         $this->db->where('s3.status', 1);             
         
         $submited_data = $this->db->order_by('s3.id', 'DESC')->get()->result_array();
         // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
         // print_r($this->db->last_query());
         // exit();
		for ($i=1; $i < 5; $i++) { 
			$form_filed_id = $i;
			
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Camel";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Cattle";
                    $color='#FFB6BA';
					break;
				case '3':
                    $form_filed_name = "Goat";
                    $color='#14C9C9';
					break;
				case '4':
                    $form_filed_name = "Sheep";
                    $color='#F7BA1E';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				
				
				$temp=0;
				$record_count=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    $record_count++;
                    switch ($form_filed_id) {
                        case '1':
                            if($value['field_515'] != NULL)
                            {
                                $temp = $value['field_515'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            break;
                        case '2':
                            if($value['field_837'] != NULL)
                            {
                                $temp = $value['field_837'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            break;
                        case '3':
                            // $this->db->where('rp.member_18_65 !=', NULL);
                            if($value['field_842'] != NULL)
                            {
                                $temp = $value['field_842'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            break;
                        case '4':
                            // $this->db->where('rp.member_above_65 !=', NULL);
                            if($value['field_847'] != NULL)
                            {
                                $temp = $value['field_847'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            break;
                        default:
                            # code...
                            break;
                    }
                        				
				}
                if($record_count!=0){
                    $totalUpload = round($totalUpload/$record_count,2);
                }else{
                    $totalUpload=0;
                }
				array_push($average_Selling_Price_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $average_Selling_Price_option_item_array;
	}
    public function average_production_volume_graph_array($data){
		$production_volume_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s3.*');
        $this->db->from('survey3 as s3');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s3.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s3.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s3.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s3.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s3.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s3.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s3.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s3.pa_verified_status', [1,2]);
        $this->db->where('s3.status', 1);
        $submited_data = $this->db->order_by('s3.id', 'DESC')->get()->result_array();
                    
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 5; $i++) { 
			$form_filed_id = $i;
			
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Camel";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Cattle";
                    $color='#FFB6BA';
					break;
				case '3':
                    $form_filed_name = "Goat";
                    $color='#14C9C9';
					break;
				case '4':
                    $form_filed_name = "Sheep";
                    $color='#F7BA1E';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				
				$temp=0;
				$record_count=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    $record_count++;
                    switch ($form_filed_id) {
                        case '1':
                            if($value['field_513'] != NULL)
                            {
                                $temp = $value['field_513'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            break;
                        case '2':
                            if($value['field_835'] != NULL)
                            {
                                $temp = $value['field_835'];
                                $totalUpload = $totalUpload + $temp ;
                            } 	
                            break;
                        case '3':
                            // $this->db->where('rp.member_18_65 !=', NULL);
                            if($value['field_840'] != NULL)
                            {
                                $temp = $value['field_840'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            break;
                        case '4':
                            // $this->db->where('rp.member_above_65 !=', NULL);
                            if($value['field_845'] != NULL)
                            {
                                $temp = $value['field_845'];
                                $totalUpload = $totalUpload + $temp ;
                            } 
                            break;
                        default:
                            # code...
                            break;
                    }
                        				
				}
                if($record_count!=0){
                    // $totalUpload = round($totalUpload/$record_count,2);
                }else{
                    $totalUpload=0;
                }
				array_push($production_volume_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $production_volume_option_item_array;
	}

    public function animal_gender_graph_array($data){
		$animal_gender_bargraph_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s4.*');
        $this->db->from('survey4 as s4');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s4.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s4.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s4.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s4.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s4.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s4.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s4.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s4.pa_verified_status', [1,2]);
        $this->db->where('s4.status', 1); 
       
       $submited_data = $this->db->order_by('s4.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 4; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Female";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Male, uncastrated";
                    $color='#14C9C9';
					break;
				case '3':
                    $form_filed_name = "Male, castrated";
                    // $color='#FFB6BA';
                    $color='#F7BA1E';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {

                if($value['field_531'] == $form_filed_name){
                    $camel_age++ ;
                }
                if($value['field_536'] == $form_filed_name){
                    $goat_age++ ;
                } 
                if($value['field_541'] == $form_filed_name){
                    $sheep_age++ ;
                }                  	
                if($value['field_545'] == $form_filed_name){
                    $cattel_age++ ;
                } 
                
            }
            array_push($data_array,$camel_age,$goat_age,$sheep_age,$cattel_age);
            array_push($animal_gender_bargraph_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_gender_bargraph_option_item_array;
	}

    public function animal_gender_1_graph_array($data){
		$animal_gender_1_bargraph_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s4.*');
        $this->db->from('survey4 as s4');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s4.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s4.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s4.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s4.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s4.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s4.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s4.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s4.pa_verified_status', [1,2]);
        $this->db->where('s4.status', 1); 
       
       $submited_data = $this->db->order_by('s4.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 4; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Female";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Male, uncastrated";
                    $color='#14C9C9';
					break;
				case '3':
                    $form_filed_name = "Male, castrated";
                    // $color='#FFB6BA';
                    $color='#F7BA1E';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {
                if($value['field_528'] != NULL){
                    $field_data = explode("&#44;", $value['field_528']);
                    foreach ($field_data as $fvalue) {
                        switch ($fvalue) {
                            case '1':
                                if($value['field_531'] == $form_filed_name){
                                    $camel_age++ ;
                                }
                                break;
                            case '3':
                                if($value['field_536'] == $form_filed_name){
                                    $goat_age++ ;
                                } 
                                break;
                            case '4':
                                if($value['field_541'] == $form_filed_name){
                                    $sheep_age++ ;
                                } 
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                    }
                }                
            }
            // array_push($data_array,$camel_age,$goat_age,$sheep_age,$cattel_age);
            array_push($data_array,$camel_age,$goat_age,$sheep_age);
            array_push($animal_gender_1_bargraph_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_gender_1_bargraph_option_item_array;
	}

    public function animal_gender_2_graph_array($data){
		$animal_gender_2_bargraph_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s4.*');
        $this->db->from('survey4 as s4');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s4.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s4.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s4.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s4.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s4.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s4.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s4.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s4.pa_verified_status', [1,2]);
        $this->db->where('s4.status', 1); 
       
       $submited_data = $this->db->order_by('s4.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 3; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Lactating cow";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Heifer";
                    $color='#14C9C9';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {

                if($value['field_528'] != NULL){
                    $field_data = explode("&#44;", $value['field_528']);
                    foreach ($field_data as $fvalue) {
                        switch ($fvalue) {
                            case '2':
                                if($value['field_545'] == $form_filed_name){
                                    $cattel_age++ ;
                                } 
                                break;
                            default:
                                # code...
                                break;
                        }
                        
                    }
                }
                
            }
            // array_push($data_array,$camel_age,$goat_age,$sheep_age,$cattel_age);
            array_push($data_array,$cattel_age);
            array_push($animal_gender_2_bargraph_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_gender_2_bargraph_option_item_array;
	}

    public function animal_age_graph_array($data){
		$animal_age_bargraph_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s4.*');
        $this->db->from('survey4 as s4');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s4.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s4.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s4.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s4.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s4.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s4.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s4.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s4.pa_verified_status', [1,2]);
        $this->db->where('s4.status', 1); 
       
       $submited_data = $this->db->order_by('s4.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 3; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Young";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Mature";
                    $color='#14C9C9';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {

                if($value['field_532'] == $form_filed_name){
                    $camel_age++ ;
                } 
                if($value['field_537'] == $form_filed_name){
                    $goat_age++ ;
                } 
                if($value['field_542'] == $form_filed_name){
                    $sheep_age++ ;
                }                 	
                if($value['field_547'] == $form_filed_name){
                    $cattel_age++ ;
                } 
                
            }
            array_push($data_array,$camel_age,$goat_age,$sheep_age,$cattel_age);
            array_push($animal_age_bargraph_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_age_bargraph_option_item_array;
	}

    public function animal_body_condition_graph_array($data){
		$animal_body_condition_bargraph_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s4.*');
        $this->db->from('survey4 as s4');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s4.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s4.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s4.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s4.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s4.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s4.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s4.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s4.pa_verified_status', [1,2]);
        $this->db->where('s4.status', 1); 
       
       $submited_data = $this->db->order_by('s4.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 5; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Fat (Grade 1)";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Moderate (Grade 2)";
                    $color='#FFB6BA';
					break;
				case '3':
                    $form_filed_name = "Thin (Grade 3)";
                    $color='#14C9C9';
					break;
				case '4':
                    $form_filed_name = "Emaciated (Grade 4)";
                    $color='#F7BA1E';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {

                if($value['field_533'] == $form_filed_name){
                    $camel_age++ ;
                } 
                if($value['field_538'] == $form_filed_name){
                    $goat_age++ ;
                } 
                if($value['field_543'] == $form_filed_name){
                    $sheep_age++ ;
                }                 	
                if($value['field_550'] == $form_filed_name){
                    $cattel_age++ ;
                } 
                
            }
            array_push($data_array,$camel_age,$goat_age,$sheep_age,$cattel_age);
            array_push($animal_body_condition_bargraph_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_body_condition_bargraph_option_item_array;
	}

    public function animal_body_condition_1_graph_array($data){
		$animal_body_condition_1_bargraph_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s4.*');
        $this->db->from('survey4 as s4');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s4.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s4.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s4.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s4.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s4.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s4.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s4.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s4.pa_verified_status', [1,2]);
        $this->db->where('s4.status', 1); 
       
       $submited_data = $this->db->order_by('s4.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 5; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Fat (Grade 1)";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Moderate (Grade 2)";
                    $color='#FFB6BA';
					break;
				case '3':
                    $form_filed_name = "Thin (Grade 3)";
                    $color='#14C9C9';
					break;
				case '4':
                    $form_filed_name = "Emaciated (Grade 4)";
                    $color='#F7BA1E';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {

                if($value['field_528'] != NULL){
                    $field_data = explode("&#44;", $value['field_528']);
                    foreach ($field_data as $fvalue) {
                        switch ($fvalue) {
                            case '1':
                                if($value['field_533'] == $form_filed_name){
                                    $camel_age++ ;
                                } 
                                break;
                            case '2':
                                if($value['field_550'] == $form_filed_name){
                                    $cattel_age++ ;
                                } 
                                break;
                            default:
                                # code...
                                break;
                        }
                        
                    }
                }
            }
            // array_push($data_array,$camel_age,$goat_age,$sheep_age,$cattel_age);
            array_push($data_array,$camel_age,$cattel_age);
            array_push($animal_body_condition_1_bargraph_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_body_condition_1_bargraph_option_item_array;
	}
    public function animal_body_condition_2_graph_array($data){
		$animal_body_condition_2_bargraph_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s4.*');
        $this->db->from('survey4 as s4');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s4.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s4.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s4.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s4.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s4.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s4.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s4.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s4.pa_verified_status', [1,2]);
        $this->db->where('s4.status', 1); 
       
       $submited_data = $this->db->order_by('s4.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 4; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Fat (Grade 1)";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Moderate (Grade 2)";
                    $color='#FFB6BA';
					break;
				case '3':
                    $form_filed_name = "Emaciated (Grade 3)";
                    $color='#F7BA1E';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {

                if($value['field_528'] != NULL){
                    $field_data = explode("&#44;", $value['field_528']);
                    foreach ($field_data as $fvalue) {
                        switch ($fvalue) {
                            case '3':
                                if($value['field_538'] == $form_filed_name){
                                    $goat_age++ ;
                                } 
                                break;
                            case '4':
                                if($value['field_543'] == $form_filed_name){
                                    $sheep_age++ ;
                                }  
                                break;
                            default:
                                # code...
                                break;
                        }
                        
                    }
                }
            }
            // array_push($data_array,$camel_age,$goat_age,$sheep_age,$cattel_age);
            array_push($data_array,$goat_age,$sheep_age);
            array_push($animal_body_condition_2_bargraph_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_body_condition_2_bargraph_option_item_array;
	}

    public function measurement_color_graph_array($data){
		$measurement_color_option_item_array = array();
        
        // Get Survey submited Data
        $this->db->select('s6.*');
        $this->db->from('survey6 as s6');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s6.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s6.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s6.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s6.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s6.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s6.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s6.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s6.pa_verified_status', [1,2]);
        $this->db->where('s6.status', 1);             
        
        $submited_data = $this->db->order_by('s6.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 4; $i++) { 
			$form_filed_id = $i;
			
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name1 = "Red";
                    $form_filed_name = "SAM";
                    $color='red';
					break;
				case '2':
                    $form_filed_name1 = "Yellow";
                    $form_filed_name = "MAM";
                    $color='yellow';
					break;
				case '3':
                    $form_filed_name1 = "Green";
                    $form_filed_name = "Normal";
                    $color='green';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				foreach ($submited_data as $value) {
                    
                    if($value['field_564']==$form_filed_name1){
                        $totalUpload++;
                    }
                    
                        				
				}
				array_push($measurement_color_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $measurement_color_option_item_array;
	}
    public function muac_measurement_graph_array($data){
		$muac_measurement_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s6.*');
        $this->db->from('survey6 as s6');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s6.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s6.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s6.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s6.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s6.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s6.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s6.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s6.pa_verified_status', [1,2]);
        $this->db->where('s6.status', 1);             
        
        $submited_data = $this->db->order_by('s6.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 5; $i++) { 
			$form_filed_id = $i;
			//, , Variety, IPM 
			switch ($form_filed_id) {
				case '1':
                    // $form_filed_name = "Age 0-5";
                    $form_filed_name = "0-6 centimeters";
                    $color='#165DFF';
					break;
				case '2':
                    // $form_filed_name = "Age 5-17";
                    $form_filed_name = "6-12 centimeters";
                    $color='#FFB6BA';
					break;
				case '3':
                    $form_filed_name = "12-24 centimeters";
                    $color='#14C9C9';
					break;
				case '4':
                    $form_filed_name = "24 centimeters and above";
                    $color='#F7BA1E';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				
				$temp = 0;
				foreach ($submited_data as $value) {
                    
                    $temp=0;
                    switch ($form_filed_id) {
                        case '1':
                            if($value['field_565'] >= 0 && $value['field_565'] <=6){
                                $totalUpload++;
                            }	
                            break;
                        case '2':
                            if($value['field_565'] > 6 && $value['field_565'] <=12){
                                $totalUpload++;
                            }	
                            break;
                        case '3':
                            if($value['field_565'] > 12 && $value['field_565'] <=24){
                                $totalUpload++;
                            }
                            break;
                        case '4':
                            if($value['field_565'] >= 24 ){
                                $totalUpload++;
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                        				
				}
				array_push($muac_measurement_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $muac_measurement_option_item_array;
	}

    public function get_lkp_herd_type_list(){
        $this->db->select('*');
        $this->db->from('lkp_animal_herd_type');
        $this->db->where('status', 1);
        $formfield_data = $this->db->get()->result_array();
        $list_array = array();
        foreach ($formfield_data as $key => $value) {
            array_push($list_array,$value['name']);
        }
        return $list_array;
    }

    public function livestock_animal_graph_array($data){
		$livestock_animal_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s10.*');
        $this->db->from('survey10 as s10');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s10.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s10.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s10.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s10.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s10.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s10.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s10.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s10.pa_verified_status', [1,2]);
        $this->db->where('s10.status', 1);             
        
        $submited_data = $this->db->order_by('s10.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        // for ($i=1; $i < 4; $i++) {
        $this->db->select('*');
        $this->db->from('lkp_animal_herd_type');
        $this->db->where('status', 1);
        $this->db->order_by('id');
        $formfield_data = $this->db->get()->result_array();
        foreach ($formfield_data as $fvalue) { 
            $form_filed_id = $fvalue['id'];
            $form_filed_name = $fvalue['name'];
            
            switch ($form_filed_id) {
                case '1':
                    $color='#165DFF';
                    break;
                case '2':
                    $color='#FFB6BA';
                    break;
                case '3':
                    $color='#14C9C9';
                    break;
                case '4':
                    $color='#F7BA1E';
                    break;
                case '5':
                    $color='#717276';
                    break;
                default:
                    # code...
                    break;
            }
            $totalUpload = 0;
             foreach ($submited_data as $value) {                 
                 if($value['field_630'] != NULL){
                    $field_data = explode("&#44;", $value['field_630']);
                    foreach ($field_data as $fvalue) {
                        if($form_filed_id==$fvalue){
                            $totalUpload++;
                        }
                    }
                    // if(in_array($form_filed_id, $field_data)){
					// 	$totalUpload++;
					// }
                 }
                 
                                     
             }
				array_push($livestock_animal_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $livestock_animal_option_item_array;
	}    

    public function animal_type_graph_array($data){
		$animal_type_bargraph_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s10.*');
        $this->db->from('survey10 as s10');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s10.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s10.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s10.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s10.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s10.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s10.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s10.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s10.pa_verified_status', [1,2]);
        $this->db->where('s10.status', 1); 
       
       $submited_data = $this->db->order_by('s10.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 3; $i++) { 
            $camel_count=0;
            $cattel_count=0;
            $goat_count=0;
            $sheep_count=0;
            $none_count=0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Mature";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Young";
                    $color='#14C9C9';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {
                
                
                if($value['field_630'] != NULL){
                    $field_data = explode("&#44;", $value['field_630']);
                    foreach ($field_data as $fvalue) {
                        switch ($fvalue) {
                            case '1':
                                // Camel 
                                if($form_filed_id==1){
                                    $loop_value = $value['field_631'];
                                }else {
                                    $loop_value = $value['field_635'];
                                }                                      
                                if($loop_value != NULL){
                                    $temp=0;
                                    $temp=$loop_value;
                                    $camel_count = $camel_count + $temp;
                                } 
                                break;
                            case '2':
                                // Cattle
                                if($form_filed_id==1){
                                    $loop_value = $value['field_866'];
                                }else {
                                    $loop_value = $value['field_870'];
                                } 
                                if($loop_value != NULL){
                                    $temp=0;
                                    $temp=$loop_value;
                                    $cattel_count = $cattel_count + $temp;
                                } 
                                break;
                            case '3':
                                // Goat
                                if($form_filed_id==1){
                                    $loop_value = $value['field_873'];
                                }else {
                                    $loop_value = $value['field_877'];
                                } 
                                if($loop_value != NULL){
                                    $temp=0;
                                    $temp=$loop_value;
                                    $goat_count =$goat_count + $temp;
                                }
                                break;
                            case '4':
                                // Sheep
                                if($form_filed_id==1){
                                    $loop_value = $value['field_880'];
                                }else {
                                    $loop_value = $value['field_884'];
                                } 
                                if($loop_value != NULL){
                                    $temp=0;
                                    $temp=$loop_value;
                                    $sheep_count =$sheep_count + $temp;
                                } 
                                break;
                            case '5':
                                // None
                                if($loop_value != NULL){
                                    $temp=0;
                                    $temp=$loop_value;
                                    $none_count = $none_count + $temp;
                                } 
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                }
            }
            array_push($data_array,$camel_count,$goat_count,$sheep_count,$cattel_count);
            array_push($animal_type_bargraph_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_type_bargraph_option_item_array;
	}

    public function animal_births_graph_array($data){
		$animal_births_bargraph_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s10.*');
        $this->db->from('survey10 as s10');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s10.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s10.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s10.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s10.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s10.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s10.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s10.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s10.pa_verified_status', [1,2]);
        $this->db->where('s10.status', 1); 
       
       $submited_data = $this->db->order_by('s10.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 3; $i++) { 
            $camel_count=0;
            $cattel_count=0;
            $goat_count=0;
            $sheep_count=0;
            $none_count =0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Successful Births";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Still Births";
                    $color='#14C9C9';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {
                $temp=0;
                if($form_filed_id==1){
                    $loop_value = $value['field_632'];
                }else if($form_filed_id==2){
                    $loop_value = $value['field_633'];
                } 
                switch ($value['field_630']) {
                    case '1':
                        // Camel                                      
                        if($loop_value != NULL){
                            $temp=$loop_value;
                            $camel_count = $camel_count + $temp;
                        } 
                        break;
                    case '2':
                        // Cattle
                        if($loop_value != NULL){
                            $temp=$loop_value;
                            $cattel_count = $cattel_count + $temp;
                        } 
                        break;
                    case '3':
                        // Goat
                        if($loop_value != NULL){
                            $temp=$loop_value;
                            $goat_count =$goat_count + $temp;
                        }
                        break;
                    case '4':
                        // Sheep
                        if($loop_value != NULL){
                            $temp=$loop_value;
                            $sheep_count =$sheep_count + $temp;
                        } 
                        break;
                    case '5':
                        // None
                        if($loop_value != NULL){
                            $temp=$loop_value;
                            $none_count = $none_count + $temp;
                        } 
                        break;
                    default:
                        # code...
                        break;
                }
            }
            array_push($data_array,$camel_count,$goat_count,$sheep_count,$cattel_count);
            array_push($animal_births_bargraph_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_births_bargraph_option_item_array;
	}

    public function animal_death_graph_array($data){
		$animal_death_bargraph_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s10.*');
        $this->db->from('survey10 as s10');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s10.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s10.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s10.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s10.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s10.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s10.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s10.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s10.pa_verified_status', [1,2]);
        $this->db->where('s10.status', 1); 
       
       $submited_data = $this->db->order_by('s10.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 3; $i++) { 
            $camel_count=0;
            $cattel_count=0;
            $goat_count=0;
            $sheep_count=0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Mature";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Young";
                    $color='#14C9C9';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {
                $temp=0;
                if($form_filed_id==1){
                    $loop_value = $value['field_634'];
                }else if($form_filed_id==1){
                    $loop_value = $value['field_636'];
                } 
                switch ($value['field_630']) {
                    case '1':
                        // Camel                                      
                        if($loop_value != NULL){
                            $temp=$loop_value;
                            $camel_count = $camel_count + $temp;
                        } 
                        break;
                    case '2':
                        // Cattle
                        if($loop_value != NULL){
                            $temp=$loop_value;
                            $cattel_count = $cattel_count + $temp;
                        } 
                        break;
                    case '3':
                        // Goat
                        if($loop_value != NULL){
                            $temp=$loop_value;
                            $goat_count =$goat_count + $temp;
                        }
                        break;
                    case '4':
                        // Sheep
                        if($loop_value != NULL){
                            $temp=$loop_value;
                            $sheep_count =$sheep_count + $temp;
                        } 
                        break;
                    case '5':
                        // None
                        if($loop_value != NULL){
                            $temp=$loop_value;
                            $none_count = $none_count + $temp;
                        } 
                        break;
                    default:
                        # code...
                        break;
                }
            }
            array_push($data_array,$camel_count,$goat_count,$sheep_count,$cattel_count);
            array_push($animal_death_bargraph_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_death_bargraph_option_item_array;
	}

    public function animal_births_deaths_graph_array($data){
		$animal_births_deaths_bargraph_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s10.*');
        $this->db->from('survey10 as s10');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s10.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s10.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s10.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s10.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s10.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s10.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s10.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s10.pa_verified_status', [1,2]);
        $this->db->where('s10.status', 1); 
       
       $submited_data = $this->db->order_by('s10.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
		for ($i=1; $i < 5; $i++) { 
            $camel_count=0;
            $cattel_count=0;
            $goat_count=0;
            $sheep_count=0;
            $none_count =0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Successful Births";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Still Births";
                    $color='#14C9C9';
					break;
                case '3':
                    $form_filed_name = "Mature";
                    $color='#165DFF';
                    break;
                case '4':
                    $form_filed_name = "Young";
                    $color='#14C9C9';
                    break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {
                
                
                
                $field_data = explode("&#44;", $value['field_630']);
                // if(in_array($form_filed_value, $field_data)){
                //     $totalUpload++;
                // }
                foreach ($field_data as $fvalue) {
                    $temp=0;
                    switch ($fvalue) {
                        case '1':
                            // Camel   
                            switch ($form_filed_id) {
                                case '1':
                                    $loop_value = $value['field_632'];
                                    break;
                                case '2':
                                    $loop_value = $value['field_633'];
                                    break;
                                case '3':
                                    $loop_value = $value['field_634'];
                                    break;
                                case '4':
                                    $loop_value = $value['field_636'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }                                   
                            if($loop_value != NULL){
                                $temp=$loop_value;
                                $camel_count = $camel_count + $temp;
                            } 
                            break;
                        case '2':
                            // Cattle
                            switch ($form_filed_id) {
                                case '1':
                                    $loop_value = $value['field_867'];
                                    break;
                                case '2':
                                    $loop_value = $value['field_868'];
                                    break;
                                case '3':
                                    $loop_value = $value['field_869'];
                                    break;
                                case '4':
                                    $loop_value = $value['field_871'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            if($loop_value != NULL){
                                $temp=$loop_value;
                                $cattel_count = $cattel_count + $temp;
                            } 
                            break;
                        case '3':
                            // Goat
                            switch ($form_filed_id) {
                                case '1':
                                    $loop_value = $value['field_874'];
                                    break;
                                case '2':
                                    $loop_value = $value['field_875'];
                                    break;
                                case '3':
                                    $loop_value = $value['field_876'];
                                    break;
                                case '4':
                                    $loop_value = $value['field_878'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            if($loop_value != NULL){
                                $temp=$loop_value;
                                $goat_count =$goat_count + $temp;
                            }
                            break;
                        case '4':
                            // Sheep
                            switch ($form_filed_id) {
                                case '1':
                                    $loop_value = $value['field_881'];
                                    break;
                                case '2':
                                    $loop_value = $value['field_882'];
                                    break;
                                case '3':
                                    $loop_value = $value['field_883'];
                                    break;
                                case '4':
                                    $loop_value = $value['field_885'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            if($loop_value != NULL){
                                $temp=$loop_value;
                                $sheep_count =$sheep_count + $temp;
                            } 
                            break;
                        case '5':
                            // None
                            if($loop_value != NULL){
                                $temp=$loop_value;
                                $none_count = $none_count + $temp;
                            } 
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
            array_push($data_array,$camel_count,$goat_count,$sheep_count,$cattel_count);
            array_push($animal_births_deaths_bargraph_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_births_deaths_bargraph_option_item_array;
	}

    public function animal_death_cause_graph_array($data){
		$animal_death_cause_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s10.*');
        $this->db->from('survey10 as s10');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s10.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s10.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s10.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s10.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s10.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s10.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s10.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s10.pa_verified_status', [1,2]);
        $this->db->where('s10.status', 1);             
        
        $submited_data = $this->db->order_by('s10.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        // for ($i=1; $i < 4; $i++) {
        $this->db->select('*');
        $this->db->from('form_field_multiple');
        $this->db->where('field_id', 637);
        $this->db->where('status', 1);
        $formfield_data = $this->db->get()->result_array();
        $form_filed_id=0;
        foreach ($formfield_data as $fvalue) {
            $form_filed_id++; 
            // $form_filed_id = $fvalue['multi_id'];
            $form_filed_value = $fvalue['value'];
            $form_filed_name = $fvalue['label'];
            
            switch ($form_filed_id) {
                case '1':
                    $color='#165DFF';
                    break;
                case '2':
                    $color='#FFB6BA';
                    break;
                case '3':
                    $color='#14C9C9';
                    break;
                case '4':
                    $color='#F7BA1E';
                    break;
                case '5':
                    $color='#717276';
                    break;
                case '6':
                    $color='#6FA1E7';
                    break;
                case '7':
                    $color='#C8E76F';
                    break;
                case '8':
                    $color='#5877A3';
                    break;
                case '9':
                    $color='#E49443';
                    break;
                default:
                    # code...
                    break;
            }
            $totalUpload = 0;
             foreach ($submited_data as $value) {
                 //camel
                 if($value['field_637'] != NULL && $value['field_637'] == $form_filed_value){
                    $totalUpload++;
                 }
                 //Cattle
                 if($value['field_872'] != NULL && $value['field_872'] == $form_filed_value){
                    $totalUpload++;
                 }
                 //Goat
                 if($value['field_879'] != NULL && $value['field_879'] == $form_filed_value){
                    $totalUpload++;
                 }
                 //Goat
                 if($value['field_886'] != NULL && $value['field_886'] == $form_filed_value){
                    $totalUpload++;
                 }
                 
                                     
             }
				array_push($animal_death_cause_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $animal_death_cause_option_item_array;
	}

    public function animal_death_cause_bar_graph_array($data){
		$animal_death_cause_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s10.*');
        $this->db->from('survey10 as s10');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s10.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s10.country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s10.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s10.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s10.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s10.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s10.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s10.pa_verified_status', [1,2]);
        $this->db->where('s10.status', 1);             
        
        $submited_data = $this->db->order_by('s10.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        // for ($i=1; $i < 4; $i++) {
        $this->db->select('*');
        $this->db->from('form_field_multiple');
        $this->db->where('field_id', 637);
        $this->db->where('status', 1);
        $formfield_data = $this->db->get()->result_array();
        $form_filed_id=0;
        foreach ($formfield_data as $fvalue) {
            $form_filed_id++; 
            $camel_count=0;
            $cattel_count=0;
            $goat_count=0;
            $sheep_count=0;
            $none_count=0;
            $data_array= array();
            // $form_filed_id = $fvalue['multi_id'];
            $form_filed_value = $fvalue['value'];
            $form_filed_name = $fvalue['label'];
            
            switch ($form_filed_id) {
                case '1':
                    $color='#165DFF';
                    break;
                case '2':
                    $color='#FFB6BA';
                    break;
                case '3':
                    $color='#14C9C9';
                    break;
                case '4':
                    $color='#F7BA1E';
                    break;
                case '5':
                    $color='#717276';
                    break;
                case '6':
                    $color='#6FA1E7';
                    break;
                case '7':
                    $color='#C8E76F';
                    break;
                case '8':
                    $color='#5877A3';
                    break;
                case '9':
                    $color='#E49443';
                    break;
                default:
                    # code...
                    break;
            }
            $totalUpload = 0;
             foreach ($submited_data as $value) {                
                
                $field_data = explode("&#44;", $value['field_630']);
                // if(in_array($form_filed_value, $field_data)){
                //     $totalUpload++;
                // }
                foreach ($field_data as $flvalue) {
                    $temp=0;
                    switch ($flvalue) {
                        case '1':
                            // Camel    
                            $loop_value = $value['field_637'];                                  
                            if($loop_value != NULL && $loop_value == $form_filed_value){
                                $camel_count++;
                            } 
                            break;
                        case '2':
                            // Cattle
                            $loop_value = $value['field_872'];  
                            if($loop_value != NULL && $loop_value == $form_filed_value){
                                $cattel_count++;
                            } 
                            break;
                        case '3':
                            // Goat
                            $loop_value = $value['field_879'];  
                            if($loop_value != NULL && $loop_value == $form_filed_value){
                                $goat_count++;
                            }
                            break;
                        case '4':
                            // Sheep
                            $loop_value = $value['field_886'];  
                            if($loop_value != NULL && $loop_value == $form_filed_value){
                                $sheep_count ++;
                            } 
                            break;
                        case '5':
                            // None
                            if($loop_value != NULL && $loop_value == $form_filed_value){
                                $none_count ++;
                            } 
                            break;
                        default:
                            # code...
                            break;
                    }
                }
                 
                                     
             }
             array_push($data_array,$camel_count,$goat_count,$sheep_count,$cattel_count);
            array_push($animal_death_cause_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
				// array_push($animal_death_cause_option_item_array, array(
				// 		'name' => $form_filed_name,
                //         'color' => $color,
				// 		'y' => $totalUpload
				// 	));
		}
		return $animal_death_cause_option_item_array;
	}

    public function animal_sales_graph_array($data){
		$animal_sales_option_item_array = array();
         // Get Survey submited Data
         $this->db->select('s10.*');
         $this->db->from('survey10 as s10');
         // $this->db->join('tbl_users AS tu', 'tu.user_id = s10.user_id');
         if(!empty($data['country_id'])) {
             $this->db->where('s10.country_id', $data['country_id']);
         }
         if(!empty($data['cluster_id'])) {
             $this->db->where('s10.cluster_id', $data['cluster_id']);
         }
         if(!empty($data['uai_id'])) {
             $this->db->where('s10.uai_id', $data['uai_id']);
         }
         if(!empty($data['sub_location_id'])) {
             $this->db->where('s10.sub_location_id', $data['sub_location_id']);
         }
         if(!empty($data['start_date']) && !empty($data['end_date'])){
             $this->db->where('DATE(s10.datetime) >=', $data['start_date']);
             $this->db->where('DATE(s10.datetime) <=', $data['end_date']);
         }
         $this->db->where_in('s10.pa_verified_status', [1,2]);
         $this->db->where('s10.status', 1);             
         
         $submited_data = $this->db->order_by('s10.id', 'DESC')->get()->result_array();
         // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
         // print_r($this->db->last_query());
         // exit();

		for ($i=1; $i < 5; $i++) { 
			$form_filed_id = $i;
			
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Camel";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Goat";
                    $color='#14C9C9';
					break;
				case '3':
                    $form_filed_name = "Sheep";
                    $color='#F7BA1E';
					break;                     
                case '4':
                    $form_filed_name = "Cattle";
                    $color='#FFB6BA';
                    break;                   
				
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				
            $camel_count=0;
            $cattel_count=0;
            $goat_count=0;
            $sheep_count=0;
				$temp=0;
				$record_count=0;
				foreach ($submited_data as $value) {

                    if($value['field_640'] != NULL){
                        $field_data = explode("&#44;", $value['field_640']);
                            foreach ($field_data as $fvalue) {
                                if($form_filed_id == $fvalue){
                                    $record_count++;
                                    switch ($fvalue) {
                                        case '1':
                                            // Camel  
                                            $loop_value = $value['field_641'];                   
                                            if($loop_value != NULL){
                                                $temp=0;
                                                $temp=$loop_value;
                                                $camel_count = $camel_count + $temp;
                                            } 
                                            break;
                                        case '2':
                                            // Cattle
                                            $loop_value = $value['field_893'];
                                                if($loop_value != NULL){
                                                    $temp=0;
                                                    $temp=$loop_value;
                                                    $cattel_count =$cattel_count + $temp;
                                                }
                                            break;
                                        case '3':
                                            // Goat
                                            $loop_value = $value['field_896'];
                                                if($loop_value != NULL){
                                                    $temp=0;
                                                    $temp=$loop_value;
                                                    $goat_count =$goat_count + $temp;
                                                } 
                                            break;                            
                                        case '4':
                                            // Sheep
                                            $loop_value = $value['field_899'];
                                                if($loop_value != NULL){
                                                    $temp=0;
                                                    $temp=$loop_value;
                                                    $sheep_count = $sheep_count + $temp;
                                                }
                                            break;
                                        default:
                                            # code...
                                            break;
                                    }
                                }
                            }
                    }
                        				
				}
                
                if($record_count!=0){
                    // $totalUpload = round($totalUpload/$record_count,2);
                    switch ($form_filed_id) {
                        case '1':
                            $totalUpload = round($camel_count/$record_count,2);
                            break;
                        case '2':
                            $totalUpload = round($cattel_count/$record_count,2);
                            break;
                        case '3':
                            $totalUpload = round($goat_count/$record_count,2);
                            break;                    
                        case '4':
                            $totalUpload = round($sheep_count/$record_count,2);
                            break;
                        default:
                            # code...
                            break;
                    }
                }else{
                    $totalUpload=0;
                }
				array_push($animal_sales_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $animal_sales_option_item_array;
	}

    public function animal_purchases_graph_array($data){
		$animal_sales_option_item_array = array();
         // Get Survey submited Data
         $this->db->select('s10.*');
         $this->db->from('survey10 as s10');
         // $this->db->join('tbl_users AS tu', 'tu.user_id = s10.user_id');
         if(!empty($data['country_id'])) {
             $this->db->where('s10.country_id', $data['country_id']);
         }
         if(!empty($data['cluster_id'])) {
             $this->db->where('s10.cluster_id', $data['cluster_id']);
         }
         if(!empty($data['uai_id'])) {
             $this->db->where('s10.uai_id', $data['uai_id']);
         }
         if(!empty($data['sub_location_id'])) {
             $this->db->where('s10.sub_location_id', $data['sub_location_id']);
         }
         if(!empty($data['start_date']) && !empty($data['end_date'])){
             $this->db->where('DATE(s10.datetime) >=', $data['start_date']);
             $this->db->where('DATE(s10.datetime) <=', $data['end_date']);
         }
         $this->db->where_in('s10.pa_verified_status', [1,2]);
         $this->db->where('s10.status', 1);             
         
         $submited_data = $this->db->order_by('s10.id', 'DESC')->get()->result_array();
         // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
         // print_r($this->db->last_query());
         // exit();

		for ($i=1; $i < 5; $i++) { 
			$form_filed_id = $i;
			
			switch ($form_filed_id) {
				case '1':
                    $form_filed_name = "Camel";
                    $color='#165DFF';
					break;
				case '2':
                    $form_filed_name = "Goat";
                    $color='#14C9C9';
					break;
				case '3':
                    $form_filed_name = "Sheep";
                    $color='#F7BA1E';
					break;                    
				case '4':
                    $form_filed_name = "Cattle";
                    $color='#FFB6BA';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				
            $camel_count=0;
            $cattel_count=0;
            $goat_count=0;
            $sheep_count=0;
				$temp=0;
				$record_count=0;
				foreach ($submited_data as $value) {
                    if($value['field_644'] != NULL){
                        $field_data = explode("&#44;", $value['field_644']);
                        foreach ($field_data as $fvalue) {
                            if($form_filed_id == $fvalue){
                                $record_count++;
                                switch ($fvalue) {
                                    case '1':
                                        // Camel  
                                        $loop_value = $value['field_645'];                   
                                        if($loop_value != NULL){
                                            $temp=0;
                                            $temp=$loop_value;
                                            $totalUpload = $totalUpload + $temp;
                                        } 
                                        break;
                                    case '2':
                                        // Cattle
                                        $loop_value = $value['field_903'];
                                            if($loop_value != NULL){
                                                $temp=0;
                                                $temp=$loop_value;
                                                $totalUpload =$totalUpload + $temp;
                                            }
                                        break;
                                    case '3':
                                        // Goat
                                        $loop_value = $value['field_906'];
                                            if($loop_value != NULL){
                                                $temp=0;
                                                $temp=$loop_value;
                                                $totalUpload =$totalUpload + $temp;
                                            } 
                                        break;                            
                                    case '4':
                                        // Sheep
                                        $loop_value = $value['field_909'];
                                            if($loop_value != NULL){
                                                $temp=0;
                                                $temp=$loop_value;
                                                $totalUpload = $totalUpload + $temp;
                                            }
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                            }
                        }
                    }
                    
                        				
				}
                if($record_count!=0){
                    $totalUpload = round($totalUpload/$record_count,2);
                }else{
                    $totalUpload=0;
                }
				array_push($animal_sales_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $animal_sales_option_item_array;
	}
    public function rcsi_graph_array($data){
		$rcsi_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s8.*');
        $this->db->from('survey8 as s8');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s8.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s8.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s8.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s8.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s8.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s8.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s8.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s8.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s8.pa_verified_status', [1,2]);
        // $this->db->where('s8.uai_id !=', NULL);
        $this->db->where('s8.status', 1); 
       
       $submited_data = $this->db->order_by('s8.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_food_categories');
        $this->db->where('status', 1);        
        $this->db->where('category_type', 'women');        
        $fg_categories_options = $this->db->get()->result_array();
        $fg_categories_list_array = array();
        foreach ($fg_categories_options as $fgcvalue) {
            $fg_categories_name = $fgcvalue['name'];
            array_push($fg_categories_list_array,$fg_categories_name);
        }
        $this->db->select('*');
        $this->db->from('lkp_food_groups_categories_mapping');
        $this->db->where('status', 1);        
        $this->db->where('category_type', 'women');        
        $fg_categories_map_options = $this->db->get()->result_array();
        // Initialize an empty array to store the grouped data
        $fg_categories_map_list_array = array();
        // foreach ($fg_categories_map_options as $fgc_map_value) {
        //     $fg_categories_name = $fgc_map_value['category_id'];
        //     array_push($fg_categories_map_list_array,$fg_categories_name);
        // }
        // Initialize an empty array to store the grouped data
        $groupedData = [];

        // Group the data by 'groupid' and push into $groupedData array
        foreach ($fg_categories_map_options as $item) {
            $groupId = $item['category_id'];
            if (!isset($fg_categories_map_list_array[$groupId])) {
                $fg_categories_map_list_array[$groupId] = [];
            }
            // $fg_categories_map_list_array[$groupId][] = $item['food_group_id'];'
            array_push($fg_categories_map_list_array[$groupId],$item['food_group_id']);
        }
        // print_r($fg_categories_map_list_array);
        // exit();
        $data_array= array();
        $food_group_list_array= array();
        $fg_loop_count=0;
        // food group option list
        $this->db->select('*');
        $this->db->from('lkp_food_groups');
        $this->db->where('status', 1);        
        $food_group_options = $this->db->get()->result_array();
        foreach ($food_group_options as $fgvalue) {
            array_push($food_group_list_array,$fgvalue['name']);
            $form_filed_name = $fgvalue['name'];
            $fg_categories_loop_id=0;
            foreach ($fg_categories_options as $fgcvalue) {
                $fg_categories_id = $fgcvalue['id'];
                $fg_categories_name = $fgcvalue['name'];
                $total_upload=0;
                // print_r($fg_categories_map_list_array[$fg_categories_id]);exit();
                if(in_array($fg_categories_id,$fg_categories_map_list_array[$groupId])){
                // if($fg_categories_id == $fg_categories_map_list_array[$fg_categories_id][0] || $fg_categories_id == $fg_categories_map_list_array[$fg_categories_id][1]  ||$fg_categories_id == $fg_categories_map_list_array[$fg_categories_id][2] ){
                    foreach ($submited_data as $value) {
                        if($value['field_619'] != NULL || !empty($value['field_619'] )){
                            $field_data = explode("&#44;", $value['field_619']);
                            if(in_array($fgvalue['id'], $field_data)){
                                $total_upload++;
                            }
                        }                   
                    }
                }
                
                array_push($data_array, array($fg_loop_count, $fg_categories_loop_id, $total_upload));
                $fg_categories_loop_id++;
            }
            $fg_loop_count++;
		} 
        array_push($rcsi_option_item_array, array(
                'month_list' => $food_group_list_array,
                'uai_list' => $fg_categories_list_array,
                'data' => $data_array
            ));
		return $rcsi_option_item_array;
        
	}

    public function rcsi_heat_map_graph_array($data){
		$rcsi_heat_map_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s8.*');
        $this->db->from('survey8 as s8');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s8.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s8.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s8.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s8.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s8.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s8.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s8.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s8.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s8.pa_verified_status', [1,2]);
        $this->db->where('s8.status', 1); 
       
       $submited_data = $this->db->order_by('s8.user_id', 'DESC')->get()->result_array();
        //    print_r($this->db->last_query());
        //    exit();
        $this->db->select('*');
        $this->db->from('lkp_food_categories');
        $this->db->where('status', 1);        
        $this->db->where('category_type', 'women');        
        $fg_categories_options = $this->db->get()->result_array();
        $fg_categories_list_array = array();
        foreach ($fg_categories_options as $fgcvalue) {
            $fg_categories_name = $fgcvalue['name'];
            array_push($fg_categories_list_array,$fg_categories_name);
        }
        $this->db->select('*');
        $this->db->from('lkp_food_groups_categories_mapping');
        $this->db->where('status', 1);        
        $this->db->where('category_type', 'women');        
        $fg_categories_map_options = $this->db->get()->result_array();
        
        $data_array= array();
        $month_list_array= array();
        $month=0;
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;            
        }else{
            $month=6;            
        }
        
        $loop_count=$month;
        $currentDate = new DateTime();
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;              
            $currentDate = new DateTime();              
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDateformat = $currentDate1;
            // Format the date as per your requirement
            $formattedDate = $currentDateformat->format('M-Y');
            $formattedDateid = $currentDateformat->format('m');
            $formattedYearid = $currentDateformat->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $cluster_loop_id=0;
            $month=$month-1;
            foreach ($fg_categories_options as $fgcvalue) {
                $fg_categories_id = $fgcvalue['id'];
                $fg_categories_name = $fgcvalue['name'];
                foreach ($fg_categories_map_options as $item) {
                    $groupId = $item['category_id'];
                    if($fgcvalue['id'] == $item['category_id']){
                        $food_group_id =$item['food_group_id'];
                        $total_upload=0;
                        foreach ($submited_data as $value) {                    
                            if(date('m',strtotime($value['datetime'])) == $formattedDateid){ 
                                // if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){ 
                                if($value['field_619'] != NULL || !empty($value['field_619'] )){
                                    $field_data = explode("&#44;", $value['field_619']);
                                    if(in_array($food_group_id, $field_data)){
                                        $total_upload++;
                                    }
                                }                        
                                                      
                            }                     
                        }
                    }
                }
                array_push($data_array, array($i, $cluster_loop_id, $total_upload));
                $cluster_loop_id++;
            }
		} 
        array_push($rcsi_heat_map_option_item_array, array(
                'month_list' => $month_list_array,
                'category_list' => $fg_categories_list_array,
                'data' => $data_array
            ));
		return $rcsi_heat_map_option_item_array;
	}

    public function rcsi_stacked_bar_graph_array($data){
		$rcsi_stacked_bar_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s8.*');
        $this->db->from('survey8 as s8');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s8.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s8.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s8.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s8.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s8.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s8.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s8.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s8.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s8.pa_verified_status', [1,2]);
        $this->db->where('s8.status', 1); 
       
       $submited_data = $this->db->order_by('s8.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        
        $data_array1= array();
        $data_array2= array();
        $month_list_array= array();
        $month=0;
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;            
        }else{
            $month=6;            
        }
        
        $loop_count=$month;
        
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;   
            $currentDate = new DateTime();   
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDateformat = $currentDate1;
            // Format the date as per your requirement
            $formattedDate = $currentDateformat->format('M-Y');
            $formattedDateid = $currentDateformat->format('m');
            $formattedYearid = $currentDateformat->format('y');
            array_push($month_list_array,$formattedDate);
            $month=$month-1;
            
            // print_r($valuereduce);
                $greater_count=0;
                $less_count=0;
                $total_upload_count=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){                        
                        if($value['field_619'] != NULL || !empty($value['field_619'] )){
                            
                            $field_data = explode("&#44;", $value['field_619']);
                            if(count($field_data)>=5){
                                $greater_count++;
                            }else if(count($field_data)<5){
                                $less_count++;
                            }else{
                                $total_upload_count=$value['field_619'];
                            }
                        }                        
                    }                     
                }
                array_push($data_array1, $less_count);
                array_push($data_array2, $greater_count);
                      
		} 
        array_push($rcsi_stacked_bar_option_item_array, array(
                'month_list' => $month_list_array,
                'data1' => $data_array1,
                'data2' => $data_array2
            ));
		return $rcsi_stacked_bar_option_item_array;
	}
    // from here tab 3 starts
    public function camel_milk_cluster_graph_array($data){
		$camel_milk_cluster_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.cluster_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_cluster');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('cluster_id', $data['cluster_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        
        $cluster_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $cluster_name = $ffvalue['name'];
            array_push($cluster_list_array,$cluster_name);
        }
        // $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            // print_r($data['start_date']);exit();
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;   
            // print_r($month);exit();         
        }else{
            $month=6;            
        }
        
        $loop_count=$month;
        $currentDate = new DateTime();
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;
                             
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
			$form_filed_id = $i;
            $cluster_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $cluster_id = $fvalue['cluster_id'];
                $cluster_name = $fvalue['name'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){                        
                        if($cluster_id==$value['cluster_id']){                                                        
                            if(!empty($value['field_580'])){
                                $temp=0;
                                $temp=$value['field_580'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }
                array_push($data_array, array($i, $cluster_loop_id, $total_upload));
                $cluster_loop_id++;
            }
		} 
        array_push($camel_milk_cluster_option_item_array, array(
                'month_list' => $month_list_array,
                'cluster_list' => $cluster_list_array,
                'data' => $data_array
            ));
		return $camel_milk_cluster_option_item_array;
	}
    public function camel_milk_uai_graph_array($data){
		$camel_milk_uai_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.uai_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('uai_id', $data['uai_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        // print_r($this->db->last_query());
        $uai_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $uai_name = $ffvalue['uai'];
            array_push($uai_list_array,$uai_name);
        }
        $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            // print_r($data['start_date']);exit();
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;   
            // print_r($month);exit();         
        }else{
            $month=6;            
        }
        $loop_count=$month;
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();        
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
			$form_filed_id = $i;
            $uai_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $uai_id = $fvalue['uai_id'];
                $uai_name = $fvalue['uai'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){                                       
                        if($uai_id==$value['uai_id']){                                                      
                            if(!empty($value['field_580'])){
                                $temp=0;
                                $temp=$value['field_580'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }
                array_push($data_array, array($i, $uai_loop_id, $total_upload));
                $uai_loop_id++;
            }
		} 
        array_push($camel_milk_uai_option_item_array, array(
                'month_list' => $month_list_array,
                'uai_list' => $uai_list_array,
                'data' => $data_array
            ));
		return $camel_milk_uai_option_item_array;
	}
    public function cattle_milk_cluster_graph_array($data){
		$cattle_milk_cluster_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.cluster_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_cluster');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('cluster_id', $data['cluster_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        
        $cluster_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $cluster_name = $ffvalue['name'];
            array_push($cluster_list_array,$cluster_name);
        }
        // $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }
        
        $loop_count=$month;
        $currentDate = new DateTime();
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();       
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
			$form_filed_id = $i;
            $cluster_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $cluster_id = $fvalue['cluster_id'];
                $cluster_name = $fvalue['name'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){                      
                        if($cluster_id==$value['cluster_id']){                                                        
                            if(!empty($value['field_581'])){
                                $temp=0;
                                $temp=$value['field_581'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }
                array_push($data_array, array($i, $cluster_loop_id, $total_upload));
                $cluster_loop_id++;
            }
		} 
        array_push($cattle_milk_cluster_option_item_array, array(
                'month_list' => $month_list_array,
                'cluster_list' => $cluster_list_array,
                'data' => $data_array
            ));
		return $cattle_milk_cluster_option_item_array;
	}
    public function cattle_milk_uai_graph_array($data){
		$cattle_milk_uai_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.uai_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('uai_id', $data['uai_id']);
        }
        $formfield_options = $this->db->get()->result_array();

        $uai_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $uai_name = $ffvalue['uai'];
            array_push($uai_list_array,$uai_name);
        }
        $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }
        $loop_count=$month;
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();        
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $uai_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $uai_id = $fvalue['uai_id'];
                $uai_name = $fvalue['uai'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){     
                        if($uai_id==$value['uai_id']){                                                        
                            if(!empty($value['field_581'])){
                                $temp=0;
                                $temp=$value['field_581'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }
                
                array_push($data_array, array($i, $uai_loop_id, $total_upload));
                $uai_loop_id++;
            }
		} 
        array_push($cattle_milk_uai_option_item_array, array(
                'month_list' => $month_list_array,
                'uai_list' => $uai_list_array,
                'data' => $data_array
            ));
		return $cattle_milk_uai_option_item_array;
	}
    public function maize_grain_cluster_graph_array($data){
		$maize_grain_cluster_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.cluster_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_cluster');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('cluster_id', $data['cluster_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        
        $cluster_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $cluster_name = $ffvalue['name'];
            array_push($cluster_list_array,$cluster_name);
        }
        // $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }        
        $loop_count=$month;
        $currentDate = new DateTime();
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();       
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $cluster_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $cluster_id = $fvalue['cluster_id'];
                $cluster_name = $fvalue['name'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){                       
                        if($cluster_id==$value['cluster_id']){                                                        
                            if(!empty($value['field_582'])){
                                $temp=0;
                                $temp=$value['field_582'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }
                array_push($data_array, array($i, $cluster_loop_id, $total_upload));
                $cluster_loop_id++;
            }
		} 
        array_push($maize_grain_cluster_option_item_array, array(
                'month_list' => $month_list_array,
                'cluster_list' => $cluster_list_array,
                'data' => $data_array
            ));
		return $maize_grain_cluster_option_item_array;
	}
    public function maize_grain_uai_graph_array($data){
		$maize_grain_uai_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.uai_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('uai_id', $data['uai_id']);
        }
        $formfield_options = $this->db->get()->result_array();

        $uai_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $uai_name = $ffvalue['uai'];
            array_push($uai_list_array,$uai_name);
        }
        $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }
        $loop_count=$month;
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();        
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $uai_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $uai_id = $fvalue['uai_id'];
                $uai_name = $fvalue['uai'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){     
                        if($uai_id==$value['uai_id']){                                                        
                            if(!empty($value['field_582'])){
                                $temp=0;
                                $temp=$value['field_582'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }                
                array_push($data_array, array($i, $uai_loop_id, $total_upload));
                $uai_loop_id++;
            }
		} 
        array_push($maize_grain_uai_option_item_array, array(
                'month_list' => $month_list_array,
                'uai_list' => $uai_list_array,
                'data' => $data_array
            ));
		return $maize_grain_uai_option_item_array;
	}
    public function sorghum_cluster_graph_array($data){
		$sorghum_cluster_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.cluster_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_cluster');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('cluster_id', $data['cluster_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        
        $cluster_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $cluster_name = $ffvalue['name'];
            array_push($cluster_list_array,$cluster_name);
        }
        // $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }        
        $loop_count=$month;
        $currentDate = new DateTime();
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();       
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $cluster_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $cluster_id = $fvalue['cluster_id'];
                $cluster_name = $fvalue['name'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){                       
                        if($cluster_id==$value['cluster_id']){                                                        
                            if(!empty($value['field_583'])){
                                $temp=0;
                                $temp=$value['field_583'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }
                array_push($data_array, array($i, $cluster_loop_id, $total_upload));
                $cluster_loop_id++;
            }
		} 
        array_push($sorghum_cluster_option_item_array, array(
                'month_list' => $month_list_array,
                'cluster_list' => $cluster_list_array,
                'data' => $data_array
            ));
		return $sorghum_cluster_option_item_array;
	}
    public function sorghum_uai_graph_array($data){
		$sorghum_uai_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.uai_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('uai_id', $data['uai_id']);
        }
        $formfield_options = $this->db->get()->result_array();

        $uai_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $uai_name = $ffvalue['uai'];
            array_push($uai_list_array,$uai_name);
        }
        $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }
        $loop_count=$month;
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();        
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $uai_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $uai_id = $fvalue['uai_id'];
                $uai_name = $fvalue['uai'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){    
                        if($uai_id==$value['uai_id']){                                                        
                            if(!empty($value['field_583'])){
                                $temp=0;
                                $temp=$value['field_583'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }
                
                array_push($data_array, array($i, $uai_loop_id, $total_upload));
                $uai_loop_id++;
            }
		} 
        array_push($sorghum_uai_option_item_array, array(
                'month_list' => $month_list_array,
                'uai_list' => $uai_list_array,
                'data' => $data_array
            ));
		return $sorghum_uai_option_item_array;
	}
    public function wheat_cluster_graph_array($data){
		$wheat_cluster_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.cluster_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_cluster');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('cluster_id', $data['cluster_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        
        $cluster_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $cluster_name = $ffvalue['name'];
            array_push($cluster_list_array,$cluster_name);
        }
        // $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }
        $loop_count=$month;
        $currentDate = new DateTime();
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();       
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $cluster_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $cluster_id = $fvalue['cluster_id'];
                $cluster_name = $fvalue['name'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){                        
                        if($cluster_id==$value['cluster_id']){                                                        
                            if(!empty($value['field_584'])){
                                $temp=0;
                                $temp=$value['field_584'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }
                array_push($data_array, array($i, $cluster_loop_id, $total_upload));
                $cluster_loop_id++;
            }
		} 
        array_push($wheat_cluster_option_item_array, array(
                'month_list' => $month_list_array,
                'cluster_list' => $cluster_list_array,
                'data' => $data_array
            ));
		return $wheat_cluster_option_item_array;
	}
    public function wheat_uai_graph_array($data){
		$wheat_uai_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.uai_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('uai_id', $data['uai_id']);
        }
        $formfield_options = $this->db->get()->result_array();

        $uai_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $uai_name = $ffvalue['uai'];
            array_push($uai_list_array,$uai_name);
        }
        $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }
        $loop_count=$month;
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();        
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $uai_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $uai_id = $fvalue['uai_id'];
                $uai_name = $fvalue['uai'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){     
                        if($uai_id==$value['uai_id']){                                                        
                            if(!empty($value['field_584'])){
                                $temp=0;
                                $temp=$value['field_584'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }                
                array_push($data_array, array($i, $uai_loop_id, $total_upload));
                $uai_loop_id++;
            }
		} 
        array_push($wheat_uai_option_item_array, array(
                'month_list' => $month_list_array,
                'uai_list' => $uai_list_array,
                'data' => $data_array
            ));
		return $wheat_uai_option_item_array;
	}
    public function sugar_cluster_graph_array($data){
		$sugar_cluster_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.cluster_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_cluster');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('cluster_id', $data['cluster_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        
        $cluster_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $cluster_name = $ffvalue['name'];
            array_push($cluster_list_array,$cluster_name);
        }
        // $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }        
        $loop_count=$month;
        $currentDate = new DateTime();
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();       
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $cluster_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $cluster_id = $fvalue['cluster_id'];
                $cluster_name = $fvalue['name'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){                         
                        if($cluster_id==$value['cluster_id']){                                                        
                            if(!empty($value['field_588'])){
                                $temp=0;
                                $temp=$value['field_588'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }
                array_push($data_array, array($i, $cluster_loop_id, $total_upload));
                $cluster_loop_id++;
            }
		} 
        array_push($sugar_cluster_option_item_array, array(
                'month_list' => $month_list_array,
                'cluster_list' => $cluster_list_array,
                'data' => $data_array
            ));
		return $sugar_cluster_option_item_array;
	}
    public function sugar_uai_graph_array($data){
		$sugar_uai_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.uai_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('uai_id', $data['uai_id']);
        }
        $formfield_options = $this->db->get()->result_array();

        $uai_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $uai_name = $ffvalue['uai'];
            array_push($uai_list_array,$uai_name);
        }
        $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }
        $loop_count=$month;
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();        
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $uai_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $uai_id = $fvalue['uai_id'];
                $uai_name = $fvalue['uai'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){     
                        if($uai_id==$value['uai_id']){                                                        
                            if(!empty($value['field_588'])){
                                $temp=0;
                                $temp=$value['field_588'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }
                
                array_push($data_array, array($i, $uai_loop_id, $total_upload));
                $uai_loop_id++;
            }
		} 
        array_push($sugar_uai_option_item_array, array(
                'month_list' => $month_list_array,
                'uai_list' => $uai_list_array,
                'data' => $data_array
            ));
		return $sugar_uai_option_item_array;
	}
    public function rice_cluster_graph_array($data){
		$rice_cluster_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.cluster_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_cluster');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('cluster_id', $data['cluster_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        
        $cluster_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $cluster_name = $ffvalue['name'];
            array_push($cluster_list_array,$cluster_name);
        }
        // $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }
        
        $loop_count=$month;
        $currentDate = new DateTime();
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();       
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $cluster_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $cluster_id = $fvalue['cluster_id'];
                $cluster_name = $fvalue['name'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){                        
                        if($cluster_id==$value['cluster_id']){                                                        
                            if(!empty($value['field_589'])){
                                $temp=0;
                                $temp=$value['field_589'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }
                array_push($data_array, array($i, $cluster_loop_id, $total_upload));
                $cluster_loop_id++;
            }
		} 
        array_push($rice_cluster_option_item_array, array(
                'month_list' => $month_list_array,
                'cluster_list' => $cluster_list_array,
                'data' => $data_array
            ));
		return $rice_cluster_option_item_array;
	}
    public function rice_uai_graph_array($data){
		$rice_uai_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.uai_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('uai_id', $data['uai_id']);
        }
        $formfield_options = $this->db->get()->result_array();

        $uai_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $uai_name = $ffvalue['uai'];
            array_push($uai_list_array,$uai_name);
        }
        $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }
        $loop_count=$month;
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();        
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $uai_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $uai_id = $fvalue['uai_id'];
                $uai_name = $fvalue['uai'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){     
                        if($uai_id==$value['uai_id']){                                                        
                            if(!empty($value['field_589'])){
                                $temp=0;
                                $temp=$value['field_589'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }                
                array_push($data_array, array($i, $uai_loop_id, $total_upload));
                $uai_loop_id++;
            }
		} 
        array_push($rice_uai_option_item_array, array(
                'month_list' => $month_list_array,
                'uai_list' => $uai_list_array,
                'data' => $data_array
            ));
		return $rice_uai_option_item_array;
	}

    public function livestock_animal_gender_graph_array($data){
		$livestock_animal_gender_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
       
       $submited_data = $this->db->order_by('s5.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('form_field_multiple');
        $this->db->where('field_id', 741);
        $this->db->where('status', 1);
        $formfield_data = $this->db->get()->result_array();
        $form_filed_id=0;
        foreach ($formfield_data as $fvalue) {
            $form_filed_id++; 
            // $form_filed_id = $fvalue['multi_id'];
            $form_filed_value = $fvalue['value'];
            $form_filed_name = $fvalue['label'];
		// for ($i=1; $i < 3; $i++) { 
            $male1=0;
            $male2=0;
            $female=0;
            $data_array= array();
			// $form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $color='#165DFF';
                    break;
                case '2':
                    $color='#FFB6BA';
                    break;
                case '3':
                    $color='#14C9C9';
                    break;
                case '4':
                    $color='#F7BA1E';
                    break;
                case '5':
                    $color='#717276';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {
                if(!empty($value['field_741'])){
                    if($value['field_741'] == $form_filed_value){
                        // $female++;
                        if(!empty($value['field_979'])){
                            if($value['field_979'] == 'Female'){
                                $female++;
                            }
                            if($value['field_979'] == 'Male Castrated'){
                                $male1++;
                            }
                            if($value['field_979'] == 'Male Uncastrated'){
                                $male2++;
                            }
                        }
                    }
                    // $field_data = explode("&#44;", $value['field_741']);
                    // foreach ($field_data as $fvalue) {

                    //     if($fvalue == "Camel"){
                    //         if($value['field_741'] == $form_filed_id){
                    //             $camel_age++ ;
                    //         }
                    //     }              	
                    //     if($fvalue == "Cattle"){
                    //         if($value['field_750'] == $form_filed_id){
                    //             $cattel_age++ ;
                    //         }
                    //     } 
                    // }
                }                
            }
            array_push($data_array,$female,$male1,$male2);
            array_push($livestock_animal_gender_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $livestock_animal_gender_option_item_array;
	}

    public function animal_for_trade_1_graph_array($data){
		$animal_for_trade_1_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
       
       $submited_data = $this->db->order_by('s5.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_lr_body_condition');
        $this->db->where('status', 1);
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['id'];
            $form_filed_name = $option['name'];
		// for ($i=1; $i < 3; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			// $form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $color='#165DFF';
                    break;
                case '2':
                    $color='#FFB6BA';
                    break;
                case '3':
                    $color='#14C9C9';
                    break;
                case '4':
                    $color='#F7BA1E';
                    break;
                case '5':
                    $color='#717276';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {
                if(!empty($value['field_741'])){
                    $field_data = explode("&#44;", $value['field_741']);
                    foreach ($field_data as $fvalue) {

                        if($fvalue == "Camel"){
                            if($value['field_745'] == $form_filed_id){
                                $camel_age++ ;
                            }
                        }              	
                        if($fvalue == "Cattle"){
                            if($value['field_750'] == $form_filed_id){
                                $cattel_age++ ;
                            }
                        } 
                    }
                }                
            }
            array_push($data_array,$camel_age,$cattel_age);
            array_push($animal_for_trade_1_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_for_trade_1_option_item_array;
	}

    public function animal_for_trade_2_graph_array($data){
		$animal_for_trade_2_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
       
       $submited_data = $this->db->order_by('s5.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_sr_body_condition');
        $this->db->where('status', 1);
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['id'];
            $form_filed_name = $option['name'];
		// for ($i=1; $i < 3; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			// $form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $color='#165DFF';
                    break;
                case '2':
                    $color='#FFB6BA';
                    break;
                case '3':
                    $color='#14C9C9';
                    break;
                case '4':
                    $color='#F7BA1E';
                    break;
                case '5':
                    $color='#717276';
					break;
				default:
					# code...
					break;
			}
				
            foreach ($submited_data as $value) {
                if(!empty($value['field_741'])){
                    $field_data = explode("&#44;", $value['field_741']);
                    foreach ($field_data as $fvalue) {

                        if($fvalue == "Goats"){
                            if($value['field_755'] == $form_filed_id){
                                $goat_age++ ;
                            }
                        } 
                        if($fvalue == "Sheep"){
                            if($value['field_760'] == $form_filed_id){
                                $sheep_age++ ;
                            }
                        } 
                    }
                }
            }
            array_push($data_array,$goat_age,$sheep_age);
            array_push($animal_for_trade_2_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $animal_for_trade_2_option_item_array;
	}

    public function final_selling_price_1_graph_array($data){
		$final_selling_price_1_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
       
       $submited_data = $this->db->order_by('s5.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
       
		for ($i=1; $i < 3; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    //1192  form field_multiple ID
                    $form_filed_name = "Kenya";
                    $color='#165DFF';
					break;
				case '2':
                    //1193  form field_multiple ID
                    $form_filed_name = "Ethopia";
                    $color='#14C9C9';
					break;
				default:
					# code...
					break;
			}
            $temp=0;
            foreach ($submited_data as $value) {
                $temp=0;
                if($form_filed_id == 1){
                    if(!empty($value['field_741'])){
                        $field_data = explode("&#44;", $value['field_741']);
                        foreach ($field_data as $fvalue) {
    
                            if($fvalue == "Camel"){
                                $temp = $value['field_743'];
                                $camel_age = $camel_age +$temp ;                        
                            } 
                            else if($fvalue == "Cattle"){
                                $temp = $value['field_748'];
                                $cattel_age = $cattel_age +$temp ; 
                            }
                        }
                    }
                     
                }   
                else if($form_filed_id == 2){   
                    if(!empty($value['field_741'])){
                        $field_data = explode("&#44;", $value['field_741']);
                        foreach ($field_data as $fvalue) {
    
                            if($fvalue == "Camel"){
                                $temp = $value['field_744'];
                                $camel_age = $camel_age +$temp ;                        
                            }              	
                            else if($fvalue == "Cattle"){
                                $temp = $value['field_749'];
                                $cattel_age = $cattel_age +$temp ; 
                            } 
                        }
                    }
                    
                }
                
            }
            array_push($data_array,$camel_age,$cattel_age);
            array_push($final_selling_price_1_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $final_selling_price_1_option_item_array;
	}
    
    public function final_selling_price_2_graph_array($data){
		$final_selling_price_2_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
       
       $submited_data = $this->db->order_by('s5.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
       
		for ($i=1; $i < 3; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    //1192  form field_multiple ID
                    $form_filed_name = "Kenya";
                    $color='#165DFF';
					break;
				case '2':
                    //1193  form field_multiple ID
                    $form_filed_name = "Ethopia";
                    $color='#14C9C9';
					break;
				default:
					# code...
					break;
			}
            $temp=0;
            foreach ($submited_data as $value) {
                $temp=0;
                if($form_filed_id == 1){
                    if(!empty($value['field_741'])){
                        $field_data = explode("&#44;", $value['field_741']);
                        foreach ($field_data as $fvalue) {
    
                            if($fvalue == "Goats"){
                                $temp = $value['field_753'];
                                $goat_age = $goat_age +$temp ;                        
                            } 
                            else if($fvalue == "Sheep"){
                                $temp = $value['field_758'];
                                $sheep_age = $sheep_age +$temp ; 
                            }
                        }
                    }
                     
                }   
                else if($form_filed_id == 2){   
                    if(!empty($value['field_741'])){
                        $field_data = explode("&#44;", $value['field_741']);
                        foreach ($field_data as $fvalue) {
    
                            if($fvalue == "Goats"){
                                $temp = $value['field_754'];
                                $goat_age = $goat_age +$temp ;                        
                            }              	
                            else if($fvalue == "Sheep"){
                                $temp = $value['field_759'];
                                $sheep_age = $sheep_age +$temp ; 
                            } 
                        }
                    }
                    
                }
                
            }
            array_push($data_array,$goat_age,$sheep_age);
            array_push($final_selling_price_2_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'data' => $data_array
                ));
		}
		return $final_selling_price_2_option_item_array;
	}

    public function final_selling_price_graph_array($data){
		$final_selling_price_option_item_array = array();
        
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
        $submited_data = $this->db->order_by('s5.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_animal_type');
        $this->db->where('status', 1);
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['animal_type_id'];
            $form_filed_name = $option['name'];
		// for ($i=1; $i < 3; $i++) { 
            $camel_age=0;
            $cattel_age=0;
            $goat_age=0;
            $sheep_age=0;
            $data_array= array();
			// $form_filed_id = $i;
			switch ($form_filed_id) {
				case '1':
                    $color='#165DFF';
                    break;
                case '2':
                    $color='#FFB6BA';
                    break;
                case '3':
                    $color='#14C9C9';
                    break;
                case '4':
                    $color='#F7BA1E';
                    break;
                case '5':
                    $color='#717276';
					break;
				default:
					# code...
					break;
			}		
			
            $totalUpload = 0;				
			$temp=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    if(!empty($value['field_741'])){
                        $field_data = explode("&#44;", $value['field_741']);
                        foreach ($field_data as $fvalue) {
                            if($form_filed_name == $fvalue){
                                switch ($fvalue) {
                                    case "Camel":
                                            if($value['field_743'] != NULL)
                                            {
                                                $temp = $value['field_743'];
                                                $totalUpload = $totalUpload + $temp ;
                                            } 
                                        break;
                                    case "Cattle":
                                            if($value['field_748'] != NULL)
                                            {
                                                $temp = $value['field_748'];
                                                $totalUpload = $totalUpload + $temp ;
                                            } 
                                        break;
                                    case "Goats":
                                            if($value['field_753'] != NULL)
                                            {
                                                $temp = $value['field_753'];
                                                $totalUpload = $totalUpload + $temp ;
                                            } 
                                        break;
                                    case "Sheep":
                                            if($value['field_758'] != NULL)
                                            {
                                                $temp = $value['field_758'];
                                                $totalUpload = $totalUpload + $temp ;
                                            } 
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                            }
                        }
                    }
                               				
				}
				array_push($final_selling_price_option_item_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $final_selling_price_option_item_array;
	}

    public function camel_selling_price_graph_array($data){
		$camel_selling_price_option_item_array = array();
        
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
        $submited_data = $this->db->order_by('s5.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['market_id'];
            $form_filed_name = $option['name'];			
			
            $totalUpload = 0;				
			$temp=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['market_id'] == $form_filed_id)
                    {
                        if($value['field_743'] != NULL)
                        {
                            $temp = $value['field_743'];
                            $totalUpload = $totalUpload + $temp ;
                        }
                    }                   				
				}
				array_push($camel_selling_price_option_item_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $camel_selling_price_option_item_array;
	}
    public function cattle_selling_price_graph_array($data){
		$cattle_selling_price_option_item_array = array();
        
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
        $submited_data = $this->db->order_by('s5.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['market_id'];
            $form_filed_name = $option['name'];			
			
            $totalUpload = 0;				
			$temp=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['market_id'] == $form_filed_id)
                    {
                        if($value['field_748'] != NULL)
                        {
                            $temp = $value['field_748'];
                            $totalUpload = $totalUpload + $temp ;
                        } 
                    }                   				
				}
				array_push($cattle_selling_price_option_item_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $cattle_selling_price_option_item_array;
	}
    public function goats_selling_price_graph_array($data){
		$goats_selling_price_option_item_array = array();
        
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
        $submited_data = $this->db->order_by('s5.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['market_id'];
            $form_filed_name = $option['name'];			
			
            $totalUpload = 0;				
			$temp=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['market_id'] == $form_filed_id)
                    {
                        if($value['field_753'] != NULL)
                        {
                            $temp = $value['field_753'];
                            $totalUpload = $totalUpload + $temp ;
                        } 
                    }                   				
				}
				array_push($goats_selling_price_option_item_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $goats_selling_price_option_item_array;
	}
    public function sheep_selling_price_graph_array($data){
		$sheep_selling_price_option_item_array = array();
        
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
        $submited_data = $this->db->order_by('s5.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['market_id'];
            $form_filed_name = $option['name'];			
			
            $totalUpload = 0;				
			$temp=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['market_id'] == $form_filed_id)
                    {
                        if($value['field_758'] != NULL)
                        {
                            $temp = $value['field_758'];
                            $totalUpload = $totalUpload + $temp ;
                        }
                    }                   				
				}
				array_push($sheep_selling_price_option_item_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $sheep_selling_price_option_item_array;
	}

    public function camel_volumes_graph_array($data){
		$camel_volumes_option_item_array = array();
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('survey11 as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s11.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s11.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s11.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s11.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s11.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s11.pa_verified_status', [1,2]);
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['market_id'];
            $form_filed_name = $option['name'];			
			
            $totalUpload = 0;				
			$temp=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['market_id'] == $form_filed_id)
                    {
                        if($value['field_861'] != NULL)
                        {
                            $temp = $value['field_861'];
                            $totalUpload = $totalUpload + $temp ;
                        }
                    }                   				
				}
				array_push($camel_volumes_option_item_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $camel_volumes_option_item_array;
	}

    public function cattle_volumes_graph_array($data){
		$cattle_volumes_option_item_array = array();
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('survey11 as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s11.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s11.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s11.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s11.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s11.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s11.pa_verified_status', [1,2]);
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['market_id'];
            $form_filed_name = $option['name'];			
			
            $totalUpload = 0;				
			$temp=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['market_id'] == $form_filed_id)
                    {
                        if($value['field_862'] != NULL)
                        {
                            $temp = $value['field_862'];
                            $totalUpload = $totalUpload + $temp ;
                        }
                    }                   				
				}
				array_push($cattle_volumes_option_item_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $cattle_volumes_option_item_array;
	}

    public function goats_volumes_graph_array($data){
		$goats_volumes_option_item_array = array();
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('survey11 as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s11.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s11.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s11.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s11.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s11.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s11.pa_verified_status', [1,2]);
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['market_id'];
            $form_filed_name = $option['name'];			
			
            $totalUpload = 0;				
			$temp=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['market_id'] == $form_filed_id)
                    {
                        if($value['field_863'] != NULL)
                        {
                            $temp = $value['field_863'];
                            $totalUpload = $totalUpload + $temp ;
                        }
                    }                   				
				}
				array_push($goats_volumes_option_item_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $goats_volumes_option_item_array;
	}

    public function sheep_volumes_graph_array($data){
		$sheep_volumes_option_item_array = array();
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('survey11 as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s11.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s11.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s11.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s11.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s11.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s11.pa_verified_status', [1,2]);
        $this->db->where('s11.status', 1);            
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['market_id'];
            $form_filed_name = $option['name'];			
			
            $totalUpload = 0;				
			$temp=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['market_id'] == $form_filed_id)
                    {
                        if($value['field_864'] != NULL)
                        {
                            $temp = $value['field_864'];
                            $totalUpload = $totalUpload + $temp ;
                        }
                    }                   				
				}
				array_push($sheep_volumes_option_item_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $sheep_volumes_option_item_array;
	}

    
    public function camel_cluster_volumes_graph_array($data){
		$camel_cluster_volumes_option_item_array = array();
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('survey11 as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s11.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s11.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s11.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s11.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s11.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s11.pa_verified_status', [1,2]);
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('lkp_cluster');
        $this->db->where('status', 1);
        $cluster_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];			
                
                $totalUpload = 0;				
                $temp=0;
                    foreach ($submited_data as $value) {
                        $temp=0;
                        if($value['market_id'] == $form_filed_id)
                        {
                            if($value['field_861'] != NULL)
                            {
                                $temp = $value['field_861'];
                                $totalUpload = $totalUpload + $temp ;
                            }
                        }                   				
                    }
                    
            }
            array_push($camel_cluster_volumes_option_item_array, array(
                'name' => $form_filed_name,
                'y' => $totalUpload
            ));
        }
		return $camel_cluster_volumes_option_item_array;
	}

    //upto here tab3 functions ends

    // from here tab4 starts
    public function animal_types_are_currently_grazing_graph_array($data){
		$animal_types_are_currently_grazing_option_item_array = array();

         // Get Survey submited Data
         $this->db->select('s9.*');
         $this->db->from('survey9 as s9');
         // $this->db->join('tbl_users AS tu', 'tu.user_id = s9.user_id');
         if(!empty($data['country_id'])) {
             $this->db->where('s9.country_id', $data['country_id']);
         }
         if(!empty($data['cluster_id'])) {
             $this->db->where('s9.cluster_id', $data['cluster_id']);
         }
         if(!empty($data['uai_id'])) {
             $this->db->where('s9.uai_id', $data['uai_id']);
         }
         if(!empty($data['sub_location_id'])) {
             $this->db->where('s9.sub_location_id', $data['sub_location_id']);
         }
         if(!empty($data['start_date']) && !empty($data['end_date'])){
             $this->db->where('DATE(s9.datetime) >=', $data['start_date']);
             $this->db->where('DATE(s9.datetime) <=', $data['end_date']);
         }
         $this->db->where_in('s9.pa_verified_status', [1,2]);
         $this->db->where('s9.status', 1);             
         
         $submited_data = $this->db->order_by('s9.id', 'DESC')->get()->result_array();
         // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        //  print_r($this->db->last_query());
        //  exit();

		// for ($i=1; $i < 5; $i++) { 
		// 	$form_filed_id = $i;
        $this->db->select('*');
        $this->db->from('form_field_multiple');
        $this->db->where('field_id', 782);
        $this->db->where('status', 1);
        $formfield_data = $this->db->get()->result_array();
        $form_filed_id=0;
        foreach ($formfield_data as $fvalue) {
            $form_filed_id++; 
            // $form_filed_id = $fvalue['multi_id'];
            $form_filed_value = $fvalue['value'];
            $form_filed_name = $fvalue['label'];
			
			switch ($form_filed_value) {
				case '1':
                    $color='#165DFF';
                    break;
                case '2':
                    $color='#FFB6BA';
                    break;
                case '3':
                    $color='#14C9C9';
                    break;
                case '4':
                    $color='#F7BA1E';
                    break;
                case '5':
                    $color='#717276';
					break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
				
				foreach ($submited_data as $value) {
                    
                    if(!empty($value['field_782'])){
                        $field_data = explode("&#44;", $value['field_782']);
                        foreach ($field_data as $fvalue) {
    
                            if($fvalue == $form_filed_value)
                            {
                                $totalUpload++ ;
                            }
                        }
                    }                        				
				}
				array_push($animal_types_are_currently_grazing_option_item_array, array(
						'name' => $form_filed_name,
                        'color' => $color,
						'y' => $totalUpload
					));
		}
		return $animal_types_are_currently_grazing_option_item_array;
	}

    public function protected_grazing_area_graph_array($data){
		$protected_grazing_area_option_item_array = array();

         // Get Survey submited Data
         $this->db->select('s9.*');
         $this->db->from('survey9 as s9');
         // $this->db->join('tbl_users AS tu', 'tu.user_id = s9.user_id');
         if(!empty($data['country_id'])) {
             $this->db->where('s9.country_id', $data['country_id']);
         }
         if(!empty($data['cluster_id'])) {
             $this->db->where('s9.cluster_id', $data['cluster_id']);
         }
         if(!empty($data['uai_id'])) {
             $this->db->where('s9.uai_id', $data['uai_id']);
         }
         if(!empty($data['sub_location_id'])) {
             $this->db->where('s9.sub_location_id', $data['sub_location_id']);
         }
         if(!empty($data['start_date']) && !empty($data['end_date'])){
             $this->db->where('DATE(s9.datetime) >=', $data['start_date']);
             $this->db->where('DATE(s9.datetime) <=', $data['end_date']);
         }
         $this->db->where_in('s9.pa_verified_status', [1,2]);
         $this->db->where('s9.status', 1);             
         
         $submited_data = $this->db->order_by('s9.id', 'DESC')->get()->result_array();
         // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
         // print_r($this->db->last_query());
         // exit();

		// for ($i=1; $i < 5; $i++) { 
		// 	$form_filed_id = $i;
        $this->db->select('*');
        $this->db->from('form_field_multiple');
        $this->db->where('field_id', 784);
        $this->db->where('status', 1);
        $formfield_data = $this->db->get()->result_array();
        $form_filed_id=0;
        foreach ($formfield_data as $fvalue) {
            // $form_filed_id++; 
            // $form_filed_id = $fvalue['multi_id'];
            $form_filed_value = $fvalue['value'];
            // $form_filed_name = $fvalue['label'];
			
			switch ($form_filed_value) {
				case 'Yes':
                    $color='#165DFF';
                    $form_filed_name='Protected';
                    break;
                case 'No':
                    $color='#FFB6BA';
                    $form_filed_name='Not protected';
                    break;
				default:
					# code...
					break;
			}
            $totalUpload = 0;
            foreach ($submited_data as $value) {
                if($value['field_784'] != NULL)
                {
                    if($value['field_784'] == $form_filed_value)
                    {
                        $totalUpload++ ;
                    }
                } 
                
                                    
            }
            array_push($protected_grazing_area_option_item_array, array(
                    'name' => $form_filed_name,
                    'color' => $color,
                    'y' => $totalUpload
                ));
		}
		return $protected_grazing_area_option_item_array;
	}

    public function rangeland_map_kml_graph_array($data){
		$rangeland_map_kml_option_item_array = array();

         // Get Survey submited Data
         $this->db->select('s9.*,tp.pasture_name,tp.pasture_type,tp.contributor_name');
         $this->db->from('survey9 as s9');
         $this->db->join('tbl_transect_pastures AS tp', 'tp.data_id = s9.transect_pasture_data_id');
         if(!empty($data['country_id'])) {
             $this->db->where('s9.country_id', $data['country_id']);
         }
         if(!empty($data['cluster_id'])) {
             $this->db->where('s9.cluster_id', $data['cluster_id']);
         }
         if(!empty($data['uai_id'])) {
             $this->db->where('s9.uai_id', $data['uai_id']);
         }
         if(!empty($data['sub_location_id'])) {
             $this->db->where('s9.sub_location_id', $data['sub_location_id']);
         }
         if(!empty($data['start_date']) && !empty($data['end_date'])){
             $this->db->where('DATE(s9.datetime) >=', $data['start_date']);
             $this->db->where('DATE(s9.datetime) <=', $data['end_date']);
         }
         $this->db->where_in('s9.pa_verified_status', [1,2]);
         $this->db->where('s9.status', 1);             
         
         $submited_data = $this->db->order_by('s9.id', 'DESC')->get()->result_array();
        //  $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        //  print_r($this->db->last_query());
        //  exit();
        foreach ($submited_data as $value) {
            $form_filed_value = $value['field_777'];
            $animal_type = $value['field_782'];
            $forage_type = $value['field_777'];
			$lanlang =array();
			$lanlang1 =array();
			$lanlangvalue =array();
			$popupdata =array();
            $lat=0;
            $lang=0;
            array_push($popupdata, array(
                'name' => $value['pasture_name'],
                'type' => $value['pasture_type'],
                'animal_type' => $animal_type,
                'forage_type' => $forage_type,
                'contributor_name' => $value['contributor_name']
            ));
			switch ($form_filed_value) {
				case 'Very scarce':
                    // $color='#165DFF';
                    $color='brown';
                    break;
                case 'Somewhat scarce':
                    // $color='#FFB6BA';
                    $color='orange';
                    break;
                case 'Available':
                    // $color='#14C9C9';
                    $color='red';
                    break;
                case 'Somewhat plenty':
                    // $color='#F7BA1E';
                    $color='blue';
                    break;
                case 'Very plenty':
                    // $color='#717276';
                    $color='green';
					break;
				default:
					# code...
					break;
			}
            if($value['field_788'] != NULL && $value['field_789'] != NULL ){
                $lanlang1 =array();
                $lat=(float)$value['field_788'];
                $lang=(float)$value['field_789'];
                array_push($lanlang1,$lat,$lang);
                array_push($lanlang,$lanlang1);
            }
            if($value['field_792'] != NULL && $value['field_793'] != NULL ){
                $lanlang1 =array();
                $lat=(float)$value['field_792'];
                $lang=(float)$value['field_793'];
                array_push($lanlang1,$lat,$lang);
                array_push($lanlang,$lanlang1);
            }
            if($value['field_796'] != NULL && $value['field_797'] != NULL ){
                $lanlang1 =array();
                $lat=(float)$value['field_796'];
                $lang=(float)$value['field_797'];
                array_push($lanlang1,$lat,$lang);
                array_push($lanlang,$lanlang1);
            }
            if($value['field_800'] != NULL && $value['field_801'] != NULL ){
                $lanlang1 =array();
                $lat=(float)$value['field_800'];
                $lang=(float)$value['field_801'];
                array_push($lanlang1,$lat,$lang);
                array_push($lanlang,$lanlang1);
            }
            if($value['field_804'] != NULL && $value['field_805'] != NULL ){
                $lanlang1 =array();
                $lat=(float)$value['field_804'];
                $lang=(float)$value['field_805'];
                array_push($lanlang1,$lat,$lang);
                array_push($lanlang,$lanlang1);
            }
            if($value['field_808'] != NULL && $value['field_809'] != NULL ){
                $lanlang1 =array();
                $lat=(float)$value['field_808'];
                $lang=(float)$value['field_809'];
                array_push($lanlang1,$lat,$lang);
                array_push($lanlang,$lanlang1);
            }
            if($value['field_813'] != NULL && $value['field_814'] != NULL ){
                $lanlang1 =array();
                $lat=(float)$value['field_813'];
                $lang=(float)$value['field_814'];
                array_push($lanlang1,$lat,$lang);
                array_push($lanlang,$lanlang1);
            }
            if($value['field_817'] != NULL && $value['field_818'] != NULL ){
                $lanlang1 =array();
                $lat=(float)$value['field_817'];
                $lang=(float)$value['field_818'];
                array_push($lanlang1,$lat,$lang);
                array_push($lanlang,$lanlang1);
            }
            if($value['field_821'] != NULL && $value['field_822'] != NULL ){
                $lanlang1 =array();
                $lat=(float)$value['field_821'];
                $lang=(float)$value['field_822'];
                array_push($lanlang1,$lat,$lang);
                array_push($lanlang,$lanlang1);
            }
            if($value['field_825'] != NULL && $value['field_826'] != NULL ){
                $lanlang1 =array();
                $lat=(float)$value['field_825'];
                $lang=(float)$value['field_826'];
                array_push($lanlang1,$lat,$lang);
                array_push($lanlang,$lanlang1);
            }
            if($value['field_829'] != NULL && $value['field_830'] != NULL ){
                $lanlang1 =array();
                $lat=(float)$value['field_829'];
                $lang=(float)$value['field_830'];
                array_push($lanlang1,$lat,$lang);
                array_push($lanlang,$lanlang1);
            }
            
            // array_push($lanlangvalue,$lanlang);
            array_push($rangeland_map_kml_option_item_array, array(
                    'latlng' => $lanlang,
                    'color' => $color,
                    'popupdata' => $popupdata
                ));
		}
		return $rangeland_map_kml_option_item_array;
	}

    // upto here tab4 ends

    //from here mobile dashboard charts starts

    public function sorghum_cluster_graph_array1($data){
		$sorghum_cluster_option_item_array = array();
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where('s7.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s7.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s7.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s7.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s7.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s7.datetime) <=', $data['end_date']);
        }
        $this->db->where('s7.cluster_id !=', NULL);
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_cluster');
        $this->db->where('status', 1);
        if(!empty($data['country_id'])) {
            $this->db->where('country_id', $data['country_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('cluster_id', $data['cluster_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        
        $cluster_list_array = array();
        foreach ($formfield_options as $ffvalue) {
            $cluster_name = $ffvalue['name'];
            array_push($cluster_list_array,$cluster_name);
        }
        // $currentDate = new DateTime();
        
        $data_array= array();
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }        
        $loop_count=$month;
        $currentDate = new DateTime();
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();       
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $cluster_loop_id=0;
            $month=$month-1;
            foreach ($formfield_options as $fvalue) {
                $cluster_id = $fvalue['cluster_id'];
                $cluster_name = $fvalue['name'];
                $total_upload=0;
                foreach ($submited_data as $value) {                    
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid ){                       
                        if($cluster_id==$value['cluster_id']){                                                        
                            if(!empty($value['field_583'])){
                                $temp=0;
                                $temp=$value['field_583'];
                                $total_upload=$total_upload+$temp;
                            }
                        }                        
                    }                     
                }
                array_push($data_array, array($i, $cluster_loop_id, $total_upload));
                $cluster_loop_id++;
            }
		} 
        array_push($sorghum_cluster_option_item_array, array(
                'month_list' => $month_list_array,
                'cluster_list' => $cluster_list_array,
                'data' => $data_array
            ));
		return $sorghum_cluster_option_item_array;
	}
    public function camel_selling_price_date_graph_array($data){
		$camel_selling_price_option_item_array = array();
        
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        // if(!empty($data['market_id'])) {
        //     $this->db->where('s5.market_id', $data['market_id']);
        // }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
        $submited_data = $this->db->order_by('s5.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();

        // $this->db->select('*');
        // $this->db->from('lkp_market');
        // $this->db->where('status', 1);
        // if(!empty($data['market_id'])) {
        //     $this->db->where('market_id', $data['market_id']);
        // }
        // $formfield_options = $this->db->get()->result_array();
        // foreach ($formfield_options as $option) {
		// 	$form_filed_id = $option['market_id'];
        //     $form_filed_name = $option['name'];	
        $month_list_array= array();
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $startDate = new DateTime( $data['start_date']);
            $endDate = new DateTime( $data['end_date']);
            $interval = $startDate->diff($endDate);
            $month = ($interval->y * 12) + $interval->m;  
        }else{
            $month=6;            
        }        
        $loop_count=$month;
        $currentDate = new DateTime();
        // Loop for last 6 months
        for ($i = 0; $i <= $loop_count; $i++) {
            // Subtract one month from the current date
            $valuereduce = -$month;            
            $currentDate1 = $currentDate->modify(''.$valuereduce.' month'); 
            $currentDate = new DateTime();       
            // Format the date as per your requirement
            $formattedDate = $currentDate1->format('M-Y');
            $formattedDateid = $currentDate1->format('m');
            $formattedYearid = $currentDate1->format('y');
            array_push($month_list_array,$formattedDate);
            $form_filed_name = $formattedDate;
			$form_filed_id = $i;
            $cluster_loop_id=0;
            $month=$month-1;		
			

            $totalUpload = 0;				
			$temp=0;
				foreach ($submited_data as $value) {
                    $temp=0;
                    if(date('m',strtotime($value['datetime'])) == $formattedDateid && date('y',strtotime($value['datetime'])) == $formattedYearid )
                    {
                        if($value['field_743'] != NULL)
                        {
                            $temp = $value['field_743'];
                            $totalUpload = $totalUpload + $temp ;
                        }
                    }                   				
				}
				array_push($camel_selling_price_option_item_array, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $camel_selling_price_option_item_array;
	}
    public function camel_volumes_date_graph_array($data){
		$camel_volumes_date_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('survey11 as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s11.country_id', $data['country_id']);
        }
        // if(!empty($data['market_id'])) {
        //     $this->db->where('s11.market_id', $data['market_id']);
        // }
        // if(!empty($data['cluster_id'])) {
        //     $this->db->where('s11.cluster_id', $data['cluster_id']);
        // }
        // if(!empty($data['uai_id'])) {
        //     $this->db->where('s11.uai_id', $data['uai_id']);
        // }
        // if(!empty($data['sub_location_id'])) {
        //     $this->db->where('s11.sub_location_id', $data['sub_location_id']);
        // }
        // if(!empty($data['start_date']) && !empty($data['end_date'])){
        //     $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
        //     $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        // }
        $this->db->where_in('s11.pa_verified_status', [1,2]);
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
            $form_filed_name =$option['name'];
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
            $data_array= array();
            while ($startDate <= $endDate) {
                // Output the week's start and end dates
                $loop_Start_date =$startDate->format('Y-m-d');
                // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+6 days');
                $loop_end_date =$startDate->format('Y-m-d');
                // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+1 day');
                // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                $weeknumber =date('W',strtotime($loop_Start_date));

                $i++; 
                $totalUpload =0;
                $unique_user = array();
                $unique_user_count=0;
                foreach ($submited_data as $value) {

                        if($option['market_id'] == $value['market_id'])
                        {
                            if($value['field_861'] != NULL)
                            {
                                if($weeknumber == date('W',strtotime($value['datetime']))){
                                    $temp = $value['field_861'];
                                    $totalUpload = $totalUpload + $temp ;
                                    if (!in_array($value['user_id'] , $unique_user)) {
                                        array_push($unique_user,$value['user_id']);
                                    }
                                }
                            }
                            
                        }
                        
                } 
                // print_r($totalUpload);
                // print_r('pre');
                $unique_user_count = count($unique_user);
                if($unique_user_count !=0){
                    $totalUpload = round($totalUpload/$unique_user_count,0);
                }
                // print_r($unique_user_count);
                // print_r('pre');
                array_push($data_array,$totalUpload);               
            }
            array_push($camel_volumes_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $camel_volumes_date_graph_array;
	}
    public function cattle_volumes_date_graph_array($data){
		$cattle_volumes_date_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('survey11 as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s11.country_id', $data['country_id']);
        }
        // if(!empty($data['market_id'])) {
        //     $this->db->where('s11.market_id', $data['market_id']);
        // }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s11.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s11.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s11.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s11.pa_verified_status', [1,2]);
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
            $form_filed_name =$option['name'];
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
            $data_array= array();
            while ($startDate <= $endDate) {
                // Output the week's start and end dates
                $loop_Start_date =$startDate->format('Y-m-d');
                // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+6 days');
                $loop_end_date =$startDate->format('Y-m-d');
                // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+1 day');
                // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                $weeknumber =date('W',strtotime($loop_Start_date));

                $i++; 
            
                $totalUpload =0;
                $unique_user = array();
                $unique_user_count=0;
                foreach ($submited_data as $value) {

                        if($option['market_id'] == $value['market_id'])
                        {
                            if($value['field_862'] != NULL)
                            {
                                if($weeknumber == date('W',strtotime($value['datetime']))){
                                    $temp = $value['field_862'];
                                    $totalUpload = $totalUpload + $temp ;
                                    if (!in_array($value['user_id'] , $unique_user)) {
                                        array_push($unique_user,$value['user_id']);
                                    }
                                }
                            }
                            
                        }
                        
                } 
                $unique_user_count = count($unique_user);
                if($unique_user_count !=0){
                    $totalUpload = round($totalUpload/$unique_user_count,0);
                }
                array_push($data_array,$totalUpload);               
            }
            array_push($cattle_volumes_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $cattle_volumes_date_graph_array;
	}
    public function goats_volumes_date_graph_array($data){
		$goats_volumes_date_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('survey11 as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s11.country_id', $data['country_id']);
        }
        // if(!empty($data['market_id'])) {
        //     $this->db->where('s11.market_id', $data['market_id']);
        // }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s11.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s11.uai_id', $data['uai_id']);
        }
        // if(!empty($data['sub_location_id'])) {
        //     $this->db->where('s11.sub_location_id', $data['sub_location_id']);
        // }
        // if(!empty($data['start_date']) && !empty($data['end_date'])){
        //     $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
        //     $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        // }
        $this->db->where_in('s11.pa_verified_status', [1,2]);
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
            $form_filed_name =$option['name'];
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
            $data_array= array();
            while ($startDate <= $endDate) {
                // Output the week's start and end dates
                $loop_Start_date =$startDate->format('Y-m-d');
                // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+6 days');
                $loop_end_date =$startDate->format('Y-m-d');
                // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+1 day');
                // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                $weeknumber =date('W',strtotime($loop_Start_date));

                $i++; 
            
                $totalUpload =0;
                $unique_user = array();
                $unique_user_count=0;
                foreach ($submited_data as $value) {

                    if($option['market_id'] == $value['market_id'])
                    {
                        if($value['field_863'] != NULL)
                        {
                            if($weeknumber == date('W',strtotime($value['datetime']))){
                                $temp = $value['field_863'];
                                $totalUpload = $totalUpload + $temp ;
                                if (!in_array($value['user_id'] , $unique_user)) {
                                    array_push($unique_user,$value['user_id']);
                                }
                            }
                        }
                        
                    }
                } 
                $unique_user_count = count($unique_user);
                if($unique_user_count !=0){
                    $totalUpload = round($totalUpload/$unique_user_count,0);
                }
                array_push($data_array,$totalUpload);               
            }
            array_push($goats_volumes_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $goats_volumes_date_graph_array;
	}
    public function sheep_volumes_date_graph_array($data){
		$sheep_volumes_date_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('survey11 as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s11.country_id', $data['country_id']);
        }
        // if(!empty($data['market_id'])) {
        //     $this->db->where('s11.market_id', $data['market_id']);
        // }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s11.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s11.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s11.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s11.pa_verified_status', [1,2]);
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
            $form_filed_name =$option['name'];
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
            $data_array= array();
            while ($startDate <= $endDate) {
                // Output the week's start and end dates
                $loop_Start_date =$startDate->format('Y-m-d');
                // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+6 days');
                $loop_end_date =$startDate->format('Y-m-d');
                // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+1 day');
                // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                $weeknumber =date('W',strtotime($loop_Start_date));

                $i++;             
                $totalUpload =0;
                $unique_user = array();
                $unique_user_count=0;
                foreach ($submited_data as $value) {

                    if($option['market_id'] == $value['market_id'])
                    {
                        if($value['field_864'] != NULL)
                        {
                            if($weeknumber == date('W',strtotime($value['datetime']))){
                                $temp = $value['field_864'];
                                $totalUpload = $totalUpload + $temp ;
                                if (!in_array($value['user_id'] , $unique_user)) {
                                    array_push($unique_user,$value['user_id']);
                                }
                            }
                        }
                        
                    }
                } 
                $unique_user_count = count($unique_user);
                if($unique_user_count !=0){
                    $totalUpload = round($totalUpload/$unique_user_count,0);
                }
                array_push($data_array,$totalUpload);               
            }
            array_push($sheep_volumes_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $sheep_volumes_date_graph_array;
	}

    public function camel_final_price_date_graph_array($data){
		$camel_final_price_date_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }
        
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where_in('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
        $submited_data = $this->db->order_by('s5.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
        
            
                $form_filed_name =$option['name'];
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
                    $data_array= array();
                    while ($startDate <= $endDate) {
                        // Output the week's start and end dates
                        $loop_Start_date =$startDate->format('Y-m-d');
                        // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+6 days');
                        $loop_end_date =$startDate->format('Y-m-d');
                        // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+1 day');
                        // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                        $weeknumber =date('W',strtotime($loop_Start_date));

                        $i++; 
                        
                        $form_filed_id = $i;
                        $totalUpload =0;
                        $loopCount =0;
                        // $unique_user = array();
                        // $unique_user_count=0;
                        foreach ($submited_data as $value) {
                        
                            if($option['market_id'] == $value['market_id'])
                            {
                                if($value['field_743'] != NULL)
                                {
                                    // if(date('m',strtotime($loop_Start_date)) == date('m',strtotime($value['datetime']))){
                                        if($weeknumber == date('W',strtotime($value['datetime']))){
                                            $temp = $value['field_743'];
                                            $totalUpload = $totalUpload + $temp ;
                                            // if (!in_array($value['user_id'] , $unique_user)) {
                                            //     array_push($unique_user,$value['user_id']);
                                            // }
                                            $loopCount++;
                                        }
                                    // }
                                }
                            }
                            
                        }
                        // $unique_user_count = count($unique_user);
                        // if($unique_user_count !=0){
                        //     $totalUpload = round($totalUpload/$unique_user_count,0);
                        // }
                        if($loopCount !=0){
                            $totalUpload = round($totalUpload/$loopCount,0);
                        }
                        array_push($data_array,$totalUpload); 
                    } 
                array_push($camel_final_price_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));                
           
            
		}
		return $camel_final_price_date_graph_array;
	}

    public function cattle_final_price_date_graph_array($data){
		$cattle_final_price_date_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }
        
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where_in('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
        $submited_data = $this->db->order_by('s5.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
            $form_filed_name =$option['name'];
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
            $data_array= array();
            while ($startDate <= $endDate) {
                // Output the week's start and end dates
                $loop_Start_date =$startDate->format('Y-m-d');
                // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+6 days');
                $loop_end_date =$startDate->format('Y-m-d');
                // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+1 day');
                // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                $weeknumber =date('W',strtotime($loop_Start_date));

                $i++; 
                
                $form_filed_id = $i;
                $totalUpload =0;
                // $unique_user = array();
                // $unique_user_count=0;
                $loopCount =0;
                foreach ($submited_data as $value) {

                    if($option['market_id'] == $value['market_id'])
                    {
                        if($value['field_748'] != NULL)
                        {
                            if($weeknumber == date('W',strtotime($value['datetime']))){
                                // if(date('m',strtotime($loop_Start_date)) == date('m',strtotime($value['datetime']))){
                                    $temp = $value['field_748'];
                                    $totalUpload = $totalUpload + $temp ;
                                    // if (!in_array($value['user_id'] , $unique_user)) {
                                    //     array_push($unique_user,$value['user_id']);
                                    // }
                                    $loopCount++;
                                // }
                            }
                        }
                        
                    }
                } 
                // print_r($totalUpload);
                // print_r('pre');
                // $unique_user_count = count($unique_user);
                // if($unique_user_count !=0){
                //     $totalUpload = round($totalUpload/$unique_user_count,0);
                // }
                if($loopCount !=0){
                    $totalUpload = round($totalUpload/$loopCount,0);
                }
                // print_r($unique_user_count);
                // print_r('pre');
                array_push($data_array,$totalUpload);               
            }
            array_push($cattle_final_price_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $cattle_final_price_date_graph_array;
	}

    public function goats_final_price_graph_array($data){
		$goats_final_price_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }
        
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where_in('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
        $submited_data = $this->db->order_by('s5.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
            $form_filed_name =$option['name'];
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
            $data_array= array();
            while ($startDate <= $endDate) {
                // Output the week's start and end dates
                $loop_Start_date =$startDate->format('Y-m-d');
                // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+6 days');
                $loop_end_date =$startDate->format('Y-m-d');
                // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+1 day');
                // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                $weeknumber =date('W',strtotime($loop_Start_date));

                $i++; 
                
                $form_filed_id = $i;
            
                $totalUpload =0;
                $loopCount =0;
                foreach ($submited_data as $value) {

                    if($option['market_id'] == $value['market_id'])
                    {
                        if($value['field_753'] != NULL)
                        {
                            if($weeknumber == date('W',strtotime($value['datetime']))){
                                $temp = $value['field_753'];
                                $totalUpload = $totalUpload + $temp ;
                                $loopCount++;
                            }
                        }
                        
                    }
                } 
                if($loopCount !=0){
                    $totalUpload = round($totalUpload/$loopCount,0);
                }
                array_push($data_array,$totalUpload);               
            }
            array_push($goats_final_price_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $goats_final_price_graph_array;
	}

    public function sheep_final_price_graph_array($data){
		$sheep_final_price_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }
        
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        if(!empty($data['market_id'])) {
            $this->db->where_in('s5.market_id', $data['market_id']);
        }
        if(!empty($data['cluster_id'])) {
            $this->db->where('s5.cluster_id', $data['cluster_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where('s5.uai_id', $data['uai_id']);
        }
        if(!empty($data['sub_location_id'])) {
            $this->db->where('s5.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s5.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s5.datetime) <=', $data['end_date']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
        $submited_data = $this->db->order_by('s5.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
            $form_filed_name =$option['name'];
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
            $data_array= array();
            while ($startDate <= $endDate) {
                // Output the week's start and end dates
                $loop_Start_date =$startDate->format('Y-m-d');
                // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+6 days');
                $loop_end_date =$startDate->format('Y-m-d');
                // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                $startDate->modify('+1 day');
                // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                $weeknumber =date('W',strtotime($loop_Start_date));

                $i++; 
                
                $form_filed_id = $i;
                // if(!empty($data['timeline_id'])){
                //     $weeknumber = date('W', strtotime($data['timeline_id']."-01"));
                //     // $form_filed_name ='Week'.$weeknumber;
                // }else{
                //     $weeknumber =date('W',strtotime($loop_Start_date));  
                //     // $form_filed_name ='Week'.$weeknumber; 
                // }
				
            
                $totalUpload =0;
                $loopCount =0;
                foreach ($submited_data as $value) {

                    if($option['market_id'] == $value['market_id'])
                    {
                        if($value['field_758'] != NULL)
                        {
                            if($weeknumber == date('W',strtotime($value['datetime']))){
                                $temp = $value['field_758'];
                                $totalUpload = $totalUpload + $temp ;
                                $loopCount++;
                            }
                        }
                        
                    }
                } 
                if($loopCount !=0){
                    $totalUpload = round($totalUpload/$loopCount,0);
                }
                array_push($data_array,$totalUpload);               
            }
            array_push($sheep_final_price_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $sheep_final_price_graph_array;
	}


    public function camel_index_date_graph_array($data){
		$camel_index_date_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }        
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
                $form_filed_name =$option['name'];
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
                    $data_array= array();
                    while ($startDate <= $endDate) {
                        // Output the week's start and end dates
                        $loop_Start_date =$startDate->format('Y-m-d');
                        // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+6 days');
                        $loop_end_date =$startDate->format('Y-m-d');
                        // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+1 day');
                        // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                        $weeknumber =date('W',strtotime($loop_Start_date));
                        $i++;                         
                        $form_filed_id = $i;
                        $totalUpload =0;
                        $loop_count =0;
                        $unique_user = array();
                        $unique_user_count=0;
                        foreach ($submited_data as $value) {                        
                            if($option['market_id'] == $value['market_id'])
                            {
                                if($value['field_580'] != NULL)
                                {
                                    if($weeknumber == date('W',strtotime($value['datetime']))){
                                        $temp = $value['field_580'];
                                        $totalUpload = $totalUpload + $temp ; 
                                        $loop_count++;  
                                        if (!in_array($value['user_id'] , $unique_user)) {
                                            array_push($unique_user,$value['user_id']);
                                        }                                     
                                    }
                                }
                            }                            
                        }
                        $unique_user_count = count($unique_user);
                        if($unique_user_count !=0){
                            $totalUpload = round($totalUpload/$unique_user_count,0);
                        }
                        array_push($data_array,$totalUpload); 
                    } 
                array_push($camel_index_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                )); 
		}
		return $camel_index_date_graph_array;
	}

    public function cattle_index_date_graph_array($data){
		$cattle_index_date_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }        
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
                $form_filed_name =$option['name'];
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
                    $data_array= array();
                    while ($startDate <= $endDate) {
                        // Output the week's start and end dates
                        $loop_Start_date =$startDate->format('Y-m-d');
                        // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+6 days');
                        $loop_end_date =$startDate->format('Y-m-d');
                        // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+1 day');
                        // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                        $weeknumber =date('W',strtotime($loop_Start_date));
                        $i++;                         
                        $form_filed_id = $i;
                        $totalUpload =0;
                        $loop_count =0;
                        $unique_user = array();
                        $unique_user_count=0;
                        foreach ($submited_data as $value) {                        
                            if($option['market_id'] == $value['market_id'])
                            {
                                if($value['field_581'] != NULL)
                                {
                                    if($weeknumber == date('W',strtotime($value['datetime']))){
                                        $temp = $value['field_581'];
                                        $totalUpload = $totalUpload + $temp ; 
                                        $loop_count++;  
                                        if (!in_array($value['user_id'] , $unique_user)) {
                                            array_push($unique_user,$value['user_id']);
                                        }                                     
                                    }
                                }
                            }                            
                        }
                        $unique_user_count = count($unique_user);
                        if($unique_user_count !=0){
                            $totalUpload = round($totalUpload/$unique_user_count,0);
                        }
                        array_push($data_array,$totalUpload); 
                    } 
                array_push($cattle_index_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                )); 
		}
		return $cattle_index_date_graph_array;
	}

    public function maize_index_date_graph_array($data){
		$maize_index_date_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }        
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
                $form_filed_name =$option['name'];
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
                    $data_array= array();
                    while ($startDate <= $endDate) {
                        // Output the week's start and end dates
                        $loop_Start_date =$startDate->format('Y-m-d');
                        // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+6 days');
                        $loop_end_date =$startDate->format('Y-m-d');
                        // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+1 day');
                        // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                        $weeknumber =date('W',strtotime($loop_Start_date));
                        $i++;                         
                        $form_filed_id = $i;
                        $totalUpload =0;
                        $loop_count =0;
                        $unique_user = array();
                        $unique_user_count=0;
                        foreach ($submited_data as $value) {                        
                            if($option['market_id'] == $value['market_id'])
                            {
                                if($value['field_582'] != NULL)
                                {
                                    if($weeknumber == date('W',strtotime($value['datetime']))){
                                        $temp = $value['field_582'];
                                        $totalUpload = $totalUpload + $temp ; 
                                        $loop_count++;  
                                        if (!in_array($value['user_id'] , $unique_user)) {
                                            array_push($unique_user,$value['user_id']);
                                        }                                     
                                    }
                                }
                            }                            
                        }
                        $unique_user_count = count($unique_user);
                        if($unique_user_count !=0){
                            $totalUpload = round($totalUpload/$unique_user_count,0);
                        }
                        array_push($data_array,$totalUpload); 
                    } 
                array_push($maize_index_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                )); 
		}
		return $maize_index_date_graph_array;
	}
    public function sugar_index_date_graph_array($data){
		$sugar_index_date_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }        
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
                $form_filed_name =$option['name'];
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
                    $data_array= array();
                    while ($startDate <= $endDate) {
                        // Output the week's start and end dates
                        $loop_Start_date =$startDate->format('Y-m-d');
                        // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+6 days');
                        $loop_end_date =$startDate->format('Y-m-d');
                        // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+1 day');
                        // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                        $weeknumber =date('W',strtotime($loop_Start_date));
                        $i++;                         
                        $form_filed_id = $i;
                        $totalUpload =0;
                        $loop_count =0;
                        $unique_user = array();
                        $unique_user_count=0;
                        foreach ($submited_data as $value) {                        
                            if($option['market_id'] == $value['market_id'])
                            {
                                if($value['field_588'] != NULL)
                                {
                                    if($weeknumber == date('W',strtotime($value['datetime']))){
                                        $temp = $value['field_588'];
                                        $totalUpload = $totalUpload + $temp ; 
                                        $loop_count++;  
                                        if (!in_array($value['user_id'] , $unique_user)) {
                                            array_push($unique_user,$value['user_id']);
                                        }                                     
                                    }
                                }
                            }                            
                        }
                        $unique_user_count = count($unique_user);
                        if($unique_user_count !=0){
                            $totalUpload = round($totalUpload/$unique_user_count,0);
                        }
                        array_push($data_array,$totalUpload); 
                    } 
                array_push($sugar_index_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                )); 
		}
		return $sugar_index_date_graph_array;
	}
    public function rice_index_date_graph_array($data){
		$rice_index_date_graph_array = array();
        // print_r($data['market_id']);exit();
        if(!empty($data['market_id'])){
            $market_name_list = array();
            $this->db->select('*');
            $this->db->from('lkp_market');
            $this->db->where('status', 1);
            if(!empty($data['market_id'])) {
                $this->db->where_in('market_id', $data['market_id']);
            }
            $formfield_options = $this->db->get()->result_array();
            // print_r($this->db->last_query());exit();
            foreach ($formfield_options as $option) {
                $form_filed_id = $option['market_id'];
                $form_filed_name = $option['name'];	
                array_push($market_name_list,$form_filed_name);
            }
        }        
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
       
       $submited_data = $this->db->order_by('s7.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        foreach ($formfield_options as $option) {
                $form_filed_name =$option['name'];
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
                    $data_array= array();
                    while ($startDate <= $endDate) {
                        // Output the week's start and end dates
                        $loop_Start_date =$startDate->format('Y-m-d');
                        // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+6 days');
                        $loop_end_date =$startDate->format('Y-m-d');
                        // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+1 day');
                        // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                        $weeknumber =date('W',strtotime($loop_Start_date));
                        $i++;                         
                        $form_filed_id = $i;
                        $totalUpload =0;
                        $loop_count =0;
                        $unique_user = array();
                        $unique_user_count=0;
                        foreach ($submited_data as $value) {                        
                            if($option['market_id'] == $value['market_id'])
                            {
                                if($value['field_589'] != NULL)
                                {
                                    if($weeknumber == date('W',strtotime($value['datetime']))){
                                        $temp = $value['field_589'];
                                        $totalUpload = $totalUpload + $temp ; 
                                        $loop_count++;  
                                        if (!in_array($value['user_id'] , $unique_user)) {
                                            array_push($unique_user,$value['user_id']);
                                        }                                     
                                    }
                                }
                            }                            
                        }
                        $unique_user_count = count($unique_user);
                        if($unique_user_count !=0){
                            $totalUpload = round($totalUpload/$unique_user_count,0);
                        }
                        array_push($data_array,$totalUpload); 
                    } 
                array_push($rice_index_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                )); 
		}
		return $rice_index_date_graph_array;
	}
    
    public function camel_animal_trade_date_graph_array($data){
		$camel_animal_trade_date_graph_array = array();
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
       
       $submited_data = $this->db->order_by('s5.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_lr_body_condition');
        $this->db->where('status', 1);
        $body_conditions = $this->db->get()->result_array();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where_in('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
            $form_filed_name = $option['name'];
            $data_array= array();
			$unique_user = array();
            $unique_user_count=0;
            foreach ($body_conditions as $bcvalue) {  
                $camel_age=0;
                $bc_value =    $bcvalue['id'];
                foreach ($submited_data as $value) {
                    if($option['market_id'] == $value['market_id'])
                    {
                        if(!empty($value['field_741'])){
                            $field_data = explode("&#44;", $value['field_741']);
                            foreach ($field_data as $fvalue) {
                                    if($fvalue == "Camel"){
                                        if($value['field_745'] == $bc_value){
                                            $camel_age++ ;
                                            if (!in_array($value['user_id'] , $unique_user)) {
                                                array_push($unique_user,$value['user_id']);
                                            }
                                        }
                                    } 
                            }
                        }                
                    }
                }
                $unique_user_count = count($unique_user);
                if($unique_user_count !=0){
                    $camel_age = round($camel_age/$unique_user_count,0);
                }
                array_push($data_array,$camel_age);
            }
            array_push($camel_animal_trade_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $camel_animal_trade_date_graph_array;
	}
    
    public function cattle_animal_trade_date_graph_array($data){
		$cattle_animal_trade_date_graph_array = array();
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
       
       $submited_data = $this->db->order_by('s5.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_lr_body_condition');
        $this->db->where('status', 1);
        $body_conditions = $this->db->get()->result_array();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where_in('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
            $form_filed_name = $option['name'];
            $data_array= array();			
            foreach ($body_conditions as $bcvalue) { 
                $cattel_age=0; 
                $bc_value =    $bcvalue['id'];
                $unique_user = array();
                $unique_user_count=0;
                foreach ($submited_data as $value) {
                    if($option['market_id'] == $value['market_id'])
                    {
                        if(!empty($value['field_741'])){
                            $field_data = explode("&#44;", $value['field_741']);
                            foreach ($field_data as $fvalue) {                                                	
                                    if($fvalue == "Cattle"){
                                        if($value['field_750'] == $bc_value){
                                            $cattel_age++ ;
                                            if (!in_array($value['user_id'] , $unique_user)) {
                                                array_push($unique_user,$value['user_id']);
                                            }
                                        }
                                    }
                            }
                        }                
                    }
                }
                $unique_user_count = count($unique_user);
                if($unique_user_count !=0){
                    $cattel_age = round($cattel_age/$unique_user_count,0);
                }
                array_push($data_array,$cattel_age);
            }
            array_push($cattle_animal_trade_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $cattle_animal_trade_date_graph_array;
	}

    public function goats_animal_trade_date_graph_array($data){
		$goats_animal_trade_date_graph_array = array();
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
       
       $submited_data = $this->db->order_by('s5.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_sr_body_condition');
        $this->db->where('status', 1);
        $body_conditions = $this->db->get()->result_array();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where_in('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
            $form_filed_name = $option['name'];
            
            $data_array= array();			
            foreach ($body_conditions as $bcvalue) {  
                $goats_age=0;
                $bc_value =    $bcvalue['id'];
                $unique_user = array();
                $unique_user_count=0;
                foreach ($submited_data as $value) {
                    if($option['market_id'] == $value['market_id'])
                    {
                        if(!empty($value['field_741'])){
                            $field_data = explode("&#44;", $value['field_741']);
                            foreach ($field_data as $fvalue) {                                                	
                                    if($fvalue == "Goats"){
                                        if($value['field_755'] == $bc_value){
                                            $goats_age++ ;
                                            if (!in_array($value['user_id'] , $unique_user)) {
                                                array_push($unique_user,$value['user_id']);
                                            }
                                        }
                                    }
                            }
                        }                
                    }
                }
                $unique_user_count = count($unique_user);
                if($unique_user_count !=0){
                    $goats_age = round($goats_age/$unique_user_count,0);
                }
                array_push($data_array,$goats_age);
            }
            array_push($goats_animal_trade_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $goats_animal_trade_date_graph_array;
	}
    public function sheep_animal_trade_date_graph_array($data){
		$sheep_animal_trade_date_graph_array = array();
        // Get Survey submited Data
        $this->db->select('s5.*');
        $this->db->from('survey5 as s5');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s5.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s5.country_id', $data['country_id']);
        }
        $this->db->where_in('s5.pa_verified_status', [1,2]);
        $this->db->where('s5.status', 1); 
       
       $submited_data = $this->db->order_by('s5.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_sr_body_condition');
        $this->db->where('status', 1);
        $body_conditions = $this->db->get()->result_array();
        $this->db->select('*');
        $this->db->from('lkp_market');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where_in('market_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
            $form_filed_name = $option['name'];
            
            $data_array= array();			
            foreach ($body_conditions as $bcvalue) {  
                $sheep_age=0;
                $bc_value =    $bcvalue['id'];
                $unique_user = array();
                $unique_user_count=0;
                foreach ($submited_data as $value) {
                    if($option['market_id'] == $value['market_id'])
                    {
                        if(!empty($value['field_741'])){
                            $field_data = explode("&#44;", $value['field_741']);
                            foreach ($field_data as $fvalue) {                                                	
                                    if($fvalue == "Sheep"){
                                        if($value['field_760'] == $bc_value){
                                            $sheep_age++ ;
                                            if (!in_array($value['user_id'] , $unique_user)) {
                                                array_push($unique_user,$value['user_id']);
                                            }
                                        }
                                    }
                            }
                        }                
                    }
                }
                $unique_user_count = count($unique_user);
                if($unique_user_count !=0){
                    $sheep_age = round($sheep_age/$unique_user_count,0);
                }
                array_push($data_array,$sheep_age);
            }
            array_push($sheep_animal_trade_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $sheep_animal_trade_date_graph_array;
	}


    public function camel_births_date_graph_array($data){
		$camel_births_date_graph_array = array();
        // Get Survey submited Data
        $this->db->select('s10.*');
        $this->db->from('survey10 as s10');
        if(!empty($data['country_id'])) {
            $this->db->where('s10.country_id', $data['country_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where_in('s10.uai_id', $data['uai_id']);
        }
        if(!empty($data['timeline_id'])){
            $firstDayOfMonth = date('Y-m-01', strtotime($data['timeline_id']."-01"));
            $month =date('m',strtotime($firstDayOfMonth));
            $year =date('Y',strtotime($firstDayOfMonth));
            $this->db->where('MONTH(s10.datetime) =', $month);
            $this->db->where('YEAR(s10.datetime) =', $year);
        }else{
            $current_date = date('Y-m-d');
            $month =date('m',strtotime($current_date));
            $year =date('Y',strtotime($current_date));
            $this->db->where('MONTH(s10.datetime) =', $month);
            $this->db->where('YEAR(s10.datetime) =', $year);
        }
        $this->db->where_in('s10.pa_verified_status', [1,2]);
        $this->db->where('s10.status', 1); 
       
       $submited_data = $this->db->order_by('s10.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        if(!empty($data['uai_id'])) {
            $this->db->where_in('uai_id', $data['uai_id']);
        }
        $this->db->where('country_id', $data['country_id']);
        $this->db->where('status', 1);
        $uai_list = $this->db->get()->result_array();
		for ($i=1; $i < 3; $i++) { 
            
            $none_count =0;
            $data_array= array();
			$form_filed_id = $i;
			switch ($form_filed_id) {
                case '1':
                    $form_filed_name = "Mature";
                    $color='#165DFF';
                    break;
                case '2':
                    $form_filed_name = "Young";
                    $color='#14C9C9';
                    break;
				case '3':
                    $form_filed_name = "Successful Births";
                    $color='#165DFF';
					break;
				case '4':
                    $form_filed_name = "Still Births";
                    $color='#14C9C9';
					break;
                
				default:
					# code...
					break;
			}
			foreach ($uai_list as $uvalue) {
                $uai_id=$uvalue['uai_id'];	
                $loop_count=0;
                $unique_user = array();
                $unique_user_count=0;
                foreach ($submited_data as $value) {
                    if($value['uai_id']==$uai_id){                        
                        $temp=0;
                        switch ($data['field1']) {
                            case '1':
                                // Camel   
                                switch ($form_filed_id) {
                                        case '1':
                                            $loop_value = $value['field_632'];
                                            break;
                                        case '2':
                                            $loop_value = $value['field_633'];
                                            break;
                                        case '3':
                                            $loop_value = $value['field_634'];
                                            break;
                                        case '4':
                                            $loop_value = $value['field_636'];
                                            break;
                                        default:
                                            # code...
                                            break;
                                    } 
                                    if($loop_value != NULL){
                                        $temp=$loop_value;
                                        $loop_count = $loop_count + $temp;
                                    }  
                                break;
                            case '2':
                                // Cattle
                                switch ($form_filed_id) {
                                    case '1':
                                        $loop_value = $value['field_867'];
                                        break;
                                    case '2':
                                        $loop_value = $value['field_868'];
                                        break;
                                    case '3':
                                        $loop_value = $value['field_869'];
                                        break;
                                    case '4':
                                        $loop_value = $value['field_871'];
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                                if($loop_value != NULL){
                                    $temp=$loop_value;
                                    $loop_count = $loop_count + $temp;
                                } 
                                break;
                            case '3':
                                // Goat
                                switch ($form_filed_id) {
                                    case '1':
                                        $loop_value = $value['field_874'];
                                        break;
                                    case '2':
                                        $loop_value = $value['field_875'];
                                        break;
                                    case '3':
                                        $loop_value = $value['field_876'];
                                        break;
                                    case '4':
                                        $loop_value = $value['field_878'];
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                                if($loop_value != NULL){
                                    $temp=$loop_value;
                                    $loop_count = $loop_count + $temp;
                                }
                                break;
                            case '4':
                                // Sheep
                                switch ($form_filed_id) {
                                    case '1':
                                        $loop_value = $value['field_881'];
                                        break;
                                    case '2':
                                        $loop_value = $value['field_882'];
                                        break;
                                    case '3':
                                        $loop_value = $value['field_883'];
                                        break;
                                    case '4':
                                        $loop_value = $value['field_885'];
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                                if($loop_value != NULL){
                                    $temp=$loop_value;
                                    $loop_count = $loop_count + $temp;
                                } 
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                        if (!in_array($value['user_id'] , $unique_user)) {
                            array_push($unique_user,$value['user_id']);
                        }
                    }
                }
                $unique_user_count = count($unique_user);
                if($unique_user_count !=0){
                    $loop_count = round($loop_count/$unique_user_count,0);
                }
                array_push($data_array,$loop_count);
            }
            // array_push($data_array,$camel_count,$goat_count,$sheep_count,$cattel_count);
            array_push($camel_births_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $camel_births_date_graph_array;
	}

    public function camel_deaths_date_graph_array($data){
		$camel_deaths_date_graph_array = array();
        // Get Survey submited Data
        $this->db->select('s10.*');
        $this->db->from('survey10 as s10');
        if(!empty($data['country_id'])) {
            $this->db->where('s10.country_id', $data['country_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where_in('s10.uai_id', $data['uai_id']);
        }
        if(!empty($data['timeline_id'])){
            $firstDayOfMonth = date('Y-m-01', strtotime($data['timeline_id']."-01"));
            $month =date('m',strtotime($firstDayOfMonth));
            $year =date('Y',strtotime($firstDayOfMonth));
            $this->db->where('MONTH(s10.datetime) =', $month);
            $this->db->where('YEAR(s10.datetime) =', $year);
        }else{
            $current_date = date('Y-m-d');
            $month =date('m',strtotime($current_date));
            $year =date('Y',strtotime($current_date));
            $this->db->where('MONTH(s10.datetime) =', $month);
            $this->db->where('YEAR(s10.datetime) =', $year);
        }
        $this->db->where_in('s10.pa_verified_status', [1,2]);
        $this->db->where('s10.status', 1); 
       
       $submited_data = $this->db->order_by('s10.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        if(!empty($data['uai_id'])) {
            $this->db->where_in('uai_id', $data['uai_id']);
        }
        $this->db->where('country_id', $data['country_id']);
        $this->db->where('status', 1);
        $uai_list = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('form_field_multiple');
        $this->db->where('field_id', 637);
        $this->db->where('label!=', 'Not applicable');
        $this->db->where('status', 1);
        $formfield_data = $this->db->get()->result_array();
        $form_filed_id=0;
        foreach ($formfield_data as $fvalue) {
            $form_filed_id++; 
            $data_array= array();
            $form_filed_value = $fvalue['value'];
            $form_filed_name = $fvalue['label'];
            
            switch ($form_filed_id) {
                case '1':
                    $color='#165DFF';
                    break;
                case '2':
                    $color='#FFB6BA';
                    break;
                case '3':
                    $color='#14C9C9';
                    break;
                case '4':
                    $color='#F7BA1E';
                    break;
                case '5':
                    $color='#717276';
                    break;
                case '6':
                    $color='#6FA1E7';
                    break;
                case '7':
                    $color='#C8E76F';
                    break;
                case '8':
                    $color='#5877A3';
                    break;
                case '9':
                    $color='#E49443';
                    break;
                default:
                    # code...
                    break;
            }
            $totalUpload = 0;
            // $unique_user = array();
            // $unique_user_count=0;
            foreach ($uai_list as $uvalue) {
                $uai_id=$uvalue['uai_id'];	
                $loop_count=0;  
                foreach ($submited_data as $value) {   
                    if($value['uai_id']==$uai_id)
                    { 
                        $temp=0;
                        switch ($data['field2']) {
                            case '1':
                                // Camel    
                                $loop_value = $value['field_637'];                                  
                                if($loop_value != NULL && $loop_value == $form_filed_value){
                                    $loop_count++;
                                } 
                                break;
                            case '2':
                                // Cattle
                                $loop_value = $value['field_872'];  
                                if($loop_value != NULL && $loop_value == $form_filed_value){
                                    $loop_count++;
                                } 
                                break;
                            case '3':
                                // Goat
                                $loop_value = $value['field_879'];  
                                if($loop_value != NULL && $loop_value == $form_filed_value){
                                    $loop_count++;
                                }
                                break;
                            case '4':
                                // Sheep
                                $loop_value = $value['field_886'];  
                                if($loop_value != NULL && $loop_value == $form_filed_value){
                                    $loop_count ++;
                                } 
                                break;
                            default:
                                # code...
                                break;
                        }
                        // if (!in_array($value['user_id'] , $unique_user)) {
                        //     array_push($unique_user,$value['user_id']);
                        // }
                    }
                }   
                // $unique_user_count = count($unique_user);
                // if($unique_user_count !=0){
                //     $loop_count = round($loop_count/$unique_user_count,0);
                // }                 
                array_push($data_array,$loop_count);
            }
            array_push($camel_deaths_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $camel_deaths_date_graph_array;
	}

    public function current_condition_date_graph_array($data){
		$current_condition_date_graph_array = array();
        // Get Survey submited Data
        $this->db->select('s9.*');
        $this->db->from('survey9 as s9');
        if(!empty($data['country_id'])) {
            $this->db->where('s9.country_id', $data['country_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where_in('s9.uai_id', $data['uai_id']);
        }
        if(!empty($data['timeline_id'])){
            $firstDayOfMonth = date('Y-m-01', strtotime($data['timeline_id']."-01"));
            $month =date('m',strtotime($firstDayOfMonth));
            $year =date('Y',strtotime($firstDayOfMonth));
            $this->db->where('MONTH(s9.datetime) =', $month);
            $this->db->where('YEAR(s9.datetime) =', $year);
        }else{
            $current_date = date('Y-m-d');
            $month =date('m',strtotime($current_date));
            $year =date('Y',strtotime($current_date));
            $this->db->where('MONTH(s9.datetime) =', $month);
            $this->db->where('YEAR(s9.datetime) =', $year);
        }
        $this->db->where_in('s9.pa_verified_status', [1,2]);
        $this->db->where('s9.status', 1); 
       
       $submited_data = $this->db->order_by('s9.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        if(!empty($data['uai_id'])) {
            $this->db->where_in('uai_id', $data['uai_id']);
        }
        $this->db->where('country_id', $data['country_id']);
        $this->db->where('status', 1);
        $uai_list = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('form_field_multiple');
        if($data['field2']==1){
            $field_id=777;
        }else if($data['field2']==2){
            $field_id=778;
        }
        $this->db->where('field_id', $field_id);
        $this->db->where('status', 1);
        $formfield_data = $this->db->get()->result_array();
        $form_filed_id=0;
        foreach ($formfield_data as $fvalue) {
            $form_filed_id++; 
            $data_array= array();
            $form_filed_value = $fvalue['value'];
            $form_filed_name = $fvalue['label'];
            
            switch ($form_filed_id) {
                case '1':
                    $color='#165DFF';
                    break;
                case '2':
                    $color='#FFB6BA';
                    break;
                case '3':
                    $color='#14C9C9';
                    break;
                case '4':
                    $color='#F7BA1E';
                    break;
                case '5':
                    $color='#717276';
                    break;
                case '6':
                    $color='#6FA1E7';
                    break;
                case '7':
                    $color='#C8E76F';
                    break;
                case '8':
                    $color='#5877A3';
                    break;
                case '9':
                    $color='#E49443';
                    break;
                default:
                    # code...
                    break;
            }
            $totalUpload = 0;
            $unique_user = array();
            $unique_user_count=0;
            foreach ($uai_list as $uvalue) {
                $uai_id=$uvalue['uai_id'];	
                $loop_count=0;  
                foreach ($submited_data as $value) {   
                    if($value['uai_id']==$uai_id)
                    { 
                        $temp=0;
                        switch ($data['field2']) {
                            case '1':
                                // Camel    
                                $loop_value = $value['field_777'];                                  
                                if($loop_value != NULL && $loop_value == $form_filed_value){
                                    $loop_count++;
                                } 
                                break;
                            case '2':
                                // Cattle
                                $loop_value = $value['field_778'];  
                                if($loop_value != NULL && $loop_value == $form_filed_value){
                                    $loop_count++;
                                } 
                                break;
                            default:
                                # code...
                                break;
                        }
                        if (!in_array($value['user_id'] , $unique_user)) {
                            array_push($unique_user,$value['user_id']);
                        }
                    }
                }  
                $unique_user_count = count($unique_user);
                if($unique_user_count !=0){
                    $loop_count = round($loop_count/$unique_user_count,0);
                }                  
                array_push($data_array,$loop_count);
            }
            array_push($current_condition_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));
		}
		return $current_condition_date_graph_array;
	}
    
    public function bale_dry_fodder_date_graph_array($data){
		$bale_dry_fodder_date_graph_array = array();
        // print_r($data['market_id']);exit();
        
        
        // Get Survey submited Data
        $this->db->select('s7.*');
        $this->db->from('survey7 as s7');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s7.user_id');
        if(!empty($data['country_id'])) {
            $this->db->where('s7.country_id', $data['country_id']);
        }
        if(!empty($data['uai_id'])) {
            $this->db->where_in('s7.uai_id', $data['uai_id']);
        }
        $this->db->where_in('s7.pa_verified_status', [1,2]);
        $this->db->where('s7.status', 1); 
        $submited_data = $this->db->order_by('s7.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        if(!empty($data['uai_id'])) {
            $this->db->where_in('uai_id', $data['uai_id']);
        }
        $this->db->where('country_id', $data['country_id']);
        $this->db->where('status', 1);
        $uai_list = $this->db->get()->result_array();
        foreach ($uai_list as $option) {
            $uai_id=$option['uai_id'];
            
                $form_filed_name =$option['uai'];
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
                    $data_array= array();
                    while ($startDate <= $endDate) {
                        // Output the week's start and end dates
                        $loop_Start_date =$startDate->format('Y-m-d');
                        // echo 'Week Start: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+6 days');
                        $loop_end_date =$startDate->format('Y-m-d');
                        // echo 'Week End: ' . $startDate->format('Y-m-d') . '<br>';
                        $startDate->modify('+1 day');
                        // $form_filed_name ='Week'.$i.'-'.date('M-Y', strtotime($loop_Start_date));
                        $weeknumber =date('W',strtotime($loop_Start_date));

                        $i++; 
                        
                        $form_filed_id = $i;
                        $totalUpload =0;
                        $loopcount=0;
                        $unique_user = array();
                        $unique_user_count=0;
                        foreach ($submited_data as $value) {
                        
                            if($option['uai_id'] == $value['uai_id'])
                            {
                                if($value['field_591'] != NULL)
                                {
                                    if($weeknumber == date('W',strtotime($value['datetime']))){
                                        $temp = $value['field_591'];
                                        $totalUpload = $totalUpload + $temp ;
                                        $loopcount++;
                                        if (!in_array($value['user_id'] , $unique_user)) {
                                            array_push($unique_user,$value['user_id']);
                                        }
                                    }
                                }
                            }
                            
                        }
                        $unique_user_count = count($unique_user);
                        if($unique_user_count !=0){
                            $totalUpload = round($totalUpload/$unique_user_count,0);
                        }
                        array_push($data_array,$totalUpload); 
                    } 
                array_push($bale_dry_fodder_date_graph_array, array(
                    'name' => $form_filed_name,
                    // 'color' => $color,
                    'data' => $data_array
                ));                
           
            
		}
		return $bale_dry_fodder_date_graph_array;
	}
    //mobile dashboard charts ends upto here
    public function insert_suer_feedback_data($data){
            // $category="";
			// $insert_data = array(
			// 	'category' => $category,
			// 	'country_id' => $country_id,
			// 	'market_id' => $market_id,
			// 	'user_id' => $this->session->userdata('login_id'),
			// 	'datetime' => date('Y-m-d H:i:s'),
			// 	'status' => 1
			// );
            foreach ($data['market_id'] as $value) {
                $insert_data = array(
                    'category' => $data['category'],
                    'country_id' => $data['country_id'],
                    'market_id' =>  $value,
                    'user_id' => $this->session->userdata('login_id'),
                    'datetime' => date('Y-m-d H:i:s'),
                    'status' => 1
                );
                // $insert_data = $this->security->xss_clean($insert_data);
                $insert_query = $this->db->insert('dissemination_role_report', $insert_data);
            }
    }
    
    public function f_m_ethiopia_market_data($data){
		$f_m_ethiopia_market_data = array();
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('dissemination_role_report as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        
        if(!empty($data['market_id'])) {
            $this->db->where('s11.market_id', $data['market_id']);
        }
        if(!empty($data['user_id'])) {
            $this->db->where('s11.user_id', $data['user_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where('s11.category', "Market Task");
        $this->db->where('s11.country_id', 1);  //ethiopia country filter        
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_market_map');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where('market_map_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['market_map_id'];
            $form_filed_name = $option['name'];			
			
            $totalUpload = 0;	
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['market_id'] == $form_filed_id)
                    {
                        if($value['user_id'] != NULL)
                        {
                            $totalUpload++ ;
                        }
                    }                   				
				}
				array_push($f_m_ethiopia_market_data, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $f_m_ethiopia_market_data;
	}
    public function f_m_kenya_market_data($data){
		$f_m_kenya_market_data = array();
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('dissemination_role_report as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        
        if(!empty($data['market_id'])) {
            $this->db->where('s11.market_id', $data['market_id']);
        }
        if(!empty($data['user_id'])) {
            $this->db->where('s11.user_id', $data['user_id']);
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where('s11.category', "Market Task");
        $this->db->where('s11.country_id', 2);  //kenya country filter        
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_market_map');
        $this->db->where('status', 1);
        if(!empty($data['market_id'])) {
            $this->db->where('market_map_id', $data['market_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['market_map_id'];
            $form_filed_name = $option['name'];			
			
            $totalUpload = 0;	
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['market_id'] == $form_filed_id)
                    {
                        if($value['user_id'] != NULL)
                        {
                            $totalUpload++ ;
                        }
                    }                   				
				}
				array_push($f_m_kenya_market_data, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $f_m_kenya_market_data;
	}
    
    public function f_u_ethiopia_hh_data($data){
		$f_u_ethiopia_hh_data = array();
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('dissemination_role_report as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        
    
        if(!empty($data['uai_id'])) {
            $this->db->where('s11.uai_id', $data['uai_id']);
        }
        if(!empty($data['user_id'])) {
            $this->db->where('s11.user_id', $data['user_id']);
        }
        $this->db->where('s11.category', "Household Task");
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where('s11.country_id', 1);  //ethiopia country filter        
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        $this->db->where('status', 1);
        if(!empty($data['uai_id'])) {
            $this->db->where('uai_id', $data['uai_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['uai_id'];
            $form_filed_name = $option['uai'];			
			
            $totalUpload = 0;	
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['uai_id'] == $form_filed_id)
                    {
                        if($value['user_id'] != NULL)
                        {
                            $totalUpload++ ;
                        }
                    }                   				
				}
				array_push($f_u_ethiopia_hh_data, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $f_u_ethiopia_hh_data;
	}
    public function f_u_ethiopia_tfc_data($data){
		$f_u_ethiopia_tfc_data = array();
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('dissemination_role_report as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        
    
        if(!empty($data['uai_id'])) {
            $this->db->where('s11.uai_id', $data['uai_id']);
        }
        if(!empty($data['user_id'])) {
            $this->db->where('s11.user_id', $data['user_id']);
        }
        
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where('s11.category', "Rangeland Task");
        $this->db->where('s11.country_id', 1);  //ethiopia country filter        
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        $this->db->where('status', 1);
        if(!empty($data['uai_id'])) {
            $this->db->where('uai_id', $data['uai_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['uai_id'];
            $form_filed_name = $option['uai'];			
			
            $totalUpload = 0;	
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['uai_id'] == $form_filed_id)
                    {
                        if($value['user_id'] != NULL)
                        {
                            $totalUpload++ ;
                        }
                    }                   				
				}
				array_push($f_u_ethiopia_tfc_data, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $f_u_ethiopia_tfc_data;
	}
    public function f_u_kenya_hh_data($data){
		$f_u_kenya_hh_data = array();
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('dissemination_role_report as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        
        if(!empty($data['uai_id'])) {
            $this->db->where('s11.uai_id', $data['uai_id']);
        }
        if(!empty($data['user_id'])) {
            $this->db->where('s11.user_id', $data['user_id']);
        }
        
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where('s11.category', "Household Task");
        $this->db->where('s11.country_id', 2);  //kenya country filter        
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        $this->db->where('status', 1);
        if(!empty($data['uai_id'])) {
            $this->db->where('uai_id', $data['uai_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['uai_id'];
            $form_filed_name = $option['uai'];			
			
            $totalUpload = 0;	
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['uai_id'] == $form_filed_id)
                    {
                        if($value['user_id'] != NULL)
                        {
                            $totalUpload++ ;
                        }
                    }                   				
				}
				array_push($f_u_kenya_hh_data, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $f_u_kenya_hh_data;
	}
    public function f_u_kenya_tfc_data($data){
		$f_u_kenya_tfc_data = array();
        
        // Get Survey submited Data
        $this->db->select('s11.*');
        $this->db->from('dissemination_role_report as s11');
        // $this->db->join('tbl_users AS tu', 'tu.user_id = s11.user_id');
        
        if(!empty($data['uai_id'])) {
            $this->db->where('s11.uai_id', $data['uai_id']);
        }
        if(!empty($data['user_id'])) {
            $this->db->where('s11.user_id', $data['user_id']);
        }
        
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(s11.datetime) >=', $data['start_date']);
            $this->db->where('DATE(s11.datetime) <=', $data['end_date']);
        }
        $this->db->where('s11.category', "Rangeland Task");
        $this->db->where('s11.country_id', 2);  //kenya country filter        
        $this->db->where('s11.status', 1);             
        
        $submited_data = $this->db->order_by('s11.id', 'DESC')->get()->result_array();
        // $totalUpload = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        // print_r($this->db->last_query());
        // exit();
        $this->db->select('*');
        $this->db->from('lkp_uai');
        $this->db->where('status', 1);
        if(!empty($data['uai_id'])) {
            $this->db->where('uai_id', $data['uai_id']);
        }
        $formfield_options = $this->db->get()->result_array();
        foreach ($formfield_options as $option) {
			$form_filed_id = $option['uai_id'];
            $form_filed_name = $option['uai'];			
			
            $totalUpload = 0;	
				foreach ($submited_data as $value) {
                    $temp=0;
                    if($value['uai_id'] == $form_filed_id)
                    {
                        if($value['user_id'] != NULL)
                        {
                            $totalUpload++ ;
                        }
                    }                   				
				}
				array_push($f_u_kenya_tfc_data, array(
						'name' => $form_filed_name,
						'y' => $totalUpload
					));
		}
		return $f_u_kenya_tfc_data;
	}
}
