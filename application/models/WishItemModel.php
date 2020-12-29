<?php

class WishItemModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function getWishList($listId) {
        $this->db->select('wi.id, wi.title, wi.list_id, wi.occasion, wi.priority, wi.item_url, wi.price, 
        wi.quantity, o.name o_name, p.name p_name, p.priority p_level');
        $this->db->join('occasions o', 'wi.occasion = o.id', 'left');
        $this->db->join('priorities p', 'wi.priority = p.id', 'left');
        $query = $this->db->get_where('wish_items wi', array('list_id' => $listId));
        return $query->result();
    }

    function getWishItem($id) {
        $this->db->select('wi.id, wi.title, wi.list_id, wi.occasion, wi.priority, wi.item_url, wi.price, 
        wi.quantity, o.name o_name, p.name p_name, p.priority p_level');
        $this->db->join('occasions o', 'wi.occasion = o.id', 'left');
        $this->db->join('priorities p', 'wi.priority = p.id', 'left');
        $query = $this->db->get_where('wish_items wi', array('id' => $id));
        return $query->row();
    }

    function saveWishItem($title, $listId, $occasionId, $priorityId, $itemUrl, $price, $quantity) {
        $newItem = array('title' => $title, 'list_id' => $listId, 'occasion' => $occasionId,
            'priority' => $priorityId, 'item_url' => $itemUrl, 'price' => $price, 'quantity' => $quantity);
        $this->db->insert('wish_items', $newItem);

        return $this->db->insert_id();
    }

    function updateWishItem($id, $title, $occasionId, $priorityId, $itemUrl, $price, $quantity) {
        $item = array('title' => $title, 'occasion' => $occasionId, 'priority' => $priorityId,
            'item_url' => $itemUrl, 'price' => $price, 'quantity' => $quantity);
        $this->db->update('wish_items', $item, array('id' => $id));
    }

    function deleteWishItem($id) {
        $this->db->delete('wish_items', array('id' => $id));
    }
}
