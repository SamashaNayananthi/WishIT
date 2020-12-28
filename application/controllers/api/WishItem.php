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

                $this->load->model('ItemOptionModel');

                foreach ($result as $row) {
                    $item = array("id" => $row->id, "title" => $row->title, "listId" => $row->list_id,
                        "occasionId" => $row->occasion, "priorityId" => $row->priority, "itemUrl" => $row->item_url,
                        "price" => $row->price, "quantity" => $row->quantity,
                        "priorityLvl" => $this->ItemOptionModel->setPriorityLvl($row->priority));

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

                $this->load->model('ItemOptionModel');

                $item = array("id" => $result->id, "title" => $result->title, "listId" => $result->list_id,
                    "occasionId" => $result->occasion, "priorityId" => $result->priority, "itemUrl" => $result->item_url,
                    "price" => $result->price, "quantity" => $result->quantity,
                    "priorityLvl" => $this->ItemOptionModel->setPriorityLvl($result->priority));

                $this->response($item, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        }
    }

    public function wishItems_post() {
        $title = $this->post('title');
        $listId = $this->post('listId');
        $occasionId = $this->post('occasionId');
        $priorityId = $this->post('priorityId');
        $itemUrl = $this->post('itemUrl');
        $price = $this->post('price');
        $quantity = $this->post('quantity');

        $this->load->model('WishItemModel');
        $newItemId = $this ->WishItemModel->saveWishItem($title, $listId, $occasionId,
            $priorityId, $itemUrl, $price, $quantity);

        $this->load->model('ItemOptionModel');

        $newItem = array("id" => $newItemId, "title" => $title, "listId" => $listId, "occasionId" => $occasionId,
            "priorityId" => $priorityId, "itemUrl" => $itemUrl, "price" => $price, "quantity" => $quantity,
            "priorityLvl" => $this->ItemOptionModel->setPriorityLvl($priorityId));

        $this->set_response($newItem, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
    }

}