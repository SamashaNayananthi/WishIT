<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class ListDetails extends \Restserver\Libraries\REST_Controller {

    public function list_get() {
        $this->load->model('UserModel');

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
                $this->load->model('ListModel');
                $result = $this ->ListModel->getListDetails($userId);

                $list = new stdClass();
                $list->id = $result->id;
                $list->name = $result->name;
                $list->description = $result->description;
                $list->occasionId = $result->occasion_id;
                $list->occasion = $result->occasion;
                $list->userId = $result->user_id;
                //log_message('debug',print_r($list,TRUE));

                $this->response($list, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        }
    }

    public function list_post() {
        $this->load->model('UserModel');

        if ($this->UserModel->isLoggedIn()) {
            $name = $this->post('name');
            $description = $this->post('description');
            $occasionId = $this->post('occasionId');
            $userId = $this->post('userId');

            $this->load->model('ListModel');
            $listId = $this ->ListModel->saveList($name, $description, $occasionId, $userId);

            $this->load->model('OccasionModel');

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
        $this->load->model('UserModel');

        if ($this->UserModel->isLoggedIn()) {
            $id = $this->put('id');
            $name = $this->put('name');
            $description = $this->put('description');
            $occasionId = $this->put('occasionId');
            $userId = $this->put('userId');

            $this->load->model('ListModel');
            $this ->ListModel->updateList($id, $name, $description, $occasionId);

            $this->load->model('OccasionModel');

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
        $this->load->model('UserModel');

        if ($this->UserModel->isLoggedIn()) {
            $username = $this->session->user->username;
            $link = base_url()."WishList/sharedList/".$username;

            $this->set_response($link, \Restserver\Libraries\REST_Controller::HTTP_OK);

        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

}
