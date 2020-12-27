<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class ListDetails extends \Restserver\Libraries\REST_Controller {

    public function list_get() {
        $userId = $this->session->user->id;

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
                $list->userId = $result->user_id;
                //log_message('debug',print_r($list,TRUE));

                $this->response($list, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        }
    }

    public function list_post() {
        $name = $this->post('name');
        $description = $this->post('description');
        $userId = $this->post('userId');

        $this->load->model('ListModel');
        $listId = $this ->ListModel->insertList($name, $description, $userId);

        $list = new stdClass();
        $list->id = $listId;
        $list->name = $name;
        $list->description = $description;
        $list->userId = $userId;

        $this->set_response($list, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
    }

    public function list_put() {
        $id = $this->put('id');
        $name = $this->put('name');
        $description = $this->put('description');
        $userId = $this->put('userId');

        $this->load->model('ListModel');
        $this ->ListModel->updateList($id, $name, $description);

        $list = new stdClass();
        $list->id = $id;
        $list->name = $name;
        $list->description = $description;
        $list->userId = $userId;

        $this->set_response($list, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

}
