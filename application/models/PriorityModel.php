<?php

class PriorityModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function getPriorities() {
        $this->db->order_by('priority', 'asc');
        $query = $this->db->get('priorities');
        return $query->result();
    }

    function setPriority($id) {
        $priorityObj = 0;
        $priorityList = $this->getPriorities();

        foreach ($priorityList as $priority) {
            if ($priority->id == $id) {
                $priorityObj = $priority;
            }
        }
        return $priorityObj;
    }

}
