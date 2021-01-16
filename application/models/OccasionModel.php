<?php

class OccasionModel extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    function getOccasions() {
        $query = $this->db->get('wi_occasions');
        return $query->result();
    }

    function setOccasionName($id) {
        $occasionName = '';
        $occasionList = $this->getOccasions();

        foreach ($occasionList as $occasion) {
            if ($occasion->id == $id) {
                $occasionName = $occasion->name;
            }
        }
        return $occasionName;
    }

}
