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
        $this->load->view('header');
        $this->load->view('sidebar');
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
        $result['status'] = 1;
        $result['form_id'] = $form_id;
		$result['msg'] = 'Successfully created form.';
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
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('menu', $menu_result);
        $this->load->view('template/render_form', $data);
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
            log_message('error', 'Invalid form data. Form ID is empty.');
            echo json_encode(['status' => 'error', 'message' => 'Invalid form data']);
            exit();
        }

        // Handle file uploads
        if (!empty($_FILES)) {
            $this->load->library('upload');
            $uploaded_files = [];
            $files_value = '';
            $count=0;
            // $totalFiles = count($_FILES['files']['name']);
            foreach ($_FILES as $field => $file) {
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
            }
            $files_value = rtrim($files_value, ', ');
            $submitted_data[$field] = $files_value;
            
            
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
            echo json_encode(['status' => 'error', 'message' => 'Failed to save form data']);
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
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('menu', $menu_result);
        $this->load->view('template/list_forms', $data);
        $this->load->view('footer');
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
        /*echo '<pre>';
            print_r($submitted_data);
        echo '</pre>';
        die();*/
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('menu', $menu_result);
        $this->load->view('template/view_form_data', $data);
        $this->load->view('footer');
    }
    public function get_form_data() {
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
            "record_per_page" => $record_per_page,
            "is_pagination" => $this->input->post('pagination') != null
        );
        // print_r($data);exit();
        $submitted_data = $this->FormModel->get_submitted_data($data);
        $submitted_data['total_records'] = $this->FormModel->get_submitted_data_r_count($survey_id); //added by sagar for pagenation
        $submitted_data['formdetails'] = $this->FormModel->get_all_forms($survey_id);
        // $result['submitted_data'] = $submitted_data;
        echo json_encode($submitted_data);
		exit();
    }
}
?>
