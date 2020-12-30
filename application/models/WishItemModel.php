<?php

class WishItemModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function getWishList($listId) {
        $this->db->select('wi.id, wi.title, wi.list_id, wi.priority, wi.item_url, wi.price, 
        wi.quantity, p.name p_name, p.priority p_level');
        $this->db->join('priorities p', 'wi.priority = p.id', 'left');
        $this->db->order_by("p.priority", "asc");
        $query = $this->db->get_where('wish_items wi', array('list_id' => $listId));
        return $query->result();
    }

    function getWishItem($id) {
        $this->db->select('wi.id, wi.title, wi.list_id, wi.priority, wi.item_url, wi.price, 
        wi.quantity, p.name p_name, p.priority p_level');
        $this->db->join('priorities p', 'wi.priority = p.id', 'left');
        $query = $this->db->get_where('wish_items wi', array('id' => $id));
        return $query->row();
    }

    function saveWishItem($title, $listId, $priorityId, $itemUrl, $price, $quantity) {
        $newItem = array('title' => $title, 'list_id' => $listId, 'priority' => $priorityId,
            'item_url' => $itemUrl, 'price' => $price, 'quantity' => $quantity);
        $this->db->insert('wish_items', $newItem);

        return $this->db->insert_id();
    }

    function updateWishItem($id, $title, $priorityId, $itemUrl, $price, $quantity) {
        $item = array('title' => $title, 'priority' => $priorityId, 'item_url' => $itemUrl,
            'price' => $price, 'quantity' => $quantity);
        $this->db->update('wish_items', $item, array('id' => $id));
    }

    function deleteWishItem($id) {
        $this->db->delete('wish_items', array('id' => $id));
    }
}
