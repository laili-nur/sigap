<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Production_report extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'production_report';

        // load model
        $this->load->model('production_report_model', 'production_report');
    }

    public function index()
    {
        $this->total();
    }

    public function total()
    {
        $filters = [
            'date_year'             => $this->input->get('date_year', true),
            'date_month'            => $this->input->get('date_month', true)
        ];

        // $get_data = $this->print_order->filter_print_order($filters, $page);

        $pages        = $this->pages;
        $main_view  = 'production_report/total';
        $this->load->view('template', compact('main_view', 'pages'));
    }

    public function detail()
    {
        $filters = [
            'date_year'             => $this->input->get('date_year', true),
            'date_month'            => $this->input->get('date_month', true)
        ];

        // $get_data = $this->print_order->filter_print_order($filters, $page);

        $pages        = $this->pages;
        $main_view  = 'production_report/detail';
        $this->load->view('template', compact('main_view', 'pages'));
    }
}

/* End of file Production_report.php */
