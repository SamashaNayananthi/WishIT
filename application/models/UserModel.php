<?php

class UserModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function registerUser($fname, $lname, $username, $password) {
        $query = $this->db->get_where('users', array('username' => $username));

        if ($query->num_rows() != 0) {
            return false;
        } else {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $data = array('first_name' => $fname, 'last_name' => $lname, 'username' => $username,
                'password' => $hashPassword);

            $this->db->insert('users', $data);

            return true;
        }
    }

    function isLoggedIn() {
        if (isset($this->session->user)) {
            return true;

        } else {
            return false;
        }
    }

    function getUserByUsername($username) {
        $query = $this->db->get_where('users', array('username' => $username));
        return $query->row();
    }

}
