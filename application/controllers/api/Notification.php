<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notification extends CI_Controller {

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
			case 'token_registration':
				$this->token_registration($data);
				break;

			case 'manual_push':
				$this->manual_push($data);
				break;

			default:
				$this->bad_request();
				break;
		}
	}

	public function bad_request()
	{
		$this->jsonify(array(
			'status' => 0,
			'msg' => 'Bad Request...'
		));
	}

	public function jsonify($data)
	{
		echo(json_encode($data));
		exit();
	}

	public function token_registration()
	{	
		$data = (array)json_decode(file_get_contents("php://input"));
		if(!isset($data['purpose']) && $data['purpose'] != 'token_registration') {
			$this->bad_request();
		}

		// Block all previous matching user_id and token
		$this->db->where('user_id', $data['user_id'])->update('tbl_push_notification', array(
			'status' => 0
		));
		$this->db->where('token', $data['token_id'])->update('tbl_push_notification', array(
			'status' => 0
		));
		
		date_default_timezone_set("UTC");
		$inserttoken = $this->db->insert('tbl_push_notification', array(
			'user_id' => $data['user_id'],
			'token' => $data['token_id'],
			'ip_address' => $this->input->ip_address(),
			'date_time' => date('Y-m-d H:i:s')
		));
		if(!$inserttoken){
			$this->jsonify(array(
				'msg'=>'Sorry! Unable to register user token. Please try after sometime.',
				'status' => 0
			));
		}
		$this->jsonify(array(
			'status' => 1,
			'msg' => 'Token registered successfully.'
		));
	}

	public function manual_push()
	{	
		$data = (array)json_decode(file_get_contents("php://input"));
		if(!isset($data['purpose']) && $data['purpose'] != 'manual_push') {
			$this->bad_request();
		}

		if(!$data) $this->bad_request();
		if(!$data['user_id'] || strlen($data['user_id']) == 0) $this->bad_request();

		$pushtoken = array();
		// Get user's device tokens to send push
		$this->db->distinct()->select('token');
		$this->db->where('user_id', $data['user_id'])->where('status', 1);
		$usertoken = $this->db->get('tbl_push_notification')->result_array();
		foreach ($usertoken as $tkey => $utoken) {
			array_push($pushtoken, $utoken['token']);
		}

		define('FIREBASE_API_KEY', 'AAAAU3aENuY:APA91bGj_Jb-rjYNw2QKjAq-aMKCVvvFL-GzwMJwzjVgXq-f07IkWGX8H3r06Ym6n_7bFKleq9o8Qg0nxcilKsLobX-ma8nQIv-S7EVC7x-owiACt2hTQJBC43igp-swHz1_wlnsOxRe');

		if(count($pushtoken) > 0) {
			$body = (!$data['message'] || strlen($data['message']) == 0) ? "You are receiving this pushnotification because for testing purpose." : $data['message'];
			$title = (!$data['title'] || strlen($data['title']) == 0) ? "Manual Push Notification" : $data['title'];
			
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

			$result = curl_exec($ch );
			curl_close( $ch );
		}

		$this->jsonify(array(
			'msg' => 'Notification sent successfully.',
			'status' => 1
		));
	}
}