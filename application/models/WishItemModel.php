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
        $this->db->join('priorities', 'priorities.id = wish_items.priority');
        $query = $this->db->get_where('wish_items', array('id' => $id));
        return $query->row();
    }

    function saveWishItem($title, $listId, $occasionId, $priorityId, $itemUrl, $price, $quantity) {
        $newItem = array('title' => $title, 'list_id' => $listId, 'occasion' => $occasionId,
            'priority' => $priorityId, 'item_url' => $itemUrl, 'price' => $price, 'quantity' => $quantity);
        $this->db->insert('wish_items', $newItem);

        return $this->db->insert_id();
    }

}
