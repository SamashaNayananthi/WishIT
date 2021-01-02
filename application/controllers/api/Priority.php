<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Priority extends \Restserver\Libraries\REST_Controller {

    public function priority_get() {
        $this->load->model('PriorityModel');
        $priorityList = $this->PriorityModel->getPriorities();
        $this->response($priorityList, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

}