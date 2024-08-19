<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Prices_of_index_commodities extends CI_Controller {

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
	}

	public function index()
	{
		$survey_id = 7;
        $end = $this->input->get('end');
        $start = $this->input->get('start');
        $country = $this->input->get('country');

        if(!isset($country) || is_null($country) || strlen($country) == 0) {
            $this->jsonify(array(
                'status' => 0,
                'msg' => 'Country is mandatory.',
            ));
        }
        if(!isset($start) || is_null($start) || strlen($start) == 0) {
            $this->jsonify(array(
                'status' => 0,
                'msg' => 'Start date is mandatory.',
            ));
        }
        if(!isset($end) || is_null($end) || strlen($end) == 0) {
            $this->jsonify(array(
                'status' => 0,
                'msg' => 'End date is mandatory.',
            ));
        }

        $field_array_old = $field_array_new = $field_array_type = array();
		$this->db->select('*');
		$this->db->from('form_field');
		$this->db->where('form_id', $survey_id)->where('status', 1);
		$fields = $this->db->get()->result_array();
		foreach ($fields as $key => $field) {
			array_push($field_array_old, 'field_'.$field['field_id']);
			array_push($field_array_new, $field['label']);
            array_push($field_array_type, $field['type']);
		}

        $this->db->select("
            lm.name AS market_name, lc.name AS country_name,
            survey.*, survey.datetime AS uploaded_datetime_UTC,
            survey.pa_verified_date AS verified_date_UTC,
            (CASE 
                WHEN survey.pa_verified_status IS NULL THEN 'Submitted'
                WHEN survey.pa_verified_status = 2 THEN 'Approved'
                WHEN survey.pa_verified_status = 3 THEN 'Rejected'
                ELSE 'Unknown'
            END) AS verified_status,
            concat(tu.first_name,' ', tu.last_name,' (', tu.username,')') AS uploaded_by
        ");
        $this->db->from('survey'.$survey_id.' AS survey');
        $this->db->join('tbl_users AS tu', 'tu.user_id = survey.user_id');
        $this->db->join('lkp_market AS lm', 'lm.market_id = survey.market_id');
        $this->db->join('lkp_country AS lc', 'lc.country_id = survey.country_id');
        $this->db->where('lc.name', $country);
        $this->db->where('DATE(survey.datetime) >=', $start);
        $this->db->where('DATE(survey.datetime) <=', $end);
        $this->db->where('survey.status', 1);
        $this->db->group_start();
            $this->db->where('survey.pa_verified_status', 1);
            $this->db->or_where('survey.pa_verified_status', 2);
        $this->db->group_end();
        $records = $this->db->get()->result_array();

        foreach ($records as $key => $value) {
            $records[$key]['lat'] = NULL;
            $records[$key]['lng'] = NULL;
			$records[$key]['verified_by'] = NULL;
            $records[$key]['cluster_name'] = NULL;
            $records[$key]['uai_name'] = NULL;
            $records[$key]['sub_location_name'] = NULL;

            // Get verified by name
            if(isset($value['pa_verified_by']) && !is_null($value['pa_verified_by']) && !empty($value['pa_verified_by'])) {
                $result = $this->db->where('user_id', $value['pa_verified_by'])->get('tbl_users')->row_array();
                if(!is_null($result)) {
                    $records[$key]['verified_by'] = $result['first_name'].' '.$result['last_name'].' ('.$result['username'].')';
                }
            }
            // Get cluster name
            if(isset($value['cluster_id']) && !is_null($value['cluster_id']) && !empty($value['cluster_id'])) {
                $result = $this->db->where('cluster_id', $value['cluster_id'])->get('lkp_cluster')->row_array();
                if(!is_null($result)) {
                    $records[$key]['cluster_name'] = $result['name'];
                }
            }
            // Get uai name
            if(isset($value['uai_id']) && !is_null($value['uai_id']) && !empty($value['uai_id'])) {
                $result = $this->db->where('uai_id', $value['uai_id'])->get('lkp_uai')->row_array();
                if(!is_null($result)) {
                    $records[$key]['uai_name'] = $result['uai'];
                }
            }
            // Get sub-location name
            if(isset($value['sub_location_id']) && !is_null($value['sub_location_id']) && !empty($value['sub_location_id'])) {
                $result = $this->db->where('sub_loc_id', $value['sub_location_id'])->get('lkp_sub_location')->row_array();
                if(!is_null($result)) {
                    $records[$key]['sub_location_name'] = $result['location_name'];
                }
            }
            
            foreach ($field_array_old as $name_key => $old_name) {
                if(isset($value[$old_name])) {
                    switch ($field_array_type[$name_key]) {
                        case 'lkp_cluster':
                            $cluster = $this->db->where('cluster_id', $value[$old_name])->get('lkp_cluster')->row_array();
                            if(!is_null($cluster) && isset($cluster['name'])) {
                                $records[$key][$field_array_new[$name_key]] = $cluster['name'];
                            } else {
                                $records[$key][$field_array_new[$name_key]] = 'N/A';
                            }
                        break;

                        case 'lkp_country':
                            $country = $this->db->where('country_id', $value[$old_name])->get('lkp_country')->row_array();
                            if(!is_null($country) && isset($country['name'])) {
                                $records[$key][$field_array_new[$name_key]] = $country['name'];
                            } else {
                                $records[$key][$field_array_new[$name_key]] = 'N/A';
                            }
                        break;

                        case 'lkp_lr_body_condition':
                            $llbc = $this->db->where('id', $value[$old_name])->get('lkp_lr_body_condition')->row_array();
                            if(!is_null($llbc) && isset($llbc['name'])) {
                                $records[$key][$field_array_new[$name_key]] = $llbc['name'];
                            } else {
                                $records[$key][$field_array_new[$name_key]] = 'N/A';
                            }
                        break;

                        case 'lkp_market':
                            $market = $this->db->where('market_id', $value[$old_name])->get('lkp_market')->row_array();
                            if(!is_null($market) && isset($market['name'])) {
                                $records[$key][$field_array_new[$name_key]] = $market['name'];
                            } else {
                                $records[$key][$field_array_new[$name_key]] = 'N/A';
                            }
                        break;

                        case 'lkp_sr_body_condition':
                            $lsbc = $this->db->where('id', $value[$old_name])->get('lkp_sr_body_condition')->row_array();
                            if(!is_null($lsbc) && isset($lsbc['name'])) {
                                $records[$key][$field_array_new[$name_key]] = $lsbc['name'];
                            } else {
                                $records[$key][$field_array_new[$name_key]] = 'N/A';
                            }
                        break;

                        default:
                            $records[$key][$field_array_new[$name_key]] = $value[$old_name];
                        break;
                    }
                } else {
                    $records[$key][$field_array_new[$name_key]] = 'N/A';
                }
			}
		}

        $this->jsonify(array(
            'status' => 1,
            'records' => $records,
        ));
	}

    //return json data
	public function jsonify($data)
	{
		print_r(json_encode($data));
		exit();
	}
}