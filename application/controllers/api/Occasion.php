<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Occasion extends \Restserver\Libraries\REST_Controller {

    public function occasion_get() {
        $this->load->model('OccasionModel');
        $occasionList = $this->OccasionModel->getOccasions();
        $this->response($occasionList, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

}