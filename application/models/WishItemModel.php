<?php

class WishItemModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function getWishList($listId) {
        $query = $this->db->get_where('wish_items', array('list_id' => $listId));
        return $query->result();
    }

    function getWishItem($id) {
        $query = $this->db->get_where('wish_items', array('id' => $id));
        return $query->row();
    }

}
