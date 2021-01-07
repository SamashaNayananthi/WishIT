<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class WishItem extends \Restserver\Libraries\REST_Controller {

    function __construct(){
        parent::__construct();

        $this->load->model('UserModel');
        $this->load->model('ListModel');
        $this->load->model('WishItemModel');
        $this->load->model('PriorityModel');
    }

    public function wishItems_get() {
        $id = $this->get('id');

        if ($id === NULL) {
            $items = array();

            $listId = $this->get('listId');
            if ($listId == null) {
                if ($this->UserModel->isLoggedIn()) {
                    $userId = $this->session->user->id;

                    $list = $this->ListModel->getListIdBYUserId($userId);
                    $listId = $list->id;
                }
            }

            if (!empty($listId)) {
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
                $result = $this->WishItemModel->getWishItem($id);

                $item = array("id" => $result->id, "title" => $result->title, "listId" => $result->list_id,
                    "priorityId" => $result->priority, "itemUrl" => $result->item_url, "price" => $result->price,
                    "quantity" => $result->quantity, "priorityLvl" => $result->p_level, "priority" => $result->p_name);

                $this->response($item, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        }
    }

    public function wishItems_post() {
        if ($this->UserModel->isLoggedIn()) {
            $title = $this->post('title');
            $listId = $this->post('listId');
            $priorityId = $this->post('priorityId');
            $itemUrl = $this->post('itemUrl');
            $price = $this->post('price');
            $quantity = $this->post('quantity');

            $newItemId = $this ->WishItemModel->saveWishItem($title, $listId, $priorityId, $itemUrl, $price, $quantity);

            $priority = $this->PriorityModel->setPriority($priorityId);

            $newItem = array("id" => $newItemId, "title" => $title, "listId" => $listId, "priorityId" => $priorityId,
                "itemUrl" => $itemUrl, "price" => $price, "quantity" => $quantity, "priorityLvl" => $priority->priority,
                "priority" => $priority->name);

            $this->set_response($newItem, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function wishItems_put() {
        if ($this->UserModel->isLoggedIn()) {
            $id = $this->put('id');
            $title = $this->put('title');
            $priorityId = $this->put('priorityId');
            $itemUrl = $this->put('itemUrl');
            $price = $this->put('price');
            $quantity = $this->put('quantity');

            $this ->WishItemModel->updateWishItem($id, $title, $priorityId, $itemUrl, $price, $quantity);

            $priority = $this->PriorityModel->setPriority($priorityId);

            $item = array("id" => $id, "title" => $title, "priorityId" => $priorityId, "itemUrl" => $itemUrl,
                "price" => $price, "quantity" => $quantity, "priorityLvl" => $priority->priority,
                "priority" => $priority->name);

            $this->set_response($item, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function wishItems_delete() {
        if ($this->UserModel->isLoggedIn()) {
            $id = (int) $this->get('id');

            if ($id <= 0) {
                $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
            }

            $this ->WishItemModel->deleteWishItem($id);

            $message = array('id' => $id, 'message' => 'Deleted the resource');

            $this->set_response($message, \Restserver\Libraries\REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }

    }

}