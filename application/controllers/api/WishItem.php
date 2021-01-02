<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class WishItem extends \Restserver\Libraries\REST_Controller {

    public function wishItems_get() {
        $id = $this->get('id');

        if ($id === NULL) {
            $this->load->model('UserModel');
            $items = array();

            $listId = null;
            if ($this->UserModel->isLoggedIn()) {
                $userId = $this->session->user->id;

                $this->load->model('ListModel');
                $list = $this->ListModel->getListIdBYUserId($userId);
                $listId = $list->id;
            } else {
                $listId = $this->get('listId');
            }

            if (!empty($listId)) {
                $this->load->model('WishItemModel');
                $result = $this->WishItemModel->getWishList($listId);

                foreach ($result as $row) {
                    $item = array("id" => $row->id, "title" => $row->title, "listId" => $row->list_id,
                        "priorityId" => $row->priority, "itemUrl" => $row->item_url, "price" => $row->price,
                        "quantity" => $row->quantity, "priorityLvl" => $row->p_level, "priority" => $row->p_name);

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
                    "priorityId" => $result->priority, "itemUrl" => $result->item_url, "price" => $result->price,
                    "quantity" => $result->quantity, "priorityLvl" => $result->p_level, "priority" => $result->p_name);

                $this->response($item, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        }
    }

    public function wishItems_post() {
        $title = $this->post('title');
        $listId = $this->post('listId');
        $priorityId = $this->post('priorityId');
        $itemUrl = $this->post('itemUrl');
        $price = $this->post('price');
        $quantity = $this->post('quantity');

        $this->load->model('WishItemModel');
        $newItemId = $this ->WishItemModel->saveWishItem($title, $listId, $priorityId, $itemUrl, $price, $quantity);

        $this->load->model('PriorityModel');

        $priority = $this->PriorityModel->setPriority($priorityId);

        $newItem = array("id" => $newItemId, "title" => $title, "listId" => $listId, "priorityId" => $priorityId,
            "itemUrl" => $itemUrl, "price" => $price, "quantity" => $quantity, "priorityLvl" => $priority->priority,
            "priority" => $priority->name);

        $this->set_response($newItem, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
    }

    public function wishItems_put() {
        $id = $this->put('id');
        $title = $this->put('title');
        $priorityId = $this->put('priorityId');
        $itemUrl = $this->put('itemUrl');
        $price = $this->put('price');
        $quantity = $this->put('quantity');

        $this->load->model('WishItemModel');
        $this ->WishItemModel->updateWishItem($id, $title, $priorityId, $itemUrl, $price, $quantity);

        $this->load->model('PriorityModel');

        $priority = $this->PriorityModel->setPriority($priorityId);

        $item = array("id" => $id, "title" => $title, "priorityId" => $priorityId, "itemUrl" => $itemUrl,
            "price" => $price, "quantity" => $quantity, "priorityLvl" => $priority->priority,
            "priority" => $priority->name);

        $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

    public function wishItems_delete() {
        $id = (int) $this->get('id');

        if ($id <= 0) {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
        }

        log_message('debug',print_r($id,TRUE));
        $this->load->model('WishItemModel');
        $this ->WishItemModel->deleteWishItem($id);

        $message = array('id' => $id, 'message' => 'Deleted the resource');

        $this->set_response($message, \Restserver\Libraries\REST_Controller::HTTP_NO_CONTENT);
    }

}