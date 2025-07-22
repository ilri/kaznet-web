<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Result extends CI_Controller {

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
			$this->bad_request();
		}
		
		switch ($data['purpose']) {
			case 'distance_result':
				$this->distance_result($data);
				break;

			default:
				$this->bad_request();
				break;
		}
	}

	public function setMemLimit() {
		ini_set('memory_limit', '-1');
	}

	public function distance_result($data)
	{
		if(!$data) $this->bad_request();
		date_default_timezone_set("UTC");

        $user = $data['user'];
		$file_name = $data['filename'];
		$classifier_score = $data['classifier_score'];
		$classifier_result = $data['classifier_result'];

		// if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'uploads/distance_result/');
		// $uploadPath = UPLOAD_DIR . $file_name;

		// // Save file in uploads/testml folder
		// move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath);

		$this->db->insert('distance_result', array(
            'user' => $user,
			'file_name' => $file_name,
			'score' => $classifier_score,
			'result' => $classifier_result
		));
		
		$this->jsonify(array(
			'status' => 1,
			'filename' => $file_name,
			'msg' => 'Data stored successfully in DB.',
		));
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
		// Close DB
		$this->db->close();
		echo(json_encode($data));
		exit();
	}
}