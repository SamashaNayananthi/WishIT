<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WishList extends CI_Controller {

    public function myWishList() {
        $this->load->model('UserModel');

        if (!$this->UserModel->isLoggedIn()) {
            $this->load->view('login');

        } else {
            $this->load->view('wishList');
        }

    }

    public function sharedList() {

        $this->load->model('ListModel');
        $resultList = $this ->ListModel->getListDetails(5);
        $list = new stdClass();
        $list->name = $resultList->name;
        $list->desc = $resultList->description;
        $list->occasion = $resultList->occasion;

        $this->load->model('WishItemModel');
        $resultItems = $this->WishItemModel->getWishList($resultList->id);
        $listItems = array();

        foreach ($resultItems as $row) {
            $item = new stdClass();
            $item->title = $row->title;
            $item->itemUrl = $row->item_url;
            $item->price = $row->price;
            $item->quantity = $row->quantity;
            $item->priorityLvl = $row->p_level;
            $item->priority = $row->p_name;

            array_push($listItems, $item);
        }

        $data = array("list" => $list, "items" => $listItems);

        $this->load->view('sharedWishList', $data);
    }

}
