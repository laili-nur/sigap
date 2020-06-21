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

    public function add_book_request(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('book_id', 'Judul buku', 'required|max_length[10]');
        $this->form_validation->set_rules('order_number', 'Nomor Order', 'required|max_length[25]');
        $this->form_validation->set_rules('total', 'Jumlah Permintaan', 'required|max_length[10]');
        $this->form_validation->set_rules('notes', 'Catatan', 'required|max_length[250]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error',validation_errors());
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check  =   $this->Book_request_model->add_book_request();
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Berhasil menambahkan draft permintaan buku.');
                redirect('book_request');
            }else{
                $this->session->set_flashdata('error',print_r($this->db->error()));
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
    }

    public function edit_book_request($book_request_id){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('book_id', 'Judul buku', 'max_length[10]');
        $this->form_validation->set_rules('order_number', 'Nomor Order', 'max_length[25]');
        $this->form_validation->set_rules('total', 'Jumlah Permintaan', 'max_length[10]');
        $this->form_validation->set_rules('notes', 'Catatan', 'max_length[250]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error',validation_errors());
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check  =   $this->Book_request_model->edit_book_request($book_request_id);
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Berhasil mengubah data draft permintaan buku.');
                redirect('book_request/view_book_request_view/'.$book_request_id);
            }else{
                $this->session->set_flashdata('error',print_r($this->db->error()));
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
    }

    public function delete_book_request($book_request_id){
        $check  = $this->Book_request_model->delete_book_request($book_request_id);
        if($check   ==  TRUE){
            $this->session->set_flashdata('success','Berhasil menghapus data draft permintaan buku.');
            redirect('book_request');
        }else{
            $this->session->set_flashdata('error',print_r($this->db->error()));
            redirect('book_request');
        }
    }

    public function action_request($book_request_id){

    }

    public function action_final($book_request_id){
        
    }

    public function check_level_gudang_pemasaran(){
        if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang' || $_SESSION['level'] == 'admin_pemasaran'){
            return TRUE;
        }else{
            $this->session->set_flashdata('error','Hanya admin gudang dan superadmin yang dapat mengakses.');
            redirect(base_url());
        }
    }

    public function check_level_gudang(){
        if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang'){
            return TRUE;
        }else{
            $this->session->set_flashdata('error','Hanya admin gudang dan superadmin yang dapat mengakses.');
            redirect(base_url());
        }
    }
    
    public function check_level_pemasaran(){
        if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_pemasaran'){
            return TRUE;
        }else{
            $this->session->set_flashdata('error','Hanya admin pemasaran dan superadmin yang dapat mengakses.');
            redirect(base_url());
        }
    }

    public function ac_book_id(){
        $postData   =   $this->input->post();
        $data       =   $this->Book_request_model->fetch_book_id($postData);

        echo json_encode($data);
    }
}