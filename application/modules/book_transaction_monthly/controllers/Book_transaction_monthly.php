<?php defined('BASEPATH') or exit('No direct script access allowed');

class Book_transaction_monthly extends MY_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->pages = "book_transaction_monthly";
        $this->load->model('book_transaction_monthly/book_transaction_monthly_model', 'book_transaction_monthly');
    }

    public function index($page = NULL){
        
        // if ($this->check_level() == TRUE):
        $pages      = $this->pages;
        $main_view  = 'book_transaction_monthly/index_booktransactionmonthly';
        $this->load->view('template', compact('pages', 'main_view'));
        // endif;
    }
}