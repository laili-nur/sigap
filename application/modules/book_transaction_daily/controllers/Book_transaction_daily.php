<?php defined('BASEPATH') or exit('No direct script access allowed');

class Book_transaction_daily extends MY_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->pages = "book_transaction_daily";
        $this->load->model('book_transaction_daily/book_transaction_daily_model', 'book_transaction_daily');
    }

    public function index($page = NULL){
        
        // if ($this->check_level() == TRUE):
        $pages      = $this->pages;
        $main_view  = 'book_transaction_daily/index_booktransactiondaily';
        $this->load->view('template', compact('pages', 'main_view'));
        // endif;
    }

}