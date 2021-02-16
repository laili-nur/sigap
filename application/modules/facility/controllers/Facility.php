<?php defined('BASEPATH') or exit('No direct script access allowed');

class Facility extends MY_Controller{
    public function __construct() {
        parent::__construct();
        $this->pages = "facility";
        $this->load->model('facility/facility_model', 'facility');
    }

    public function index($page = NULL){
        $pages      = $this->pages;
        $main_view  = 'facility/index_facility';
        $this->load->view('template', compact('pages', 'main_view'));
    }

}