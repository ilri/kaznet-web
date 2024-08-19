<?php
class FormModel extends CI_Model {

    public function save_form($form_data, $form_title, $form_subject) {
        $data = [
            'form_data' => $form_data,
            'title' => $form_title,
            'subject' => $form_subject
        ];
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

    public function get_all_forms() {
        $query = $this->db->get('forms');
        return $query->result_array();
    }

    public function get_submitted_data($form_id) {
        $this->db->where('form_id', $form_id);
        $query = $this->db->get('submitted_data');
        return $query->result_array();
    }
}
?>
