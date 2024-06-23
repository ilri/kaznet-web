<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helper_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');		
	}

	public function all_units()
	{
		return $all_units = $this->db->where('UNIT_STATUS', 1)->get('lkp_unit')->result_array();
	}

	// public function all_divisions($UNIT = NULL)
	// {
	// 	$this->db->where('ld.DIVISION_STATUS', 1);
	// 	if(!is_null($UNIT)) {
	// 		$this->db->join('lkp_unit AS lu', 'lu.plant_code = ld.WERKS');
	// 		$this->db->where('lu.UNIT_ID', $UNIT);
	// 	}
	// 	return $all_divisions = $this->db->get('lkp_division AS ld')->result_array();
	// }

	// public function all_circles($DIV_CODE = NULL)
	// {
	// 	if(!is_null($DIV_CODE)) $this->db->where_in('DIV_CODE', $DIV_CODE);
	// 	return $all_circles = $this->db->where('CIRCLE_STATUS', 1)->get('lkp_circle')->result_array();
	// }





	public function all_agencies()
	{
		return $all_agencies = $this->db->where('UNIT_STATUS', 1)->get('lkp_unit')->result_array();
	}

	public function all_states($country = NULL)
	{
		if(!is_array($country) && !is_null($country)) $country = explode(',', $country);
		if(!is_null($country)) $this->db->where_in('country_id', $country);
		return $all_states = $this->db->where('status', 1)->get('lkp_state')->result_array();
	}
	public function all_client_states($client)
	{
		$this->db->distinct()->select('state.state_id, state.state_name');
		$this->db->join('tbl_client_location AS tcl', 'tcl.state_id = state.state_id');
		$this->db->where('tcl.status', 1)->where('tcl.client_id', $client);
		return $all_states = $this->db->get('lkp_state AS state')->result_array();
	}

	public function all_districts($state = NULL)
	{
		if(!is_array($state) && !is_null($state)) $state = explode(',', $state);
		if(!is_null($state)) $this->db->where_in('state_id', $state);
		return $all_districts = $this->db->where('status', 1)->get('lkp_district')->result_array();
	}
	public function all_client_districts($client, $state = NULL)
	{
		if(!is_array($state) && !is_null($state)) $state = explode(',', $state);

		$this->db->distinct()->select('dist.district_id, dist.district_name')->from('tbl_client_location AS tcl');
		$this->db->join('lkp_district AS dist', 'dist.district_id = tcl.district_id');
		$this->db->where('tcl.status', 1)->where('tcl.client_id', $client);
		if(!is_null($state)) $this->db->where_in('dist.state_id', $state);
		return $all_districts = $this->db->get()->result_array();
	}

	public function all_tehsils($district = NULL)
	{
		if(!is_array($district) && !is_null($district)) $district = explode(',', $district);
		if(!is_null($district)) $this->db->where_in('district_id', $district);
		return $all_tehsils = $this->db->where('tehsil_status', 1)->get('lkp_tehsil')->result_array();
	}

	public function all_blocks($tehsil = NULL)
	{
		if(!is_array($tehsil) && !is_null($tehsil)) $tehsil = explode(',', $tehsil);
		if(!is_null($tehsil)) $this->db->where_in('tehsil_id', $tehsil);
		return $all_blocks = $this->db->where('block_status', 1)->get('lkp_block')->result_array();
	}

	public function all_gps($block = NULL)
	{
		if(!is_array($block) && !is_null($block)) $block = explode(',', $block);
		if(!is_null($block)) $this->db->where_in('block_id', $block);
		return $all_gps = $this->db->where('grampanchayat_status', 1)->get('lkp_grampanchayat')->result_array();
	}

	public function all_villages($gp = NULL)
	{
		if(!is_array($gp) && !is_null($gp)) $gp = explode(',', $gp);
		if(!is_null($gp)) $this->db->where_in('grampanchayat_id', $gp);
		return $all_villages = $this->db->where('village_status', 1)->get('lkp_village')->result_array();
	}
	// added by sagar
	public function get_partner_locations_nested($data)
	{
		// $this->db->select('partner_id, partner_name, partner_email, nature_of_business, address, postcode, country, telephone, fax, added_datetime, status');
		// $partner = $this->db->where('partner_id', $data['partner_id'])->where('status !=', 0)->get('lkp_partners');

		// if($partner->num_rows() === 0) {
		// 	return false;
		// }
		// $partner = $partner->row_array();

		// if($partner['status'] == 1) {
		// 	$this->db->distinct()->select('lc.country_id AS id, lc.name AS country');
		// 	$this->db->join('lkp_country AS lc', 'lc.country_id = rpl.lkp_country_id');
		// 	$this->db->where('rpl.partner_id', $partner['partner_id']);
		// 	$countries = $this->db->get('rpt_partner_location AS rpl')->result_array();
			
		// 	foreach ($countries as $ckey => $country) {
		// 		$this->db->distinct()->select('ls.state_id AS id, ls.state_name AS state');
		// 		$this->db->join('lkp_state AS ls', 'ls.state_id = rpl.lkp_state_id');
		// 		$this->db->where('rpl.partner_id', $partner['partner_id'])->where('rpl.lkp_country_id', $country['id']);
		// 		$states = $this->db->get('rpt_partner_location AS rpl')->result_array();

		// 		foreach ($states as $skey => $state) {
		// 			$this->db->distinct()->select('ld.district_id AS id, ld.district_name AS district');
		// 			$this->db->join('lkp_district AS ld', 'ld.district_id = rpl.lkp_district_id');
		// 			$this->db->where('rpl.partner_id', $partner['partner_id'])->where('rpl.lkp_state_id', $state['id']);
		// 			$districts = $this->db->get('rpt_partner_location AS rpl')->result_array();

		// 			foreach ($districts as $dkey => $district) {
		// 				$this->db->distinct()->select('lb.block_id AS id, lb.block_name AS block');
		// 				$this->db->join('lkp_block AS lb', 'lb.block_id = rpl.lkp_block_id');
		// 				$this->db->where('rpl.partner_id', $partner['partner_id'])->where('rpl.lkp_district_id', $district['id']);
		// 				$blocks = $this->db->get('rpt_partner_location AS rpl')->result_array();

		// 				foreach ($blocks as $bkey => $block) {
		// 					$this->db->distinct()->select('lv.village_id AS id, lv.village_name AS village');
		// 					$this->db->join('lkp_village AS lv', 'lv.village_id = rpl.lkp_village_id');
		// 					$this->db->where('rpl.partner_id', $partner['partner_id'])->where('rpl.lkp_block_id', $block['id']);
		// 					$villages = $this->db->get('rpt_partner_location AS rpl')->result_array();

		// 					$blocks[$bkey]['villages'] = $villages;
		// 				}
		// 				$districts[$dkey]['blocks'] = $blocks;
		// 			}
		// 			$states[$skey]['districts'] = $districts;
		// 		}
		// 		$countries[$ckey]['states'] = $states;
		// 	}
		// } else {
			$this->db->distinct()->select('lc.country_id AS id, lc.name AS country');
			$countries = $this->db->where('lc.status', 1)->get('lkp_country AS lc')->result_array();
			
			foreach ($countries as $ckey => $country) {
				$this->db->distinct()->select('ls.state_id AS id, ls.state_name AS state');
				$this->db->where('ls.status', 1)->where('ls.country_id', $country['id']);
				$states = $this->db->get('lkp_state AS ls')->result_array();

				foreach ($states as $skey => $state) {
					$this->db->distinct()->select('ld.district_id AS id, ld.district_name AS district');
					$this->db->where('ld.status', 1)->where('ld.state_id', $state['id']);
					$districts = $this->db->get('lkp_district AS ld')->result_array();

					foreach ($districts as $dkey => $district) {
						$this->db->distinct()->select('lb.block_id AS id, lb.block_name AS block');
						$this->db->where('lb.block_status', 1)->where('lb.district_id', $district['id']);
						$blocks = $this->db->get('lkp_block AS lb')->result_array();

						foreach ($blocks as $bkey => $block) {
							$this->db->distinct()->select('lv.village_id AS id, lv.village_name AS village');
							$this->db->where('lv.village_status', 1)->where('lv.block_id', $block['id']);
							$villages = $this->db->get('lkp_village AS lv')->result_array();

							$blocks[$bkey]['villages'] = $villages;
						}
						$districts[$dkey]['blocks'] = $blocks;
					}
					$states[$skey]['districts'] = $districts;
				}
				$countries[$ckey]['states'] = $states;
			}
		// }

		return $countries;
	}
	public function get_user_details($data)
	{
		
		$this->db->select('users.user_id, users.username, users.email_id, users.first_name, users.last_name, role.role_id, role.role_name');
		$this->db->from('tbl_users as users');
		$this->db->join('tbl_role as role', 'role.role_id = users.role_id');
		$this->db->where('users.status', 1);
		$this->db->where('users.user_id', $data['user_id']);
		$this->db->where('role.status', 1);
		$user_details = $this->db->get()->row_array();

		//Get user locations
		$user_details['locations'] = array();
		$locations = $this->get_user_locations($data['user_id']);
		foreach ($locations as $key => $loc) {
			array_push($user_details['locations'], $loc['village_id']);
		}
		// return $locations;
		$result['user_details'] = $user_details;
		return $user_details;
	}
	//Get user locations
	public function get_user_locations($user_id){
		$this->db->distinct()->select('lc.name AS country, ls.state_name AS state, ld.district_name AS dist, lb.block_name AS block, lv.village_id, lv.village_name AS village');
		$this->db->join('lkp_country AS lc', 'lc.country_id = rppul.country_id');
		$this->db->join('lkp_state AS ls', 'ls.state_id = rppul.state_id');
		$this->db->join('lkp_district AS ld', 'ld.district_id = rppul.district_id');
		$this->db->join('lkp_block AS lb', 'lb.block_id = rppul.block_id');
		$this->db->join('lkp_village AS lv', 'lv.village_id = rppul.village_id');
		$this->db->where('rppul.user_id', $user_id)->where('rppul.status', 1);
		$locations = $this->db->get('tbl_user_unit_location AS rppul')->result_array();

		return $locations;
	}
}