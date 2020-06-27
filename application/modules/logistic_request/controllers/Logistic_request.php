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
}