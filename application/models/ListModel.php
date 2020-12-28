<?php

class ListModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function getListDetails($userId) {
        $query = $this->db->get_where('list_details', array('user_id' => $userId));
        return $query->row();
    }

    function saveList($name, $description, $userId) {
        $list = array('name' => $name, 'description' => $description, 'user_id' => $userId);
        $this->db->insert('list_details', $list);

        return $this->db->insert_id();
    }

    function updateList($id, $name, $description) {
        $data = array('name' => $name, 'description' => $description);
        $this->db->update('list_details', $data, array('id' => $id));
    }

    function getListIdBYUserId($userId) {
        $this->db->select('id');
        $query = $this->db->get_where('list_details', array('user_id' => $userId));
        return $query->row();
    }

}
