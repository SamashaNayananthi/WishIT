<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class WishItem extends \Restserver\Libraries\REST_Controller {

    public function wishItems_get() {
        $id = $this->get('id');

        if ($id === NULL) {
            $items = array();

            $userId = $this->session->user->id;
            $this->load->model('ListModel');
            $listId = $this->ListModel->getListIdBYUserId($userId);

            if (!empty($listId)) {
                $this->load->model('WishItemModel');
                $result = $this->WishItemModel->getWishList($listId->id);

                foreach ($result as $row) {
                    $item = array("id" => $row->id, "title" => $row->title, "listId" => $row->list_id,
                        "occasionId" => $row->occasion, "priorityId" => $row->priority, "itemUrl" => $row->item_url,
                        "price" => $row->price, "quantity" => $row->quantity, "priorityLvl" => $row->priority);

                    array_push($items, $item);
                }
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

                $item = array("id" => $result->id, "title" => $result->title, "listId" => $result->list_id,
                    "occasionId" => $result->occasion, "priorityId" => $result->priority, "itemUrl" => $result->item_url,
                    "price" => $result->price, "quantity" => $result->quantity, "priorityLvl" => $result->priority);

                $this->response($item, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        }
    }

}