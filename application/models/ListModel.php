<?php

class ListModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function getListDetails($userId) {
        $query = $this->db->get_where('list_details', array('user_id' => $userId));
        return $query->result();
    }

}
