<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logistic_request extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'logistic_request';
        $this->load->model('logistic_request_model', 'logistic_request');
    }

    public function index($page = NULL){
        // all filter
        $filters = [
            'keyword'           => $this->input->get('keyword', true),
            'status'            => $this->input->get('status', true),
            'type'              => $this->input->get('type', true)
        ];

        // custom per page
        $this->logistic_request->per_page = $this->input->get('per_page', true) ?? 10;
        
        $get_data = $this->logistic_request->filter_logistic_request($filters, $page);

        $logistic_request   = $get_data['logistic_request'];
        $total              = $get_data['total'];
        $pagination         = $this->logistic_request->make_pagination(site_url('logistic_request'), 2, $total);
        $pages              = $this->pages;
        $main_view          = 'logistic_request/index_logistic_request';
        $this->load->view('template', compact('pages', 'main_view', 'logistic_request', 'pagination', 'total'));
    }

    public function add(){
        $pages       = $this->pages;
        $main_view   = 'logistic_request/logistic_request_add';
        $this->load->view('template', compact('pages', 'main_view'));
    }

    public function edit($logistic_request_id){
        $pages       = $this->pages;
        $main_view   = 'logistic_request/logistic_request_edit';
        $rData       = $this->logistic_request->fetch_logistic_request_id($logistic_request_id);
        if(empty($rData) == FALSE):
        $this->load->view('template', compact('pages', 'main_view', 'rData'));
        else:
        $this->session->set_flashdata('error','Halaman tidak ditemukan.');
        redirect(base_url(), 'refresh');
        endif;
    }

    public function view($logistic_request_id){
        $pages       = $this->pages;
        $main_view   = 'logistic_request/logistic_request_view';
        $rData       = $this->logistic_request->fetch_logistic_request_id($logistic_request_id);
        if(empty($rData) == FALSE):
        $stock       = $this->logistic_request->fetch_logistic_stock_id($rData->logistic_id);
        $this->load->view('template', compact('pages', 'main_view', 'rData', 'stock'));
        else:
        $this->session->set_flashdata('error','Halaman tidak ditemukan.');
        redirect(base_url(), 'refresh');
        endif;
    }

    public function add_logistic_request(){
        $this->load->library('form_validation');
        if($_SESSION['level'] == 'superadmin') :
        $this->form_validation->set_rules('type', 'Tipe Permintaan', 'required|max_length[1]');
        endif;
        $this->form_validation->set_rules('logistic_id', 'Nama Logistik', 'required|max_length[10]');
        $this->form_validation->set_rules('order_number', 'Nomor Order', 'required|max_length[25]');
        $this->form_validation->set_rules('total', 'Jumlah Permintaan', 'required|max_length[10]');
        $this->form_validation->set_rules('notes', 'Catatan', 'required|max_length[250]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', 'Gagal menambahkan draft permintaan logistik.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check  =   $this->logistic_request->add_logistic_request();
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Berhasil menambahkan draft permintaan logistik.');
                redirect('logistic_request');
            }else{
                $this->session->set_flashdata('error','Gagal menambahkan draft permintaan logistik.');
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
    }

    public function edit_logistic_request($logistic_request_id){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('logistic_id', 'Nama Logistik', 'max_length[10]');
        $this->form_validation->set_rules('order_number', 'Nomor Order', 'max_length[25]');
        $this->form_validation->set_rules('total', 'Jumlah Permintaan', 'max_length[10]');
        $this->form_validation->set_rules('notes', 'Catatan', 'max_length[250]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','Gagal mengubah data draft permintaan logistik.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check  =   $this->logistic_request->edit_logistic_request($logistic_request_id);
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Berhasil mengubah data draft permintaan logistik.');
                redirect('logistic_request/view/'.$logistic_request_id);
            }else{
                $this->session->set_flashdata('error','Gagal mengubah data draft permintaan logistik.');
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
    }

    public function delete_logistic_request($logistic_request_id){
        if($this->check_level_gudang() == TRUE):
        $check  = $this->logistic_request->delete_logistic_request($logistic_request_id);
        if($check   ==  TRUE){
            $this->session->set_flashdata('success','Berhasil menghapus data draft permintaan logistik.');
            redirect('logistic_request');
        }else{
            $this->session->set_flashdata('error','Gagal menghapus data draft permintaan logistik.');
            redirect('logistic_request');
        }
        endif;
    }

    public function ac_logistic_id(){
        $postData   =   $this->input->post();
        $data       =   $this->logistic_request->fetch_logistic_id($postData);

        echo json_encode($data);
    }
}