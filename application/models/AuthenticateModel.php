<?php

class AuthenticateModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function authenticate($username, $password){
        $query = $this->db->get_where('users', array('username' => $username));

        if ($query->num_rows() != 1) {
            return false;
        } else {
            $row = $query->row();

            $hashPassword = $row->password;

            if (password_verify($password, $hashPassword)) {
                $user = new stdClass();
                $user->fname = $row->first_name;
                $user->lname = $row->last_name;
                $user->username = $row->username;

                $this->session->set_userdata('user', $user);
                return true;

            } else {
                return false;
            }
        }

    }

    public function logout(){
        $this->session->unset_userdata('user');
        $this->session->sess_destroy();
    }

}
