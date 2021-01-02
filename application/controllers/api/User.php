<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class User extends \Restserver\Libraries\REST_Controller {

    function __construct(){
        parent::__construct();
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

        if ($username == NULL) {
            $user = $this->session->user;
            $this->response($user, \Restserver\Libraries\REST_Controller::HTTP_OK);

        } else {
            $this->load->model('UserModel');
            $resultUser = $this ->UserModel->getUserByUsername($username);

            $user = new stdClass();
            $user->id = $resultUser->id;
            $user->fName = $resultUser->first_name;
            $user->lName = $resultUser->last_name;

            $this->response($user, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }
}
