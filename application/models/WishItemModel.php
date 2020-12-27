<?php

class WishItemModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function getWishList($listId) {
        $this->db->join('priorities', 'priorities.id = wish_items.priority');
        $query = $this->db->get_where('wish_items', array('list_id' => $listId));
        return $query->result();
    }

    function getWishItem($id) {
        $this->db->join('priorities', 'priorities.id = wish_items.priority');
        $query = $this->db->get_where('wish_items', array('id' => $id));
        return $query->row();
    }

}
