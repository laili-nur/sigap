<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logistic_purchase extends MY_Controller{
    public function __construct() {
        parent::__construct();
        $this->pages = "logistic_purchase";
        $this->load->model('logistic_purchase/logistic_purchase_model', 'logistic_purchase');
    }

    public function index($page = NULL){
        
        // if ($this->check_level() == TRUE):
        $pages      = $this->pages;
        $main_view  = 'logistic_purchase/index_logisticpurchase';
        $this->load->view('template', compact('pages', 'main_view'));
        // endif;
    }

    public function add(){
        $pages = $this->pages;
        $main_view = 'logistic_purchase/add_logisticpurchase';
        $this->load->view('template', compact('pages','main_view'));
    }

    public function edit(){
        $pages = $this->pages;
        $main_view = 'logistic_purchase/edit_logisticpurchase';
        $this->load->view('template', compact('pages','main_view'));
    }

    public function view(){
        $pages = $this->pages;
        $main_view = 'logistic_purchase/view_logisticpurchase';
        $this->load->view('template', compact('pages','main_view'));
    }


}