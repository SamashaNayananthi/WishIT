<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class WishItem extends \Restserver\Libraries\REST_Controller {

    public function wishItems_get() {
        $id = $this->get('id');

        if ($id === NULL) {
            $userId = $this->session->user->id;
            $this->load->model('ListModel');
            $listId = $this->ListModel->getListIdBYUserId($userId);
            log_message('debug', print_r($listId, TRUE));

            $this->load->model('WishItemModel');
            $result = $this->WishItemModel->getWishList($listId);
            $items = array();

            foreach ($result as $row) {
                $item = new stdClass();
                $item->id = $row->id;
                $item->title = $row->title;
                $item->listId = $row->list_id;
                $item->occasionId = $row->occasion;
                $item->priorityId = $row->priority;
                $item->itemUrl = $row->item_url;
                $item->price = $row->price;

                array_push($items, $item);
            }

            if (!empty($items)) {
                $this->response($items, \Restserver\Libraries\REST_Controller::HTTP_OK);

            } else {
                $this->response(['status' => FALSE, 'message' => 'No wish items were found'],
                    \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
            }

        } else {
            $id = (int) $id;

            if ($id <= 0) {
                $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);

            } else {
                $this->load->model('WishItemModel');
                $result = $this->WishItemModel->getWishItem($id);

                $item = new stdClass();
                $item->id = $result->id;
                $item->title = $result->title;
                $item->listId = $result->list_id;
                $item->occasionId = $result->occasion;
                $item->priorityId = $result->priority;
                $item->itemUrl = $result->item_url;
                $item->price = $result->price;

                $this->response($item, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        }
    }

}