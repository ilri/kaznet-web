<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sync extends CI_Controller {

	public function __construct()
	{
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Content-Type: Application/json");
		header("Accept: application/json");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}

		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
	}

	//Load Methods According to Client Request
	public function index()
	{
		$data = (array)json_decode(file_get_contents("php://input"));
		if(!isset($data['purpose'])) {
			$this->logout();
		}
		
		switch ($data['purpose']) {
			case 'download':
				$this->download($data);
				break;

			case 'upload':
				$this->upload($data);
				break;

			default:
				$this->logout();
				break;
		}
	}

	// Download Server Data to Local
	public function download($data)
	{
		if(!$data) $this->logout();
		$limit = !empty($data['limit']) ? (array)$data['limit'] : array();

		// Get circles assigned to user
		// $this->db->distinct()->select('CIR_CODE');
		// $this->db->where('UNIT_ID', $data['unit_id'])->where('user_id', $data['user_id']);
		// $assignedLoc = $this->db->where('status', 1)->get('tbl_user_unit_location')->result_array();
		// $circles = array();
		// foreach ($assignedLoc as $key => $value) {
		// 	if(!in_array($value['CIR_CODE'], $circles)) array_push($circles, $value['CIR_CODE']);
		// }

		ini_set('memory_limit', '-1');

		$tables = array(
			'query' => 'id',
			'form' => 'id',
			'form_field' => 'field_id',
			'form_field_multiple' => 'multi_id',
			'lkp_age_group' => 'age_group_id',
			'lkp_animal_herd_type' => 'id',
			'lkp_animal_type' => 'animal_type_id',
			'lkp_animal_type_lactating' => 'animal_type_lactating_id',
			'lkp_cluster' => 'cluster_id',
			'lkp_country' => 'country_id',
			'lkp_dry_wet_pasture' => 'id',
			'lkp_food_groups' => 'id',
			'lkp_gender' => 'GENDER_ID',
			'lkp_location_type' => 'location_id',
			'lkp_lr_body_condition' => 'id',
			'lkp_sr_body_condition' => 'id',
			'lkp_transect_pasture' => 'id',
			'tbl_respondent_users' => 'id',
			'tbl_respondent_hh_detail' => 'id',
			'tbl_respondent_child_detail' => 'id',
			'survey1' => 'id',
			'survey1_groupdata' => 'id',
			'survey2' => 'id',
			'survey3' => 'id',
			'survey4' => 'id',
			'survey5' => 'id',
			'survey6' => 'id',
			'survey7' => 'id',
			'survey8' => 'id',
			'survey9' => 'id',
			'survey10' => 'id',
			'survey11' => 'id',
			'survey12' => 'id',
			'survey13' => 'id',
			'survey14' => 'id',
			'lkp_county' => 'county_id',
			'lkp_africa_countries' => 'country_id',
			'lkp_market' => 'market_id',
			'lkp_group' => 'group_id',
			'lkp_education_level' => 'edu_id',
			'lkp_occupation' => 'occu_id',
			'lkp_transport_means' => 'transport_id',
			'lkp_issues_imapct_on_household' => 'id',
			'ic_data_location' => 'id',
			'ic_data_file' => 'id',
			'survey1_groupdata' => 'id',
			'survey3_groupdata' => 'id',
			'survey10_groupdata' => 'id',
			'survey6_groupdata' => 'id',
			'lkp_uai' => 'uai_id',
			'lkp_sub_location' => 'sub_loc_id',
			'tbl_survey_assignee' => 'assignee_id',
			'tbl_f_survey_assignee' => 'assignee_id',
			'lkp_payment' => 'survey_id',
			'tbl_user_profile' => 'id',
			'tbl_transect_pastures' => 'id',
			'forms' => 'id',
			'submitted_data' => 'id'
		);
		$structure = $records = array();
		
		//Get all Table Stucture and Data for Mobile Sync
		foreach($tables as $table => $pk) {
			// Get table structure
			// if(count($limit) === 0) {
				$fields = $this->db->field_data($table);
				foreach($fields as $key => $field) {
					if($fields[$key]->name == $pk) {
						if($table == 'ic_form_data' || $table == 'ic_form_group_data'
						|| $table == 'ic_data_location' || $table == 'ic_data_file'
						|| $table == 'tbl_farmers' || $table == 'tbl_farmer_bank_details'
						|| $table == 'tbl_farmer_other_details' || $table == 'tbl_farm_details'
						|| $table == 'tbl_plot' || $table == 'tbl_agreement'
						|| $table == 'tbl_kmlfile' || $table == 'tbl_kmlimage'
						|| $table == 'tbl_respondent_users' || $table == 'tbl_respondent_hh_detail'
						|| $table == 'tbl_respondent_child_detail') {
							$fields[$key] = $fields[$key]->name.' INTEGER NULL DEFAULT NULL';
						} else {
							if($fields[$key]->type == 'int') {
								$fields[$key] = $fields[$key]->name.' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL';
							} else {
								$fields[$key] = $fields[$key]->name.' TEXT PRIMARY KEY NOT NULL';
							}
						}
					} else {
						if($fields[$key]->type == 'int') {
							$fields[$key] = $fields[$key]->name.' INTEGER NULL DEFAULT NULL';
						} else {
							$fields[$key] = $fields[$key]->name.' TEXT NULL DEFAULT NULL';
						}
					}
				}
				$structure[$table] = '('.implode(', ',$fields).')';
			// }
			
			if($table != 'query') {
				// Get table data
				$this->db->distinct()->select('table.*')->from($table.' AS table');
				if($table == 'lkp_cluster') {
					$this->db->join('tbl_user_unit_location AS tuul', 'tuul.cluster_id = table.cluster_id');
					$this->db->where('tuul.status', 1)->where('tuul.user_id', $data['user_id']);
				} else if($table == 'lkp_uai') {
					$this->db->join('tbl_user_unit_location AS tuul', 'tuul.uai_id = table.uai_id');
					$this->db->where('tuul.status', 1)->where('tuul.user_id', $data['user_id']);
				} else if($table == 'lkp_sub_location') {
					$this->db->join('tbl_user_unit_location AS tuul', 'tuul.sub_loc_id = table.sub_loc_id');
					$this->db->where('tuul.status', 1)->where('tuul.user_id', $data['user_id']);
				} else if($table == 'lkp_country') {
					$this->db->join('tbl_user_unit_location AS tuul', 'tuul.country_id = table.country_id');
					$this->db->where('tuul.status', 1)->where('tuul.user_id', $data['user_id']);
				} else if($table == 'ic_data_file' || $table == 'ic_data_location') {
					$this->db->where('table.user_id', $data['user_id']);
				} else if($table == 'survey1' || $table == 'survey2' || $table == 'survey3' || $table == 'survey4' || $table == 'survey5' || $table == 'survey6' || $table == 'survey7' || $table == 'survey8' || $table == 'survey9' || $table == 'survey10' || $table == 'survey11' || $table == 'survey12' || $table == 'survey13' || $table == 'survey14') {
					$this->db->where('table.user_id', $data['user_id']);
				} else if($table == 'survey1_groupdata' || $table == 'tbl_survey_assignee') {
					$this->db->where('table.user_id', $data['user_id']);
				} else if($table == 'forms') {
					$this->db->where('table.status', 1);
				} else if($table == 'tbl_f_survey_assignee') {
					$this->db->where('table.user_id', $data['user_id']);
					$this->db->where('table.status', 1);
				} else if($table == 'tbl_respondent_users' || $table == 'tbl_respondent_child_detail' || $table == 'tbl_respondent_hh_detail' || $table == 'tbl_transect_pastures') {
					$this->db->where('table.added_by', $data['user_id']);

					// as respondent can be accessed by only contributor account hence filetr not by locations we use instead by user filter
					
					// $this->db->join('tbl_user_unit_location AS tuulc', 'tuulc.cluster_id = table.cluster_id', 'left');
					// $this->db->join('tbl_user_unit_location AS tuuls', 'tuuls.sub_loc_id = table.sub_location_id', 'left');
					// // $this->db->where('tuul.status', 1)->where('tuul.user_id', $data['user_id']);
					// $this->db->where('
					// 	(tuulc.status = 1 AND tuulc.user_id = '.$data['user_id'].' AND tuulc.cluster_id IS NOT NULL)
					// 	OR
					// 	(tuuls.status = 1 AND tuuls.user_id = '.$data['user_id'].' AND tuuls.sub_loc_id IS NOT NULL)
					// ');
				} 
				
				$this->db->order_by('table.'.$pk, "ASC");
				// if(empty($limit)) {
				// 	$this->db->limit(1000);
				// } else {
				// 	$this->db->where($pk.' >', $limit[$table]);
				// 	$this->db->limit(2000);
				// }
				$query = $this->db->get();
				$records[$table] = $query->result();
				$query->free_result();
				$query = null;
			}
		}

		$this->jsonify(array(
			'status' => 1,
			'structure' => $structure,
			'records' => $records
		));
	}

	// Upload Local Data to Server
	public function upload($data)
	{
		date_default_timezone_set("UTC");

		// Validate input data
		if (!isset($data['queries']) || !is_array($data['queries'])) {
			$this->jsonify_new(array(
				'msg' => 'Invalid or missing queries data.',
				'status' => 0,
				'error_type' => 'invalid_input',
				'details' => 'The "queries" field is missing or not an array.',
				'http_status' => 400
			));
		}

		$queries = $data['queries'];

		try {
			foreach ($queries as $key => $query) {
				// Validate query structure
				if (!isset($query->data) || !isset($query->type) || !isset($query->action)) {
					throw new Exception('Invalid query structure: missing data, type, or action.', 400);
				}

				// Decode JSON and ensure nested objects are converted to arrays
				$data = json_decode($query->data, true);
				if ($data === null) {
					throw new Exception('Failed to decode JSON data: ' . json_last_error_msg(), 400);
				}

				switch ($query->type) {
					case 'query':
						// Validate required fields
						if (!isset($data['tablename']) || !isset($data['data'])) {
							throw new Exception('Missing tablename or data in query payload.', 400);
						}

						switch ($query->action) {
							case 'insert':
								// Check for duplicate data_id
								if (isset($data['data']['data_id'])) {
									$existing = $this->db->where('data_id', $data['data']['data_id'])
														->get($data['tablename'])
														->row_array();
									if ($existing) {
										throw new Exception('Duplicate data_id: ' . $data['data']['data_id'], 400);
									}
								}
								$this->db->insert($data['tablename'], $data['data']);
								break;

							case 'update':
								if (isset($data['data_id'])) {
									$condition_array = array('data_id' => $data['data_id']);
								} else if (isset($data['file_id'])) {
									$condition_array = array('file_id' => $data['file_id']);
								} else {
									throw new Exception('Missing data_id or file_id for update operation.', 400);
								}
								$updateValue = $data['data'];
								$this->db->where($condition_array)->update($data['tablename'], $updateValue);
								break;

							case 'delete':
								if (!isset($data['data'][0]['where'])) {
									throw new Exception('Missing where condition for delete operation.', 400);
								}
								$condition = (array)$data['data'][0]['where'];
								$this->db->where($condition)->delete($data['tablename']);
								break;

							default:
								$this->db->query($query->data);
								break;
						}

						// Insert into query table
						$this->db->insert('query', array(
							'type' => $query->type,
							'action' => $query->action,
							'time' => $query->time,
							'creator' => $query->creator,
							'platform' => 'mobile',
							'data' => $query->data
						));
						break;

					case 'image':
						if (!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'Uploads/survey/');
						if (!isset($data['image']) || !is_array($data['image'])) {
							throw new Exception('Invalid or missing image data.', 400);
						}

						foreach ($data['image'] as $key => $image) {
							$mimeType = explode(';', $image);
							switch ($mimeType[0]) {
								case 'data:image/*':
									$crop = str_replace('data:image/*;charset=utf-8;base64,', '', $image);
									break;
								case 'data:image/jpeg':
									$crop = str_replace('data:image/jpeg;base64,', '', $image);
									break;
								case 'data:image/png':
									$crop = str_replace('data:image/png;base64,', '', $image);
									break;
								default:
									$crop = $image;
									break;
							}
							$crop = str_replace(' ', '+', $crop);
							$cropdata = base64_decode($crop);
							if ($cropdata === false) {
								throw new Exception('Failed to decode base64 image data.', 400);
							}

							$file = uniqid('img_', true) . $key . (isset($data['userid']) ? $data['userid'] : '') . '.jpg';
							$upload_path = UPLOAD_DIR . $file;

							if (!is_dir(UPLOAD_DIR)) {
								mkdir(UPLOAD_DIR, 0777, true);
							}

							if (file_put_contents($upload_path, $cropdata) === false) {
								throw new Exception('Failed to write image to ' . $upload_path, 500);
							}

							$this->db->insert('rpt_formdata_image', array(
								'form_id' => $data['formid'],
								'survey_id' => $data['surveyId'],
								'image' => $file
							));
						}
						break;

					case 'surveyimage':
						if ($query->action == 'insert') {
							if (!isset($data['table_name']) || !isset($data['data']['file_id'])) {
								throw new Exception('Missing table_name or file_id in surveyimage data.', 400);
							}

							// Check for duplicate file_id
							$existing = $this->db->where('file_id', $data['data']['file_id'])
												->get($data['table_name'])
												->row_array();
							if ($existing) {
								throw new Exception('Duplicate file_id: ' . $data['data']['file_id'], 400);
							}

							// Insert the record directly (no file upload)
							$this->db->insert($data['table_name'], $data['data']);
						}
						break;

					default:
						throw new Exception('Unknown query type: ' . $query->type, 400);
				}
			}

			$this->jsonify_new(array(
				'msg' => 'Successfully synced LocalDB with remoteDB.',
				'status' => 1
			));
		} catch (Exception $e) {
			$errorMessage = $e->getMessage();
			$errorCode = $e->getCode();

			// Log the error for debugging
			log_message('error', 'Upload error: ' . $errorMessage . ' | Code: ' . $errorCode);

			// Check for duplicate entry errors (from MySQL or custom exception)
			if (strpos($errorMessage, 'Duplicate entry') !== false || strpos($errorMessage, 'Duplicate data_id') !== false || strpos($errorMessage, 'Duplicate file_id') !== false || $errorCode == 400) {
				$this->jsonify_new(array(
					'msg' => 'Duplicate entry detected: ' . (isset($data['data']['data_id']) ? 'data_id: ' . $data['data']['data_id'] : (isset($data['data']['file_id']) ? 'file_id: ' . $data['data']['file_id'] : 'unknown')),
					'status' => 0,
					'error_type' => 'duplicate_entry',
					'details' => $errorMessage,
					'http_status' => 200
				));
			} else {
				$this->jsonify_new(array(
					'msg' => 'An unexpected error occurred: ' . $errorMessage,
					'status' => 0,
					'error_type' => 'general_error',
					'details' => $errorMessage,
					'http_status' => 500
				));
			}
		}
	}

	private function uploadfile($query)
	{
		date_default_timezone_set("UTC");
		if (!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'Uploads/survey/');

		// Decode JSON and ensure nested objects are converted to arrays
		$data = json_decode($query->data, true);
		if ($data === null) {
			throw new Exception('Failed to decode JSON data in uploadfile: ' . json_last_error_msg());
		}

		$tablename = $data['table_name'];
		$syncdata = $data['data'];

		// Check if base64 data is provided
		if (!isset($data['base64']) || empty($data['base64'])) {
			throw new Exception('Base64 data is missing for file upload.');
		}

		// Generate a unique file name to avoid overwrites
		$extension = pathinfo($syncdata['file_name'], PATHINFO_EXTENSION);
		$unique_filename = uniqid('kaznet_', true) . '.' . $extension;
		$upload_path = UPLOAD_DIR . $unique_filename;

		// Decode and save the file
		$base64 = str_replace(' ', '+', $data['base64']);
		$cropdata = base64_decode($base64);
		if ($cropdata === false) {
			throw new Exception('Failed to decode base64 data.');
		}

		// Ensure the upload directory exists
		if (!is_dir(UPLOAD_DIR)) {
			mkdir(UPLOAD_DIR, 0777, true);
		}

		// Save the file
		if (file_put_contents($upload_path, $cropdata) === false) {
			throw new Exception('Failed to write file to ' . $upload_path);
		}

		// Update the file_name in the database record
		$syncdata['file_name'] = $unique_filename;

		// Insert or update the database record
		$existing = $this->db->where('file_id', $syncdata['file_id'])
							->get($tablename)
							->row_array();

		if ($existing) {
			throw new Exception('Duplicate file_id in uploadfile: ' . $syncdata['file_id'], 400);
		}

		// Insert new record
		$insert = $this->db->insert($tablename, $syncdata);
		if (!$insert) {
			throw new Exception('Failed to insert record into ' . $tablename);
		}

		return true;
	}

	// Return JSON data with HTTP status code
	public function jsonify_new($data)
	{
		// Set HTTP status code if provided
		if (isset($data['http_status'])) {
			http_response_code($data['http_status']);
			unset($data['http_status']);
		} else {
			http_response_code(200);
		}
		header('Content-Type: application/json');
		echo json_encode($data);
		exit();
	}
	public function upload_file()
	{
		$config['upload_path']   = './uploads/survey/';
		$config['allowed_types'] = 'gif|jpg|png|exe|xls|doc|docx|xlsx|rar|zip|avi|mp4';
		$config['max_size']      = '131072'; 
		$config['remove_spaces'] = TRUE; //it will remove all spaces
		$config['encrypt_name']  = TRUE; //it wil encrypte the original file name
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());
			$this->jsonify(array(
				'status' => 0,
				'msg' => $error
			));
			exit();
		} else {
			$data = $this->upload->data();
			$this->jsonify(array(
				'status' => 1,
				'msg' => $data['file_name']
			));
			exit();
		}
	}
	public function upload_file_new()
	{
		// var_dump($_FILES); die();
		date_default_timezone_set("UTC");
		if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'uploads/survey/');
		$uploadPath = UPLOAD_DIR . $_FILES['file']['name'];

		// Save file in uploads/survey folder
		move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath);
		$this->jsonify(array(
			'msg' => 'Successfully synced Local files with server.',
			'status' => 1
		));
	}
	
	//return json data
	public function jsonify($data)
	{
		print_r(json_encode($data));
		exit();
	}

	//logout ++++++++ session
	public function logout()
	{
		$this->jsonify(array(
			'logout' => true
		));
	}
}