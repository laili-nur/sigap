<?php defined('BASEPATH') or exit('No direct script access allowed');

class Book_stock extends MY_Controller
{
    public $per_page = 10;

    public function __construct()
    {
        parent::__construct();
        $this->pages = "book_stock";
        $this->load->model('book_stock/book_stock_model', 'book_stock');
        $this->load->model('book/book_model', 'book');
    }

    public function index($page = NULL){
        //all filter
        $filters = [
            'keyword'           => $this->input->get('keyword', true),
            'published_year'    => $this->input->get('published_year', true),
            'warehouse_present' => $this->input->get('warehouse_present', true)
        ];
        //custom per page
        $this->book_stock->per_page = $this->input->get('per_page', true) ?? 10;
        $get_data = $this->book_stock->filter_book_stock($filters, $page);

        $book_stocks= $get_data['book_stocks'];
        $total = $get_data['total'];
        $pagination = $this->book_stock->make_pagination(site_url('book_stock'), 2, $total);
        $pages      = $this->pages;
        $main_view  = 'book_stock/index_bookstock';
        $this->load->view('template', compact('pages', 'main_view', 'book_stocks', 'pagination', 'total'));
    }


    public function view($book_stock_id){
        // $book_stock = $this->book_stock->join('book')->where('book.book_id', $book_id)->get();
        $book_stock = $this->book_stock->get_book_stock($book_stock_id);
        if (!$book_stock) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        $input = (object) $book_stock;
        // $get_stock      = $this->book_stock->fetch_stock_by_id($book_stock_id);
        // $stock_history  = $get_stock['stock_history'];
        // $stock_last     = $get_stock['stock_last'];

        $pages       = $this->pages;
        $main_view   = 'book_stock/view_bookstock';
        $this->load->view('template', compact('pages', 'main_view', 'input'));
        return;
    }

    public function edit($book_stock_id){
        if(!$this->_is_warehouse_admin()){
            redirect($this->pages);
        }

        $book_stock = $this->book_stock->get_book_stock($book_stock_id);
        // $input = (object) $book_stock;
        if(!$book_stock){
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        if(!$_POST){
            $input = (object) $book_stock;
        }
        else{
            $input = (object) $this->input->post(null, true);
            // catat orang yang menginput stok buku
            $input->user_id = $_SESSION['user_id'];
            
        }

        // if(!$this->book_stock->validate() || $this->form_validation->error_array()){
            $pages = $this->pages;
            $main_view = 'book_stock/edit_bookstock';
            $form_action = "book_stock/edit/$book_stock_id";
            $this->load->view('template', compact('pages','main_view', 'input'));   
        //     return; 
        // }
    }

    private function _is_warehouse_admin()
    {
        if ($this->level == 'superadmin' || $this->level == 'admin_gudang') {
            return true;
        } else {
            $this->session->set_flashdata('error', 'Hanya admin gudang dan superadmin yang dapat mengakses.');
            return false;
        }
    }
}
