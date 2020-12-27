<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class WishItem extends \Restserver\Libraries\REST_Controller {

    public function wishItems_get() {
        $id = $this->get('id');

        if ($id === NULL) {
            $items = [];

            $userId = $this->session->user->id;
            $this->load->model('ListModel');
            $listId = $this->ListModel->getListIdBYUserId($userId);

            if (!empty($listId)) {
                $this->load->model('WishItemModel');
                $result = $this->WishItemModel->getWishList($listId->id);

                foreach ($result as $row) {
                    $item = ["id" => $row->id, "title" => $row->title, "listId" => $row->list_id,
                        "occasionId" => $row->occasion, "priorityId" => $row->priority,
                        "itemUrl" => $row->item_url, "price" => $row->price, "quantity" => $row->quantity];

                    array_push($items, $item);
                }
            }

            if (!empty($items)) {
                log_message('debug',print_r($items,TRUE));
                $this->response($items, \Restserver\Libraries\REST_Controller::HTTP_OK);

            } else {
                log_message('debug',print_r("No items found",TRUE));
                $this->response(['status' => FALSE, 'message' => 'No wish items were found'],
                    \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
            }

        } else {
            $id = (int) $id;

            if ($id <= 0) {
                log_message('debug',print_r("bad request",TRUE));
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
                $item->quantity = $result->quantity;

                log_message('debug',print_r($item,TRUE));
                $this->response($item, \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        }
    }

}