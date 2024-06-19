<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {
	
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

	public function send_alert(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}

		//user data for profile info
		$this->load->model('Dynamicmenu_model');
		$profile_details = $this->Dynamicmenu_model->user_data();
		$menu_result = array('profile_details' => $profile_details);
		
		$result = array();
		
		$this->load->model('User_model');
		$all_users = $this->User_model->all_users_without_status(array(), array(8));
		$result['contributers'] = $all_users;

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('menu',$menu_result);
		$this->load->view('notification/send_alert', $result);
		$this->load->view('footer');
	}
	public function manual_push(){
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
		$title = $this->input->post('title');
		$message = $this->input->post('message');

		$pushtoken = array();
		// Get user's device tokens to send push
		$this->db->distinct()->select('token');
		$this->db->where_in('user_id', $user_id)->where('status', 1);
		$usertoken = $this->db->get('tbl_push_notification')->result_array();
		foreach ($usertoken as $tkey => $utoken) {
			array_push($pushtoken, $utoken['token']);
		}

		define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');

		if(count($pushtoken) > 0) {
			$body = (!$message || strlen($message) == 0) ? "You are receiving this pushnotification because for testing purpose." : $message;
			$title = (!$title || strlen($title) == 0) ? "Manual Push Notification" : $title;
			
			$msg = array(
				'body'		=> $body,
				'title'		=> $title,
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
		$result['msg'] = 'Notification sent successfully.';

		echo json_encode($result);
		exit();
	}

	public function task_deadline(){
		define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');

		$msg = array(
			// 'body'		=> $body,
			// 'title'		=> $title,
			// 'content'	=> json_encode($content),
			'type'		=> "deadline",
			'vibrate'	=> 1,
			'sound'		=> 1,
		);

		$fields = array(
			'to'       => '/topics/contributor',
			'priority' => 'high',
			'data'	   => $msg
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

		$result = curl_exec($ch );
		curl_close( $ch );

		echo json_encode(array(
			'status' => 1,
			'msg' => 'Notification sent successfully.'
		));
		exit();
	}
}