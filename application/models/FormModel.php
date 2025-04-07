<?php
class FormModel extends CI_Model {

    public function save_form($form_data, $form_title, $form_subject) {
        $data = [
            'form_data' => $form_data,
            'title' => $form_title,
            'subject' => $form_subject
        ];
        //added by sagar for updating user related data while record inserting in to table
        $time = time();
        date_default_timezone_set('UTC');
        $currentDateTime = date('Y-m-d H:i:s');
        // $data['data_id'] = $time.'-'.$this->session->userdata('login_id');
        $data['added_by'] = $this->session->userdata('login_id');
        $data['datetime']=$currentDateTime;
        $data['ip_address'] = $this->input->ip_address();
        $this->db->insert('forms', $data);
        return $this->db->insert_id();
    }
    public function update_form($form_id, $form_data, $form_title, $form_subject) {
        $data = [
            'form_id' => $form_id,
            'form_data' => $form_data,
            'title' => $form_title,
            'subject' => $form_subject
        ];
        $update_data = [
            'form_data' => $data['form_data'],
            'title' => $data['title'],
            'subject' => $data['subject']
        ];
        //added by sagar for updating user related data while record inserting in to table
        // $time = time();
        // date_default_timezone_set('UTC');
        // $currentDateTime = date('Y-m-d H:i:s');
        // $data['added_by'] = $this->session->userdata('login_id');
        // $data['datetime']=$currentDateTime;
        // $data['ip_address'] = $this->input->ip_address();
        $delete_data = $this->db->where('id', $form_id)->update('forms', $update_data);
        if($delete_data){
            return $form_id;
        }else{
            print_r($this->db->last_query());exit();
            print_r("form not updated");
        }
        // $this->db->insert('forms', $data);
        // return $this->db->insert_id();
    }

    public function get_form($form_id) {
        $query = $this->db->get_where('forms', ['id' => $form_id]);
        return $query->row()->form_data;
    }
    public function get_form_fields_data($form_id) {
        $this->db->select('form_data');
        $query = $this->db->get_where('forms', ['id' => $form_id]);
        return $query->row()->form_data;
    }

    public function save_submitted_data($form_id, $submitted_data) {
        $data = [
            'form_id' => $form_id,
            'data' => json_encode($submitted_data)
        ];
        $this->db->insert('submitted_data', $data);
    }

    public function get_all_forms($from_id=null) {
        // $query = $this->db->get('forms');
        // return $query->result_array();
        if($from_id != null){
            $query ="select f.* from forms f where id=".$from_id."";
        }else{
            $query ="select f.*,tu.first_name,tu.last_name from forms f left outer join tbl_users as tu on tu.user_id= f.added_by";
        }
        return $this->db->query($query)->result_array();
    }

    public function get_all_forms_p($data) {
        $recordcounttoprint = ($data['record_per_page']*$data['page_no'])-($data['record_per_page']);
        // if($data['status'] != null){
        //     $query ="select f.*,tu.first_name,tu.last_name from forms f left outer join tbl_users as tu on tu.user_id= f.added_by where f.status = ".$data['status']." ";
        // }else{
        //     $query ="select f.*,tu.first_name,tu.last_name from forms f left outer join tbl_users as tu on tu.user_id= f.added_by ";
        // }
        
        if($data['status'] != null){
            $query ="select f.*,tu.first_name,tu.last_name,tu1.first_name d_f_name,tu1.last_name as d_l_name from forms f left outer join tbl_users as tu on tu.user_id= f.added_by  left outer join tbl_users as tu1 on tu1.user_id= f.deleted_by where f.status = ".$data['status']." order by f.id DESC ";
        }else{
            $query ="select f.*,tu.first_name,tu.last_name,tu1.first_name d_f_name,tu1.last_name as d_l_name from forms f left outer join tbl_users as tu on tu.user_id= f.added_by  left outer join tbl_users as tu1 on tu1.user_id= f.deleted_by order by f.id DESC ";
        }
        if($data['is_pagination']){
            $query .= "LIMIT ".$recordcounttoprint.",".$data['record_per_page']."";
        }
        // print_r($data['status']);exit();
        // print_r($query);exit();
        return $this->db->query($query)->result_array();
    }
    public function get_all_forms_count($data) {
        $recordcounttoprint = ($data['record_per_page']*$data['page_no'])-($data['record_per_page']);
        if($data['status'] != null){
            $query ="select f.*,tu.first_name,tu.last_name from forms f left outer join tbl_users as tu on tu.user_id= f.added_by where f.status = ".$data['status']." ";
        }else{
            $query ="select f.*,tu.first_name,tu.last_name from forms f left outer join tbl_users as tu on tu.user_id= f.added_by ";
        }
        // if($data['is_pagination']){
        //     $query .= "LIMIT ".$recordcounttoprint.",".$data['record_per_page']."";
        // }
        // print_r($data['status']);exit();
        // print_r($query);exit();
        return $this->db->query($query)->result_array();
    }

