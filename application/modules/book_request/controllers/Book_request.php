<?php defined('BASEPATH') or exit('No direct script access allowed');

class Book_request extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'book_request';
        $this->load->model('book_request_model', 'book_request');
    }

    public function index($page = NULL){
        if($this->check_level_gudang_pemasaran() == TRUE):
        // all filter
        $filters = [
            'keyword'           => $this->input->get('keyword', true),
            'status'            => $this->input->get('status', true)
        ];

        // custom per page
        $this->book_request->per_page = $this->input->get('per_page', true) ?? 10;

        $get_data = $this->book_request->filter_book_request($filters, $page);

        $book_request   = $get_data['book_request'];
        $total          = $get_data['total'];
        $pagination     = $this->book_request->make_pagination(site_url('book_request'), 2, $total);
        $pages          = $this->pages;
        $main_view      = 'book_request/index_book_request';
        $this->load->view('template', compact('pages', 'main_view', 'book_request', 'pagination', 'total'));
        endif;
    }

    public function add(){
        if($this->check_level_gudang_pemasaran() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'book_request/book_request_add';
        $this->load->view('template', compact('pages', 'main_view'));
        endif;
    }

    public function edit($book_request_id){
        if($this->check_level_gudang() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'book_request/book_request_edit';
        $rData       = $this->book_request->fetch_book_request_id($book_request_id);
        if(empty($rData) == FALSE):
        $this->load->view('template', compact('pages', 'main_view', 'rData'));
        else:
        $this->session->set_flashdata('error','Halaman tidak ditemukan.');
        redirect(base_url(), 'refresh');
        endif;
        endif;
    }

    public function view($book_request_id){
        if($this->check_level_gudang_pemasaran() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'book_request/book_request_view';
        $rData       = $this->book_request->fetch_book_request_id($book_request_id);
        if(empty($rData) == FALSE):
        $stock       = $this->book_request->fetch_book_stock_id($rData->book_id);
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
            $check  =   $this->book_request->add_book_request();
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Berhasil menambahkan draft permintaan buku.');
                redirect('book_request');
            }else{
                $this->session->set_flashdata('error','Gagal menambahkan draft permintaan buku.');
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
            $this->session->set_flashdata('error','Gagal mengubah data draft permintaan buku.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check  =   $this->book_request->edit_book_request($book_request_id);
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Berhasil mengubah data draft permintaan buku.');
                redirect('book_request/view/'.$book_request_id);
            }else{
                $this->session->set_flashdata('error','Gagal mengubah data draft permintaan buku.');
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
        endif;
    }

    public function delete_book_request($book_request_id){
        if($this->check_level_gudang() == TRUE):
        $check  = $this->book_request->delete_book_request($book_request_id);
        if($check   ==  TRUE){
            $this->session->set_flashdata('success','Berhasil menghapus data draft permintaan buku.');
            redirect('book_request');
        }else{
            $this->session->set_flashdata('error','Gagal menghapus data draft permintaan buku.');
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
            $this->session->set_flashdata('error','Gagal melakukan aksi pada progress permintaan.');
            redirect($_SERVER['HTTP_REFERER'].'#section_request', 'refresh');
        }else{
            $check  =   $this->book_request->action_request($book_request_id);
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Berhasil melakukan aksi pada progress permintaan.');
                redirect($_SERVER['HTTP_REFERER'].'#section_request', 'refresh');
            }else{
                $this->session->set_flashdata('error','Gagal melakukan aksi pada progress permintaan.');
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
            $this->session->set_flashdata('error','Permintaan buku gagal di finalisasi.');
            redirect($_SERVER['HTTP_REFERER'].'#section_final', 'refresh');
        }else{
            $check  =   $this->book_request->action_final($book_request_id);
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Permintaan buku berhasil di finalisasi.');
                redirect($_SERVER['HTTP_REFERER'].'#section_final', 'refresh');
            }else{
                $this->session->set_flashdata('error','Permintaan buku gagal di finalisasi.');
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
        $data       =   $this->book_request->fetch_book_id($postData);

        echo json_encode($data);
    }
}