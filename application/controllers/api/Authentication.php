<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Authentication extends \Restserver\Libraries\REST_Controller {

    function __construct(){
        parent::__construct();
    }

    public function authenticate_post(){
        $username = $this->post('username');
        $password = $this->post('password');

        $this->load->model('AuthenticateModel');

        $result = $this ->AuthenticateModel->authenticate($username, $password);

        if ($result == 1) {
            $authenticated = new stdClass();
            $authenticated->username = $username;
            $this->set_response($authenticated, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->set_response(NULL, \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function logout_get(){
        $this->load->model('AuthenticateModel');

        $this ->AuthenticateModel->logout();

        $this->set_response(NULL, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

}
