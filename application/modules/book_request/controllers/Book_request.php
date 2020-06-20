<?php defined('BASEPATH') or exit('No direct script access allowed');

class Book_request extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'Book_request';
        $this->load->model('book_request/Book_request_model');
    }

    public function index(){

    }

    public function view_book_request_add(){
        $pages       = $this->pages;
        $main_view   = 'book_request/book_request_add';
        $this->load->view('template', compact('pages', 'main_view'));
    }

    public function view_book_request_edit($book_request_id){
        $pages       = $this->pages;
        $main_view   = 'book_request/book_request_edit';
        $rData       = $this->Book_request_model->fetch_book_request_id($book_request_id);
        $this->load->view('template', compact('pages', 'main_view', 'rData'));
    }

    public function view_book_request_view($book_request_id){
        $pages       = $this->pages;
        $main_view   = 'book_request/book_request_add';
        $rData       = $this->Book_request_model->fetch_book_request_id($book_request_id);
        $this->load->view('template', compact('pages', 'main_view', 'rData'));
    }
}