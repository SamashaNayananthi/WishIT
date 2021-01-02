<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WishList extends CI_Controller {

    public function myWishList() {
        $this->load->model('UserModel');

        if (!$this->UserModel->isLoggedIn()) {
            $this->load->view('login');

        } else {
            $this->load->view('wishList');
        }

    }

    public function sharedList() {
        $this->load->view('sharedWishList');
    }

}
