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

    public function get_form($form_id) {
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

    public function get_submitted_data($data) {
        $form_details = $this->db->where('id', $data['survey_id'])->get('forms')->row_array();
        $columns = (array)json_decode($form_details['form_data']);
        $recordcounttoprint = ($data['record_per_page']*$data['page_no'])-($data['record_per_page']);
        $query = "";
        if(isset($columns) && count($columns) > 0) {
            // $query = "SELECT s.id, s.form_id,s.user_id,s.datetime";
            $query = "SELECT s.id, s.form_id,s.user_id,s.datetime,u.first_name,u.last_name";
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
    public function get_submitted_data_r_count($form_id) {
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
}
?>
