<?php

class ListModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function getListDetails($userId) {
        $this->db->select('l.id, l.name, l.description, l.occasion_id, l.user_id, o.name occasion');
        $this->db->join('wi_occasions o', 'l.occasion_id = o.id', 'left');
        $query = $this->db->get_where('wi_list_details l', array('user_id' => $userId));
        return $query->row();
    }

    function saveList($name, $description, $occasionId, $userId) {
        $list = array('name' => $name, 'description' => $description, 'occasion_id' => $occasionId,
            'user_id' => $userId);
        $this->db->insert('wi_list_details', $list);

        return $this->db->insert_id();
    }

    function updateList($id, $name, $description, $occasionId) {
        $data = array('name' => $name, 'description' => $description, 'occasion_id' => $occasionId);
        $this->db->update('wi_list_details', $data, array('id' => $id));
    }

    function getListIdBYUserId($userId) {
        $this->db->select('id');
        $query = $this->db->get_where('wi_list_details', array('user_id' => $userId));
        return $query->row();
    }

    function deleteListById($id) {
        $this->db->delete('wi_list_details', array('id' => $id));
    }

}
