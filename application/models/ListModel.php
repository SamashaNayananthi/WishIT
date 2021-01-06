<?php

class ListModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function getListDetails($userId) {
        $this->db->select('l.id, l.name, l.description, l.occasion_id, l.user_id, o.name occasion');
        $this->db->join('occasions o', 'l.occasion_id = o.id', 'left');
        $query = $this->db->get_where('list_details l', array('user_id' => $userId));
        return $query->row();
    }

    function saveList($name, $description, $occasionId, $userId) {
        $list = array('name' => $name, 'description' => $description, 'occasion_id' => $occasionId,
            'user_id' => $userId);
        $this->db->insert('list_details', $list);

        return $this->db->insert_id();
    }

    function updateList($id, $name, $description, $occasionId) {
        $data = array('name' => $name, 'description' => $description, 'occasion_id' => $occasionId);
        $this->db->update('list_details', $data, array('id' => $id));
    }

    function getListIdBYUserId($userId) {
        $this->db->select('id');
        $query = $this->db->get_where('list_details', array('user_id' => $userId));
        return $query->row();
    }

    function deleteListById($id) {
        $this->db->delete('list_details', array('id' => $id));
    }

}
