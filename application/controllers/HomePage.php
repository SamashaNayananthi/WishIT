<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomePage extends CI_Controller {

    public function index() {
        $this->load->view('homePage');
    }

    public function myCV(){
        $this->load->view('samashaCV');
    }

    public function login() {
        $this->load->view('login');
    }

    public function signUp() {
        $this->load->view('signUp');
    }

    public function wishList() {
        $this->load->model('UserModel');

        if (!$this->UserModel->isLoggedIn()) {
            $this->load->view('login');

        } else {
            $this->load->model('ItemOptionModel');
            $occasionList = $this->ItemOptionModel->getOccasions();
            $priorityList = $this->ItemOptionModel->getPriorities();

            $data = array("user" => $this->session->user, "occasionList" => $occasionList, "priorityList" => $priorityList);
            $this->load->view('wishList', $data);
        }

    }
}
