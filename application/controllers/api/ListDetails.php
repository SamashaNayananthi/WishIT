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
                $list->userId = $result->userId;

                $this->response($list, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        }
    }

}