    public function get_submitted_data_old($data) {
        $form_details = $this->db->where('id', $data['survey_id'])->get('forms')->row_array();
        $columns = (array)json_decode($form_details['form_data']);
        $recordcounttoprint = ($data['record_per_page']*$data['page_no'])-($data['record_per_page']);
        // print_r($recordcounttoprint);exit();
        $query = "";
        if(isset($columns) && count($columns) > 0) {
            // $query = "SELECT s.id, s.form_id,s.user_id,s.datetime";
            $query = "SELECT s.*, u.first_name, u.last_name";
            foreach ($columns as $key => $col) {
                $col = (array)$col;
                $columns[$key] = $col;
                $query .= ", JSON_UNQUOTE(JSON_EXTRACT(s.data, '$.\"".$col['name']."\"')) AS '".$col['name']."'";
            }
            // $query .= "FROM submitted_data s WHERE s.form_id = ".$data['survey_id']." ";
            $query .= "FROM submitted_data s join tbl_users as u on u.user_id=s.user_id WHERE s.form_id = ".$data['survey_id']." ";
            // $query .= "join forms as f on s.form_id = f.id";
            //added by sagar for pagenation
            if($data['is_pagination']){
                $query .= "LIMIT ".$recordcounttoprint.",".$data['record_per_page']."";
            }
            // print_r($query);exit();
        }
        $data = $this->db->query($query)->result_array();
        // print_r($this->db->last_query());exit();
        return array('data' => $data, 'columns' => $columns);
    }

    public function get_submitted_data($data) {
        $form_details = $this->db->where('id', $data['survey_id'])->get('forms')->row_array();
        $columns = (array)json_decode($form_details['form_data']);
        $offset = ($data['page_no'] - 1) * $data['record_per_page'];
        $limit = (int)$data['record_per_page'];
        
        $query = 'SELECT s.*, 
                        CONCAT(tu.first_name, " ", tu.last_name, " (", tu.username, ")") AS first_name, 
                        CONCAT(rp.first_name, " ", rp.last_name) AS respondent, 
                        rp.hhid, 
                        lm.name AS market_name';
        
        if (!empty($columns)) {
            foreach ($columns as $col) {
                $col = (array)$col;
                $query .= ", JSON_UNQUOTE(JSON_EXTRACT(s.data, '$.\"{$col['name']}\"')) AS `{$col['name']}`";
            }
        }
        
        $query .= " FROM submitted_data s
                    JOIN tbl_users tu ON tu.user_id = s.user_id
                    LEFT JOIN tbl_respondent_users rp ON rp.data_id = s.respondent_data_id
                    LEFT JOIN lkp_market lm ON lm.market_id = s.market_id
                    LEFT JOIN ic_data_location idl ON idl.data_id = s.data_id";
        
        $query .= " WHERE s.form_id = ?";
        $params = [$data['survey_id']];
        
        if (!empty($data['country_id'])) {
            $query .= " AND s.country_id = ?";
            $params[] = $data['country_id'];
        }
        if (!empty($data['cluster_id'])) {
            $query .= " AND s.cluster_id = ?";
            $params[] = $data['cluster_id'];
        }
        if (!empty($data['uai_id'])) {
            $query .= " AND s.uai_id = ?";
            $params[] = $data['uai_id'];
        }
        if (!empty($data['sub_location_id'])) {
            $query .= " AND s.sub_location_id = ?";
            $params[] = $data['sub_location_id'];
        }
        if (!empty($data['contributor_id'])) {
            $query .= " AND s.user_id = ?";
            $params[] = $data['contributor_id'];
        }
        if (!empty($data['respondent_id'])) {
            if ($data['survey_type'] == "Market Task") {
                $query .= " AND s.market_id = ?";
            } elseif ($data['survey_type'] == "Rangeland Task") {
                $query .= " AND tp.pasture_type = ?";
            } else {
                $query .= " AND s.respondent_data_id = ?";
            }
            $params[] = $data['respondent_id'];
        }
        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $query .= " AND DATE(s.datetime) BETWEEN ? AND ?";
            $params[] = $data['start_date'];
            $params[] = $data['end_date'];
        }
        
