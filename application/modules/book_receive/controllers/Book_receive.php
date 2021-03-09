<?php defined('BASEPATH') or exit('No direct script access allowed');

class Book_receive extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = "book_receive";
        $this->load->model('book_receive/book_receive_model', 'book_receive');
    }

    public function index($page = NULL){
        
        // if ($this->check_level() == TRUE):
        $pages      = $this->pages;
        $main_view  = 'book_receive/index_bookreceive';
        $this->load->view('template', compact('pages', 'main_view'));
        // endif;
    }

    public function view(){ 
        // if ($this->check_level() == TRUE):
        $pages      = $this->pages;
        $main_view  = 'book_receive/view/view_bookreceive';
        $this->load->view('template', compact('pages', 'main_view'));
        // endif;
    }

    public function add(){
        $pages = $this->pages;
        $main_view = 'book_receive/add_bookreceive';
        $this->load->view('template', compact('pages', 'main_view'));
    }
}
