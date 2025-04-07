<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');		
	}

    /*public function all_surveys(){
        $this->db->select('form.*, concat(first_name, " ", last_name) as username');
        $this->db->from('form');
        $this->db->join('tbl_users', 'tbl_users.user_id = form.added_by');
        $this->db->where('form.status', 1)->where('type', 'Survey');
        $all_survey = $this->db->get()->result_array();

        return $all_survey;
    }*/

    public function all_surveys(){

        $this->db->distinct();
        $this->db->select('lkp_project_id');
        $this->db->where('user_id', $this->session->userdata('login_id'));
        $this->db->where('project_user_loc_status', 1);
        $user_project = $this->db->get('rpt_project_partner_user_location')->result_array();

        $project_array = array();
        foreach ($user_project as $key => $project) {
            array_push($project_array, $project['lkp_project_id']);
        }

        if(count($project_array) == 0){
            $project_array = array(0);
        }

        $this->db->distinct();
        $this->db->select('form_id');
        $this->db->where_in('lkp_project_id', $project_array)->where('relation_status', 1);
        $form_ids = $this->db->get('rpt_form_relation')->result_array();

        $form_id_array = array();
        foreach ($form_ids as $key => $form) {
            array_push($form_id_array, $form['form_id']);
        }

        if(count($form_id_array) == 0){
            $form_id_array = array(0);
        }

        $this->db->select('form.id, form.title, form.description, form.type, form.pic_min, form.pic_max, form.location, form.datetime, form.dormant, form.status, concat(tbl_users.first_name, " ", tbl_users.last_name) as username,fr.lkp_project_id, proj.project_name');
        $this->db->from('form');
        $this->db->join('rpt_form_relation as fr', 'fr.form_id = form.id');
        $this->db->join('tbl_users', 'tbl_users.user_id = form.added_by');
        $this->db->join('lkp_projects as proj', 'proj.project_id = fr.lkp_project_id');
        if($this->session->userdata('role') != 1 && $this->session->userdata('role') != 2){
            $this->db->group_start();
            $this->db->or_where('fr.lkp_project_id', 1);
            $this->db->or_where('form.added_by', $this->session->userdata('login_id'));
            $this->db->group_end();            
        }
        //$this->db->where('form.type', 'Survey');
        $this->db->group_start();
        $this->db->where('form.type', 'Survey');
        $this->db->or_where('form.type', 'Activity');
        $this->db->group_end();
        $this->db->where('fr.lkp_project_id', 1);
        $this->db->where('form.status', 1);
        return $all_survey = $this->db->get()->result_array();
    }

    public function all_beneficiary(){
        $this->db->select('form.*, concat(first_name, " ", last_name) as username');
        $this->db->from('form');
        $this->db->join('tbl_users', 'tbl_users.user_id = form.added_by');
        $this->db->where('form.status', 1)->where('type', 'Beneficiary');
        //$this->db->where('form.added_by', $this->session->userdata('login_id'));
        $all_beneficiary = $this->db->get()->result_array();

        return $all_beneficiary;
    }

    public function date_wise_data($survey_id){
        $districts = $this->district_list();
        $startDate = '2020-06-03';

        // Declare an empty array for total upload
        $totalUploads = array();
          
        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');
      
        $endDate = new DateTime();
      
        $period = new DatePeriod(new DateTime($startDate), $interval, $endDate);
      
        // Use loop to store date into array
        foreach($period as $date) {
            $today = $date->format('Y-m-d');

            $this->db->select('ifd.id');
            $this->db->where('ifd.form_id', $survey_id);
            $this->db->where('DATE(ifd.reg_date_time) >=', $today.' 00:00');
            $this->db->where('DATE(ifd.reg_date_time) <=', $today.' 23:59');
            $total = $this->db->where('ifd.data_status', 1)->get('ic_form_data AS ifd')->num_rows();

            //Create current date upload array
            $upload = array(
                'date' => $today,
                'upload' => $total
            );

            //Get district wise record
            foreach($districts as $dist) {
                $this->db->select('ifd.id');
                $this->db->where('ifd.form_id', $survey_id);
                $this->db->where('ifd.district_id', $dist['district_id']);
                $this->db->where('DATE(ifd.reg_date_time) >=', $today.' 00:00');
                $this->db->where('DATE(ifd.reg_date_time) <=', $today.' 23:59');
                $total = $this->db->where('ifd.data_status', 1)->get('ic_form_data AS ifd')->num_rows();

                $upload['upload'.$dist['district_id']] = $total;
            }

            //Push to totalUploads Array
            array_push($totalUploads, $upload);
        }

        return array(
            'uploads' => $totalUploads,
            'districts' => $districts
        );
    }
    public function registration_data($survey_id)
    {
        $survey=$this->survey_details($survey_id);
        $fields=$survey['fields'];
        // echo '<pre>';print_r($fields);exit;
        $this->db->select('survey1.*, lkp_state.state_name as field_501, lkp_district.district_name as field_502, lkp_tehsil.tehsil_name as field_643, lkp_block.block_name as field_503, lkp_grampanchayat.grampanchayat_name as field_644, lkp_village.village_name as field_504, CONCAT(tbl_users.first_name," ", tbl_users.last_name) as user_id');
        $this->db->join('lkp_state', 'lkp_state.state_id=survey1.field_501');
        $this->db->join('lkp_district', 'lkp_district.district_id=survey1.field_502');
        $this->db->join('lkp_tehsil', 'lkp_tehsil.tehsil_id=survey1.field_643');
        $this->db->join('lkp_block', 'lkp_block.block_id=survey1.field_503');
        $this->db->join('lkp_grampanchayat','lkp_grampanchayat.grampanchayat_id=survey1.field_644');
        $this->db->join('lkp_village','lkp_village.village_id=survey1.field_504');
        $this->db->join('tbl_users','tbl_users.user_id=survey1.user_id');
        $data= $this->db->get('survey1')->result_array();
        foreach ($data as $key => $value) {
            $this->db->select('file_name');
            $this->db->where('data_id', $value['data_id'])->where('status', 1);
            $this->db->where('form_id', 1);
            $data[$key]['images'] = $this->db->get('ic_data_file')->result_array();
            
            // $date = new DateTime($value['added_date'], new DateTimeZone('UTC'));
            // $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
            // $data[$key]['added_date'] = $date->format('Y-m-d H:i:s');
        }
        return $data;

    }
    public function registration_data2($survey_id)
    {
        $survey=$this->survey_details($survey_id);
        $fields=$survey['fields'];
        // echo '<pre>';print_r($fields);exit;
        $this->db->select('survey2.*, lkp_state.state_name as field_528, lkp_district.district_name as field_529, lkp_tehsil.tehsil_name as field_530, lkp_block.block_name as field_531, lkp_grampanchayat.grampanchayat_name as field_533, lkp_village.village_name as field_534 , CONCAT(tbl_users.first_name," ", tbl_users.last_name) as user_id');
        $this->db->join('lkp_state', 'lkp_state.state_id=survey2.field_528');
        $this->db->join('lkp_district', 'lkp_district.district_id=survey2.field_529');
        $this->db->join('lkp_tehsil', 'lkp_tehsil.tehsil_id=survey2.field_530');
        $this->db->join('lkp_block', 'lkp_block.block_id=survey2.field_531');
        $this->db->join('lkp_grampanchayat','lkp_grampanchayat.grampanchayat_id=survey2.field_533');
        $this->db->join('lkp_village','lkp_village.village_id=survey2.field_534');
        $this->db->join('tbl_users','tbl_users.user_id=survey2.user_id');
        $data= $this->db->get('survey2')->result_array();
        foreach ($data as $key => $value) {
            $this->db->select('file_name');
            $this->db->where('data_id', $value['data_id'])->where('status', 1);
            $this->db->where('form_id', 2);
            $data[$key]['images'] = $this->db->get('ic_data_file')->result_array();
            
            // $date = new DateTime($value['added_date'], new DateTimeZone('UTC'));
            // $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
            // $data[$key]['added_date'] = $date->format('Y-m-d H:i:s');
        }
        return $data;

    }
    public function registration_data3($survey_id)
    {
        $survey=$this->survey_details($survey_id);
        $fields=$survey['fields'];
        // echo '<pre>';print_r($fields);exit;
        $this->db->select('survey3.*, lkp_state.state_name as field_585, lkp_district.district_name as field_586, lkp_tehsil.tehsil_name as field_587, lkp_block.block_name as field_588, lkp_grampanchayat.grampanchayat_name as field_591, lkp_village.village_name as field_592 , CONCAT(tbl_users.first_name," ", tbl_users.last_name) as user_id');
        $this->db->join('lkp_state', 'lkp_state.state_id=survey3.field_585');
        $this->db->join('lkp_district', 'lkp_district.district_id=survey3.field_586');
        $this->db->join('lkp_tehsil', 'lkp_tehsil.tehsil_id=survey3.field_587');
        $this->db->join('lkp_block', 'lkp_block.block_id=survey3.field_588');
        $this->db->join('lkp_grampanchayat','lkp_grampanchayat.grampanchayat_id=survey3.field_591');
        $this->db->join('lkp_village','lkp_village.village_id=survey3.field_592');
        $this->db->join('tbl_users','tbl_users.user_id=survey3.user_id');
        $data= $this->db->get('survey3')->result_array();
        foreach ($data as $key => $value) {
            $this->db->select('file_name');
            $this->db->where('data_id', $value['data_id'])->where('status', 1);
            $this->db->where('form_id', 3);
            $data[$key]['images'] = $this->db->get('ic_data_file')->result_array();
            
            // $date = new DateTime($value['added_date'], new DateTimeZone('UTC'));
            // $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
            // $data[$key]['added_date'] = $date->format('Y-m-d H:i:s');
        }
        return $data;

    }
    // public function registration_data(){
    //     $this->db->select('tblf.*, concat(tu.first_name, " ", tu.last_name) as username');
    //     $this->db->join('tbl_users AS tu', 'tu.user_id = tblf.added_by');
    //     $this->db->where('tblf.farmer_status', 1);
    //     if(isset($_POST['start_date']) && isset($_POST['end_date'])){
    //         $this->db->where('DATE(tblf.added_date) >=', $_POST['start_date']);
    //         $this->db->where('DATE(tblf.added_date) <=', $_POST['end_date']);
    //     }
    //     if(isset($_POST['division']) && !is_null($_POST['division'])){
    //         if(isset($_POST['division'])) $division = $this->input->post('division');
    //         $this->db->where_in('tblf.division_id', $division);
    //     }
    //     if(isset($_POST['circle']) && !is_null($_POST['circle'])){
    //         if(isset($_POST['circle'])) $circle = $this->input->post('circle');
    //         $this->db->where_in('tblf.circle_id', $circle);
    //     }
    //     if(isset($_POST['village']) && !is_null($_POST['village'])){
    //         if(isset($_POST['village'])) $village = $this->input->post('village');
    //         $this->db->where_in('tblf.village_id', $village);
    //     }
    //     if(isset($_POST['last_id'])){
    //         $this->db->where('tblf.farmer_id <', $_POST['last_id']);
    //         $this->db->limit(20);
    //     } else {
    //         $this->db->limit(50);
    //     }
    //     $data = $this->db->order_by('tblf.farmer_id', 'DESC')->get('tbl_farmers AS tblf')->result_array();
    //     // echo $this->db->last_query();exit;

    //     foreach ($data as $key => $value) {
    //         $this->db->select('file_name');
    //         $this->db->where('data_id', $value['data_id'])->where('status', 1);
    //         $this->db->where('form_id', 1);
    //         $data[$key]['images'] = $this->db->get('ic_data_file')->result_array();
            
    //         $date = new DateTime($value['added_date'], new DateTimeZone('UTC'));
    //         $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
    //         $data[$key]['added_date'] = $date->format('Y-m-d H:i:s');
    //     }

    //     return $data;
    // }

    public function plot_data(){
        $this->db->select('tblp.*, concat(tu.first_name, " ", tu.last_name) as username');
        $this->db->join('tbl_users AS tu', 'tu.user_id = tblp.added_by');
        $this->db->where('tblp.plot_status', 1);
        if(isset($_POST['start_date']) && isset($_POST['end_date'])){
            $this->db->where('DATE(tblp.added_date) >=', $_POST['start_date']);
            $this->db->where('DATE(tblp.added_date) <=', $_POST['end_date']);
        }
        if(isset($_POST['division']) && !is_null($_POST['division'])){
            if(isset($_POST['division'])) $division = $this->input->post('division');
            $this->db->where_in('tblp.division_id', $division);
        }
        if(isset($_POST['circle']) && !is_null($_POST['circle'])){
            if(isset($_POST['circle'])) $circle = $this->input->post('circle');
            $this->db->where_in('tblp.circle_id', $circle);
        }
        if(isset($_POST['village']) && !is_null($_POST['village'])){
            if(isset($_POST['village'])) $village = $this->input->post('village');
            $this->db->where_in('tblp.village_id', $village);
        }
        if(isset($_POST['last_id'])){
            $this->db->where('tblp.plot_id <', $_POST['last_id']);
        }
        if(isset($_POST['last_id'])){
            $this->db->where('tblp.plot_id <', $_POST['last_id']);
            $this->db->limit(20);
        } else {
            $this->db->limit(50);
        }
        $data = $this->db->order_by('tblp.plot_id', 'DESC')->get('tbl_plot AS tblp')->result_array();

        foreach ($data as $key => $value) {
            $this->db->select('file_name');
            $this->db->where('data_id', $value['data_id'])->where('status', 1);
            $this->db->where('form_id', 2);
            $data[$key]['images'] = $this->db->get('ic_data_file')->result_array();

            $date = new DateTime($value['added_date'], new DateTimeZone('UTC'));
            $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
            $data[$key]['added_date'] = $date->format('Y-m-d H:i:s');
        }

        return $data;
    }

    public function agreement_data(){
        $this->db->select('tbla.*, concat(tu.first_name, " ", tu.last_name) as username');
        $this->db->join('tbl_users AS tu', 'tu.user_id = tbla.added_by');
        $this->db->join('tbl_plot AS tp', 'tp.data_id = tbla.plot_data_id');
        $this->db->where('tbla.agreement_status', 1);
        if(isset($_POST['start_date']) && isset($_POST['end_date'])){
            $this->db->where('DATE(tbla.added_date) >=', $_POST['start_date']);
            $this->db->where('DATE(tbla.added_date) <=', $_POST['end_date']);
        }
        if(isset($_POST['division']) && !is_null($_POST['division'])){
            if(isset($_POST['division'])) $division = $this->input->post('division');
            $this->db->where_in('tp.division_id', $division);
        }
        if(isset($_POST['circle']) && !is_null($_POST['circle'])){
            if(isset($_POST['circle'])) $circle = $this->input->post('circle');
            $this->db->where_in('tp.circle_id', $circle);
        }
        if(isset($_POST['village']) && !is_null($_POST['village'])){
            if(isset($_POST['village'])) $village = $this->input->post('village');
            $this->db->where_in('tp.village_id', $village);
        }
        if(isset($_POST['last_id'])){
            $this->db->where('tbla.agreement_id <', $_POST['last_id']);
            $this->db->limit(20);
        } else {
            $this->db->limit(50);
        }
        $data = $this->db->order_by('tbla.agreement_id', 'DESC')->get('tbl_agreement AS tbla')->result_array();

        foreach ($data as $key => $value) {
            $this->db->select('file_name');
            $this->db->where('data_id', $value['agreement_data_id'])->where('status', 1);
            $this->db->where('form_id', 3);
            $data[$key]['images'] = $this->db->get('ic_data_file')->result_array();

            $date = new DateTime($value['added_date'], new DateTimeZone('UTC'));
            $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
            $data[$key]['added_date'] = $date->format('Y-m-d H:i:s');
        }

        return $data;
    }

    public function survey_data($survey_id, $district_id = NULL){
        $this->db->select('ifd.*, concat(tu.first_name, " ", tu.last_name) as username');
        $this->db->join('tbl_users AS tu', 'tu.user_id = ifd.user_id');
        $this->db->where('ifd.form_id', $survey_id)->where('ifd.data_status', 1);
        if(isset($_POST['start_date']) && isset($_POST['end_date'])){
            $this->db->where('DATE(ifd.reg_date_time) >=', $_POST['start_date']);
            $this->db->where('DATE(ifd.reg_date_time) <=', $_POST['end_date']);
        }
        if(isset($_POST['district']) || !is_null($district_id)){
            if(isset($_POST['district'])) $district_id = $this->input->post('district');
            $this->db->where_in('ifd.district_id', $district_id);
        }
        if(isset($_POST['user_ids'])){
            $this->db->where_in('ifd.user_id', $_POST['user_ids']);
        }
        if(isset($_POST['last_id'])){
            $this->db->where('ifd.id <', $_POST['last_id']);
        }
        $data = $this->db->limit(100)->order_by('ifd.id', 'DESC')->get('ic_form_data AS ifd')->result_array();

        foreach ($data as $key => $value) {
            $this->db->select('file_name');
            $this->db->where('data_id', $value['data_id'])->where('status', 1);
            $this->db->where('form_id', $survey_id);
            if($survey_id == 22){
                $this->db->limit(1);
            }
            $data[$key]['images'] = $this->db->get('ic_data_file')->result_array();

            $this->db->select('*');
            $this->db->where('data_id', $value['data_id'])->where('status', 1);
            $this->db->where('form_id', $survey_id);
            $data[$key]['location'] = $this->db->get('ic_data_location')->row_array();

            $this->db->distinct()->select('lp.partner_name');
            $this->db->join('rpt_project_partner_user_location AS rppul', 'rppul.lkp_partner_id = lp.partner_id');
            $this->db->where('rppul.user_id', $value['user_id'])->where('rppul.project_user_loc_status', 1);
            $partner = $this->db->where_in('rppul.lkp_project_id', 1)->get('lkp_partners AS lp')->row_array();
            $data[$key]['partner_name'] = $partner['partner_name'];

            $date = new DateTime($value['reg_date_time'], new DateTimeZone('UTC'));
            $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
            $data[$key]['reg_date_time'] = $date->format('Y-m-d H:i:s');
        }

        return $data;
    }

    public function activity_data($survey_id, $village_id){
        $this->db->select('ifd.*, concat(tu.first_name, " ", tu.last_name) as username');
        $this->db->join('tbl_users AS tu', 'tu.user_id = ifd.user_id');
        $this->db->where('ifd.form_id', $survey_id)->where('ifd.data_status', 1);
        $this->db->where('ifd.village_id', $village_id);
        if(isset($_POST['last_id'])){
            $this->db->where('ifd.id <', $_POST['last_id']);
        }
        $data = $this->db->limit(100)->order_by('ifd.id', 'DESC')->get('ic_form_data AS ifd')->result_array();

        foreach ($data as $key => $value) {
            $this->db->select('file_name');
            $this->db->where('data_id', $value['data_id'])->where('status', 1);
            $this->db->where('form_id', $survey_id);
            if($survey_id == 22){
                $this->db->limit(1);
            }
            $data[$key]['images'] = $this->db->get('ic_data_file')->result_array();

            $this->db->select('*');
            $this->db->where('data_id', $value['data_id'])->where('status', 1);
            $this->db->where('form_id', $survey_id);
            $data[$key]['location'] = $this->db->get('ic_data_location')->row_array();

            $this->db->distinct()->select('lp.partner_name');
            $this->db->join('rpt_project_partner_user_location AS rppul', 'rppul.lkp_partner_id = lp.partner_id');
            $this->db->where('rppul.user_id', $value['user_id'])->where('rppul.project_user_loc_status', 1);
            $partner = $this->db->where_in('rppul.lkp_project_id', 1)->get('lkp_partners AS lp')->row_array();
            $data[$key]['partner_name'] = $partner['partner_name'];

            $date = new DateTime($value['reg_date_time'], new DateTimeZone('UTC'));
            $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
            $data[$key]['reg_date_time'] = $date->format('Y-m-d H:i:s');
        }

        return $data;
    }

    public function district_list_with_survey_data($survey_id){
        date_default_timezone_set("Asia/Kolkata");
        $districts = $this->district_list();
        $startDate = date('Y-m-d').' 00:00';
        $endDate = date('Y-m-d').' 23:59';

        foreach ($districts as $key => $district) {
            $this->db->select('ifd.id');
            $this->db->where('ifd.district_id', $district['district_id']);
            $this->db->where('ifd.form_id', $survey_id)->where('ifd.data_status', 1);
            $districts[$key]['total'] = $this->db->get('ic_form_data AS ifd')->num_rows();

            $this->db->select('ifd.id')->from('ic_form_data AS ifd');
            $this->db->where('ifd.form_id', $survey_id)->where('ifd.data_status', 1);
            $this->db->where('ifd.district_id', $district['district_id']);
            $this->db->where('DATE(ifd.reg_date_time) >=', $startDate);
            $this->db->where('DATE(ifd.reg_date_time) <=', $endDate);
            $districts[$key]['total_today'] = $this->db->get()->num_rows();

            switch ($district['district_name']) {
                case 'Khordha':
                $districts[$key]['icon'] = 'pin1.png';
                break;

                case 'Puri':
                $districts[$key]['icon'] = 'pin2.png';
                break;

                case 'Koraput':
                $districts[$key]['icon'] = 'pin3.png';
                break;

                case 'Nabarangpur':
                $districts[$key]['icon'] = 'pin4.png';
                break;

                case 'Gajapati':
                $districts[$key]['icon'] = 'pin5.png';
                break;

                case 'Rayagada':
                $districts[$key]['icon'] = 'pin6.png';
                break;
            }
        }
        
        return $districts;
    }

    public function village_list_with_survey_data($survey_id, $district_id){
        $villages = $this->village_list();

        $this->db->select('ifd.id, ifd.form_data');
        $this->db->where('ifd.district_id', $district_id);
        $this->db->where('ifd.form_id', $survey_id)->where('ifd.data_status', 1);
        $district_total = $this->db->get('ic_form_data AS ifd')->result_array();

        //Get village field id
        $this->db->where('type', 'lkp_village')->where('form_id', $survey_id);
        $field = $this->db->where('status', 1)->get('form_field')->row_array();
        $village_field = 'field_'.$field['field_id'];

        foreach ($villages as $key => $village) {
            $totalUpload = 0;
            foreach ($district_total as $value) {
                $form_data = (array)json_decode($value['form_data']);
                if(isset($form_data[$village_field]) && $form_data[$village_field] == $village['village_id']) $totalUpload++;
            }
            $villages[$key]['total'] = $totalUpload;
        }
        
        return $villages;
    }

    // public function survey_details($survey_id){
        
    //     $form_details = $this->db->where('id', $survey_id)->where('status', 1)->get('form')->row_array();

    //     $this->db->select('*');
    //     $this->db->where("form_id", $survey_id)->where('status', 1);
    //     $survey_formfields = $this->db->get('form_field')->result_array();
        
    //     $result = array('fields' => $survey_formfields, 'form_details' => $form_details, 'form_id'=>$survey_id);

    //     return $result;
    // }
    

    public function field_details($field_id){
        $this->db->select('*');
        $this->db->where('field_id', $field_id);
        $data = $this->db->where('status', 1)->get('form_field')->row_array();

        switch ($data['type']) {
            case 'checkbox-group':
            case 'radio-group':
            case 'select':
                $this->db->select('multi_id, label, value');
                $this->db->where("field_id", $data['field_id'])->where('status', 1);
                $options = $this->db->get('form_field_multiple')->result_array();

                $data['options'] = $options;
                break;
            
            case 'lkp_gender':
                $this->db->select('id, type');
                $this->db->where('status', 1);
                $options = $this->db->get('lkp_gender')->result_array();

                $data['options'] = $options;
                break;

            case 'lkp_district':
            case 'lkp_block':
            case 'lkp_village':
                $this->db->select('district_id, district_name');
                $this->db->where('status', 1);
                $districts = $this->db->get('lkp_district')->result_array();

                $this->db->select('block_id, block_name');
                $this->db->where('block_status', 1);
                $blocks = $this->db->get('lkp_block')->result_array();
                
                $this->db->select('village_id, village_name');
                $this->db->where('village_status', 1);
                $villages = $this->db->get('lkp_village')->result_array();

                $data['districts'] = $districts;
                $data['blocks'] = $blocks;
                $data['villages'] = $villages;
                break;
        }

        return $data;
    }

    public function survey_data_details($id){
        $this->db->select('*');
        $this->db->where('id', $id)->where('data_status', 1);
        $data = $this->db->get('ic_form_data')->row_array();

        return $data;
    }

    public function partners_list(){
        $this->db->select('partner_id, partner_name');
        $this->db->where('status', 1);
        return $partners = $this->db->get('lkp_partners')->result_array();
    }

    public function centre_list(){
        $this->db->select('centre_id, centre_name');
        $this->db->where('status', 1);
        return $centre = $this->db->get('lkp_centre')->result_array();
    }

    public function batch_list(){
        $this->db->select('batch_id, batch_name');
        $this->db->where('status', 1);
        return $batch = $this->db->get('lkp_batch')->result_array();
    }

    public function trainee_list(){
        $this->db->select('trainee_id, trainee_name');
        $this->db->where('status', 1);
        return $trainee = $this->db->get('lkp_trainee')->result_array();
    }

    public function age_list(){
        $this->db->select('id, age');
        $this->db->where('status', 1);
        return $age = $this->db->get('lkp_age')->result_array();
    }

    public function state_list(){
        $this->db->select('state_id, state_name');
        $this->db->where('status', 1);
        return $state = $this->db->get('lkp_state')->result_array();
    }

    public function district_list($district_id = NULL){
        $this->db->select('district_id, district_name');
        $this->db->where('status', 1);
        return $state = $this->db->get('lkp_district')->result_array();
    }

    public function block_list(){
        $this->db->select('block_id, block_name');
        $this->db->where('block_status', 1);
        return $block = $this->db->get('lkp_block')->result_array();
    }

    public function village_list(){
        $this->db->select('village_id, village_name');
        $this->db->where('village_status', 1);
        return $village = $this->db->get('lkp_village')->result_array();
    }

    public function user_list($district_id = NULL){
        $this->db->distinct()->select('tu.user_id, concat(tu.first_name, " ", tu.last_name) as username');
        $this->db->join('rpt_project_partner_user_location AS rppul', 'rppul.user_id = tu.user_id');
        $this->db->where('rppul.lkp_project_id', 1)->where('rppul.project_user_loc_status', 1);
        if(!is_null($district_id)) {
        $this->db->where('rppul.lkp_district_id', $district_id);
        }
        return $users = $this->db->where('tu.status', 1)->get('tbl_users AS tu')->result_array();
    }


    public function check_record($data){
        $this->db->select('data_id');
        $this->db->where('data_id', $data['data_id'])->where('form_id', $data['survey_id'])->where('data_status', 1);
        return $record_status = $this->db->get('ic_form_data')->num_rows();
    }


    public function group_info($data){
        $this->db->select('GROUP_CONCAT(field_id) as field_ids');
        $this->db->where('type', 'group')->where('form_id', $data['survey_id'])->where('status', 1);
        $form_group_id = $this->db->get('form_field')->row_array();

        $form_group_id_array = explode(",", $form_group_id['field_ids']);

        $group_fields = array();

        foreach ($form_group_id_array as $key => $value) {

            $group_fields[$key]['group_fieldid'] = $value;

            $group_label = $this->db->select('label')->where('field_id', $value)->get('form_field')->row_array();

            $group_fields[$key]['group_label'] = $group_label['label'];
            
            $this->db->select('child_id');
            $this->db->where('form_id', $data['survey_id'])->where('field_id', $value);
            $this->db->where('status', 1);
            $group_childid = $this->db->get('form_field')->row_array();

            $child_id_array = explode(",", $group_childid['child_id']);

            $this->db->select('field_id, type, label, slno');
            $this->db->where('form_id', $data['survey_id'])->where('type !=', 'header')->where_in('field_id', $child_id_array);
            $this->db->where('status', 1);
            $this->db->order_by('slno');
            $group_fields[$key]['group_fields'] = $this->db->get('form_field')->result_array();

            $grouptable = "survey".$data['survey_id']."_groupdata";

            $this->db->select('*');
            $this->db->where('groupfield_id', $value)->where('data_status', 1)->where('data_id', $data['data_id']);
            $group_fields[$key]['group_data'] = $this->db->get('ic_form_group_data')->result_array();
        }

        return $group_fields;
    }

    public function group_info_details($group){
        $this->db->select('*');
        $this->db->where('group_id', $group)->where('data_status', 1);
        $group_data = $this->db->get('ic_form_group_data')->row_array();

        return $group_data;
    }

    public function survey_location($survey_id){
        // $form_details = $this->db->where('id', $survey_id)->where('status', 1)->get('form')->row_array();

        $this->db->select('loc.id, loc.lat, loc.lng, loc.address, loc.created_date, concat(tu.first_name, " ", tu.last_name) as username');
        $this->db->from('ic_data_location as loc');
        $this->db->join('tbl_users AS tu', 'tu.user_id = loc.user_id');
        switch ($survey_id) {
            case 1:
                $this->db->join('tbl_farmers AS tblf', 'tblf.data_id = loc.data_id');
                if(isset($_POST['division']) && !is_null($_POST['division'])){
                    if(isset($_POST['division'])) $division = $this->input->post('division');
                    $this->db->where_in('tblf.division_id', $division);
                }
                if(isset($_POST['circle']) && !is_null($_POST['circle'])){
                    if(isset($_POST['circle'])) $circle = $this->input->post('circle');
                    $this->db->where_in('tblf.circle_id', $circle);
                }
                if(isset($_POST['village']) && !is_null($_POST['village'])){
                    if(isset($_POST['village'])) $village = $this->input->post('village');
                    $this->db->where_in('tblf.village_id', $village);
                }
            break;

            case 2:
                $this->db->join('tbl_plot AS tblp', 'tblp.data_id = loc.data_id');
                if(isset($_POST['division']) && !is_null($_POST['division'])){
                    if(isset($_POST['division'])) $division = $this->input->post('division');
                    $this->db->where_in('tblp.division_id', $division);
                }
                if(isset($_POST['circle']) && !is_null($_POST['circle'])){
                    if(isset($_POST['circle'])) $circle = $this->input->post('circle');
                    $this->db->where_in('tblp.circle_id', $circle);
                }
                if(isset($_POST['village']) && !is_null($_POST['village'])){
                    if(isset($_POST['village'])) $village = $this->input->post('village');
                    $this->db->where_in('tblp.village_id', $village);
                }
            break;

            case 3:
                $this->db->join('tbl_agreement AS tbla', 'tbla.agreement_data_id = loc.data_id');
                $this->db->join('tbl_plot AS tblp', 'tblp.data_id = tbla.plot_data_id');
                if(isset($_POST['division']) && !is_null($_POST['division'])){
                    if(isset($_POST['division'])) $division = $this->input->post('division');
                    $this->db->where_in('tblp.division_id', $division);
                }
                if(isset($_POST['circle']) && !is_null($_POST['circle'])){
                    if(isset($_POST['circle'])) $circle = $this->input->post('circle');
                    $this->db->where_in('tblp.circle_id', $circle);
                }
                if(isset($_POST['village']) && !is_null($_POST['village'])){
                    if(isset($_POST['village'])) $village = $this->input->post('village');
                    $this->db->where_in('tblp.village_id', $village);
                }
            break;
        }
        $this->db->where('loc.form_id', $survey_id)->where('loc.status', 1);
        if(isset($_POST['start_date']) && isset($_POST['end_date'])){
            $this->db->where('DATE(loc.created_date) >=', $_POST['start_date']);
            $this->db->where('DATE(loc.created_date) <=', $_POST['end_date']);
        }
        if(isset($_POST['last_id']) && strlen($_POST['last_id']) > 0){
            $this->db->where('loc.id <', $_POST['last_id']);
        } else {
            $this->db->limit(300);
        }
        $location = $this->db->order_by('loc.id', 'DESC')->get()->result_array();

        $location_data = array();
        foreach ($location as $key => $value) {
            if($value['lat'] != NULL && $value['lng'] != NULL && $value['lat'] != 0 && $value['lng'] != 0 ) {
                $address = ($value['address'] == '' || $value['address'] == NULL) ? "N/A" : $value['address'];

                $uploaded_by = $value['username'];
                $uploaded_date = $value['created_date'];
                $date = new DateTime($uploaded_date, new DateTimeZone('UTC'));
                $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
                $uploaded_date = $date->format('Y-m-d H:i:s');

                $data = "<h5>Submitted by : ".$uploaded_by."</h5><h5>Submitted date : ".$uploaded_date."</h5><h5>Address : ".$address."</h5>";

                array_push($location_data, array($value['lat'], $value['lng'], $data, $value['id']) );
            }
        }

        return $location_data;
    }
    public function get_klm_locations($survey_id){
        
        $this->db->select('loc.id, loc.lat, loc.lng, loc.address, loc.created_date, concat(tu.first_name, " ", tu.last_name) as username');
        $this->db->from('ic_data_location as loc');
        $this->db->join('tbl_users AS tu', 'tu.user_id = loc.user_id');
        switch ($survey_id) {
            case 1:
                $this->db->join('tbl_farmers AS tblf', 'tblf.data_id = loc.data_id');
                if(isset($_POST['division']) && !is_null($_POST['division'])){
                    if(isset($_POST['division'])) $division = $this->input->post('division');
                    $this->db->where_in('tblf.division_id', $division);
                }
                if(isset($_POST['circle']) && !is_null($_POST['circle'])){
                    if(isset($_POST['circle'])) $circle = $this->input->post('circle');
                    $this->db->where_in('tblf.circle_id', $circle);
                }
                if(isset($_POST['village']) && !is_null($_POST['village'])){
                    if(isset($_POST['village'])) $village = $this->input->post('village');
                    $this->db->where_in('tblf.village_id', $village);
                }
            break;

            case 2:
                $this->db->join('tbl_plot AS tblp', 'tblp.data_id = loc.data_id');
                if(isset($_POST['division']) && !is_null($_POST['division'])){
                    if(isset($_POST['division'])) $division = $this->input->post('division');
                    $this->db->where_in('tblp.division_id', $division);
                }
                if(isset($_POST['circle']) && !is_null($_POST['circle'])){
                    if(isset($_POST['circle'])) $circle = $this->input->post('circle');
                    $this->db->where_in('tblp.circle_id', $circle);
                }
                if(isset($_POST['village']) && !is_null($_POST['village'])){
                    if(isset($_POST['village'])) $village = $this->input->post('village');
                    $this->db->where_in('tblp.village_id', $village);
                }
            break;

            case 3:
                $this->db->join('tbl_agreement AS tbla', 'tbla.agreement_data_id = loc.data_id');
                $this->db->join('tbl_plot AS tblp', 'tblp.data_id = tbla.plot_data_id');
                if(isset($_POST['division']) && !is_null($_POST['division'])){
                    if(isset($_POST['division'])) $division = $this->input->post('division');
                    $this->db->where_in('tblp.division_id', $division);
                }
                if(isset($_POST['circle']) && !is_null($_POST['circle'])){
                    if(isset($_POST['circle'])) $circle = $this->input->post('circle');
                    $this->db->where_in('tblp.circle_id', $circle);
                }
                if(isset($_POST['village']) && !is_null($_POST['village'])){
                    if(isset($_POST['village'])) $village = $this->input->post('village');
                    $this->db->where_in('tblp.village_id', $village);
                }
            break;
        }
        $this->db->where('loc.form_id', $survey_id)->where('loc.status', 1);
        if(isset($_POST['start_date']) && isset($_POST['end_date'])){
            $this->db->where('DATE(loc.created_date) >=', $_POST['start_date']);
            $this->db->where('DATE(loc.created_date) <=', $_POST['end_date']);
        }
        if(isset($_POST['last_id']) && strlen($_POST['last_id']) > 0){
            $this->db->where('loc.id <', $_POST['last_id']);
        } else {
            $this->db->limit(300);
        }
        $location = $this->db->order_by('loc.id', 'DESC')->get()->result_array();

        $location_data = array();
        foreach ($location as $key => $value) {
            if($value['lat'] != NULL && $value['lng'] != NULL && $value['lat'] != 0 && $value['lng'] != 0 ) {
                $address = ($value['address'] == '' || $value['address'] == NULL) ? "N/A" : $value['address'];

                $uploaded_by = $value['username'];
                $uploaded_date = $value['created_date'];
                $date = new DateTime($uploaded_date, new DateTimeZone('UTC'));
                $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
                $uploaded_date = $date->format('Y-m-d H:i:s');

                $data = "<h5>Submitted by : ".$uploaded_by."</h5><h5>Submitted date : ".$uploaded_date."</h5><h5>Address : ".$address."</h5>";

                array_push($location_data, array($value['lat'], $value['lng'], $data, $value['id']) );
            }
        }

        return $location_data;
    }

    public function activity_location($survey_id, $village_id){
        $form_details = $this->db->where('id', $survey_id)->where('status', 1)->get('form')->row_array();

        $this->db->select('loc.lat, loc.lng, loc.address, data.id, data.form_data, data.reg_date_time, data.data_id, concat(tu.first_name, " ", tu.last_name) as username, ld.district_name');
        $this->db->from('ic_data_location as loc');
        $this->db->join('lkp_district AS ld', 'ld.district_id = loc.district_id');
        $this->db->join('ic_form_data as data', 'data.data_id = loc.data_id');
        $this->db->join('tbl_users AS tu', 'tu.user_id = data.user_id');
        $this->db->where('loc.form_id', $survey_id)->where('data.form_id', $survey_id)->where('data.village_id', $village_id);
        $this->db->where('loc.status', 1)->where('data.data_status', 1);
        if(isset($_POST['last_id'])){
            $this->db->where('data.id <', $_POST['last_id']);
        } else {
            $this->db->limit(300);
        }
        $location = $this->db->order_by('data.id', 'DESC')->get()->result_array();

        $location_data = array();
        foreach ($location as $key => $value) {
            if($value['lat'] != NULL && $value['lng'] != NULL && $value['lat'] != 0 && $value['lng'] != 0 ) {
                $address = ($value['address'] == '' || $value['address'] == NULL) ? "N/A" : $value['address'];

                $uploaded_by = $value['username'];
                $uploaded_date = $value['reg_date_time'];
                $date = new DateTime($uploaded_date, new DateTimeZone('UTC'));
                $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
                $uploaded_date = $date->format('Y-m-d H:i:s');

                if($survey_id == 1) {
                    $data_array = json_decode($value['form_data'], true);

                    $household_headname = (isset($data_array['field_1673']) ? $data_array['field_1673'] : 'N/A')." ".(isset($data_array['field_1674']) ? $data_array['field_1674'] : 'N/A');

                    $beneficiary_id = (isset($data_array['field_1670'])) ? $data_array['field_1670'] : "N/A";
                    
                    $data = "<h5 class='title'>".$form_details['title']."</h5><h5>Household headname : ". $household_headname."</h5><h5>Beneficiary id: ". $beneficiary_id."</h5><h5>Submitted by : ".$uploaded_by."</h5><h5>Submitted date : ".$uploaded_date."</h5><h5>Address : ".$address."</h5>";
                } else if($survey_id == 19) {
                    $data_array = json_decode($value['form_data'], true);

                    $farmer_name = isset($data_array['field_2870']) ? $data_array['field_2870'] : '';
                    $farmer_name .= isset($data_array['field_2871']) ? " ".$data_array['field_2871'] : '';
                    $farmer_name = strlen($farmer_name) === 0 ? 'N/A' : $farmer_name;

                    $soil_id = (isset($data_array['field_2874'])) ? $data_array['field_2874'] : "N/A";

                    $data = "<h5 class='title'>".$form_details['title']."</h5><h5>Farmer Name : ". $farmer_name."</h5><h5>Soil ID: ". $soil_id."</h5><h5>Submitted by : ".$uploaded_by."</h5><h5>Submitted date : ".$uploaded_date."</h5>";
                } else {
                    $data = "<h5 class='title'>".$form_details['title']."</h5><h5>Submitted by : ".$uploaded_by."</h5><h5>Submitted date : ".$uploaded_date."</h5><h5>Address : ".$address."</h5>";
                }

                array_push($location_data, array($value['lat'], $value['lng'], $data, $value['district_name'], $value['id']) );
            }
        }

        return $location_data;
    }

     public function get_form_fields($form_id)
    {
        $check_group_field = $this->db->where('type', 'group')->where('form_id', $form_id)->where('status', 1)->get('form_field')->num_rows();

        if($check_group_field > 0){
            $this->db->select('GROUP_CONCAT(field_id) as field_ids');
            $this->db->where('type', 'group')->where('form_id', $form_id)->where('status', 1);
            $form_group_id = $this->db->get('form_field')->row_array();

            $form_group_id_array = explode(",", $form_group_id['field_ids']);

            $group_fields_array = array();
            foreach ($form_group_id_array as $key => $value) {
                $this->db->select('child_id');
                $this->db->where('form_id', $form_id)->where('field_id', $value);
                $this->db->where('status', 1);
                $group_childid = $this->db->get('form_field')->row_array();

                $child_id_array = explode(",", $group_childid['child_id']);

                foreach ($child_id_array as $key => $child) {
                    array_push($group_fields_array, $child);
                }
            }
        }else{
            $group_fields_array = array(0);
        }

        $this->db->select('field_id, label, name, type, multiple, required, parent_id, maxlength, subtype');
        $this->db->where('form_id', $form_id)->where('type !=', 'header')->where('type !=', 'collapse')->where('type !=', 'group');
        $this->db->where('status', 1)->where_not_in('field_id', $group_fields_array)->order_by('slno');
        
        return $form_field = $this->db->get('form_field')->result_array();
    }

    public function lkp_crop_types(){
        $this->db->select('type_id, type_name');
        $this->db->where('status', 1);
        return $age = $this->db->get('lkp_crop_types')->result_array();
    }

    public function lkp_crops(){
        $this->db->select('crop_id, crop_name');
        $this->db->where('status', 1);
        return $age = $this->db->get('lkp_crops')->result_array();
    }

    public function lkp_crop_intervention(){
        $this->db->select('intervention_id, intervention_name');
        $this->db->where('status', 1);
        return $age = $this->db->get('lkp_crop_intervention')->result_array();
    }

    public function lkp_crop_inputname(){
        $this->db->select('inputname_id, inputname_name');
        $this->db->where('status', 1);
        return $age = $this->db->get('lkp_crop_inputname')->result_array();
    }

    public function lkp_crop_varieties(){
        $this->db->select('variety_id, variety_name');
        $this->db->where('status', 1);
        return $age = $this->db->get('lkp_crop_varieties')->result_array();
    }

    public function coconutplantation_info($data){
        $result = array();

        $this->db->select('file_name');
        $this->db->where('data_id', $data['data_id'])->where('status', 1);
        $this->db->where('form_id', $data['survey_id']);
        $this->db->order_by('created_date', 'DESC');
        $result['images'] = $this->db->get('ic_data_file')->result_array();

        $this->db->select('*');
        $this->db->where('data_id', $data['data_id'])->where('status', 1);
        $this->db->where('form_id', $data['survey_id']);
        $this->db->order_by('created_date', 'DESC');
        $result['location'] = $this->db->get('ic_data_location')->result_array();

        return $result;
    }

    public function get_lookup_data($table) {
        return $lookup_data = $this->db->get($table)->result_array();
    }

    /*kaznet functions stat by mallikgarjuna*/

    public function survey_details($survey_id){
        
        $form_details = $this->db->where('id', $survey_id)->where('status', 1)->get('form')->row_array();

        $this->db->where('type', 'group')->where('form_id', $survey_id)->where('status', 1);
        $check_group_field = $this->db->get('form_field')->num_rows();

        if($check_group_field > 0){
            $this->db->select('GROUP_CONCAT(field_id) as field_ids');
            $this->db->where('type', 'group')->where('form_id', $survey_id)->where('status', 1);
            $form_group_id = $this->db->get('form_field')->row_array();

            $form_group_id_array = explode(",", $form_group_id['field_ids']);

            $form_group_id_array_list = array();
            foreach ($form_group_id_array as $key => $value) {
                $this->db->select('child_id');
                $this->db->where('form_id', $survey_id)->where('field_id', $value);
                $this->db->where('status', 1);
                $group_childid = $this->db->get('form_field')->row_array();

                $child_id_array = explode(",", $group_childid['child_id']);

                foreach ($child_id_array as $key => $child) {
                    array_push($form_group_id_array_list, $child);
                }
            }
        }else{
            $form_group_id_array_list = array(0);
        }

        $this->db->select('*');
        $this->db->where("form_id", $survey_id)->where('status', 1);
        $this->db->where_not_in('field_id', $form_group_id_array_list);
        $this->db->where('type !=', 'header');
        // $this->db->where('type !=', 'group')->where('type !=', 'header');
        $survey_formfields = $this->db->order_by('slno')->get('form_field')->result_array();
        
        $result = array('fields' => $survey_formfields, 'form_details' => $form_details, 'form_id'=>$survey_id, 'check_group_field' => $check_group_field);

        return $result;
    }
    public function export_survey_title($survey_id){
        $this->db->select('title');
        $this->db->where("id", $survey_id)->where('status', 1);
        $title = $this->db->get('form')->row_array();
        return $title['title'];
    }

    public function survey_submited_data($data){
        $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        // $this->db->select('GROUP_CONCAT(field_id ",") as checkbox_fileds_ids');
        // $this->db->where('id', $survey_id)->like('type', '%checkbox-group%')->where('status', 1);
        // $checkbox_fileds_ids = $this->db->get('form_field')->row_array();
        // $this->db->select('GROUP_CONCAT(value ",") as checkbox_fileds_values');
        // $this->db->where('id', $survey_id)->like('type', '%checkbox-group%')->where('status', 1);
        // $checkbox_fileds_values = $this->db->get('form_field')->row_array();

        // $type = $form_type['type'];
        
        
        // Get Survey submited Data
        if($data['survey_type'] == "Household Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, concat(rp.first_name," ", rp.last_name) as respondent,rp.hhid, idl.lat, idl.lng');
        }else  if($data['survey_type'] == "Rangeland Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, tp.contributor_name as contributor_name, idl.lat, idl.lng');
        }else if($data['survey_type'] == "Market Task" ){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, lm.name as market_name, idl.lat, idl.lng');
        }
		$this->db->from('survey'.$survey_id.' AS survey');
		$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
		// if($data['survey_type'] != "Market Task" ){
		    $this->db->join('ic_data_location AS idl', 'idl.data_id = survey.data_id', 'left');
        // }
        if($data['survey_type'] == "Household Task"){
            $this->db->join('tbl_respondent_users AS rp', 'rp.data_id = survey.respondent_data_id');
            $this->db->where('rp.status', 1);
        }
        if($data['survey_type'] == "Rangeland Task"){
            $this->db->join('tbl_transect_pastures AS tp', 'tp.data_id = survey.transect_pasture_data_id');
        }
        if($data['survey_type'] == "Market Task"){
            $this->db->join('lkp_market AS lm', 'lm.market_id = survey.market_id');
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
            $this->db->where('survey.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('survey.user_id', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            if($data['survey_type'] == "Market Task"){
                $this->db->where('survey.market_id', $data['respondent_id']);
            }else if($data['survey_type'] == "Rangeland Task" ){
                $this->db->where('tp.pasture_type', $data['respondent_id']);
            }else{
                $this->db->where('survey.respondent_data_id', $data['respondent_id']);
            }
            
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(survey.datetime) >=', $data['start_date']);
            $this->db->where('DATE(survey.datetime) <=', $data['end_date']);
        }
		$this->db->where('survey.status', 1);
        if($data['is_pa_verified_status']){
            $this->db->where('survey.pa_verified_status', $data['pa_verified_status']);
        }
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        // if($data['is_search']){
        //     $this->db->group_start();
        //     $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
        //     $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
        //     $this->db->or_like('rp.first_name',$data['search_input']); // respondent First name
        //     $this->db->or_like('rp.last_name',$data['search_input']); // respondent last Name
        //     $this->db->or_like('rp.username',$data['search_input']); // respondent user name
        //     $this->db->or_like('tu.username',$data['search_input']); // contributor user name
        //     $this->db->group_end();
        // }
		$submited_data = $this->db->order_by('survey.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());exit;
        foreach($submited_data as $key => $value){
            // if($checkbox_fileds_ids['checkbox_fileds_ids']){
            //     $loop_value='';
            //     foreach($checkbox_fileds_ids['checkbox_fileds_ids'] as $ckey => $cbvalue){
            //         $loop_value += cbvalue[$value['field_'.$cbvalue]];
            //     }
            // }
            $this->db->select('field_id,file_name');
            $this->db->where('data_id',$value['data_id']);
            $images = $this->db->where('status',1)->get('ic_data_file')->result_array();
            foreach($images as $ikey => $ivalue){
                $submited_data[$key]['field_'.$ivalue['field_id']] = $ivalue['file_name'];
            }
        }
        // print_r($this->db->last_query());exit;
        return $submited_data;
    }
    public function survey_records($data){
        $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        $this->db->select('type');
        $this->db->where('id', $survey_id)->where('status', 1);
        $form_type = $this->db->get('form')->row_array();

        $type = $form_type['type'];
        
        
        // Get Survey submited Data
        if($data['survey_type'] == "Household Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name) as first_name, concat(rp.first_name," ", rp.last_name) as respondent');
        }else  if($data['survey_type'] == "Rangeland Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name) as first_name, tp.contributor_name as contributor_name');
        }else if($data['survey_type'] == "Market Task" ){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name) as first_name, lm.name as market_name');
        }
		$this->db->from('survey'.$survey_id.' AS survey');
		$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
        // if($data['survey_type'] != "Market Task" ){
		    $this->db->join('ic_data_location AS idl', 'idl.data_id = survey.data_id', 'left');
        // }
        if($data['survey_type'] == "Household Task"){
            $this->db->join('tbl_respondent_users AS rp', 'rp.data_id = survey.respondent_data_id');
            $this->db->where('rp.status', 1);
        }
        if($data['survey_type'] == "Rangeland Task"){
            $this->db->join('tbl_transect_pastures AS tp', 'tp.data_id = survey.transect_pasture_data_id');
        }
        if($data['survey_type'] == "Market Task"){
            $this->db->join('lkp_market AS lm', 'lm.market_id = survey.market_id');
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
            $this->db->where('survey.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('survey.user_id', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            if($data['survey_type'] == "Market Task"){
                $this->db->where('survey.market_id', $data['respondent_id']);
            }else if($data['survey_type'] == "Rangeland Task" ){
                $this->db->where('tp.pasture_type', $data['respondent_id']);
            }else{
                $this->db->where('survey.respondent_data_id', $data['respondent_id']);
            }
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(survey.datetime) >=', $data['start_date']);
            $this->db->where('DATE(survey.datetime) <=', $data['end_date']);
        }
		$this->db->where('survey.status', 1);
		$this->db->where('survey.pa_verified_status', 1);
        // if($data['is_search']){
        //     $this->db->group_start();
        //     $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
        //     $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
        //     $this->db->or_like('rp.first_name',$data['search_input']); // respondent First name
        //     $this->db->or_like('rp.last_name',$data['search_input']); // respondent last Name
        //     $this->db->or_like('rp.username',$data['search_input']); // respondent user name
        //     $this->db->or_like('tu.username',$data['search_input']); // contributor user name
        //     $this->db->group_end();
        // }
		$submited_data = $this->db->order_by('survey.id', 'DESC')->get()->num_rows();
        return $submited_data;
    }
    public function survey_approved_data($data){
        $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        $this->db->select('type');
        $this->db->where('id', $survey_id)->where('status', 1);
        $form_type = $this->db->get('form')->row_array();

        $type = $form_type['type'];
        
        
        // Get Survey submited Data
        if($data['survey_type'] == "Household Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, concat(rp.first_name," ", rp.last_name) as respondent,rp.hhid, idl.lat, idl.lng');
        }else  if($data['survey_type'] == "Rangeland Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, tp.contributor_name as contributor_name, idl.lat, idl.lng');
        }else if($data['survey_type'] == "Market Task" ){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, lm.name as market_name, idl.lat, idl.lng');
            
        }
		$this->db->from('survey'.$survey_id.' AS survey');
		$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
        // if($data['survey_type'] != "Market Task" ){
		    $this->db->join('ic_data_location AS idl', 'idl.data_id = survey.data_id', 'left');
        // }
        if($data['survey_type'] == "Household Task"){
            $this->db->join('tbl_respondent_users AS rp', 'rp.data_id = survey.respondent_data_id');
            $this->db->where('rp.status', 1);
        }
        if($data['survey_type'] == "Rangeland Task"){
            $this->db->join('tbl_transect_pastures AS tp', 'tp.data_id = survey.transect_pasture_data_id');
        }
        if($data['survey_type'] == "Market Task"){
            $this->db->join('lkp_market AS lm', 'lm.market_id = survey.market_id');
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
            $this->db->where('survey.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('survey.user_id', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            if($data['survey_type'] == "Market Task"){
                $this->db->where('survey.market_id', $data['respondent_id']);
            }else if($data['survey_type'] == "Rangeland Task" ){
                $this->db->where('tp.pasture_type', $data['respondent_id']);
            }else{
                $this->db->where('survey.respondent_data_id', $data['respondent_id']);
            }
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(survey.datetime) >=', $data['start_date']);
            $this->db->where('DATE(survey.datetime) <=', $data['end_date']);
        }
		$this->db->where('survey.status', 1);
		$this->db->where('survey.pa_verified_status', 2);
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
            $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
            $this->db->or_like('rp.first_name',$data['search_input']); // respondent First name
            $this->db->or_like('rp.last_name',$data['search_input']); // respondent last Name
            $this->db->or_like('rp.username',$data['search_input']); // respondent user name
            $this->db->or_like('tu.username',$data['search_input']); // contributor user name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('survey.id', 'DESC')->get()->result_array();
        // print_r( $this->db->last_query());exit;
        foreach($submited_data as $key => $value){
            $this->db->select('field_id,file_name');
            $this->db->where('data_id',$value['data_id']);
            $images = $this->db->where('status',1)->get('ic_data_file')->result_array();
            foreach($images as $ikey => $ivalue){
                $submited_data[$key]['field_'.$ivalue['field_id']] = $ivalue['file_name'];
            }
        }
        return $submited_data;
    }
    public function survey_approved_records($data){
        $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];
        
        
        // Get Survey submited Data
        if($data['survey_type'] == "Household Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name) as first_name, concat(rp.first_name," ", rp.last_name) as respondent');
        }else  if($data['survey_type'] == "Rangeland Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name) as first_name, tp.contributor_name as contributor_name');
        }else if($data['survey_type'] == "Market Task" ){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name) as first_name, lm.name as market_name');
        }
		$this->db->from('survey'.$survey_id.' AS survey');
		$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
        // if($data['survey_type'] != "Market Task" ){
		    $this->db->join('ic_data_location AS idl', 'idl.data_id = survey.data_id', 'left');
        // }
        if($data['survey_type'] == "Household Task"){
            $this->db->join('tbl_respondent_users AS rp', 'rp.data_id = survey.respondent_data_id');
            $this->db->where('rp.status', 1);
        }
        if($data['survey_type'] == "Rangeland Task"){
            $this->db->join('tbl_transect_pastures AS tp', 'tp.data_id = survey.transect_pasture_data_id');
        }
        if($data['survey_type'] == "Market Task"){
            $this->db->join('lkp_market AS lm', 'lm.market_id = survey.market_id');
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
            $this->db->where('survey.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('survey.user_id', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            if($data['survey_type'] == "Market Task"){
                $this->db->where('survey.market_id', $data['respondent_id']);
            }else if($data['survey_type'] == "Rangeland Task" ){
                $this->db->where('tp.pasture_type', $data['respondent_id']);
            }else{
                $this->db->where('survey.respondent_data_id', $data['respondent_id']);
            }
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(survey.datetime) >=', $data['start_date']);
            $this->db->where('DATE(survey.datetime) <=', $data['end_date']);
        }
		$this->db->where('survey.status', 1);
		$this->db->where('survey.pa_verified_status', 2);
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
            $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
            $this->db->or_like('rp.first_name',$data['search_input']); // respondent First name
            $this->db->or_like('rp.last_name',$data['search_input']); // respondent last Name
            $this->db->or_like('rp.username',$data['search_input']); // respondent user name
            $this->db->or_like('tu.username',$data['search_input']); // contributor user name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('survey.id', 'DESC')->get()->num_rows();
        return $submited_data;
    }
    public function survey_rejected_data($data){
        $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];
        
        
        // Get Survey submited Data
        if($data['survey_type'] == "Household Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, concat(rp.first_name," ", rp.last_name) as respondent,rp.hhid, idl.lat, idl.lng');
        }else  if($data['survey_type'] == "Rangeland Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, tp.contributor_name as contributor_name, idl.lat, idl.lng');
        }else if($data['survey_type'] == "Market Task" ){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, lm.name as market_name, idl.lat, idl.lng');
        }
		$this->db->from('survey'.$survey_id.' AS survey');
		$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
        // if($data['survey_type'] != "Market Task" ){
		    $this->db->join('ic_data_location AS idl', 'idl.data_id = survey.data_id', 'left');
        // }
        if($data['survey_type'] == "Household Task"){
            $this->db->join('tbl_respondent_users AS rp', 'rp.data_id = survey.respondent_data_id');
            $this->db->where('rp.status', 1);
        }
        if($data['survey_type'] == "Rangeland Task"){
            $this->db->join('tbl_transect_pastures AS tp', 'tp.data_id = survey.transect_pasture_data_id');
        }
        if($data['survey_type'] == "Market Task"){
            $this->db->join('lkp_market AS lm', 'lm.market_id = survey.market_id');
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
            $this->db->where('survey.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('survey.user_id', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            if($data['survey_type'] == "Market Task"){
                $this->db->where('survey.market_id', $data['respondent_id']);
            }else if($data['survey_type'] == "Rangeland Task" ){
                $this->db->where('tp.pasture_type', $data['respondent_id']);
            }else{
                $this->db->where('survey.respondent_data_id', $data['respondent_id']);
            }
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(survey.datetime) >=', $data['start_date']);
            $this->db->where('DATE(survey.datetime) <=', $data['end_date']);
        }
		$this->db->where('survey.status', 1);
		$this->db->where('survey.pa_verified_status', 3);
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
            $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
            $this->db->or_like('rp.first_name',$data['search_input']); // respondent First name
            $this->db->or_like('rp.last_name',$data['search_input']); // respondent last Name
            $this->db->or_like('rp.username',$data['search_input']); // respondent user name
            $this->db->or_like('tu.username',$data['search_input']); // contributor user name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('survey.id', 'DESC')->get()->result_array();
        // print_r( $this->db->last_query());exit;
        foreach($submited_data as $key => $value){
            $this->db->select('field_id,file_name');
            $this->db->where('data_id',$value['data_id']);
            $images = $this->db->where('status',1)->get('ic_data_file')->result_array();
            foreach($images as $ikey => $ivalue){
                $submited_data[$key]['field_'.$ivalue['field_id']] = $ivalue['file_name'];
            }
        }
        return $submited_data;
    }
    public function survey_rejected_records($data){
        $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        $this->db->select('type');
        $this->db->where('id', $survey_id)->where('status', 1);
        $form_type = $this->db->get('form')->row_array();

        $type = $form_type['type'];
        
        
        // Get Survey submited Data
        if($data['survey_type'] == "Household Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name) as first_name, concat(rp.first_name," ", rp.last_name) as respondent');
        }else  if($data['survey_type'] == "Rangeland Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name) as first_name, tp.contributor_name as contributor_name');
        }else if($data['survey_type'] == "Market Task" ){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name) as first_name, lm.name as market_name');
        }
		$this->db->from('survey'.$survey_id.' AS survey');
		$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
        // if($data['survey_type'] != "Market Task" ){
		    $this->db->join('ic_data_location AS idl', 'idl.data_id = survey.data_id', 'left');
        // }
        if($data['survey_type'] == "Household Task"){
            $this->db->join('tbl_respondent_users AS rp', 'rp.data_id = survey.respondent_data_id');
            $this->db->where('rp.status', 1);
        }
        if($data['survey_type'] == "Rangeland Task"){
            $this->db->join('tbl_transect_pastures AS tp', 'tp.data_id = survey.transect_pasture_data_id');
        }
        if($data['survey_type'] == "Market Task"){
            $this->db->join('lkp_market AS lm', 'lm.market_id = survey.market_id');
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
            $this->db->where('survey.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('survey.user_id', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            if($data['survey_type'] == "Market Task"){
                $this->db->where('survey.market_id', $data['respondent_id']);
            }else if($data['survey_type'] == "Rangeland Task" ){
                $this->db->where('tp.pasture_type', $data['respondent_id']);
            }else{
                $this->db->where('survey.respondent_data_id', $data['respondent_id']);
            }
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(survey.datetime) >=', $data['start_date']);
            $this->db->where('DATE(survey.datetime) <=', $data['end_date']);
        }
		$this->db->where('survey.status', 1);
		$this->db->where('survey.pa_verified_status', 3);
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
            $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
            $this->db->or_like('rp.first_name',$data['search_input']); // respondent First name
            $this->db->or_like('rp.last_name',$data['search_input']); // respondent last Name
            $this->db->or_like('rp.username',$data['search_input']); // respondent user name
            $this->db->or_like('tu.username',$data['search_input']); // contributor user name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('survey.id', 'DESC')->get()->num_rows();
        return $submited_data;
    }
    
    public function survey_submited_data_export($data){
        $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        // $this->db->select('GROUP_CONCAT(field_id ",") as checkbox_fileds_ids');
        // $this->db->where('id', $survey_id)->like('type', '%checkbox-group%')->where('status', 1);
        // $checkbox_fileds_ids = $this->db->get('form_field')->row_array();
        // $this->db->select('GROUP_CONCAT(value ",") as checkbox_fileds_values');
        // $this->db->where('id', $survey_id)->like('type', '%checkbox-group%')->where('status', 1);
        // $checkbox_fileds_values = $this->db->get('form_field')->row_array();

        // $type = $form_type['type'];
        
        
        // Get Survey submited Data
        if($data['survey_type'] == "Household Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, concat(rp.first_name," ", rp.last_name) as respondent,rp.hhid, idl.lat, idl.lng');
        }else  if($data['survey_type'] == "Rangeland Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, tp.contributor_name as contributor_name, idl.lat, idl.lng');
        }else if($data['survey_type'] == "Market Task" ){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, lm.name as market_name, idl.lat, idl.lng');
        }
		$this->db->from('survey'.$survey_id.' AS survey');
		$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
        // if($data['survey_type'] != "Market Task" ){
		    $this->db->join('ic_data_location AS idl', 'idl.data_id = survey.data_id', 'left');
        // }
        if($data['survey_type'] == "Household Task"){
            $this->db->join('tbl_respondent_users AS rp', 'rp.data_id = survey.respondent_data_id');
            $this->db->where('rp.status', 1);
        }
        if($data['survey_type'] == "Rangeland Task"){
            $this->db->join('tbl_transect_pastures AS tp', 'tp.data_id = survey.transect_pasture_data_id');
        }
        if($data['survey_type'] == "Market Task"){
            $this->db->join('lkp_market AS lm', 'lm.market_id = survey.market_id');
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
            $this->db->where('survey.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('survey.user_id', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            if($data['survey_type'] == "Market Task"){
                $this->db->where('survey.market_id', $data['respondent_id']);
            }else if($data['survey_type'] == "Rangeland Task" ){
                $this->db->where('tp.pasture_type', $data['respondent_id']);
            }else{
                $this->db->where('survey.respondent_data_id', $data['respondent_id']);
            }
            
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(survey.datetime) >=', $data['start_date']);
            $this->db->where('DATE(survey.datetime) <=', $data['end_date']);
        }
		$this->db->where('survey.status', 1);
        if($data['is_pa_verified_status']){
            $this->db->where('survey.pa_verified_status', $data['pa_verified_status']);
        }
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        // if($data['is_search']){
        //     $this->db->group_start();
        //     $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
        //     $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
        //     $this->db->or_like('rp.first_name',$data['search_input']); // respondent First name
        //     $this->db->or_like('rp.last_name',$data['search_input']); // respondent last Name
        //     $this->db->or_like('rp.username',$data['search_input']); // respondent user name
        //     $this->db->or_like('tu.username',$data['search_input']); // contributor user name
        //     $this->db->group_end();
        // }
		$submited_data = $this->db->order_by('survey.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());exit;
        foreach($submited_data as $key => $value){
            // if($checkbox_fileds_ids['checkbox_fileds_ids']){
            //     $loop_value='';
            //     foreach($checkbox_fileds_ids['checkbox_fileds_ids'] as $ckey => $cbvalue){
            //         $loop_value += cbvalue[$value['field_'.$cbvalue]];
            //     }
            // }
            $this->db->select('field_id,file_name');
            $this->db->where('data_id',$value['data_id']);
            $images = $this->db->where('status',1)->get('ic_data_file')->result_array();
            foreach($images as $ikey => $ivalue){
                $submited_data[$key]['field_'.$ivalue['field_id']] = $ivalue['file_name'];
            }
        }
        // print_r($this->db->last_query());exit;
        return $submited_data;
    }

    public function survey_submited_data_export_all($data){
        $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        // $this->db->select('GROUP_CONCAT(field_id ",") as checkbox_fileds_ids');
        // $this->db->where('id', $survey_id)->like('type', '%checkbox-group%')->where('status', 1);
        // $checkbox_fileds_ids = $this->db->get('form_field')->row_array();
        // $this->db->select('GROUP_CONCAT(value ",") as checkbox_fileds_values');
        // $this->db->where('id', $survey_id)->like('type', '%checkbox-group%')->where('status', 1);
        // $checkbox_fileds_values = $this->db->get('form_field')->row_array();

        // $type = $form_type['type'];
        
        
        // Get Survey submited Data
        if($data['survey_type'] == "Household Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, concat(rp.first_name," ", rp.last_name) as respondent,rp.hhid, idl.lat, idl.lng');
        }else  if($data['survey_type'] == "Rangeland Task"){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, tp.contributor_name as contributor_name, idl.lat, idl.lng');
        }else if($data['survey_type'] == "Market Task" ){
            $this->db->select('survey.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as first_name, lm.name as market_name, idl.lat, idl.lng');
        }
		$this->db->from('survey'.$survey_id.' AS survey');
		$this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
        // if($data['survey_type'] != "Market Task" ){
		    $this->db->join('ic_data_location AS idl', 'idl.data_id = survey.data_id', 'left');
        // }
        if($data['survey_type'] == "Household Task"){
            $this->db->join('tbl_respondent_users AS rp', 'rp.data_id = survey.respondent_data_id');
            $this->db->where('rp.status', 1);
        }
        if($data['survey_type'] == "Rangeland Task"){
            $this->db->join('tbl_transect_pastures AS tp', 'tp.data_id = survey.transect_pasture_data_id');
        }
        if($data['survey_type'] == "Market Task"){
            $this->db->join('lkp_market AS lm', 'lm.market_id = survey.market_id');
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
            $this->db->where('survey.sub_location_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('survey.user_id', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            if($data['survey_type'] == "Market Task"){
                $this->db->where('survey.market_id', $data['respondent_id']);
            }else if($data['survey_type'] == "Rangeland Task" ){
                $this->db->where('tp.pasture_type', $data['respondent_id']);
            }else{
                $this->db->where('survey.respondent_data_id', $data['respondent_id']);
            }
            
        }
        if(!empty($data['start_date']) && !empty($data['end_date'])){
            $this->db->where('DATE(survey.datetime) >=', $data['start_date']);
            $this->db->where('DATE(survey.datetime) <=', $data['end_date']);
        }
		$this->db->where('survey.status', 1);
        // if($data['is_pa_verified_status']){
        //     $this->db->where('survey.pa_verified_status', $data['pa_verified_status']);
        // }
        // if($data['is_pagination']){
        //     $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        // }
        // if($data['is_search']){
        //     $this->db->group_start();
        //     $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
        //     $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
        //     $this->db->or_like('rp.first_name',$data['search_input']); // respondent First name
        //     $this->db->or_like('rp.last_name',$data['search_input']); // respondent last Name
        //     $this->db->or_like('rp.username',$data['search_input']); // respondent user name
        //     $this->db->or_like('tu.username',$data['search_input']); // contributor user name
        //     $this->db->group_end();
        // }
		$submited_data = $this->db->order_by('survey.id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());exit;
        // foreach($submited_data as $key => $value){
        //     // if($checkbox_fileds_ids['checkbox_fileds_ids']){
        //     //     $loop_value='';
        //     //     foreach($checkbox_fileds_ids['checkbox_fileds_ids'] as $ckey => $cbvalue){
        //     //         $loop_value += cbvalue[$value['field_'.$cbvalue]];
        //     //     }
        //     // }
        //     $this->db->select('field_id,file_name');
        //     $this->db->where('data_id',$value['data_id']);
        //     $images = $this->db->where('status',1)->get('ic_data_file')->result_array();
        //     foreach($images as $ikey => $ivalue){
        //         $submited_data[$key]['field_'.$ivalue['field_id']] = $ivalue['file_name'];
        //     }
        // }
        // print_r($this->db->last_query());exit;
        return $submited_data;
    }

    public function survey_submited_household_data($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        // Get Survey submited Data
		$this->db->select('rp.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as added_by');
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
		// $this->db->where('rp.pa_verified_status', 1);
        if($data['is_pa_verified_status']){
            $this->db->where('rp.pa_verified_status', $data['pa_verified_status']);
        }
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('rp.first_name',$data['search_input']); // First name
            $this->db->or_like('rp.last_name',$data['search_input']); // last Name
            $this->db->or_like('rp.mobile_number',$data['search_input']); // Phonenumber
            $this->db->or_like('rp.hhid',$data['search_input']); // hhid
            $this->db->or_like('rp.username',$data['search_input']); // Farmer user name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();
        // print_r( $this->db->last_query());exit;
        return $submited_data;
    }
    public function survey_household_records($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];
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
		$this->db->where('rp.pa_verified_status', 1);
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('rp.first_name',$data['search_input']); // First name
            $this->db->or_like('rp.last_name',$data['search_input']); // last Name
            $this->db->or_like('rp.mobile_number',$data['search_input']); // Phonenumber
            $this->db->or_like('rp.hhid',$data['search_input']); // hhid
            $this->db->or_like('rp.username',$data['search_input']); // Farmer user name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        return $submited_data;
    }
    public function survey_approved_household_data($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        // Get Survey submited Data
		$this->db->select('rp.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as added_by');
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
		$this->db->where('rp.pa_verified_status', 2);
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('rp.first_name',$data['search_input']); // First name
            $this->db->or_like('rp.last_name',$data['search_input']); // last Name
            $this->db->or_like('rp.mobile_number',$data['search_input']); // Phonenumber
            $this->db->or_like('rp.hhid',$data['search_input']); // hhid
            $this->db->or_like('rp.username',$data['search_input']); // Farmer user name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();
        return $submited_data;
    }
    public function survey_approved_household_records($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];
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
		$this->db->where('rp.pa_verified_status', 2);
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('rp.first_name',$data['search_input']); // First name
            $this->db->or_like('rp.last_name',$data['search_input']); // last Name
            $this->db->or_like('rp.mobile_number',$data['search_input']); // Phonenumber
            $this->db->or_like('rp.hhid',$data['search_input']); // hhid
            $this->db->or_like('rp.username',$data['search_input']); // Farmer user name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        return $submited_data;
    }
    public function survey_rejected_household_data($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        // Get Survey submited Data
		$this->db->select('rp.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as added_by');
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
		$this->db->where('rp.pa_verified_status', 3);
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('rp.first_name',$data['search_input']); // First name
            $this->db->or_like('rp.last_name',$data['search_input']); // last Name
            $this->db->or_like('rp.mobile_number',$data['search_input']); // Phonenumber
            $this->db->or_like('rp.hhid',$data['search_input']); // hhid
            $this->db->or_like('rp.username',$data['search_input']); // Farmer user name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();
        return $submited_data;
    }
    public function survey_rejected_household_records($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];
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
		$this->db->where('rp.pa_verified_status', 3);
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('rp.first_name',$data['search_input']); // First name
            $this->db->or_like('rp.last_name',$data['search_input']); // last Name
            $this->db->or_like('rp.mobile_number',$data['search_input']); // Phonenumber
            $this->db->or_like('rp.hhid',$data['search_input']); // hhid
            $this->db->or_like('rp.username',$data['search_input']); // Farmer user name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        return $submited_data;
    }

    public function survey_submited_contributor_data($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        // Get Survey submited Data
		$this->db->select('tu.*, concat(tuaddby.first_name," ", tuaddby.last_name," (", tuaddby.username,")") as added_by1, tup.*, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
        $this->db->from('tbl_users as tu');
		$this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
		$this->db->join('tbl_user_unit_location AS tul', 'tul.user_id = tu.user_id');
        $this->db->join('tbl_users AS tuaddby', 'tuaddby.user_id = tu.user_id', 'left');
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
		$this->db->where('tu.role_id', 8);
		// $this->db->where('tup.pa_verified_status', 1);
        if($data['is_pa_verified_status']){
            $this->db->where('tup.pa_verified_status', $data['pa_verified_status']);
        }
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
            $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
            $this->db->or_like('tu.username',$data['search_input']); // contributor user name
            $this->db->or_like('tu.mobile_number',$data['search_input']); // contributor user name
            $this->db->or_like('tup.bank_name',$data['search_input']); // contributor bank
            $this->db->or_like('tup.branch_name',$data['search_input']); // contributor branch_name
            $this->db->or_like('tup.account_number',$data['search_input']); // contributor account_number
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();
        // print_r($this->db->last_query());exit();
        return $submited_data;
    }
    public function survey_contributor_records($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];
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
		$this->db->where('tu.role_id', 8);
		$this->db->where('tup.pa_verified_status', 1);
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
            $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
            $this->db->or_like('tu.username',$data['search_input']); // contributor user name
            $this->db->or_like('tu.mobile_number',$data['search_input']); // contributor user name
            $this->db->or_like('tup.bank_name',$data['search_input']); // contributor bank
            $this->db->or_like('tup.branch_name',$data['search_input']); // contributor branch_name
            $this->db->or_like('tup.account_number',$data['search_input']); // contributor account_number
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->num_rows();
        return $submited_data;
    }
    public function survey_approved_contributor_data($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        // Get Survey submited Data
		$this->db->select('tu.*,  concat(tuaddby.first_name," ", tuaddby.last_name," (", tuaddby.username,")") as added_by1, tup.*, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
        $this->db->from('tbl_users as tu');
		$this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
		$this->db->join('tbl_user_unit_location AS tul', 'tul.user_id = tu.user_id');
        $this->db->join('tbl_users AS tuaddby', 'tuaddby.user_id = tu.user_id', 'left');
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
		$this->db->where('tu.role_id', 8);
		$this->db->where('tup.pa_verified_status', 2);
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
            $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
            $this->db->or_like('tu.username',$data['search_input']); // contributor user name
            $this->db->or_like('tu.mobile_number',$data['search_input']); // contributor user name
            $this->db->or_like('tup.bank_name',$data['search_input']); // contributor bank
            $this->db->or_like('tup.branch_name',$data['search_input']); // contributor branch_name
            $this->db->or_like('tup.account_number',$data['search_input']); // contributor account_number
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();
        return $submited_data;
    }
    public function survey_approved_contributor_records($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];
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
		$this->db->where('tu.role_id', 8);
		$this->db->where('tup.pa_verified_status', 2);
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
            $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
            $this->db->or_like('tu.username',$data['search_input']); // contributor user name
            $this->db->or_like('tu.mobile_number',$data['search_input']); // contributor user name
            $this->db->or_like('tup.bank_name',$data['search_input']); // contributor bank
            $this->db->or_like('tup.branch_name',$data['search_input']); // contributor branch_name
            $this->db->or_like('tup.account_number',$data['search_input']); // contributor account_number
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->num_rows();
        return $submited_data;
    }
    public function survey_rejected_contributor_data($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        // Get Survey submited Data
		$this->db->select('tu.*, concat(tuaddby.first_name," ", tuaddby.last_name," (", tuaddby.username,")") as added_by1,  tup.*, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
        $this->db->from('tbl_users as tu');
		$this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
		$this->db->join('tbl_user_unit_location AS tul', 'tul.user_id = tu.user_id');
        $this->db->join('tbl_users AS tuaddby', 'tuaddby.user_id = tu.user_id', 'left');
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
		$this->db->where('tu.role_id', 8);
		$this->db->where('tup.pa_verified_status', 3);
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
            $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
            $this->db->or_like('tu.username',$data['search_input']); // contributor user name
            $this->db->or_like('tu.mobile_number',$data['search_input']); // contributor user name
            $this->db->or_like('tup.bank_name',$data['search_input']); // contributor bank
            $this->db->or_like('tup.branch_name',$data['search_input']); // contributor branch_name
            $this->db->or_like('tup.account_number',$data['search_input']); // contributor account_number
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();
        return $submited_data;
    }
    public function survey_rejected_contributor_records($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];
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
		$this->db->where('tu.role_id', 8);
		$this->db->where('tup.pa_verified_status', 3);
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('tu.first_name',$data['search_input']); // contributor First name
            $this->db->or_like('tu.last_name',$data['search_input']); // contributor last Name
            $this->db->or_like('tu.username',$data['search_input']); // contributor user name
            $this->db->or_like('tu.mobile_number',$data['search_input']); // contributor user name
            $this->db->or_like('tup.bank_name',$data['search_input']); // contributor bank
            $this->db->or_like('tup.branch_name',$data['search_input']); // contributor branch_name
            $this->db->or_like('tup.account_number',$data['search_input']); // contributor account_number
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->num_rows();
        return $submited_data;
    }

    public function survey_submited_transect_data($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        // Get Survey submited Data
		$this->db->select('rp.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as added_by');
        $this->db->from('tbl_transect_pastures as rp');
		$this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
        // $this->db->join('ic_data_location AS idl', 'idl.data_id = rp.data_id', 'left');
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
        if(!empty($data['pasture_type'])) {
            $this->db->where('rp.pasture_type', $data['pasture_type']);
        }
        // if(!empty($data['respondent_id'])) {
        //     $this->db->where('rp.id', $data['respondent_id']);
        // }
		$this->db->where('rp.status', 1);
		// $this->db->where('rp.pa_verified_status', 1);
        if($data['is_pa_verified_status']){
            $this->db->where('rp.pa_verified_status', $data['pa_verified_status']);
        }
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('rp.pasture_name',$data['search_input']); // wet_pasture_name
            $this->db->or_like('rp.pasture_name',$data['search_input']); // dry_pasture_name
            $this->db->or_like('rp.contributor_name',$data['search_input']); // Contributor name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();
		// $submited_data = $this->db->order_by('rp.id', 'DESC')->get();
        // print_r($this->db->last_query());exit();
        return $submited_data;
    }
    public function survey_transect_records($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];
        // Get Survey submited Data
		$this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by');
        $this->db->from('tbl_transect_pastures as rp');
		$this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
        // $this->db->join('ic_data_location AS idl', 'idl.data_id = rp.data_id', 'left');
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
        if(!empty($data['pasture_type'])) {
            $this->db->where('rp.pasture_type', $data['pasture_type']);
        }
        // if(!empty($data['respondent_id'])) {
        //     $this->db->where('rp.id', $data['respondent_id']);
        // }
		$this->db->where('rp.status', 1);
		$this->db->where('rp.pa_verified_status', 1);
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('rp.pasture_name',$data['search_input']); // wet_pasture_name
            $this->db->or_like('rp.pasture_name',$data['search_input']); // dry_pasture_name
            $this->db->or_like('rp.contributor_name',$data['search_input']); // Contributor name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        return $submited_data;
    }
    public function survey_approved_transect_data($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        // Get Survey submited Data
		$this->db->select('rp.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as added_by, concat(tu1.first_name," ", tu1.last_name) as approved_by');
        $this->db->from('tbl_transect_pastures as rp');
		$this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
		$this->db->join('tbl_users AS tu1', 'tu1.user_id = rp.pa_verified_by');
        // $this->db->join('ic_data_location AS idl', 'idl.data_id = rp.data_id', 'left');
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
        if(!empty($data['pasture_type'])) {
            $this->db->where('rp.pasture_type', $data['pasture_type']);
        }
        // if(!empty($data['respondent_id'])) {
        //     $this->db->where('rp.id', $data['respondent_id']);
        // }
		$this->db->where('rp.status', 1);
		$this->db->where('rp.pa_verified_status', 2);
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('rp.pasture_name',$data['search_input']); // wet_pasture_name
            $this->db->or_like('rp.pasture_name',$data['search_input']); // dry_pasture_name
            $this->db->or_like('rp.contributor_name',$data['search_input']); // Contributor name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();
        return $submited_data;
    }
    public function survey_approved_transect_records($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];
        // Get Survey submited Data
		$this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by, concat(tu1.first_name," ", tu1.last_name) as approved_by');
        $this->db->from('tbl_transect_pastures as rp');
		$this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
		$this->db->join('tbl_users AS tu1', 'tu1.user_id = rp.pa_verified_by');
        // $this->db->join('ic_data_location AS idl', 'idl.data_id = rp.data_id', 'left');
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
        if(!empty($data['pasture_type'])) {
            $this->db->where('rp.pasture_type', $data['pasture_type']);
        }
        // if(!empty($data['respondent_id'])) {
        //     $this->db->where('rp.id', $data['respondent_id']);
        // }
		$this->db->where('rp.status', 1);
		$this->db->where('rp.pa_verified_status', 2);
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('rp.pasture_name',$data['search_input']); // wet_pasture_name
            $this->db->or_like('rp.pasture_name',$data['search_input']); // dry_pasture_name
            $this->db->or_like('rp.contributor_name',$data['search_input']); // Contributor name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        return $submited_data;
    }
    public function survey_rejected_transect_data($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];

        // Get Survey Rejected Data
		$this->db->select('rp.*, concat(tu.first_name," ", tu.last_name," (", tu.username,")") as added_by, concat(tu1.first_name," ", tu1.last_name) as rejected_by');
        $this->db->from('tbl_transect_pastures as rp');
		$this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
		$this->db->join('tbl_users AS tu1', 'tu1.user_id = rp.pa_verified_by');
        // $this->db->join('ic_data_location AS idl', 'idl.data_id = rp.data_id', 'left');
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
        if(!empty($data['pasture_type'])) {
            $this->db->where('rp.pasture_type', $data['pasture_type']);
        }
        // if(!empty($data['respondent_id'])) {
        //     $this->db->where('rp.id', $data['respondent_id']);
        // }
		$this->db->where('rp.status', 1);
		$this->db->where('rp.pa_verified_status', 3);
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('rp.pasture_name',$data['search_input']); // wet_pasture_name
            $this->db->or_like('rp.pasture_name',$data['search_input']); // dry_pasture_name
            $this->db->or_like('rp.contributor_name',$data['search_input']); // Contributor name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('rp.id', 'DESC')->get()->result_array();
        return $submited_data;
    }
    public function survey_rejected_transect_records($data){
        // $survey_id = $data['survey_id'];
        $user_id = $data['user_id'];
        // Get Survey Rejected Data list count
		$this->db->select('rp.*, concat(tu.first_name," ", tu.last_name) as added_by, concat(tu1.first_name," ", tu1.last_name) as rejected_by');
        $this->db->from('tbl_transect_pastures as rp');
		$this->db->join('tbl_users AS tu', 'tu.user_id = rp.added_by');
		$this->db->join('tbl_users AS tu1', 'tu1.user_id = rp.pa_verified_by');
        // $this->db->join('ic_data_location AS idl', 'idl.data_id = rp.data_id', 'left');
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
        if(!empty($data['pasture_type'])) {
            $this->db->where('rp.pasture_type', $data['pasture_type']);
        }
        // if(!empty($data['respondent_id'])) {
        //     $this->db->where('rp.id', $data['respondent_id']);
        // }
		$this->db->where('rp.status', 1);
		$this->db->where('rp.pa_verified_status', 3);
        if($data['is_search']){
            $this->db->group_start();
            $this->db->or_like('rp.pasture_name',$data['search_input']); // wet_pasture_name
            $this->db->or_like('rp.pasture_name',$data['search_input']); // dry_pasture_name
            $this->db->or_like('rp.contributor_name',$data['search_input']); // Contributor name
            $this->db->group_end();
        }
		$submited_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        return $submited_data;
    }

    public function payment_tasks_data($data){
        if(!empty($data['respondent_id'])) {
			$this->db->select('data_id');
			$this->db->where('data_id', $data['respondent_id']);
			$respondent_list = $this->db->where('status', 1)->get('tbl_respondent_users')->row_array();
			// var_dump($this->db->last_query());exit;
		}
        // $this->db->select('survey_id');
        // if(!empty($data['country_id'])) {
        //     $this->db->where('country_id', $data['country_id']);
        // }
        // if(!empty($data['cluster_id'])) {
        //     $this->db->where('cluster_id', $data['cluster_id']);
        // }
        // if(!empty($data['uai_id'])) {
        //     $this->db->where('uai_id', $data['uai_id']);
        // }
        // if(!empty($data['sub_location_id'])) {
        //     $this->db->where('sub_loc_id', $data['sub_location_id']);
        // }
        // if(!empty($data['contributor_id'])) {
        //     $this->db->where('user_id', $data['contributor_id']);
        // }
        // if(!empty($data['respondent_id'])) {
            
        //     $this->db->where('respondent_id', $respondent_list['data_id']);
        // }	
        // // $this->db->where('respondent_id !=', NULL);
        // $this->db->group_by('survey_id');
        // $survey_list = $this->db->where('status', 1)->get('tbl_survey_assignee')->result_array();
        // // print_r($this->db->last_query());exit();
        // $survey_list1 = array();
        // foreach ($survey_list as $key => $survey) {
        //     array_push($survey_list1,$survey['survey_id']);
        // }


        // Get House hold survey submited Data
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
		$this->db->where('rp.pa_verified_status', 1);
        if($data['is_pagination']){
            // $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
		$hh_submited_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();

        // Get House hold survey approved Data
		$this->db->select('rp.*');
        $this->db->from('tbl_respondent_users as rp');
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
            $this->db->where('DATE(rp.pa_verified_date) >=', $data['start_date']);
            $this->db->where('DATE(rp.pa_verified_date) <=', $data['end_date']);
        }
		$this->db->where('rp.status', 1);
		$this->db->where('rp.pa_verified_status', 2);
        if($data['is_pagination']){
            // $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
		$hh_approved_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();

        // Get House hold survey rejected Data
		$this->db->select('rp.*');
        $this->db->from('tbl_respondent_users as rp');
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
            $this->db->where('DATE(rp.pa_verified_date) >=', $data['start_date']);
            $this->db->where('DATE(rp.pa_verified_date) <=', $data['end_date']);
        }
		$this->db->where('rp.status', 1);
		$this->db->where('rp.pa_verified_status', 3);
        if($data['is_pagination']){
            // $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
		$hh_rejected_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        $payment_list1 =$this->db->select('price_per_survey')->where('survey_id', 1)->where('status', 1)->get('lkp_payment')->row_array();
		$hh_payment_amount = $payment_list1['price_per_survey'] * $hh_approved_data;


        $this->db->select('*');
		$this->db->where('status', 1);
        if(!empty($data['tasks']))
        {
            $this->db->where_in('id', $data['tasks']);
        }
        if($data['is_pagination']){
            // $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        $this->db->order_by('type', 'ASC');
		$surveys = $this->db->get('form')->result_array();
        $count=0;
        // print_r($this->db->last_query());exit();
		foreach ($surveys as $key => $surv) {
            $count++;
			// Get approved
			$this->db->distinct()->select('*');
			$this->db->where('pa_verified_status',2);
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
			if(!empty($data['contributor_id'])) {
				$this->db->where('user_id', $data['contributor_id']);
			}
			if(!empty($data['respondent_id'])) {
				$this->db->where('respondent_data_id', $respondent_list['data_id']);
			}            
            if(!empty($data['start_date']) && !empty($data['end_date'])){
                $this->db->where('DATE(pa_verified_date) >=', $data['start_date']);
                $this->db->where('DATE(pa_verified_date) <=', $data['end_date']);
            }
			$approved = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();
            // print_r($this->db->last_query());exit();
			if($approved) $surveys[$key]['approved'] = $approved;
			else $surveys[$key]['approved'] = 0;

			// get submitted
			$this->db->distinct()->select('*');
			$this->db->where('pa_verified_status',1);
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
			if(!empty($data['contributor_id'])) {
				$this->db->where('user_id', $data['contributor_id']);
			}
			if(!empty($data['respondent_id'])) {
				$this->db->where('respondent_data_id', $respondent_list['data_id']);
			}
            if(!empty($data['start_date']) && !empty($data['end_date'])){
                $this->db->where('DATE(datetime) >=', $data['start_date']);
                $this->db->where('DATE(datetime) <=', $data['end_date']);
            }
			$submitted = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();

			if($submitted) $surveys[$key]['submitted'] = $submitted;
			else $surveys[$key]['submitted'] = 0;

			// get rejected
			$this->db->distinct()->select('*');
			$this->db->where('pa_verified_status',3);
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
			if(!empty($data['contributor_id'])) {
				$this->db->where('user_id', $data['contributor_id']);
			}
			if(!empty($data['respondent_id'])) {
				$this->db->where('respondent_data_id', $respondent_list['data_id']);
			}
            if(!empty($data['start_date']) && !empty($data['end_date'])){
                $this->db->where('DATE(pa_verified_date) >=', $data['start_date']);
                $this->db->where('DATE(pa_verified_date) <=', $data['end_date']);
            }
			$rejected = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();

			if($rejected) $surveys[$key]['rejected'] = $rejected;
			else $surveys[$key]['rejected'] = 0;

			$payment_list =$this->db->select('price_per_survey')->where('survey_id', $surv['id'])->where('status', 1)->get('lkp_payment')->row_array();
            if(!empty($payment_list)){
                $surveys[$key]['payment_amount'] = $payment_list['price_per_survey'] * $surveys[$key]['approved'];
            }else{
                $surveys[$key]['payment_amount'] = 0;
            }
		}
       
        $hh_array_data = array();
        $hh_array_data['id']= 12;
        $hh_array_data['title']="Household Profile";
        $hh_array_data['approved']=$hh_approved_data;
        $hh_array_data['submitted']=$hh_submited_data;
        $hh_array_data['rejected']=$hh_rejected_data;
        $hh_array_data['payment_amount']=$hh_payment_amount;
        array_push($surveys,$hh_array_data);

        $submited_data = $surveys;
        return $submited_data;
    }
    public function payment_tasks_records($data){
        if(!empty($data['respondent_id'])) {
			$this->db->select('data_id');
			$this->db->where('data_id', $data['respondent_id']);
			$respondent_list = $this->db->where('status', 1)->get('tbl_respondent_users')->row_array();
			// var_dump($this->db->last_query());exit;
		}
        $this->db->select('*');
		$this->db->where('status', 1);
        if(!empty($data['tasks']))
        {
            $this->db->where_in('id', $data['tasks']);
        }
		$submited_data = $this->db->get('form')->num_rows();
        // $submited_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        return $submited_data;
		// foreach ($surveys as $key => $surv) {
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
    }

    public function payment_contributors_data($data){
        if(!empty($data['respondent_id'])) {
			$this->db->select('data_id');
			$this->db->where('data_id', $data['respondent_id']);
			$respondent_list = $this->db->where('status', 1)->get('tbl_respondent_users')->row_array();
			// var_dump($this->db->last_query());exit;
		}
        $this->db->select('tu.*,tul.user_id, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
        $this->db->from('tbl_users as tu');
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
        $this->db->group_by('tul.user_id, tul.country_id, tul.sub_loc_id, tul.cluster_id, tul.uai_id, tu.user_id');
        // $this->db->where('uai_id !=', NULL);
		// $this->db->where('tu.status', 1);
        // $this->db->where('tul.status', 1);
		$this->db->where('tu.role_id', 8);
        if($data['is_pagination']){
            // $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
		$users_list = $this->db->order_by('tu.user_id', 'DESC')->get()->result_array();
        // var_dump($this->db->last_query());exit();
		// $this->db->select('*');
		// $this->db->where('role_id', 8);
		// $this->db->where('status', 1);
		// if(!empty($data['contributor_id'])) {
		// 	$this->db->where('user_id', $data['contributor_id']);
		// }
        // if($data['is_pagination']){
        //     $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        // }
		// $users_list = $this->db->get('tbl_users')->result_array();
        // var_dump($this->db->last_query());exit();
		// $contributor_list = $this->db->select('tu.*,tsa.*')->from('tbl_users as tu')->join('tbl_survey_assignee AS tsa', 'tsa.user_id = tu.user_id')->where('tu.role_id',8)->where('tu.status',1)->where('tsa.status',1)->group_by('tsa.user_id')->get()->result_array();
        $users_array = array();
		foreach ($users_list as $ukey1 => $user1) {
            // array_push($users_array,$user1['user_id']);
            $users_array[$ukey1]['user_id'] = $user1['user_id'];
            $users_array[$ukey1]['first_name'] = $user1['first_name'];
            $users_array[$ukey1]['last_name'] = $user1['last_name'];
        }

        foreach($users_array as $ukey => $user) { 
         				
            $payment_amount=0;
            $approved_value1=0;
            $submitted_value1=0;
            $rejected_value1=0;

            $this->db->select('mpesa_id,account_number,bank_name');
            $this->db->where('user_id', $user['user_id']);
            $user_profile = $this->db->where('status', 1)->get('tbl_user_profile')->row_array();
            $users_list[$ukey]['mpesa_id'] = $user_profile['mpesa_id'];
            $users_list[$ukey]['account_number'] = $user_profile['account_number'];
            $users_list[$ukey]['bank_name'] = $user_profile['bank_name'];

			// $this->db->distinct('survey_id');
			$this->db->select('user_id,survey_id');
			$this->db->where('user_id', $user['user_id']);	
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
				$this->db->where('sub_loc_id', $data['sub_location_id']);
			}
			if(!empty($data['contributor_id'])) {
				$this->db->where('user_id', $data['contributor_id']);
			}
			if(!empty($data['respondent_id'])) {
				
				$this->db->where('respondent_id', $respondent_list['data_id']);
			}	
            if(!empty($data['tasks'])) {				
				$this->db->where_in('survey_id', $data['tasks']); //added by sagar for tasks filter
			}	
			// $this->db->where('respondent_id !=', NULL);
            $this->db->group_by('survey_id');
			// $contributor_list = $this->db->where('status', 1)->get('tbl_survey_assignee')->result_array();
			$contributor_list = $this->db->get('tbl_survey_assignee')->result_array();
			// if($user['user_id']==63){
			// 	var_dump($this->db->last_query());exit;
			// }

			foreach ($contributor_list as $ckey => $contributor) {
                
                
                $approved_value=0;
                $submitted_value=0;
                $rejected_value=0;
				// Get approved
				$this->db->distinct()->select('id');
				$this->db->where('pa_verified_status',2);
				$this->db->where('user_id', $contributor['user_id']);
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
				if(!empty($data['contributor_id'])) {
					$this->db->where('user_id', $data['contributor_id']);
				}
				if(!empty($data['respondent_id'])) {
					$this->db->where('respondent_data_id', $respondent_list['data_id']);
				}
                if(!empty($data['start_date']) && !empty($data['end_date'])){
                    $this->db->where('DATE(pa_verified_date) >=', $data['start_date']);
                    $this->db->where('DATE(pa_verified_date) <=', $data['end_date']);
                }
				$approved = $this->db->where('status', 1)->get('survey'.$contributor['survey_id'])->num_rows();
				// if($contributor['user_id']==63){
					// var_dump($this->db->last_query());
				// }
				$temp_approved= $approved;
				$approved_value =$approved_value+$temp_approved;
	
				// get submitted
				$this->db->distinct()->select('id');
				$this->db->where('pa_verified_status',1);
                $this->db->where('user_id', $contributor['user_id']);
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
				if(!empty($data['contributor_id'])) {
					$this->db->where('user_id', $data['contributor_id']);
				}
				if(!empty($data['respondent_id'])) {
					$this->db->where('respondent_data_id', $respondent_list['data_id']);
				}
                if(!empty($data['start_date']) && !empty($data['end_date'])){
                    $this->db->where('DATE(datetime) >=', $data['start_date']);
                    $this->db->where('DATE(datetime) <=', $data['end_date']);
                }
				$submitted = $this->db->where('status', 1)->get('survey'.$contributor['survey_id'])->num_rows();
				$temp_submitted= $submitted;
				$submitted_value =$submitted_value+$temp_submitted;			
	
				// get rejected
				$this->db->distinct()->select('id');
				$this->db->where('pa_verified_status',3);
                $this->db->where('user_id', $contributor['user_id']);
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
				if(!empty($data['contributor_id'])) {
					$this->db->where('user_id', $data['contributor_id']);
				}
				if(!empty($data['respondent_id'])) {
					$this->db->where('respondent_data_id', $respondent_list['data_id']);
				}
                if(!empty($data['start_date']) && !empty($data['end_date'])){
                    $this->db->where('DATE(pa_verified_date) >=', $data['start_date']);
                    $this->db->where('DATE(pa_verified_date) <=', $data['end_date']);
                }
				$rejected = $this->db->where('status', 1)->get('survey'.$contributor['survey_id'])->num_rows();
				$temp_rejected= $rejected;
				$rejected_value =$rejected_value+$temp_rejected;
				
				$payment_list =$this->db->select('price_per_survey')->where('survey_id', $contributor['survey_id'])->where('status', 1)->get('lkp_payment')->row_array();
                
				if(!empty($payment_list)){
                    $temp_payment= $payment_list['price_per_survey'];
                }else{
                    $temp_payment= 0;
                }
				// $payment_amount =$payment_amount+$temp_payment;
				$payment_amount1 =$temp_payment * $approved_value;
				$payment_amount =$payment_amount+$payment_amount1;
				$approved_value1 =$approved_value1+$approved_value;
				$submitted_value1 =$submitted_value1+$submitted_value;
				$rejected_value1 =$rejected_value1+$rejected_value;                
			}
            // Get House hold survey submited Data
            $this->db->select('rp.id');
            $this->db->from('tbl_respondent_users as rp');
            $this->db->where('rp.added_by', $user['user_id']);
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
            $this->db->where('rp.pa_verified_status', 1);
            // if($data['is_pagination']){
            //     $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
            // }
            $hh_submited_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
            // var_dump($this->db->last_query());

            // Get House hold survey approved Data
            $this->db->select('rp.id');
            $this->db->from('tbl_respondent_users as rp');
            $this->db->where('rp.added_by', $user['user_id']);
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
                $this->db->where('DATE(pa_verified_date) >=', $data['start_date']);
                $this->db->where('DATE(pa_verified_date) <=', $data['end_date']);
            }
            $this->db->where('rp.status', 1);
            $this->db->where('rp.pa_verified_status', 2);

            $hh_approved_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
            // var_dump($this->db->last_query());
            // Get House hold survey rejected Data
            $this->db->select('rp.id');
            $this->db->from('tbl_respondent_users as rp');
            $this->db->where('rp.added_by', $user['user_id']);
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
                $this->db->where('DATE(pa_verified_date) >=', $data['start_date']);
                $this->db->where('DATE(pa_verified_date) <=', $data['end_date']);
            }
            $this->db->where('rp.status', 1);
            $this->db->where('rp.pa_verified_status', 3);

            $hh_rejected_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
            // var_dump($this->db->last_query());exit();
            $payment_list1 =$this->db->select('price_per_survey')->where('survey_id', 1)->where('status', 1)->get('lkp_payment')->row_array();
            if(!empty($payment_list1)){
                $hh_payment_amount = $payment_list1['price_per_survey'] * $hh_approved_data;
            }else{
                $hh_payment_amount = 0;
            }
            $task_amount = $payment_amount+$hh_payment_amount;
			$users_list[$ukey]['task_amount'] = $task_amount;
			// $users_list[$ukey]['payment_amount'] = $task_amount +1800;
			$users_list[$ukey]['payment_amount'] = $task_amount; //handiling in page load
            $users_list[$ukey]['approved'] = $approved_value1+$hh_approved_data;
            $users_list[$ukey]['submitted'] = $submitted_value1+$hh_submited_data;
            $users_list[$ukey]['rejected'] = $rejected_value1+$hh_rejected_data;
            $users_list[$ukey]['transport'] = 1200;
            $users_list[$ukey]['int_bundles'] = 600;
			// if($approved_value1) $users_list[$ukey]['approved'] = $approved_value1+$hh_approved_data;
			// 	else $users_list[$ukey]['approved'] = 0;

			// if($submitted_value1) $users_list[$ukey]['submitted'] = $submitted_value1+$hh_submited_data;
			// 	else $users_list[$ukey]['submitted'] = 0;

			// if($rejected_value1) $users_list[$ukey]['rejected'] = $rejected_value1+$hh_rejected_data;
			// 	else $users_list[$ukey]['rejected'] = 0;
			$users_list[$ukey]['contributor_name'] = $user['first_name']." ".$user['last_name'];
			$data['r_contributor_id']=$user['user_id'];
            $user_task_value = $this->payment_tasks_data_by_user($data);
            $users_list[$ukey]['usertasksData']=$user_task_value;
		}
        // exit();
        
        $submited_data = $users_list;
        return $submited_data;
    }
    public function payment_contributors_records($data){

        if(!empty($data['respondent_id'])) {
			$this->db->select('data_id');
			$this->db->where('data_id', $data['respondent_id']);
			$respondent_list = $this->db->where('status', 1)->get('tbl_respondent_users')->row_array();
			// var_dump($this->db->last_query());exit;
		}
        $this->db->select('tu.*, tul.country_id, tul.sub_loc_id,tul.cluster_id,tul.uai_id');
        $this->db->from('tbl_users as tu');
		// $this->db->join('tbl_user_profile AS tup', 'tup.user_id = tu.user_id');
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
        // $this->db->where('uai_id !=', NULL);
		// $this->db->where('tu.status', 1);
        // $this->db->where('tul.status', 1);
		$this->db->where('tu.role_id', 8);
        if($data['is_pagination']){
            // $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
		$submited_data = $this->db->order_by('tu.user_id', 'DESC')->get()->num_rows();
		// $this->db->select('*');
		// $this->db->where('role_id', 8);
		// $this->db->where('status', 1);
		// if(!empty($data['contributor_id'])) {
		// 	$this->db->where('user_id', $data['contributor_id']);
		// }
		// // $users_list = $this->db->get('tbl_users')->result_array();
        // $submited_data = $this->db->get('tbl_users')->num_rows();
        return $submited_data;
    }
    public function payment_tasks_data_by_user($data){
        $data['contributor_id']=$data['r_contributor_id'];
        if(!empty($data['respondent_id'])) {
			$this->db->select('data_id');
			$this->db->where('data_id', $data['respondent_id']);
			$respondent_list = $this->db->where('status', 1)->get('tbl_respondent_users')->row_array();
			// var_dump($this->db->last_query());exit;
		}
        $this->db->select('survey_id');
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
            $this->db->where('sub_loc_id', $data['sub_location_id']);
        }
        if(!empty($data['contributor_id'])) {
            $this->db->where('user_id', $data['contributor_id']);
        }
        if(!empty($data['respondent_id'])) {
            
            $this->db->where('respondent_id', $respondent_list['data_id']);
        }	
        // $this->db->where('uai_id !=', NULL);
        // $this->db->where('respondent_id !=', NULL);
        $this->db->group_by('survey_id');
        $survey_list = $this->db->where('status', 1)->get('tbl_survey_assignee')->result_array();
        // print_r($this->db->last_query());exit();
        $survey_list1 = array();
        foreach ($survey_list as $key => $survey) {
            array_push($survey_list1,$survey['survey_id']);
        }


        // Get House hold survey submited Data
		$this->db->select('rp.id, concat(tu.first_name," ", tu.last_name) as added_by');
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
		$this->db->where('rp.pa_verified_status', 1);
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
		$hh_submited_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();

        // Get House hold survey approved Data
		$this->db->select('rp.id');
        $this->db->from('tbl_respondent_users as rp');
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
            $this->db->where('DATE(rp.pa_verified_date) >=', $data['start_date']);
            $this->db->where('DATE(rp.pa_verified_date) <=', $data['end_date']);
        }
		$this->db->where('rp.status', 1);
		$this->db->where('rp.pa_verified_status', 2);
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
		$hh_approved_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();

        // Get House hold survey rejected Data
		$this->db->select('rp.id');
        $this->db->from('tbl_respondent_users as rp');
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
            $this->db->where('DATE(rp.pa_verified_date) >=', $data['start_date']);
            $this->db->where('DATE(rp.pa_verified_date) <=', $data['end_date']);
        }
		$this->db->where('rp.status', 1);
		$this->db->where('rp.pa_verified_status', 3);
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
		$hh_rejected_data = $this->db->order_by('rp.id', 'DESC')->get()->num_rows();
        $payment_list1 =$this->db->select('price_per_survey')->where('survey_id', 1)->where('status', 1)->get('lkp_payment')->row_array();
		if(!empty($payment_list1)){
            $hh_payment_amount = $payment_list1['price_per_survey'] * $hh_approved_data;
        }else{
            $hh_payment_amount = 0;
        }

        $this->db->select('*');
		$this->db->where('status', 1);
        if(!empty($data['tasks']))
        {
            $this->db->where_in('id', $data['tasks']);
        }
        if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
        $this->db->order_by('type', 'ASC');
		$surveys = $this->db->get('form')->result_array();
        $count=0;
        
		foreach ($surveys as $key => $surv) {
            $count++;
			// Get approved
			$this->db->distinct()->select('id');
			$this->db->where('pa_verified_status',2);
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
			if(!empty($data['contributor_id'])) {
				$this->db->where('user_id', $data['contributor_id']);
			}
			if(!empty($data['respondent_id'])) {
				$this->db->where('respondent_data_id', $respondent_list['data_id']);
			}            
            if(!empty($data['start_date']) && !empty($data['end_date'])){
                $this->db->where('DATE(pa_verified_date) >=', $data['start_date']);
                $this->db->where('DATE(pa_verified_date) <=', $data['end_date']);
            }
			$approved = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();
            // print_r($this->db->last_query());exit();
			if($approved) $surveys[$key]['approved'] = $approved;
			else $surveys[$key]['approved'] = 0;

			// get submitted
			$this->db->distinct()->select('id');
			$this->db->where('pa_verified_status',1);
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
			if(!empty($data['contributor_id'])) {
				$this->db->where('user_id', $data['contributor_id']);
			}
			if(!empty($data['respondent_id'])) {
				$this->db->where('respondent_data_id', $respondent_list['data_id']);
			}
            if(!empty($data['start_date']) && !empty($data['end_date'])){
                $this->db->where('DATE(datetime) >=', $data['start_date']);
                $this->db->where('DATE(datetime) <=', $data['end_date']);
            }
			$submitted = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();

			if($submitted) $surveys[$key]['submitted'] = $submitted;
			else $surveys[$key]['submitted'] = 0;

			// get rejected
			$this->db->distinct()->select('id');
			$this->db->where('pa_verified_status',3);
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
			if(!empty($data['contributor_id'])) {
				$this->db->where('user_id', $data['contributor_id']);
			}
			if(!empty($data['respondent_id'])) {
				$this->db->where('respondent_data_id', $respondent_list['data_id']);
			}
            if(!empty($data['start_date']) && !empty($data['end_date'])){
                $this->db->where('DATE(pa_verified_date) >=', $data['start_date']);
                $this->db->where('DATE(pa_verified_date) <=', $data['end_date']);
            }
			$rejected = $this->db->where('status', 1)->get('survey'.$surv['id'])->num_rows();

			if($rejected) $surveys[$key]['rejected'] = $rejected;
			else $surveys[$key]['rejected'] = 0;

			$payment_list =$this->db->select('price_per_survey')->where('survey_id', $surv['id'])->where('status', 1)->get('lkp_payment')->row_array();
			if(!empty($payment_list)){
                $surveys[$key]['payment_amount'] = $payment_list['price_per_survey'] * $surveys[$key]['approved'];
            }else{
                $surveys[$key]['payment_amount'] = 0;
            }
		}
       
        $hh_array_data = array();
        $hh_array_data['id']= 12;
        $hh_array_data['title']="Household Profile";
        $hh_array_data['approved']=$hh_approved_data;
        $hh_array_data['submitted']=$hh_submited_data;
        $hh_array_data['rejected']=$hh_rejected_data;
        $hh_array_data['payment_amount']=$hh_payment_amount;
        array_push($surveys,$hh_array_data);

        $submited_data = $surveys;
        return $submited_data;
    }
    /*kaznet functions stat by end*/
}
