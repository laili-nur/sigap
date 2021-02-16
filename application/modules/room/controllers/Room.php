<?php defined('BASEPATH') or exit('No direct script access allowed');

class Room extends MY_Controller{
    public function __construct() {
        parent::__construct();
        $this->pages = "room";
        $this->load->model('room/room_model', 'room');
    }

    public function index($page = NULL){
        $pages      = $this->pages;
        $main_view  = 'room/index_room';
        $this->load->view('template', compact('pages', 'main_view'));
    }

}