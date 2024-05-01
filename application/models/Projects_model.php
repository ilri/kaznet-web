<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');		
	}

	public function all_project()
	{
		$this->db->distinct()->select('lp.project_id, lp.project_name, lp.project_description, lp.added_datetime, lp.status');
		$this->db->from('lkp_projects AS lp');
		if($this->session->userdata('role') != 1 && $this->session->userdata('role') != 2) {
			$this->db->join('rpt_project_partner_user_location AS rppul', 'rppul.lkp_project_id = lp.project_id');
			$this->db->where('rppul.user_id', $this->session->userdata('login_id'))->where('rppul.project_user_loc_status', 1);
		}
		$all_projects = $this->db->where('lp.project_id', 1)->where('lp.status', 1)->get()->result_array();
		foreach ($all_projects as $key => $project) {
			$this->db->select('id, partner_id')->from('rpt_partner_project')->where('status', 1);
			$partners = $this->db->where('project_id', $project['project_id'])->get();
			$all_projects[$key]['partners'] = $partners->num_rows();

			$this->db->distinct()->select('user_id')->from('rpt_project_partner_user_location')->where('project_user_loc_status', 1);
			$users = $this->db->where('lkp_project_id', $project['project_id'])->get();
			$all_projects[$key]['users'] = $users->num_rows();
		}

		return $all_projects;
	}

	public function get_project_details($data)
	{
		$this->db->select('project_id, project_name, project_description, added_datetime, status');
		$project = $this->db->where('project_id', $data['project_id'])->where('status', 1)->get('lkp_projects');

		if($project->num_rows() === 0) {
			return false;
		} else {
			return $project->row_array();
		}
	}

	public function get_project_locations($data)
	{
		$this->db->select('project_id, project_name, project_description, added_datetime, status');
		$project = $this->db->where('project_id', $data['project_id'])->where('status', 1)->get('lkp_projects');

		if($project->num_rows() === 0) {
			return false;
		}

		$partIds = array();
		$this->db->select('id, partner_id')->from('rpt_partner_project')->where('status', 1);
		$partners = $this->db->where('project_id', $data['project_id'])->get()->result_array();
		foreach ($partners as $partner) {
			if(!in_array($partner['partner_id'], $partIds)) {
				array_push($partIds, $partner['partner_id']);
			}
		}
		if(count($partIds) == 0) $partIds = array(0);

		$this->db->distinct()->select('lc.name AS country, ls.state_name AS state, ld.district_name AS dist, lb.block_name AS block, lv.village_name AS village');
		$this->db->join('lkp_country AS lc', 'lc.country_id = rpl.lkp_country_id');
		$this->db->join('lkp_state AS ls', 'ls.state_id = rpl.lkp_state_id');
		$this->db->join('lkp_district AS ld', 'ld.district_id = rpl.lkp_district_id');
		$this->db->join('lkp_block AS lb', 'lb.block_id = rpl.lkp_block_id');
		$this->db->join('lkp_village AS lv', 'lv.village_id = rpl.lkp_village_id');
		$locations = $this->db->where_in('rpl.partner_id', $partIds)->get('rpt_partner_location AS rpl')->result_array();

		return $locations;
	}

	public function get_project_partners($data)
	{
		$this->db->select('project_id, project_name, project_description, added_datetime, status');
		$project = $this->db->where_in('project_id', $data['project_id'])->where('status', 1)->get('lkp_projects');

		if($project->num_rows() === 0) {
			return false;
		}

		$this->db->distinct()->select('lp.partner_id, lp.partner_name, lp.partner_email, lp.nature_of_business, lp.address, lp.postcode, lp.country, lp.telephone, lp.fax, lp.added_datetime, lp.status');
		$this->db->join('lkp_partners AS lp', 'lp.partner_id = rpp.partner_id');
		$this->db->where_in('rpp.project_id', $data['project_id'])->where('rpp.status', 1);
		$this->db->having('count(distinct rpp.project_id) = '.count($data['project_id']));
		$partners = $this->db->group_by('rpp.partner_id')->get('rpt_partner_project AS rpp')->result_array();

		return $partners;
	}

	public function add_project($data)
	{
		$query = $this->db->insert('lkp_projects', $data);
		if($query) {
			return true;
		} else {
			return false;
		}
	}

	public function edit_project($data)
	{
		$query = $this->db->where($data['where'])->update('lkp_projects', $data['set']);
		if($query) {
			return true;
		} else {
			return false;
		}
	}
}