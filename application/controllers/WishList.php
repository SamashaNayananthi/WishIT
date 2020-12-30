<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WishList extends CI_Controller {

    public function sharedList() {
        $username = $this->uri->segment(3);

        $this->load->model('UserModel');
        $resultUser = $this ->UserModel->getUserByUsername($username);
        $user = new stdClass();
        $user->fName = $resultUser->first_name;
        $user->lName = $resultUser->last_name;

        $this->load->model('ListModel');
        $resultList = $this ->ListModel->getListDetails($resultUser->id);
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

        $data = array("user" => $user, "list" => $list, "items" => $listItems);

        $this->load->view('sharedWishList', $data);
    }

}
