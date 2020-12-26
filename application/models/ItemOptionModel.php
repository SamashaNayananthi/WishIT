<?php

class ItemOptionModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function getOccasions() {
        $query = $this->db->get('occasions');
        return $query->result();
    }

    function getPriorities() {
        $this->db->order_by('priority', 'asc');
        $query = $this->db->get('priorities');
        return $query->result();
    }
}
