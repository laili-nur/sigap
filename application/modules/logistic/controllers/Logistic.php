<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logistic extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'logistic';
        $this->load->model('logistic/Logistic_model');
    }

    public function index(){

    }

    public function view_logistic_add(){
        if($this->check_level_gudang() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'logistic/logistic_add';
        $this->load->view('template', compact('pages', 'main_view'));
        endif;
    }

    public function view_logistic_edit($logistic_id){
        if($this->check_level_gudang() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'logistic/logistic_edit';
        $lData       = $this->Logistic_model->fetch_logistic_id($logistic_id);
        if(empty($lData) == FALSE):
        $this->load->view('template', compact('pages', 'main_view', 'lData'));
        else:
        $this->session->set_flashdata('error','Halaman tidak ditemukan.');
        redirect(base_url(), 'refresh');
        endif;
        endif;
    }

    public function view_logistic_view($logistic_id){
        if($this->check_level_gudang_keuangan() == TRUE):
        $pages          = $this->pages;
        $main_view      = 'logistic/logistic_view';
        $lData          = $this->Logistic_model->fetch_logistic_id($logistic_id);
        $get_stock      = $this->Logistic_model->fetch_stock_by_id($logistic_id);
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

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error',validation_errors());
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check = $this->Logistic_model->add_logistic();
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Logistik berhasil ditambah.');
                redirect('logistic');
            }else{
                $this->session->set_flashdata('error',print_r($this->db->error()));
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
            $this->session->set_flashdata('error',validation_errors());
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check = $this->Logistic_model->edit_logistic($logistic_id);
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Order cetak berhasil diubah.');
                redirect('logistic/view_logistic_view/'.$logistic_id);
            }else{
                $this->session->set_flashdata('error',print_r($this->db->error()));
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
        endif;
    }

    public function delete_logistic($logistic_id){
        if($this->check_level_gudang() == TRUE):
        $check = $this->Logistic_model->delete_logistic($logistic_id);
        if($check   ==  TRUE){
            $this->session->set_flashdata('success','Logistik berhasil di hapus.');
            redirect('logistic');
        }else{
            $this->session->set_flashdata('error',print_r($this->db->error()));
            redirect('logistic');
        }
        endif;
    }

    public function add_logistic_stock(){
        if($this->check_level_gudang() == TRUE):
        $this->load->library('form_validation');
        $this->form_validation->set_rules('stock_warehouse', 'Stok Gudang', 'required|max_length[10]');
        $this->form_validation->set_rules('stock_production', 'Stok Produksi', 'required|max_length[10]');
        $this->form_validation->set_rules('stock_other', 'Stok Lainnya', 'max_length[10]');
        $this->form_validation->set_rules('input_notes', 'Catatan', 'required|max_length[256]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error',validation_errors());
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check  =   $this->Logistic_model->add_logistic_stock();
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Berhasil mengubah stok.');
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }else{
                $this->session->set_flashdata('error',$this->db->error());
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
        endif;
    }

    public function delete_logistic_stock($logistic_stock_id){
        if($this->check_level_gudang() == TRUE):
        $isDeleted  = $this->Book_model->delete_logistic_stock($logistic_stock_id);
        if($isDeleted   ==  TRUE){
            $this->session->set_flashdata('success','Berhasil menghapus data stok logistik.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $this->session->set_flashdata('error',print_r($this->db->error()));
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
        endif;
    }
    
    public function check_level_gudang_keuangan(){
        if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang' || $_SESSION['level'] == 'admin_keuangan'){
            return TRUE;
        }else{
            $this->session->set_flashdata('error','Hanya admin gudang, admin keuangan, dan superadmin yang dapat mengakses.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
    }

    public function check_level_gudang(){
        if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang'){
            return TRUE;
        }else{
            $this->session->set_flashdata('error','Hanya admin gudang dan superadmin yang dapat mengakses.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
    }

    // public function check_level_keuangan(){
    //     if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_keuangan'){
    //         return TRUE;
    //     }else{
    //         $this->session->set_flashdata('error','Hanya admin keuangan dan superadmin yang dapat mengakses.');
    //         redirect($_SERVER['HTTP_REFERER'], 'refresh');
    //     }
    // }
}