<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('User_model');
        $this->load->model('FormModel');
    }

    // Load form builder view
    public function create_form() {
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
        $this->load->view('menu', $menu_result);
        $this->load->view('template/create_form');
        $this->load->view('footer');
    }

    // Save form to database
    public function save_form() {
        $form_data = $this->input->post('form_data');
        $form_title = $this->input->post('form_title');
        $form_subject = $this->input->post('form_subject');
        $form_id = $this->FormModel->save_form($form_data, $form_title, $form_subject);
        if($form_id){
            
            define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');

            $msg = array(
                'body'		=> "".$form_title." has been created.\n
                            Please sync the application to reflect the changes.\n
                            Kindly reach out to the administrator adminkaznet@ilri.org in case of any further questions or assistance",
                'title'		=> "New Task has been created - ".$form_title,
                // 'content'	=> json_encode($content),
                'type'		=> "task",
                'vibrate'	=> 1,
                'sound'		=> 1,
            );

            // $fields = array(
            //     'registration_ids' => $pushtoken,
            //     'priority' => 'high',
            //     'data' => $msg
            // );
            $fields = array
            (
                'to'  => '/topics/contributor',
                'notification'          => $msg
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
        $result['form_id'] = $form_id;
		$result['msg'] = 'Successfully created task.';
		echo json_encode($result);
		exit();
        // echo json_encode(['form_id' => $form_id]);
    }
    // Save form to database
    public function update_form() {
        $form_id = $this->input->post('form_id');
        $form_data = $this->input->post('form_data');
        $form_title = $this->input->post('form_title');
        $form_subject = $this->input->post('form_subject');
        $form_id = $this->FormModel->update_form($form_id, $form_data, $form_title, $form_subject);
        $result['status'] = 1;
        $result['form_id'] = $form_id;
		$result['msg'] = 'Successfully updated task.';
		echo json_encode($result);
		exit();
        // echo json_encode(['form_id' => $form_id]);
    }

    // Load form by ID and render it
    public function render_form($form_id) {
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
        $form_data = $this->FormModel->get_form($form_id);
        $form_details = $this->db->where('id', $form_id)->get('forms')->row_array();
        $data['form_data'] = $form_data;
        $data['form_id'] = $form_id;
        $data['form_title'] = $form_details['title'];
        
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
        $this->load->view('template/render_form', $data);
        $this->load->view('footer');
    }

     // Load form by ID and  form edit
     public function edit_form($form_id) {
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
        $form_data = $this->FormModel->get_form_fields_data($form_id);
        $form_details = $this->db->where('id', $form_id)->get('forms')->row_array();
        $data['form_data'] = $form_data;
        $data['form_id'] = $form_id;
        $data['form_title'] = $form_details['title'];
        $data['form_subject'] = $form_details['subject'];
       
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
        $this->load->view('template/edit_form', $data);
        $this->load->view('footer');
    }

    /*public function submit_form() {
    header('Content-Type: application/json');

    // Get POST data
    $form_id = $this->input->post('form_id');
    $submitted_data = $this->input->post('submitted_data');

    if (empty($form_id) || empty($submitted_data)) {
        log_message('error', 'Invalid form data. Form ID or Submitted Data is empty.');
        echo json_encode(['status' => 'error', 'message' => 'Invalid form data']);
        exit();
    }

    // Process the data (you can customize this part as needed)
    $data = [
        'form_id' => $form_id,
        'data' => $submitted_data // Ensure this is JSON encoded
    ];

    // Attempt to insert data
    if ($this->db->insert('submitted_data', $data)) {
        log_message('debug', 'Data successfully inserted into the database.');
        echo json_encode(['status' => 'success']);
    } else {
        // Log database errors if insertion fails
        $error = $this->db->error();
        log_message('error', 'Database insertion failed: ' . json_encode($error));
        echo json_encode(['status' => 'error', 'message' => 'Failed to save form data']);
    }

    // Ensure script terminates after outputting the response
    exit();
}*/

    public function submit_form() {
        header('Content-Type: application/json');

        $form_id = $this->input->post('form_id');
        $submitted_data = $this->input->post();

        if (empty($form_id)) {
            log_message('error', 'Invalid task data. Task ID is empty.');
            echo json_encode(['status' => 'error', 'message' => 'Invalid task data']);
            exit();
        }

        // Handle file uploads
        if (!empty($_FILES)) {
            $this->load->library('upload');
            
            $count=0;
            // $totalFiles = count($_FILES['files']['name']);
            foreach ($_FILES as $field => $file) {
                $uploaded_files = [];
                $files_value = '';
                $count++;
                // Check if multiple files are uploaded (for fields with multiple files)
                if (is_array($file['name'])) {
                    $fileCount = count($file['name']);
                        
                    // Loop through all files in the field
                    for ($i = 0; $i < $fileCount; $i++) {
                        $fileName = $file['name'][$i];
                        $fileTmpName = $file['tmp_name'][$i];
                        $fileError = $file['error'][$i];
                        // $config['upload_path'] = './uploads/survey';
                        // $config['allowed_types'] = 'jpg|png|gif|pdf|docx|csv|xlsx';
                        // $this->upload->initialize($config);

                        // if ($this->upload->do_upload($field[$i])) {
                            // $uploaded_data = $this->upload->data();
                        $targetDir = './uploads/survey';
                        $targetFile = $targetDir . basename($fileName);

                        // Only pass a single string (the temp file path) to move_uploaded_file
                        if (move_uploaded_file($fileTmpName, $targetFile)) {
                            $uploaded_files[$field] = $fileName;
                            $files_value .= $fileName. ', ';
                            
                        } else {
                            log_message('error', 'File upload error: ' . $this->upload->display_errors());
                            // echo json_encode(['status' => 'error', 'message' => 'File upload failed: ' . $this->upload->display_errors()]);
                            // exit();
                        }
                    }
                    
                }else{
                    $fileName = $file['name'];
                    $fileTmpName = $file['tmp_name'];
                    $fileError = $file['error'];
                    $targetDir = './uploads/survey';
                    $targetFile = $targetDir . basename($fileName);
                    // Only pass a single string (the temp file path) to move_uploaded_file
                    if (move_uploaded_file($fileTmpName, $targetFile)) {
                        $uploaded_files[$field] = $fileName;
                        $files_value .= $fileName. ', ';
                        
                    } else {
                        log_message('error', 'File upload error: ' . $this->upload->display_errors());
                        // echo json_encode(['status' => 'error', 'message' => 'File upload failed: ' . $this->upload->display_errors()]);
                        // exit();
                    }
                }
                $files_value = rtrim($files_value, ', ');
                $submitted_data[$field] = $files_value;
            }
            
            
            
            // // Merge uploaded file names with submitted data
            // foreach ($uploaded_files as $field => $file_names) {
            //     // $submitted_data[$field] = is_array($file_names) ? $file_names : $file_names;
            // }
            // $submitted_data[$field_name] = $files_value;
        }

        // Process the rest of the data
        $data = [
            'form_id' => $form_id,
            'data' => json_encode($submitted_data)
        ];

        //added by sagar for updating user related data while record inserting in to table
        $time = time();
        date_default_timezone_set('UTC');
        $currentDateTime = date('Y-m-d H:i:s');
        $data['data_id'] = $time.'-'.$this->session->userdata('login_id');
        $data['user_id'] = $this->session->userdata('login_id');
        $data['datetime']=$currentDateTime;
        $data['ip_address'] = $this->input->ip_address();

        // Insert data into the database
        if ($this->db->insert('submitted_data', $data)) {
            log_message('debug', 'Data successfully inserted into the database.');
            echo json_encode(['status' => 'success']);
        } else {
            $error = $this->db->error();
            log_message('error', 'Database insertion failed: ' . json_encode($error));
            echo json_encode(['status' => 'error', 'message' => 'Failed to save task data']);
        }

        exit();
    }







    // Fetch and display all forms
    public function list_forms() {
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
        $forms = $this->FormModel->get_all_forms();
        $data['forms'] = $forms;
                
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
        $this->load->view('template/list_forms', $data);
        $this->load->view('footer');
    }
    public function get_forms_list() {
        if(($this->session->userdata('login_id') == '')) {
            $baseurl = base_url();
            redirect($baseurl);
        }
        $survey_id = $this->input->post('survey_id');
        // $survey_id = $this->input->post('survey_id');
        // $survey_id = $this->input->post('survey_id');
        $page_no =  1;
        $record_per_page = 100;
        if($this->input->post('pagination')){
            $pagination = $this->input->post('pagination');
            $page_no = $pagination['pageNo'] != null ? $pagination['pageNo'] : 1;
            $record_per_page = $pagination['recordperpage'] != null ? $pagination['recordperpage'] : 100;
        }
        $data = array(
            'survey_id' => $survey_id,
            "page_no" => $page_no,
            "status" => $this->input->post('status'),
            "record_per_page" => $record_per_page,
            "is_pagination" => $this->input->post('pagination') != null
        );
        // print_r($data);exit();
        // $submitted_data = $this->FormModel->get_forms_list($data);
        // $submitted_data['total_records'] = $this->FormModel->get_forms_list_r_count($survey_id); //added by sagar for pagenation
        $submitted_data['user_role'] = $this->session->userdata('role');
        $submitted_data['data'] = $this->FormModel->get_all_forms_p($data);
        $submitted_data['total_records'] = count($this->FormModel->get_all_forms_count($data));
        // $result['submitted_data'] = $submitted_data;
        echo json_encode($submitted_data);
		exit();
    }

    // View form data by form ID
    public function view_form_data($form_id) {
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
        // $submitted_data = $this->FormModel->get_submitted_data($form_id);
        // $data['submitted_data'] = $submitted_data;
        $data = array();
        $form_details = $this->db->where('id', $form_id)->get('forms')->row_array();
        $data['form_title'] = $form_details['title'];

		$this->db->select('lc.*, tul.country_id')->from('lkp_country as lc')->join('tbl_user_unit_location AS tul', 'tul.country_id = lc.country_id');
		if($this->session->userdata('role') != 1){
			$this->db->where('tul.user_id', $user_id);
		}
		$data['lkp_country'] = $this->db->where('lc.status', 1)->group_by('tul.country_id')->get()->result_array();
        /*echo '<pre>';
            print_r($submitted_data);
        echo '</pre>';
        die();*/
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
        $this->load->view('template/view_form_data', $data);
        $this->load->view('footer');
    }
    public function get_form_data() {
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
			$survey_id = $this->input->post('survey_id');
			$survey_type = $this->input->post('survey_type');

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
				'survey_id' => $survey_id,
				'survey_type' => $survey_type,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"pa_verified_status" => $pa_verified_status,
				"is_pa_verified_status" => $pa_verified_status != null,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);
		
			// print_r($data);exit();
			$submitted_data = $this->FormModel->get_submitted_data($data);
			$submitted_data['total_records'] = $this->FormModel->get_submitted_data_r_count($data); //added by sagar for pagenation
			$submitted_data['formdetails'] = $this->FormModel->get_all_forms($survey_id);
			$submitted_data['user_role'] = $this->session->userdata('role');
			$submitted_data['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
			$submitted_data['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();
			$submitted_data['lkp_uai'] = $this->db->select('*')->where('status', 1)->get('lkp_uai')->result_array();
			$submitted_data['lkp_sub_location'] = $this->db->select('*')->where('status', 1)->get('lkp_sub_location')->result_array();
			$submitted_data['lkp_location_type'] = $this->db->select('*')->where('status', 1)->get('lkp_location_type')->result_array();
			$submitted_data['lkp_animal_type_lactating'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type_lactating')->result_array();
			$submitted_data['respondent_name'] = $this->db->select('first_name, last_name,data_id')->where('status', 1)->get('tbl_respondent_users')->result_array();
			$submitted_data['lkp_market'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
			$submitted_data['lkp_lr_body_condition'] = $this->db->select('*')->where('status', 1)->get('lkp_lr_body_condition')->result_array();
			$submitted_data['lkp_sr_body_condition'] = $this->db->select('*')->where('status', 1)->get('lkp_sr_body_condition')->result_array();
			$submitted_data['lkp_animal_type'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type')->result_array();
			$submitted_data['lkp_animal_herd_type'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_herd_type')->result_array();
			$submitted_data['lkp_food_groups'] = $this->db->select('*')->where('status', 1)->get('lkp_food_groups')->result_array();
			$submitted_data['lkp_transect_pasture'] = $this->db->select('*')->where('status', 1)->get('lkp_transect_pasture')->result_array();
			$submitted_data['lkp_dry_wet_pasture'] = $this->db->select('*')->where('status', 1)->get('lkp_dry_wet_pasture')->result_array();
			$submitted_data['lkp_transport_means'] = $this->db->select('*')->where('status', 1)->get('lkp_transport_means')->result_array();

			// $result['submitted_data'] = $submitted_data;
			echo json_encode($submitted_data);
			exit();
		}
    }

	public function get_form_data_export(){
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
			$survey_id = $this->input->post('survey_id');
			$survey_type = $this->input->post('survey_type');

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
				'survey_id' => $survey_id,
				'survey_type' => $survey_type,
				"search_input" => $search_input,
				"is_search" => $search_input != null,
				"pa_verified_status" => $pa_verified_status,
				"is_pa_verified_status" => $pa_verified_status != null,
				"page_no" => $page_no,
				"record_per_page" => $record_per_page,
				"is_pagination" => $this->input->post('pagination') != null
			);

			$submitted_data = $this->FormModel->get_submitted_data($data);
			// $submitted_data['total_records'] = $this->FormModel->get_submitted_data_r_count($survey_id); //added by sagar for pagenation
			$submitted_data['formdetails'] = $this->FormModel->get_all_forms($survey_id);
			$submitted_data['user_role'] = $this->session->userdata('role');
			$submitted_data['lkp_country'] = $this->db->select('*')->where('status', 1)->get('lkp_country')->result_array();
			$submitted_data['lkp_cluster'] = $this->db->select('*')->where('status', 1)->get('lkp_cluster')->result_array();
			$submitted_data['lkp_uai'] = $this->db->select('*')->where('status', 1)->get('lkp_uai')->result_array();
			$submitted_data['lkp_sub_location'] = $this->db->select('*')->where('status', 1)->get('lkp_sub_location')->result_array();
			$submitted_data['lkp_location_type'] = $this->db->select('*')->where('status', 1)->get('lkp_location_type')->result_array();
			$submitted_data['lkp_animal_type_lactating'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type_lactating')->result_array();
			$submitted_data['respondent_name'] = $this->db->select('first_name, last_name,data_id')->where('status', 1)->get('tbl_respondent_users')->result_array();
			$submitted_data['lkp_market'] = $this->db->select('*')->where('status', 1)->get('lkp_market')->result_array();
			$submitted_data['lkp_lr_body_condition'] = $this->db->select('*')->where('status', 1)->get('lkp_lr_body_condition')->result_array();
			$submitted_data['lkp_sr_body_condition'] = $this->db->select('*')->where('status', 1)->get('lkp_sr_body_condition')->result_array();
			$submitted_data['lkp_animal_type'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_type')->result_array();
			$submitted_data['lkp_animal_herd_type'] = $this->db->select('*')->where('status', 1)->get('lkp_animal_herd_type')->result_array();
			$submitted_data['lkp_food_groups'] = $this->db->select('*')->where('status', 1)->get('lkp_food_groups')->result_array();
			$submitted_data['lkp_transect_pasture'] = $this->db->select('*')->where('status', 1)->get('lkp_transect_pasture')->result_array();
			$submitted_data['lkp_dry_wet_pasture'] = $this->db->select('*')->where('status', 1)->get('lkp_dry_wet_pasture')->result_array();
			$submitted_data['lkp_transport_means'] = $this->db->select('*')->where('status', 1)->get('lkp_transport_means')->result_array();

			// $result['submitted_data'] = $submitted_data;
			echo json_encode($submitted_data);
			exit();

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
            
            $time = time();
            date_default_timezone_set('UTC');
            $currentDateTime = date('Y-m-d H:i:s');
            $data['status'] = '0';
            $data['deleted_by'] = $this->session->userdata('login_id');
            $data['deleted_datetime']=$currentDateTime;
			$delete_data = $this->db->where('id', $_POST['id'])->update('forms', $data);
            $form_id = $_POST['id'];
            $form_title = $_POST['name'];
			if($delete_data){
                if($form_id){
            
                    define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');
        
                    $msg = array(
                        'body'		=> "".$form_title." has been created.\n
                                    Please sync the application to reflect the changes.\n
                                    Kindly reach out to the administrator adminkaznet@ilri.org in case of any further questions or assistance",
                        'title'		=> "New Task has been created - ".$form_title,
                        // 'content'	=> json_encode($content),
                        'type'		=> "task",
                        'vibrate'	=> 1,
                        'sound'		=> 1,
                    );
        
                    // $fields = array(
                    //     'registration_ids' => $pushtoken,
                    //     'priority' => 'high',
                    //     'data' => $msg
                    // );
                    $fields = array
                    (
                        'to'  => '/topics/contributor',
                        'notification'          => $msg
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
				$msg = 'Task deleted Successfully!';
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
    public function restoreData()
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
            
            $time = time();
            date_default_timezone_set('UTC');
            $currentDateTime = date('Y-m-d H:i:s');
            $data['status'] = '1';
            // $data['deleted_by'] = $this->session->userdata('login_id');
            // $data['deleted_datetime']=$currentDateTime;
			$delete_data = $this->db->where('id', $_POST['id'])->update('forms', $data);
			if($delete_data){
				$msg = 'Task restored Successfully!';
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
    //from here mangae coustom task
    public function f_manage_task(){
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
		$this->db->where('status', 1);
		// $this->db->order_by('type');
		$surveys = $this->db->get('forms')->result_array();
		foreach ($surveys as $key => $surv) {
			// Get total assigned
			$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
			$total = $this->db->where('status', 1)->get('tbl_f_survey_assignee')->num_rows();

			if($total) $surveys[$key]['assigned'] = $total;
			else $surveys[$key]['assigned'] = 0;

			// get not yet started contributors count
			$this->db->select('*')->where('survey_id', $surv['id']);
			$this->db->where('start_date >', date("Y-m-d"));
			$nstotal = $this->db->where('status', 1)->get('tbl_f_survey_assignee')->num_rows();

			if($nstotal) $surveys[$key]['nstotal'] = $nstotal;
			else $surveys[$key]['nstotal'] = 0;

			// get Active contributors count
			$this->db->select('*')->where('survey_id', $surv['id']);
			$this->db->where('start_date <=', date("Y-m-d"));
			$this->db->where('end_date >=', date("Y-m-d"));
			$actotal = $this->db->where('status', 1)->get('tbl_f_survey_assignee')->num_rows();
			// print_r($this->db->last_query());exit();

			if($actotal) $surveys[$key]['actotal'] = $actotal;
			else $surveys[$key]['actotal'] = 0;

			// get Expired contributors count
			$this->db->select('*')->where('survey_id', $surv['id']);
			$this->db->where('end_date <', date("Y-m-d"));
			$extotal = $this->db->where('status', 1)->get('tbl_f_survey_assignee')->num_rows();
			if($surv['id']==6){

				// print_r($this->db->last_query());exit();
			}
			

			if($extotal) $surveys[$key]['extotal'] = $extotal;
			else $surveys[$key]['extotal'] = 0;
		}
		$result['surveys_ht'] = $surveys;

		// $this->db->where('type', 'Market Task')->where('status', 1);
		// // $this->db->order_by('type');
		// $surveys_mt = $this->db->get('form')->result_array();
		// foreach ($surveys_mt as $key => $surv) {
		// 	// Get total assigned
		// 	$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
		// 	$total = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

		// 	if($total) $surveys_mt[$key]['assigned'] = $total;
		// 	else $surveys_mt[$key]['assigned'] = 0;

		// 	// get not yet started contributors count
		// 	$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
		// 	$this->db->where('start_date >', date("Y-m-d"));
		// 	$nstotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

		// 	if($nstotal) $surveys_mt[$key]['nstotal'] = $nstotal;
		// 	else $surveys_mt[$key]['nstotal'] = 0;

		// 	// get Active contributors count
		// 	$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
		// 	$this->db->where('start_date <=', date("Y-m-d"));
		// 	$this->db->where('end_date >=', date("Y-m-d"));
		// 	$actotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

		// 	if($actotal) $surveys_mt[$key]['actotal'] = $actotal;
		// 	else $surveys_mt[$key]['actotal'] = 0;

		// 	// get Expired contributors count
		// 	$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
		// 	$this->db->where('end_date <', date("Y-m-d"));
		// 	$extotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

		// 	if($extotal) $surveys_mt[$key]['extotal'] = $extotal;
		// 	else $surveys_mt[$key]['extotal'] = 0;
		// }
		// $result['surveys_mt'] = $surveys_mt;

		// $this->db->where('type', 'Rangeland Task')->where('status', 1);
		// // $this->db->order_by('type');
		// $surveys_rt = $this->db->get('form')->result_array();
		// foreach ($surveys_rt as $key => $surv) {
		// 	// Get total assigned
		// 	$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
		// 	$total = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

		// 	if($total) $surveys_rt[$key]['assigned'] = $total;
		// 	else $surveys_rt[$key]['assigned'] = 0;

		// 	// get not yet started contributors count
		// 	$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
		// 	$this->db->where('start_date >', date("Y-m-d"));
		// 	$nstotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

		// 	if($nstotal) $surveys_rt[$key]['nstotal'] = $nstotal;
		// 	else $surveys_rt[$key]['nstotal'] = 0;

		// 	// get Active contributors count
		// 	$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
		// 	$this->db->where('start_date <=', date("Y-m-d"));
		// 	$this->db->where('end_date >=', date("Y-m-d"));
		// 	$actotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

		// 	if($actotal) $surveys_rt[$key]['actotal'] = $actotal;
		// 	else $surveys_rt[$key]['actotal'] = 0;

		// 	// get Expired contributors count
		// 	$this->db->distinct()->select('*')->where('survey_id', $surv['id']);
		// 	$this->db->where('end_date <', date("Y-m-d"));
		// 	$extotal = $this->db->where('status', 1)->get('tbl_survey_assignee')->num_rows();

		// 	if($extotal) $surveys_rt[$key]['extotal'] = $extotal;
		// 	else $surveys_rt[$key]['extotal'] = 0;
		// }
		// $result['surveys_rt'] = $surveys_rt;

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
		$this->load->view('template/f_manage_task', $result);
		$this->load->view('footer');
	}
	
	public function f_assign_task(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}

		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		
		$result = array();

		// $task_type = $this->uri->segment(3);
		// $result['task_type'] = ($task_type && strlen($task_type) > 0) ? urldecode($task_type) : null;

		$task = $this->uri->segment(3);
		$result['task'] = ($task && strlen($task) > 0) ? $task : null;
		
		// Get all tasks types
		$tasks_types = $this->db->distinct()->select('type')->where('status', 1)->get('form')->result_array();
		$result['tasks_types'] = $tasks_types;

		// Get all countries
		$countries = $this->db->where('status', 1)->get('lkp_country')->result_array();
		$result['countries'] = $countries;

		// var_dump($result); die();

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
		$this->load->view('template/f_assign_task', $result);
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

		// if(!$this->input->post('task_type') || $this->input->post('task_type') == '') {
		// 	$result['status'] = 0;
		// 	$result['msg'] = 'Invalid request. Please refresh the page and try again.';

		// 	echo json_encode($result);
		// 	exit();
		// }

		// $task_type = $this->input->post('task_type');

		// Get all tasks
		$tasks = $this->db->where('status', 1)->get('forms')->result_array();
		$result['tasks'] = $tasks;

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
		// if(!isset($type) || strlen($type) === 0) {
		// 	$result['status'] = 0;
		// 	$result['msg'] = 'Task type selection is mandatory.';

		// 	echo json_encode($result);
		// 	exit();
		// }
		
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
				
				// if(strtolower($type) == 'household task') {
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
						))->get('tbl_f_survey_assignee');
                        $result1 =  $assignment->num_rows();
                        
                        if($result1 > 0) {
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
						$this->db->insert_batch('tbl_f_survey_assignee', $insertArray);
					
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
				// }

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
			$msg1 .= 'You can check the assignment details in Custom Tasks --> Task Contributors';
		}else if(count($errorResps) > 0 && count($succResps) == 0) {
			$result['status'] = 0;
			$msg .= 'Task(s) which are already assigned in the given date range, are not updated.';
			$msg1 .= 'You can check the assignment details in Custom Tasks --> Task Contributors';
		}else if(count($succResps) > 0 && count($errorResps) > 0) {
			$result['status'] = 2;
			$msg .= 'Task(s) have been successfully assigned.';
			$msg1 .= 'Task(s) which are already assigned in the given date range, are not updated.';
			$msg2 .= 'You can check the assignment details in Custom Tasks --> Task Contributors';
		}
		$result['msg'] = $msg;
		$result['msg1'] = $msg1;
		$result['msg2'] = $msg2;

		echo json_encode($result);
		exit();
	}
    public function f_task_contributer(){
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
			$tasks = $this->db->where('status', 1)->get('forms')->result_array();
			$result['tasks_list'] = $tasks;
		}else{
			// Get all tasks
			$tasks = $this->db->where('status', 1)->get('forms')->result_array();
			$result['tasks_list'] = $tasks;
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
		$this->load->view('template/f_task_contributer', $result);
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
		// $task_list1 =$this->db->select('type')->where('id', $survey_id)->where('status', 1)->get('forms')->row_array();
        // if($task_type){
        //     $task_type = $task_list1['type'];
        // }else{
            $task_type ="N/A";
        // }
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
		if($data['is_pagination']){
            $this->db->limit($data['record_per_page'],($data['record_per_page']*$data['page_no'])-($data['record_per_page']));
        }
		$contributor_list = $this->db->where('status', 1)->get('tbl_f_survey_assignee as survey')->result_array();
		print_r($this->db->last_query());
		// print_r($this->db->last_query());exit();
		foreach ($contributor_list as $ckey => $contributor) {
			$task_list =$this->db->select('title')->where('id', $contributor['survey_id'])->where('status', 1)->get('forms')->row_array();
			if(!empty($task_list)){
				$contributor_list[$ckey]['task_name'] = $task_list['title'];
			}else{
				$contributor_list[$ckey]['task_name'] = "";
			}

			$country_list =$this->db->select('name')->where('country_id', $contributor['country_id'])->where('status', 1)->get('lkp_country')->row_array();
			if(!empty($country_list)){
				$contributor_list[$ckey]['country_name'] = $country_list['name'];
			}else{
				$contributor_list[$ckey]['country_name'] ="";
			}

			$cluster_list =$this->db->select('name')->where('cluster_id', $contributor['cluster_id'])->where('status', 1)->get('lkp_cluster')->row_array();
			if(!empty($cluster_list)){
				$contributor_list[$ckey]['cluster_name'] = $cluster_list['name'];
			}else{
				$contributor_list[$ckey]['cluster_name'] = "";
			}

			$uai_list =$this->db->select('uai')->where('uai_id', $contributor['uai_id'])->where('status', 1)->get('lkp_uai')->row_array();
			if(!empty($uai_list)){
				$contributor_list[$ckey]['uai_name'] = $uai_list['uai'];
			}else{
				$contributor_list[$ckey]['uai_name'] = "";
			}

			$sub_loc_list =$this->db->select('location_name')->where('sub_loc_id', $contributor['sub_loc_id'])->where('status', 1)->get('lkp_sub_location')->row_array();
			if(!empty($sub_loc_list)){
				$contributor_list[$ckey]['location_name'] = $sub_loc_list['location_name'];
			}else{
				$contributor_list[$ckey]['location_name'] = "";
			}

			$user_list =$this->db->select('first_name,last_name')->where('user_id', $contributor['user_id'])->where('status', 1)->get('tbl_users')->row_array();
			if(!empty($user_list)){
				$contributor_list[$ckey]['contributor_name'] = $user_list['first_name']." ".$user_list['last_name'];
			}else{
				$contributor_list[$ckey]['contributor_name'] = "";
			}

			$respondent_list =$this->db->select('first_name,last_name')->where('data_id', $contributor['respondent_id'])->where('status', 1)->get('tbl_respondent_users')->row_array();
			if(!empty($respondent_list)){
				$contributor_list[$ckey]['respondent_name'] = $respondent_list['first_name']." ".$respondent_list['last_name'];
			}else{
				$contributor_list[$ckey]['respondent_name'] = "";
			}
			// $contributor_list[$ckey]['respondent_name'] = $contributor['user_id'];

			$this->db->select('name')->where('market_id', $contributor['market_id']);
			$market_name_list = $this->db->where('status', 1)->get('lkp_market')->row_array();
			if(!empty($market_name_list)){
				$contributor_list[$ckey]['market_name'] = $market_name_list['name'];
			}else{
				$contributor_list[$ckey]['market_name'] = "";
			}

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
		print_r($this->db->last_query());

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
		$submited_data = $this->db->where('survey.status', 1)->get('tbl_f_survey_assignee as survey')->num_rows();
		print_r($this->db->last_query());
        
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
		$unassign_survey_list = $this->db->where_in('assignee_id', $_POST['assignee_id'])->get('tbl_f_survey_assignee')->result_array();
		foreach ($unassign_survey_list as $skey => $survey) {
			array_push($survey_ids , $survey['survey_id']);
			array_push($contributer , $survey['user_id']);
		}
		$survey_list = $this->db->where_in('id', $survey_ids)->where('status', 1)->get('form')->result_array();
		$reject_user = $this->db->where('assignee_id', $_POST['assignee_id'])->update('tbl_f_survey_assignee', array(
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
		$unassign_survey_list = $this->db->where_in('assignee_id', $ids)->get('tbl_f_survey_assignee')->result_array();
		foreach ($unassign_survey_list as $skey => $survey) {
			array_push($survey_ids , $survey['survey_id']);
			array_push($contributer , $survey['user_id']);
		}
		$survey_list = $this->db->where_in('id', $survey_ids)->where('status', 1)->get('form')->result_array();
		// foreach ($ids as $id) {
			$reject_user = $this->db->where_in('assignee_id', $ids)->update('tbl_f_survey_assignee', array(
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
}
?>
