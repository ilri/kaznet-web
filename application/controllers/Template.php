<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url');

		$baseurl = base_url();
		$this->load->model('Auth_model');
		$this->load->model('User_model');
		$this->load->model('Helper_model');
		$this->load->library('uniqueid_lib');
		// $session_allowed = $this->Auth_model->match_account_activity();
		// if(!$session_allowed) redirect($baseurl.'auth/logout');
		
        $this->load->model('FormModel');
	}

	public function index(){
		show_404();
	}

	public function create_template(){
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
		$this->load->view('template/create', $result);
		$this->load->view('footer');
	}

	/*drag_gata form submit*/
	public function drag_data(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			redirect($baseurl);
		}
		else {
			date_default_timezone_set("UTC");
			$data = (array)json_decode(file_get_contents("php://input"));
			$returnData = array();
			$time = time();

			/*echo $_POST['formdata'];*/
			$title = $_POST['title'];
			$subject = $_POST['subject'];
			$location_val = $_POST['location_val'];
			if($location_val == 1){
				$location = 'true';
			}else{
				$location = NULL;
			}
			$datanew = array(
				/*'pm_id'=> $this->session->userdata('login_id'),*/
				'title' => htmlspecialchars($title, ENT_QUOTES),
				'subject' => htmlspecialchars($subject, ENT_QUOTES),
				'pic_min' => NULL,
				'pic_max' => NULL,
				'location' => $location,
				'public_id' => time().'-'.$this->session->userdata('login_id').'-'.$this->uniqueid_lib->shuffle(),
				'status' => 1
			);

			$formquery = $this->db->insert('custom_form',$datanew);

			if($formquery){
				$formlast_insertid = $this->db->insert_id();

				   	//Add id in form array and insert in query table as well as push to return array
				$datanew['id'] = $formlast_insertid;
				$queryData = array(
					'creator' => $this->session->userdata('login_id'),
					'type' => 'query',
					'action' => 'insert',
					'platform' => 'web',
					'time' => $time,
					'tablename' => 'form',
					'data' => json_encode($datanew)
				);
				$this->db->insert('query', $queryData);
				array_push($returnData, $queryData);

				$decode_data = json_decode($_POST['formdata']);
				
				$datafield = array();
				$datamultiple = array();
				foreach ($decode_data as $value) {
					$formarray = array(
						'form_id' => $formlast_insertid,
						'type' => isset($value->type) ? $value->type : '',
						'required' => isset($value->required) ? 1 : NULL,
						'label' => isset($value->label) ? trim(strip_tags($value->label)) : NULL,
						'description' => isset($value->description) ? $value->description : NULL,
						'name' => isset($value->name) ? $value->name : NULL,
						'subtype' => isset($value->subType) ? $value->subType : '',
						'maxlength' => isset($value->maxlength) ? $value->maxlength : NULL,
						'className' => isset($value->className) ? $value->className : '',
						'inline' => isset($value->inline) ? 'true' : NULL,
						'multiple' => isset($value->multiple) ? 'true' : NULL,
						'status' => 1
					);
					$formfieldquery = $this->db->insert('custom_form_field', $formarray);

					if($formfieldquery){
						$formfeildlast_insertid = $this->db->insert_id();

						$formarray['field_id'] = $formfeildlast_insertid;
						array_push($datafield, $formarray);

						if($value->type == 'radio-group'){
							foreach ($value->values as $option) {
								$formmultarray = array(
									'form_id' => $formlast_insertid,
									'field_id' => $formfeildlast_insertid,
									'label' => isset($option->label) ? trim(strip_tags($option->label)) : NULL,
									'selected' => isset($option->selected) ? 'true' : NULL,
									'value' => isset($option->value) ? trim(strip_tags($option->value)) : NULL,
									'status' => 1
								);
						       		//if(isset($option->selected)) $formmultarray['selected'] = 'true';
								$formmulquery = $this->db->insert('custom_form_field_multiple', $formmultarray);

								$formmultarray['multi_id'] = $this->db->insert_id();
								array_push($datamultiple, $formmultarray);
							}
						}

						if($value->type == 'checkbox-group'){
							foreach ($value->values as $option) {
								$formmultarray = array(
									'form_id' => $formlast_insertid,
									'field_id' => $formfeildlast_insertid,
									'label' => isset($option->label) ? trim(strip_tags($option->label)) : NULL,
									'selected' => isset($option->selected) ? 'true' : NULL,
									'value' => isset($option->value) ? trim(strip_tags($option->value)) : NULL,
									'status' => 1
								);
						       		//if(isset($option->selected)) $formmultarray['selected'] = 'true';
								$formmulquery = $this->db->insert('custom_form_field_multiple', $formmultarray);

								$formmultarray['multi_id'] = $this->db->insert_id();
								array_push($datamultiple, $formmultarray);
							}
						}

						if($value->type == 'select'){
							foreach ($value->values as $option) {
								$formmultarray = array(
									'form_id' => $formlast_insertid,
									'field_id' => $formfeildlast_insertid,
									'label' => isset($option->label) ? trim(strip_tags($option->label)) : NULL,
									'selected' => isset($option->selected) ? 'true' : NULL,
									'value' => isset($option->value) ? trim(strip_tags($option->value)) : NULL,
									'status' => 1
								);
								    //if(isset($option->selected)) $formmultarray['selected'] = 'true';
								$formmulquery = $this->db->insert('custom_form_field_multiple', $formmultarray);

								$formmultarray['multi_id'] = $this->db->insert_id();
								array_push($datamultiple, $formmultarray);
							}
						}
					}    
				}

				   	//field data insert in query table as well as push to return array
				$queryData = array(
					'creator' => $this->session->userdata('login_id'),
					'type' => 'query',
					'action' => 'insert',
					'platform' => 'web',
					'time' => $time,
					'tablename' => 'form_field',
					'data' => json_encode($datafield)
				);
				$this->db->insert('query', $queryData);
				array_push($returnData, $queryData);

				if(count($datamultiple) > 0) {
						//multiple data insert in query table as well as push to return array
					$queryData = array(
						'creator' => $this->session->userdata('login_id'),
						'type' => 'query',
						'action' => 'insert',
						'platform' => 'web',
						'time' => $time,
						'tablename' => 'form_field_multiple',
						'data' => json_encode($datamultiple)
					);
					$this->db->insert('query', $queryData);
					array_push($returnData, $queryData);
				}

				$data['msg'] = '<div class="alert dark alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
				</button>Form Created Successfully.
				</div>';
				$data['query'] = $returnData;
			}else{
				$data['msg'] = '<div class="alert dark alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
				</button>Failed to create survey. Please try again later.
				</div>';
			}
			echo json_encode($data);
			exit();
		}
	}

	/*Manage Template*/
	public function manage_templates(){
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

		$this->db->select();
		$this->db->from('custom_form');
		$this->db->where('status >', 0);
		$this->db->order_by('id', 'DESC');
		$forms = $this->db->get()->result_array();
		
		$result = array('forms' => $forms);

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
		$this->load->view('template/manage_template', $result);
	}

	/*View Template*/
	public function drag_form() {
    $baseurl = base_url();
    
    if ($this->session->userdata('login_id') == '') {
        redirect($baseurl);
    } else {
        $result = array();
        
        // Fetch all roles
        $all_roles = $this->User_model->all_roles();
        $result['all_roles'] = $all_roles;
        
        // Load dynamic menu model and fetch profile details
        $this->load->model('Dynamicmenu_model');
        $profile_details = $this->Dynamicmenu_model->user_data();
        $menu_result = array('profile_details' => $profile_details);
        
        // Get form ID from URL segment
        $formid = intval($this->uri->segment(3));
        
        if (empty($formid)) {
            show_404();
        }
        
        // Fetch form name
        $formname = $this->db->where('id', $formid)->get('custom_form')->row();
        
        if ($formname == NULL) {
            show_404();
        } else {
            // Fetch fields related to the form
            $fields = $this->db->query("SELECT * FROM custom_form_field WHERE form_id = ".$formid)->result_array();
            
            foreach ($fields as $key => $field) {
                $this->db->distinct();
                $this->db->select('multi_id, label, selected, value');
                $this->db->from('custom_form_field_multiple');
                $options = $this->db->where("field_id", $field['field_id'])->get()->result_array();
                $fields[$key]['options'] = $options;
                
                /*if ($field['type'] == 'ranking_system') {
                    $this->db->select('*');
                    $this->db->where('parent_id', $field['field_id'])->where('parent_value IS NULL');
                    $this->db->where('form_id', $formid)->where('status', 1)->order_by('slno');
                    $fields[$key]['options'] = $this->db->get('vd_complex_form_field')->result_array();
                }*/
            }
            
            $result = array('fields' => $fields, 'formname' => $formname);
            
            // Load views            
			$postData_ = array(
				"page_no" => 1,
				"status" => 1,
				"record_per_page" => 100,
				"is_pagination" => false
			);
			$customData = $this->FormModel->get_all_forms_p($postData_);
			$this->load->view('header');
			$this->load->view('sidebar', ['customData' => $customData]);
            $this->load->view('menu', $menu_result);
            $this->load->view('template/view_template', $result);
        }
    }
}

}