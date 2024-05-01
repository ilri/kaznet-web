<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth extends CI_Controller {

	public function __construct()
	{
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
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

	//Load Login Form
	public function index()
	{
		$this->logout();
	}
	//Login Code
	// login
	public function login()
	{
		$data = (array)json_decode(file_get_contents("php://input"));
		if(isset($data['purpose']) && $data['purpose'] == 'login') {
			date_default_timezone_set("UTC");
			$user = array(
				'email_id' => $data['email_id']
			);

			if(isset($data['logintype'])) {
				switch ($data['logintype']) {
					case 'simple':
						$checkuser = $this->db->where("(username = '".$data['email_id']."' OR email_id = '".$data['email_id']."' OR mobile_number = '".$data['email_id']."')")->get('tbl_users');
						if($checkuser->num_rows() === 0) {
							$this->jsonify(array(
								'msg' => 'Invalid Credentials.',
								'status' => 0
							));
							exit();
						}
					break;

					case 'ldap':
						$username = explode('@', $data['email_id']);
						$username = $username[0];
						$email = $data['email_id'];

						//Start LDAP login process
						$ldapport = 636;
						$ldaphostA = "ldaps://AZCGNEROOT2.CGIARAD.ORG";
						$ldaphostB = "ldaps://AZCGCCROOT2.CGIARAD.ORG";

						// Connecting to LDAP
						$ldapconn = ldap_connect($ldaphostB, $ldapport);
						if(!$ldapconn) {
						    return false;
						}

						// configure ldap params
						ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
						ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
						ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 10);

						// binding to ldap server
						$ldapbind = ldap_bind($ldapconn, $email, $data['pass']);
						if(!$ldapbind) {
							$this->jsonify(array(
								'msg' => 'Invalid AD Credentials.',
								'status' => 0
							));
							exit();
						}

						$checkuser = $this->db->where("email_id", $email)->get('tbl_users');
						if($checkuser->num_rows() === 0) {
							$this->jsonify(array(
								'msg' => 'Invalid Login. Please contact s.nagaraji@cgiar.org to get access.',
								'status' => 0
							));
							exit();
						}
					break;
					
					default:
						$checkuser = $this->db->where("(username = '".$data['email_id']."' OR email_id = '".$data['email_id']."' OR mobile_number = '".$data['email_id']."')")->get('tbl_users');
						if($checkuser->num_rows() === 0) {
							$this->jsonify(array(
								'msg' => 'Invalid Credentials.',
								'status' => 0
							));
							exit();
						}
					break;
				}
			} else {
				$checkuser = $this->db->where("(username = '".$data['email_id']."' OR email_id = '".$data['email_id']."' OR mobile_number = '".$data['email_id']."')")->get('tbl_users');
				if($checkuser->num_rows() === 0) {
					$this->jsonify(array(
						'msg' => 'Invalid Credentials.',
						'status' => 0
					));
					exit();
				}
			}

			$getData = $checkuser->row_array();
			$password = $data['pass'];
			$salt = $getData['salt'];
			$saltedPW =  $password . $salt;
			$hashedPW = hash('sha256', $saltedPW);
			if(isset($data['logintype']) && $data['logintype'] == 'ldap') {
				$newData = array(
					'email_id' => $getData['email_id'],
					'status' => 1
				);
			} else {
				$newData = array(
					'email_id' => $getData['email_id'],
					'password' => $hashedPW,
					// 'status' => 1
				);
			}

			$query = $this->db->where($newData)->get('tbl_users');
			if($query->num_rows() > 0){
				// Check if user id inactive
				if($getData['status'] == 0) {
					$this->jsonify(array(
						'msg' => 'User is inactive. Please contact admin to activate your account.',
						'status' => 0
					));
					exit();
				}
				// Check if user id deleted added by sagar on 22_Dec_23
				if($getData['status'] == -1) {
					$this->jsonify(array(
						'msg' => 'User is deleted. Please contact admin to activate your account.',
						'status' => 0
					));
					exit();
				}
				// Get user avatar
				$getImage = $this->db->where('user_id', $getData['user_id'])->where('status', 1)->get('tbl_images')->row_array();

				// // Get user account group
				// $this->db->select('lagm.*')->from('lkp_account_group_master AS lagm');
				// $this->db->join('tbl_user_account_group AS tuag', 'tuag.account_group_id = lagm.account_group_id');
				// $getAccGrp = $this->db->where('tuag.user_id', $getData['user_id'])->where('tuag.status', 1)->get()->row_array();

				// // Get user house bank
				// $this->db->select('lhb.*')->from('lkp_house_bank AS lhb');
				// $this->db->join('tbl_user_account_group AS tuag', 'tuag.house_bank_id = lhb.house_bank_id');
				// $getHseBnk = $this->db->where('tuag.user_id', $getData['user_id'])->where('tuag.status', 1)->get()->row_array();

				// Get user location
				$this->db->distinct()->from('tbl_user_unit_location AS tuul');
				$this->db->where('tuul.user_id', $getData['user_id'])->where('tuul.status', 1);
				$location = $this->db->get()->row_array();

				// Get user profile
				$this->db->distinct()->from('tbl_user_profile');
				$this->db->where('user_id', $getData['user_id'])->where('status', 1);
				$profile = $this->db->get()->row_array();

				// if($getData['role_id'] == 1 || $getData['role_id'] == 2) $fpo_fpc = NULL;

				$newdata = array(
					'user_id'=>$getData['user_id'],
					'first_name'=>$getData['first_name'],
					'last_name'=>$getData['last_name'],
					'email_id'=>$getData['email_id'],
					'mobile_number'=>$getData['mobile_number'],
					'user_role'=>$getData['role_id'],
					'image'=>$getImage['image'],
					'location'=>$location,
					'profile'=>$profile
					// 'fpo_fpc'=>(is_null($fpo_fpc) ? NULL : $fpo_fpc['fpo_fpc_id'])
					// 'account_group'=>$getAccGrp,
					// 'house_bank'=>$getHseBnk
				);
				$this->jsonify(array(
					'user' => $newdata,
					'status' => 1
				));
				exit();
			}else {
				$this->jsonify(array(
					'msg' => 'Invalid Credentials.',
					'status' => 0
				));
				exit();
			}
		}
		else {
			$this->jsonify(array(
				'msg' => 'Oops! Some Error Occured!!!',
				'status' => 0
			));
			exit();
		}
	}

	//forgot password using email
	public function forgotpass()
	{
		$data = (array)json_decode(file_get_contents("php://input"));
		if(isset($data['purpose']) && $data['purpose'] == 'forgotpassword') {
			if(isset($data['email_id'])) {
				$baseurl = base_url();
				$check = $this->db->where('email_id', $data['email_id'])->get('tbl_users');
				if($check->num_rows() == 0) {
		        	$this->jsonify(array(
						'status' => 0,
						'msg' => 'Enter email id is not registered. please contact admin'
					));
					exit();
				}
				else{
					$get = $check->row_array();
					if($get['status'] == 0) {
						$this->jsonify(array(
							'status' => 0,
							'msg' => 'Enter email id is block. please contact admin'
						));
						exit();
					}
					$alpha   = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
		            $numeric = str_shuffle('0123456789');
		            $code = substr($alpha, 0, 4) . substr($numeric, 0, 2);
		            $code = str_shuffle($code);
					$code = $code.uniqid();
					$update = $this->db->where('email_id', $data['email_id'])->update('tbl_users', array('forgot_pass' => $code));
					/*$config = Array(
						'protocol' => 'smtp',
					    'smtp_host' => 'smtp.office365.com',
					    'smtp_user' => 'me-icrisat@cgiar.org',
					    'smtp_pass' => '$Admin#2021',
					    'smtp_crypto' => 'tls',    
					    'newline' => "\r\n",
					    'smtp_port' => 587,
					    'charset' => 'utf-8',
					    'starttls' => TRUE,
						'mailtype' => 'html'
					);
					$this->load->library('email', $config);
					$this->email->set_crlf( "\r\n" );
					$this->email->set_newline("\r\n");
					$this->email->from('me-icrisat@cgiar.org','ICRISAT M&E');
					$this->email->to($data['email_id']);
					$this->email->subject('Password Mail');
					$this->email->set_mailtype("html");*/
					$this->load->library('phpmailer_lib');
			        $mail = $this->phpmailer_lib->load();
			        
			        // SMTP configuration
			        $mail->isSMTP();
			        $mail->Host     = 'smtp.office365.com';
			        $mail->SMTPAuth = true;
			        $mail->Username = 'me-icrisat@cgiar.org';
			        $mail->Password = '$Admin#2021';
			        $mail->SMTPSecure = 'tls';
			        $mail->Port     = 587;
			        
			        $mail->setFrom('me-icrisat@cgiar.org', 'Mbook');
			        $mail->addReplyTo('noreply@cgiar.org', 'Mbook');
			        
			        // Add a recipient
			        $mail->addAddress($data['email_id']);
			        
			        // Email subject
			        $mail->Subject = 'Password Reset Mail';
			        
			        // Set email format to HTML
			        $mail->isHTML(true);
					$data = array(
						'name'=> $get['first_name'].' '.$get['last_name'],
						'link'=> '<a href = "'.base_url().'password/cpassword/'.$code.'/">Set a New Password</a>'
					);
					$body = $this->load->view('passwordlinkemail.php',$data,TRUE);
					$mail->Body = $body;
					if(!$mail->send()){
						$this->jsonify(array(
							'status' => 1,
							'msg' => $mail->ErrorInfo
						));
						exit();
			        }else{
			            $this->jsonify(array(
							'status' => 1,
							'msg' => 'Password Reset Link Sent Successfully to your registered email id.'
						));
						exit();
			        }
				}
			}
			else{
				$this->jsonify(array(
					'status' => 0,
					'msg' => 'Email id is required'
				));
				exit();
			}
		}
	}

	//reset password using forgot key
	public function resetpass()
	{
		$data = (array)json_decode(file_get_contents("php://input"));
		if(isset($data['purpose']) && $data['purpose'] == 'changepassword') {
			if(isset($data['forgot_pass'])) {
				$baseurl = base_url();
				$check = $this->db->where('forgot_pass', $data['forgot_pass'])->get('tbl_users');
				if($check->num_rows() == 0) {
					$this->jsonify(array(
						'status' => 0,
						'msg' => 'Link is not working.'
					));
					exit();
				}
				else{
					$get = $check->row_array();
					if($get['status'] == 0) {
						$this->jsonify(array(
							'status' => 0,
							'msg' => 'Enter email id is block. please contact admin'
						));
						exit();
					}

					$user_id = $get['user_id'];
					$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
					$saltedPW = $data['new_password'] . $salt;
					$hashedPW = hash('sha256', $saltedPW);
					$newdata = array(
						'password'=>$hashedPW,
						'salt'=>$salt
					);
					$query = $this->db->where('user_id', $user_id)->update('tbl_users', $newdata);
					$update = $this->db->where('user_id', $user_id)->update('tbl_users', array('forgot_pass' => NULL));
					if($update)
					{
						$this->jsonify(array(
							'status' => 1,
							'msg' => 'Password reset successfully.'
						));
						exit();
					}
					else
					{
						$this->jsonify(array(
							'status' => 0,
							'msg' => 'Something is wrong!.'
						));
						exit();
					}
				}
			}

			else{
				$this->jsonify(array(
					'status' => 0,
					'msg' => 'something went wrong.'
				));
				exit();
			}
		}

		else{
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Purpose not received.'
			));
			exit();
		}
	}

	// update profile image
	public function profileimage()
	{	
		$data = (array)json_decode(file_get_contents("php://input"));
		if(isset($data['purpose']) && $data['purpose'] == 'profileimage') {
			date_default_timezone_set("UTC");
			if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'uploads/user/');
			$crop = $data['img'];
			$crop = str_replace('data:image/jpeg;base64,', '', $crop);
			$crop = str_replace(' ', '+', $crop);
			$cropdata = base64_decode($crop);
			$file = uniqid() . '.jpg';
			$url = UPLOAD_DIR . $file;
			
			//file_put_contents(UPLOAD_DIR . $file, $cropdata);
			$this->load->model('Compress_model');
			$filename = $this->Compress_model->compress_image_mobile($cropdata, $url, 90);

			$imgData = array(
				'user_id' => $data['id'],
				'image' => $file,
				'original_image' => $file,
				'ip_address' => $this->input->ip_address(),
				'regdate' => date('Y-m-d H:i:s'),
				'status' => 1
			);
			$this->db->where('user_id', $data['id'])->update('tbl_images', array('status' => 0));
			$insert = $this->db->insert('tbl_images', $imgData);
			
			$this->jsonify(array(
				'img' => $file,
				'status' => 1
			));
			exit();
		}else{
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Purpose not received.'
			));
			exit();
		}
	}

	// update profile password
	public function changepassword()
	{	
		$data = (array)json_decode(file_get_contents("php://input"));
		if(isset($data['purpose']) && $data['purpose'] == 'changepassword') {
			$pass = (array)$data['password'];
			$checkuser = $this->db->select('salt')->where("user_id", $data['id'])->get('tbl_users');
			if($checkuser->num_rows() === 0) {
				$this->jsonify(array(
					'msg' => 'Sorry! Cannot change password. Please try again later.',
					'status' => 0
				));
				exit();
			}

			$getData = $checkuser->row_array();
			$password = $pass['old'];
			$salt = $getData['salt'];
			$saltedPW =  $password . $salt;
			$hashedPW = hash('sha256', $saltedPW);
			$newData = array(
			    'password' => $hashedPW,
			    'user_id' => $data['id']
			);
			$query = $this->db->where($newData)->get('tbl_users');

			if($query->num_rows() == 0) {
				$this->jsonify(array(
					'msg' => 'Current password mismatch.',
					'status' => 0
				));
				exit();
			}

			if($pass['old'] == $pass['new']){
				$this->jsonify(array(
					'msg' => 'The New Password must differ from Current Password.',
					'status' => 0
				));
				exit();
			}

			$salt = bin2hex(random_bytes(32));
			$saltedPW =  $pass['new'] . $salt;
			$hashedPW = hash('sha256', $saltedPW);
			$newdata = array(
				'password'=>$hashedPW,
				'salt'=>$salt
			);

			$update = $this->db->where('user_id', $data['id'])->update('tbl_users', $newdata);
			$this->jsonify(array(
				'msg' => 'Your password has been changed. Please login again to continue.',
				'status' => 1
			));
			exit();
		}else{
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Purpose not received.'
			));
			exit();
		}
	}

	// contributer registration
	public function register_contributer()
	{
		date_default_timezone_set("UTC");
		$data = (array)json_decode(file_get_contents("php://input"));
		if(!isset($data['purpose']) && $data['purpose'] != 'register_contributer') {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Purpose not received.'
			));
			exit();
		}

		if(!isset($data['username']) || !isset($data['email_id']) || !isset($data['mobile_number']) || !isset($data['password'])) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Username, email, mobile number and password are mandatory.'
			));
			exit();
		}

		// Check if username or email_id or mobile_number already exit
		$checkuser = $this->db->where("(username = '".$data['username']."' OR email_id = '".$data['email_id']."' OR mobile_number = '".$data['mobile_number']."')")->get('tbl_users');
		if($checkuser->num_rows() > 0) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Username, Email ID and Mobile Number must be unique.'
			));
			exit();
		}

		$salt = bin2hex(random_bytes(32));
		$saltedPW = $data['password'] . $salt;
		$hashedPW = hash('sha256', $saltedPW);

		$user_details = array(
			'username' => $data['username'],
			'email_id' => $data['email_id'],
			'password' => $hashedPW,
			'salt' => $salt,
			'first_name' => isset($data['first_name']) ? $data['first_name'] : NULL,
			'last_name' => isset($data['last_name']) ? $data['last_name'] : NULL,
			'mobile_number' => $data['mobile_number'],
			'designation' => isset($data['designation']) ? $data['designation'] : NULL,
			'role_id' => $data['user_role'],
			'added_datetime' => date('Y-m-d H:i:s'),
			'ip_address' => $this->input->ip_address(),
			'status' => isset($data['status']) ? $data['status'] : 1,
		);
		// Insert User
		$user = $this->db->insert('tbl_users', $user_details);
		if(!$user) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Unable to register contributer. Please contact the Administrator.'
			));
			exit();
		}

		$user_id = $this->db->insert_id();
		
		// Update added_by
		$this->db->where(array(
			'username' => $data['username'],
			'email_id' => $data['email_id'],
			'mobile_number' => $data['mobile_number']
		))->update('tbl_users', array(
			'user_id' => $user_id
		));

		// Insert user_id in tbl_user_profile
		$this->db->insert('tbl_user_profile', array(
			'user_id' => $user_id,
			'added_by' => $user_id,
			'added_datetime' => date('Y-m-d H:i:s'),
			'ip_address' => $this->input->ip_address(),
			'status' => 1
		));

		$this->jsonify(array(
			'status' => 1,
			'msg' => 'Signed up successfully.',
		));
		exit();
	}
	// contributer profile update
	public function update_contributer()
	{
		date_default_timezone_set("UTC");
		$data = (array)json_decode(file_get_contents("php://input"));
		if(!isset($data['purpose']) && $data['purpose'] != 'update_contributer') {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Purpose not received.'
			));
			exit();
		}

		if(!isset($data['user_id']) || (strlen($data['user_id']) === 0)) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Bad Request...'
			));
			exit();
		}
		$user_id = $data['user_id'];

		// Update tbl_users
		$this->db->where(array(
			'first_name' => isset($data['first_name']) ? $data['first_name'] : NULL,
			'last_name' => isset($data['last_name']) ? $data['last_name'] : NULL,
			'mobile_number' => isset($data['mobile_number']) ? $data['mobile_number'] : NULL,
		))->update('tbl_users', array(
			'user_id' => $user_id
		));

		// Update new location details if posted
		if(isset($data['country_id']) && isset($data['cluster_id'])) {
			// Delete previous location data
			$this->db->where('user_id', $user_id)->delete('tbl_user_unit_location');
			// Insert new location data
			$this->db->insert('tbl_user_unit_location', array(
				'user_id' => $user_id,
				'country_id' => $data['country_id'],
				'cluster_id' => $data['cluster_id'],
				'added_by' => $user_id,
				'added_datetime' => date('Y-m-d H:i:s'),
				'ip_address' => $this->input->ip_address(),
				'status' => 1
			));
		}

		// Check if user exist in tbl_user_profile
		$check = $this->db->where('user_id', $user_id)->get('tbl_user_profile');
		if($check->num_rows() === 0) {
			// Insert user_id in tbl_user_profile
			$this->db->insert('tbl_user_profile', array(
				'user_id' => $user_id,
				'added_by' => $user_id,
				'added_datetime' => date('Y-m-d H:i:s'),
				'ip_address' => $this->input->ip_address(),
				'status' => 1
			));
		}
		// Update tbl_user_profile
		$user_data_update_array = array(
			'year_of_birth' => isset($data['year_of_birth']) ? $data['year_of_birth'] : NULL,
			'gender_id' => isset($data['gender_id']) ? $data['gender_id'] : NULL,
			'national_id' => isset($data['national_id']) ? $data['national_id'] : NULL,
			'mpesa_id' => isset($data['mpesa_id']) ? $data['mpesa_id'] : NULL,
			'bank_name' => isset($data['bank_name']) ? $data['bank_name'] : NULL,
			'branch_name' => isset($data['branch_name']) ? $data['branch_name'] : NULL,
			'branch_code' => isset($data['branch_code']) ? $data['branch_code'] : NULL,
			'account_number' => isset($data['account_number']) ? $data['account_number'] : NULL,
			'smartphone_brand' => isset($data['smartphone_brand']) ? $data['smartphone_brand'] : NULL,
			'other_smartphone_brand' => isset($data['other_smartphone_brand']) ? $data['other_smartphone_brand'] : NULL,
			'android_version' => isset($data['android_version']) ? $data['android_version'] : NULL,
			'years_of_use' => isset($data['years_of_use']) ? $data['years_of_use'] : NULL,
			'highest_education' => isset($data['highest_education']) ? $data['highest_education'] : NULL,
			'primary_occupation' => isset($data['primary_occupation']) ? $data['primary_occupation'] : NULL,
			'market_id' => isset($data['market_id']) ? $data['market_id'] : NULL,
			'formal_livestock_market_distance' => isset($data['formal_livestock_market_distance']) ? $data['formal_livestock_market_distance'] : NULL,
			'means_of_transport' => isset($data['means_of_transport']) ? $data['means_of_transport'] : NULL,
			'time_taken_to_reach_market' => isset($data['time_taken_to_reach_market']) ? $data['time_taken_to_reach_market'] : NULL,
			'time_taken_to_reach_assigned_household' => isset($data['time_taken_to_reach_assigned_household']) ? $data['time_taken_to_reach_assigned_household'] : NULL,
			'time_taken_to_reach_wet_transect_point' => isset($data['time_taken_to_reach_wet_transect_point']) ? $data['time_taken_to_reach_wet_transect_point'] : NULL,
			'time_taken_to_reach_dry_transect_point' => isset($data['time_taken_to_reach_dry_transect_point']) ? $data['time_taken_to_reach_dry_transect_point'] : NULL,
			'joined_group' => isset($data['joined_group']) ? join(",", $data['joined_group']) : NULL,
			
			'participated_in_survey' => isset($data['participated_in_survey']) ? $data['participated_in_survey'] : NULL,
			'terms_conditions' => isset($data['terms_conditions']) ? $data['terms_conditions'] : NULL,
			'lat' => isset($data['lat']) ? $data['lat'] : NULL,
			'lng' => isset($data['lng']) ? $data['lng'] : NULL,
			'added_datetime' => date('Y-m-d H:i:s'),
			'ip_address' => $this->input->ip_address()
		);
		
		$this->db->distinct()->from('tbl_user_profile');
		$this->db->where('user_id', $user_id);
		$user_profile_details = $this->db->get()->row_array();
		$user_data_update_array1 = array();

		if($user_profile_details['pa_verified_status'] ==3){
			$user_data_update_array1 = array_merge($user_data_update_array,array(
			'pa_verified_status' => isset($data['pa_verified_status']) ? $data['pa_verified_status'] : 1,
			'pa_verified_by' => isset($data['pa_verified_by']) ? $data['pa_verified_by'] : NULL,
			'pa_verified_date' => isset($data['pa_verified_date']) ? $data['pa_verified_date'] : NULL,
			'rejected_remarks' => isset($data['rejected_remarks']) ? $data['rejected_remarks'] : NULL));
		}else{
			$user_data_update_array1 = $user_data_update_array;
		}

		$this->db->where('user_id', $user_id)->update('tbl_user_profile', $user_data_update_array1);

		$result = array(
			'status' => 1,
			'msg' => 'Profile updated successfully.'
		);

		// Get user profile
		$this->db->distinct()->from('tbl_user_profile');
		$this->db->where('user_id', $user_id);
		$result['profile'] = $this->db->get()->row_array();

		$this->jsonify($result);
		exit();
	}
	// Update contributer signature
	public function update_contributer_signature()
	{
		$data = (array)json_decode(file_get_contents("php://input"));
		if(!$this->input->post('purpose') && $this->input->post('purpose') != 'update_contributer_signature') {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Purpose not received.'
			));
			exit();
		}

		if(!$this->input->post('user_id') || $this->input->post('user_id') === ''
		|| !$this->input->post('filename') || $this->input->post('filename') === '') {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Bad Request...'
			));
			exit();
		}
		$user_id = $this->input->post('user_id');
		$filename = $this->input->post('filename');
		
		date_default_timezone_set("UTC");
		if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'uploads/user/');
		$uploadPath = UPLOAD_DIR . $filename;

		// Save file in uploads/survey folder
		move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath);
		
		// Update user profile
		$this->db->where('user_id', $user_id)->update('tbl_user_profile', array(
			'signature' => $filename
		));

		// Get user profile
		$this->db->distinct()->from('tbl_user_profile');
		$this->db->where('user_id', $user_id);
		$profile = $this->db->get()->row_array();

		$this->jsonify(array(
			'msg' => 'Successfully updated user signature.',
			'profile' => $profile,
			'status' => 1
		));
		exit();
	}

	public function mobile_verification(){
		$data = (array)json_decode(file_get_contents("php://input"));
		if(!isset($data['purpose']) || $data['purpose'] != 'mobile_verification') {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Purpose not received.'
			));
			exit();
		}
		
		$checkphone = $this->db->where('mobile_number', $data['phone_no'])->where('status', 1)->get('tbl_users');
		if($checkphone->num_rows() === 0) {
			$this->jsonify(array(
				'msg' => 'Invalid number.',
				'status' => 0
			));
			exit();
		} else {
			$getData = $checkphone->row_array();
			$user_id = $getData['user_id'];
			$this->jsonify(array(
				'msg' => 'Number found.',
				'userid' => $user_id,
				'status' => 1
			));
			exit();
		}
	}
	public function changepassword_otp()
	{	
		$data = (array)json_decode(file_get_contents("php://input"));
		if(isset($data['purpose']) && $data['purpose'] == 'changepassword_otp') {
			$this->load->model('User_model');
			$error = array(
				'status' => 1
			);
			$password = $data['new_password'];
			// $encpassword = $data['new_password'];
			// $iv = "1234567890123456";
			// $key = "LmJaJeCSHKFdF02w";
			// $password = openssl_decrypt(base64_decode($encpassword), "aes-128-cbc", $key, OPENSSL_RAW_DATA, $iv);
			if(empty($password)) {
				$error['password'] = 'Password is mandatory.';
				$error['status'] = 0;
			}

			if(strlen($password)>0) {
				$uppercase = preg_match('@[A-Z]@', $password);
				$lowercase = preg_match('@[a-z]@', $password);
				$number    = preg_match('@[0-9]@', $password);
				if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
					$error['password'] = 'Password must be at least 8 characters 1 uppercase 1 lowercase and 1 number';
					$error['status'] = 0;
				}
			}
			if($error['status'] == 0) {
				$error['type'] = 'fields';
				echo json_encode($error);
				exit();
			}
			// $password = $password;
			$salt = bin2hex(random_bytes(32));
			$saltedPW = $password.$salt;
			$hashedPW = hash('sha256', $saltedPW);
			$reset_user_password = $this->db->where('user_id', $data['userID'])->update('tbl_users', array(
				'password' => $hashedPW,
				'salt' => $salt
			));
			if(!$reset_user_password){
				$this->jsonify(array(
					'status' => 0,
					'msg' => 'Purpose not received.'
				));
				exit();
			}
			// Return data
			$this->jsonify(array(
				'msg' => 'Password Updated Successfully!',
				'status'=> 1
			));
			exit();
		}else{
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Purpose not received.'
			));
			exit();
		}
	}

	//logout ++++++++ session
	public function logout()
	{
	$data = (array)json_decode(file_get_contents("php://input"));
		if(isset($data['purpose']) && $data['purpose'] == 'logout') {
			$this->jsonify(array(
				'status' => 1
			));
			exit();
		}
	}

	public function jsonify($data)
	{
		print_r(json_encode($data));
		exit();
	}
}