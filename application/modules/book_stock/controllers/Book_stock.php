<?php defined('BASEPATH') or exit('No direct script access allowed');

class Book_stock extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = "book_stock";
        $this->load->model('book_stock/book_stock_model', 'book_stock');
    }

    public function index($page = NULL){
        
        // if ($this->check_level() == TRUE):
        $pages      = $this->pages;
        $main_view  = 'book_stock/index_bookstock';
        $this->load->view('template', compact('pages', 'main_view'));
        // endif;
    }

    public function edit(){
        $pages = $this->pages;
        $main_view = 'book_stock/edit_bookstock';
        $this->load->view('template', compact('pages','main_view'));
    }
}
