<?php defined('BASEPATH') or exit('No direct script access allowed');

class Book_request extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'book_request';
        $this->load->model('book_request/Book_request_model');
    }

    public function index(){

    }

    public function view_book_request_add(){
        if($this->check_level_gudang_pemasaran() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'book_request/book_request_add';
        $this->load->view('template', compact('pages', 'main_view'));
        endif;
    }

    public function view_book_request_edit($book_request_id){
        if($this->check_level_gudang() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'book_request/book_request_edit';
        $rData       = $this->Book_request_model->fetch_book_request_id($book_request_id);
        if(empty($rData) == FALSE):
        $this->load->view('template', compact('pages', 'main_view', 'rData'));
        else:
        $this->session->set_flashdata('error','Halaman tidak ditemukan.');
        redirect(base_url(), 'refresh');
        endif;
        endif;
    }

    public function view_book_request_view($book_request_id){
        if($this->check_level_gudang_pemasaran() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'book_request/book_request_view';
        $rData       = $this->Book_request_model->fetch_book_request_id($book_request_id);
        if(empty($rData) == FALSE):
        $stock       = $this->Book_request_model->fetch_book_stock_id($rData->book_id);
        $this->load->view('template', compact('pages', 'main_view', 'rData', 'stock'));
        else:
        $this->session->set_flashdata('error','Halaman tidak ditemukan.');
        redirect(base_url(), 'refresh');
        endif;
        endif;
    }

    public function add_book_request(){
        if($this->check_level_gudang_pemasaran() == TRUE):
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
        endif;
    }

    public function edit_book_request($book_request_id){
        if($this->check_level_gudang() == TRUE):
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
        endif;
    }

    public function delete_book_request($book_request_id){
        if($this->check_level_gudang() == TRUE):
        $check  = $this->Book_request_model->delete_book_request($book_request_id);
        if($check   ==  TRUE){
            $this->session->set_flashdata('success','Berhasil menghapus data draft permintaan buku.');
            redirect('book_request');
        }else{
            $this->session->set_flashdata('error',print_r($this->db->error()));
            redirect('book_request');
        }
        endif;
    }

    public function action_request($book_request_id){
        if($this->check_level_gudang() == TRUE):
        $this->load->library('form_validation');
        $this->form_validation->set_rules('flag', 'Aksi', 'required|max_length[1]');
        $this->form_validation->set_rules('request_notes_admin', 'Catatan', 'required|max_length[1000]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error',validation_errors());
            redirect($_SERVER['HTTP_REFERER'].'#section_request', 'refresh');
        }else{
            $check  =   $this->Book_request_model->action_request($book_request_id);
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Berhasil melakukan aksi pada progress permintaan.');
                redirect($_SERVER['HTTP_REFERER'].'#section_request', 'refresh');
            }else{
                $this->session->set_flashdata('error',print_r($this->db->error()));
                redirect($_SERVER['HTTP_REFERER'].'#section_request', 'refresh');
            }
        }
        endif;
    }

    public function action_final($book_request_id){
        if($this->check_level_gudang() == TRUE):
        $this->load->library('form_validation');
        $this->form_validation->set_rules('stock_in_warehouse', 'Stok dalam gudang', 'required|max_length[10]');
        $this->form_validation->set_rules('stock_out_warehouse', 'Stok luar gudang', 'required|max_length[10]');
        $this->form_validation->set_rules('stock_marketing', 'Stok pemasaran', 'required|max_length[10]');
        $this->form_validation->set_rules('stock_input_notes', 'Catatan', 'required|max_length[256]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error',validation_errors());
            redirect($_SERVER['HTTP_REFERER'].'#section_final', 'refresh');
        }else{
            $check  =   $this->Book_request_model->action_final($book_request_id);
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Permintaan buku berhasil di finalisasi.');
                redirect($_SERVER['HTTP_REFERER'].'#section_final', 'refresh');
            }else{
                $this->session->set_flashdata('error',print_r($this->db->error()));
                redirect($_SERVER['HTTP_REFERER'].'#section_final', 'refresh');
            }
        }
        endif;
    }

    public function check_level_gudang_pemasaran(){
        if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang' || $_SESSION['level'] == 'admin_pemasaran'){
            return TRUE;
        }else{
            $this->session->set_flashdata('error','Hanya admin gudang, admin pemasaran, dan superadmin yang dapat mengakses.');
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