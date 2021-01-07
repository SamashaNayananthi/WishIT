<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class User extends \Restserver\Libraries\REST_Controller {

    function __construct(){
        parent::__construct();

        $this->load->model('UserModel');
    }

    public function users_post(){
        $fname = $this->post('fname');
        $lname = $this->post('lname');
        $username = $this->post('username');
        $password = $this->post('password');

        $this->load->model('UserModel');

        $result = $this ->UserModel->registerUser(ucfirst($fname), ucfirst($lname), $username, $password);

        if ($result != 0) {
            $user = new stdClass();
            $user->id = $result;
            $user->fname = $fname;
            $user->lname = $lname;
            $user->username = $username;
            $this->set_response($user, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $this->set_response(NULL, \Restserver\Libraries\REST_Controller::HTTP_CONFLICT);
        }
    }

    public function users_get(){
        $username = $this->get('username');
        $user = new stdClass();

        if ($username == null) {
            if ($this->UserModel->isLoggedIn()) {
                $username = $this->session->user->username;
                $user = $this->session->user;
            }
        } else {
            $resultUser = $this ->UserModel->getUserByUsername($username);

            $user->id = $resultUser->id;
            $user->fname = $resultUser->first_name;
            $user->lname = $resultUser->last_name;
        }

        if ($username != null) {
            $this->response($user, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }

    }
}
