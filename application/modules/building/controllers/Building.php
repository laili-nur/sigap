<?php defined('BASEPATH') or exit('No direct script access allowed');

class Building extends MY_Controller{
    public function __construct() {
        parent::__construct();
        $this->pages = "building";
        $this->load->model('building/building_model', 'building');
    }

    public function index($page = NULL){
        $pages      = $this->pages;
        $main_view  = 'building/index_building';
        $this->load->view('template', compact('pages', 'main_view'));
    }
}