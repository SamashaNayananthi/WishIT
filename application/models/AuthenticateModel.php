<?php

class AuthenticateModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function authenticate($username, $password){
        $query = $this->db->get_where('users', array('username' => $username));

        if ($query->num_rows() != 1) {
            return -1;
        } else {
            $row = $query->row();

            $hashPassword = $row->password;

            if (password_verify($password, $hashPassword)) {
                $user = new stdClass();
                $user->id = $row->id;
                $user->fname = $row->first_name;
                $user->lname = $row->last_name;
                $user->username = $row->username;

                $this->session->set_userdata('user', $user);
                return 1;

            } else {
                return 0;
            }
        }

    }

    public function logout(){
        $this->session->unset_userdata('user');
        $this->session->sess_destroy();
    }

}
