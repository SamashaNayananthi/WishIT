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
        $password = $this->post('psw');

        $this->load->model('UserModel');

        $result = $this ->UserModel->registerUser($fname, $lname, $username, $password);

        if ($result) {
            $this->set_response(NULL, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $this->set_response(NULL, \Restserver\Libraries\REST_Controller::HTTP_CONFLICT);
        }
    }

}
