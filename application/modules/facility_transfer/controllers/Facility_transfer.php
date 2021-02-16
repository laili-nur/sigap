<?php defined('BASEPATH') or exit('No direct script access allowed');

class Facility_transfer extends MY_Controller{
    public function __construct() {
        parent::__construct();
        $this->pages = "facility_transfer";
        $this->load->model('facility_transfer/facility_transfer_model', 'facility_transfer');
    }

    public function index($page = NULL){
        $pages      = $this->pages;
        $main_view  = 'facility_transfer/index_facilitytransfer';
        $this->load->view('template', compact('pages', 'main_view'));
    }

    public function add(){
        $pages      = $this->pages;
        $main_view  = 'facility_transfer/add_facilitytransfer';
        $this->load->view('template', compact('pages', 'main_view'));
    }
}