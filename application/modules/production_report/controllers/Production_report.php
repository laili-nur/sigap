<?php
Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

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

        // GET DATA
        $model              = $this->production_report->filter($filters);
        $data               = $model['data'];
        $total              = $model['total'];
        $new                = $model['new'];
        $revise             = $model['revise'];
        $reprint            = $model['reprint'];
        $nonbook            = $model['nonbook'];
        $outsideprint       = $model['outsideprint'];
        $from_outside       = $model['from_outside'];
        $pod                = $model['pod'];
        $offset             = $model['offset'];
        $laminate_inside    = $model['laminate_inside'];
        $laminate_outside   = $model['laminate_outside'];
        $laminate_partial   = $model['laminate_partial'];
        $binding_inside     = $model['binding_inside'];
        $binding_outside    = $model['binding_outside'];
        $binding_partial    = $model['binding_partial'];

        $pages              = 'production_report/detail';
        $main_view          = 'production_report/detail';

        $this->load->view('template', compact(
            'main_view',
            'pages',
            'data',
            'total',
            'new',
            'revise',
            'reprint',
            'nonbook',
            'outsideprint',
            'from_outside',
            'pod',
            'offset',
            'laminate_inside',
            'laminate_outside',
            'laminate_partial',
            'binding_inside',
            'binding_outside',
            'binding_partial'
        ));
    }

    public function coba()
    {
        // $filters = [
        //     'date_year'             => '2020',
        //     'date_month'            => '1',
        // ];

        // return $this->production_report->detail_data($filters, $this->pages);
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        echo json_encode($this->production_report->detail_data($year, $month), JSON_PRETTY_PRINT);
    }
}

/* End of file Production_report.php */