        $query .= " AND s.status = 1";
        
        // if (!empty($data['is_pa_verified_status'])) {
        //     $query .= " AND s.pa_verified_status = ?";
        //     $params[] = $data['pa_verified_status'];
        // }
        
        $query .= " ORDER BY s.id DESC";
        
        if ($data['is_pagination']) {
            $query .= " LIMIT $offset, $limit";
        }
        
        $submitted_data = $this->db->query($query, $params)->result_array();
        
        foreach ($submitted_data as $key => $value) {
            $this->db->select('field_id, file_name');
            $this->db->where('data_id', $value['data_id']);
            $images = $this->db->where('status', 1)->get('ic_data_file')->result_array();
            
            foreach ($images as $ikey => $ivalue) {
                $submitted_data[$key]['field_' . $ivalue['field_id']] = $ivalue['file_name'];
            }
        }
        
        return ['data' => $submitted_data, 'columns' => $columns];
    }

    public function get_submitted_data_r_count_old($form_id) {
        //added this function  by sagar for pagenation
        $form_details = $this->db->where('id', $form_id)->get('forms')->row_array();
        $columns = (array)json_decode($form_details['form_data']);
        
        $query = "";
        if(isset($columns) && count($columns) > 0) {
            $query = "SELECT s.id, s.form_id";
            foreach ($columns as $key => $col) {
                $col = (array)$col;
                $columns[$key] = $col;
                $query .= ", JSON_UNQUOTE(JSON_EXTRACT(s.data, '$.\"".$col['name']."\"')) AS '".$col['name']."'";
            }
            $query .= "FROM
                submitted_data s
            WHERE
                s.form_id = $form_id";
        }
        $count = $this->db->query($query)->num_rows();
        return $count;
    }

    public function get_submitted_data_r_count($data) {
        $form_details = $this->db->where('id', $data['survey_id'])->get('forms')->row_array();
        $columns = (array)json_decode($form_details['form_data']);
        
        $query = "SELECT COUNT(*) AS total FROM submitted_data s ";
        
        // Joins
        $query .= " JOIN tbl_users tu ON tu.user_id = s.user_id";
        $query .= " LEFT JOIN tbl_respondent_users rp ON rp.data_id = s.respondent_data_id";
        $query .= " LEFT JOIN lkp_market lm ON lm.market_id = s.market_id";
        $query .= " LEFT JOIN ic_data_location idl ON idl.data_id = s.data_id";
        
        // Base condition
        $query .= " WHERE s.form_id = ?";
        $params = [$data['survey_id']];
        
        // Apply filters
        if (!empty($data['country_id'])) {
            $query .= " AND s.country_id = ?";
            $params[] = $data['country_id'];
        }
        if (!empty($data['cluster_id'])) {
            $query .= " AND s.cluster_id = ?";
            $params[] = $data['cluster_id'];
        }
        if (!empty($data['uai_id'])) {
            $query .= " AND s.uai_id = ?";
            $params[] = $data['uai_id'];
        }
        if (!empty($data['sub_location_id'])) {
            $query .= " AND s.sub_location_id = ?";
            $params[] = $data['sub_location_id'];
        }
        if (!empty($data['contributor_id'])) {
            $query .= " AND s.user_id = ?";
            $params[] = $data['contributor_id'];
        }
        if (!empty($data['respondent_id'])) {
            if ($data['survey_type'] == "Market Task") {
                $query .= " AND s.market_id = ?";
            } elseif ($data['survey_type'] == "Rangeland Task") {
                $query .= " AND tp.pasture_type = ?";
            } else {
                $query .= " AND s.respondent_data_id = ?";
            }
            $params[] = $data['respondent_id'];
        }
        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $query .= " AND DATE(s.datetime) BETWEEN ? AND ?";
            $params[] = $data['start_date'];
            $params[] = $data['end_date'];
        }
        
        $query .= " AND s.status = 1";
        
        $count_result = $this->db->query($query, $params)->row_array();
        return $count_result['total'] ?? 0;
    }
    
}
?>
