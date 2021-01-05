<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class ListDetails extends \Restserver\Libraries\REST_Controller {

    function __construct(){
        parent::__construct();

        $this->load->model('UserModel');
        $this->load->model('ListModel');
        $this->load->model('OccasionModel');
    }

    public function list_get() {
        $userId = null;
        if ($this->UserModel->isLoggedIn()) {
            $userId = $this->session->user->id;
        } else {
            $userId = $this->get('userId');
        }

        if ($userId === NULL) {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            if ($userId <= 0) {
                $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $result = $this ->ListModel->getListDetails($userId);

                $list = new stdClass();
                $list->id = $result->id;
                $list->name = $result->name;
                $list->description = $result->description;
                $list->occasionId = $result->occasion_id;
                $list->occasion = $result->occasion;
                $list->userId = $result->user_id;

                $this->response($list, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        }
    }

    public function list_post() {
        if ($this->UserModel->isLoggedIn()) {
            $name = $this->post('name');
            $description = $this->post('description');
            $occasionId = $this->post('occasionId');
            $userId = $this->post('userId');

            $listId = $this ->ListModel->saveList($name, $description, $occasionId, $userId);

            $list = new stdClass();
            $list->id = $listId;
            $list->name = $name;
            $list->description = $description;
            $list->occasionId = $occasionId;
            $list->occasion = $this->OccasionModel->setOccasionName($occasionId);
            $list->userId = $userId;

            $this->set_response($list, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function list_put() {
        if ($this->UserModel->isLoggedIn()) {
            $id = $this->put('id');
            $name = $this->put('name');
            $description = $this->put('description');
            $occasionId = $this->put('occasionId');
            $userId = $this->put('userId');

            $this ->ListModel->updateList($id, $name, $description, $occasionId);

            $list = new stdClass();
            $list->id = $id;
            $list->name = $name;
            $list->description = $description;
            $list->occasionId = $occasionId;
            $list->occasion = $this->OccasionModel->setOccasionName($occasionId);
            $list->userId = $userId;

            $this->set_response($list, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }

    }

    public function shareableLink_get() {
        if ($this->UserModel->isLoggedIn()) {
            $username = $this->session->user->username;
            $link = base_url()."WishList/sharedList/".$username;

            $this->set_response($link, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

}
