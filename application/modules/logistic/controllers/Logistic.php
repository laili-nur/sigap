<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logistic extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'logistic';
        $this->load->model('logistic_model', 'logistic');
    }

    public function index($page = NULL){
        if($this->check_level() == TRUE):
        // all filter
        $filters = [
            'keyword'   => $this->input->get('keyword', true)
        ];

        // custom per page
        $this->logistic->per_page = $this->input->get('per_page', true) ?? 10;

        $get_data = $this->logistic->filter_logistic($filters, $page);

        $logistic   = $get_data['logistic'];
        $total      = $get_data['total'];
        $pagination = $this->logistic->make_pagination(site_url('logistic'), 2, $total);
        $pages      = $this->pages;
        $main_view  = 'logistic/index_logistic';
        $this->load->view('template', compact('pages', 'main_view', 'logistic', 'pagination', 'total'));
        endif;
    }

    public function add(){
        if($this->check_level_gudang() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'logistic/logistic_add';
        $this->load->view('template', compact('pages', 'main_view'));
        endif;
    }

    public function edit($logistic_id){
        if($this->check_level_gudang() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'logistic/logistic_edit';
        $lData       = $this->logistic->fetch_logistic_id($logistic_id);
        if(empty($lData) == FALSE):
        $this->load->view('template', compact('pages', 'main_view', 'lData'));
        else:
        $this->session->set_flashdata('error','Halaman tidak ditemukan.');
        redirect(base_url(), 'refresh');
        endif;
        endif;
    }

    public function view($logistic_id){
        if($this->check_level() == TRUE):
        $pages          = $this->pages;
        $main_view      = 'logistic/logistic_view';
        $lData          = $this->logistic->fetch_logistic_id($logistic_id);
        $get_stock      = $this->logistic->fetch_stock_by_id($logistic_id);
        $stock_history  = $get_stock['stock_history'];
        $stock_last     = $get_stock['stock_last'];
        if(empty($lData) == FALSE):
        $this->load->view('template', compact('pages', 'main_view', 'lData','stock_history','stock_last'));
        else:
        $this->session->set_flashdata('error','Halaman tidak ditemukan.');
        redirect(base_url(), 'refresh');
        endif;
        endif;
    }

    public function add_logistic(){
        if($this->check_level_gudang() == TRUE):
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Nama Logistik', 'required|max_length[250]');
        $this->form_validation->set_rules('type', 'Tipe Logistik', 'required|max_length[25]');
        $this->form_validation->set_rules('category', 'Kategori Logistik', 'required|max_length[25]');
        $this->form_validation->set_rules('notes', 'Catatan', 'max_length[1000]');
        $this->form_validation->set_rules('stock_warehouse', 'Stok Gudang', 'max_length[10]');
        $this->form_validation->set_rules('stock_production', 'Stok Produksi', 'max_length[10]');
        $this->form_validation->set_rules('stock_other', 'Stok Lainnya', 'max_length[10]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','Logistik gagal ditambah.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check = $this->logistic->add_logistic();
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Logistik berhasil ditambah.');
                redirect('logistic');
            }else{
                $this->session->set_flashdata('error','Logistik gagal ditambah.');
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
        endif;
    }

    public function edit_logistic($logistic_id){
        if($this->check_level_gudang() == TRUE):
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Nama Logistik', 'required|max_length[250]');
        $this->form_validation->set_rules('type', 'Tipe Logistik', 'required|max_length[25]');
        $this->form_validation->set_rules('category', 'Kategori Logistik', 'required|max_length[25]');
        $this->form_validation->set_rules('notes', 'Catatan', 'max_length[1000]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','Logistik gagal diubah.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check = $this->logistic->edit_logistic($logistic_id);
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Logistik berhasil diubah.');
                redirect('logistic/view/'.$logistic_id);
            }else{
                $this->session->set_flashdata('error','Logistik gagal diubah.');
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
        endif;
    }

    public function delete_logistic($logistic_id){
        if($this->check_level_gudang() == TRUE):
        $check = $this->logistic->delete_logistic($logistic_id);
        if($check   ==  TRUE){
            $this->session->set_flashdata('success','Logistik berhasil di hapus.');
            redirect('logistic');
        }else{
            $this->session->set_flashdata('error','Logistik gagal di hapus.');
            redirect('logistic');
        }
        endif;
    }

    public function add_logistic_stock(){
        if($this->check_level_gudang() == TRUE):
        $this->load->library('form_validation');
        $this->form_validation->set_rules('modifier_warehouse', 'Stok Gudang', 'max_length[10]');
        $this->form_validation->set_rules('modifier_production', 'Stok Produksi', 'max_length[10]');
        $this->form_validation->set_rules('modifier_other', 'Stok Lainnya', 'max_length[10]');
        $this->form_validation->set_rules('input_notes', 'Catatan', 'required|max_length[256]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','Gagal mengubah stok.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check  =   $this->logistic->add_logistic_stock();
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Berhasil mengubah stok.');
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }else{
                $this->session->set_flashdata('error','Gagal mengubah stok.');
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
        endif;
    }

    public function delete_logistic_stock($logistic_stock_id){
        if($this->check_level_gudang() == TRUE):
        $isDeleted  = $this->logistic->delete_logistic_stock($logistic_stock_id);
        if($isDeleted   ==  TRUE){
            $this->session->set_flashdata('success','Berhasil menghapus data stok logistik.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $this->session->set_flashdata('error','Gagal menghapus data stok logistik.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        endif;
    }
    
    public function check_level(){
        if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang' || $_SESSION['level'] == 'admin_keuangan' || $_SESSION['level'] == 'admin_penerbitan' || $_SESSION['level'] == 'admin_percetakan'){
            return TRUE;
        }else{
            $this->session->set_flashdata('error','Hanya admin gudang, admin keuangan, admin penerbitan dan superadmin yang dapat mengakses.');
            redirect(base_url(), 'refresh');
        }
    }

    public function check_level_gudang(){
        if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang'){
            return TRUE;
        }else{
            $this->session->set_flashdata('error','Hanya admin gudang dan superadmin yang dapat mengakses.');
            redirect(base_url(), 'refresh');
        }
    }
}