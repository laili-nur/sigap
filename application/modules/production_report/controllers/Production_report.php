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
        $filters['date_year'] = $this->input->get('date_year', true);

        // GET DATA
        $model              = $this->production_report->filter_total($filters);
        $by_month           = $this->production_report->total_exemplar($filters);
        $by_month2          = $this->production_report->total_exemplar2($filters);
        $by_month3          = $this->production_report->total_exemplar3($filters);
        $jan_total          = $model['jan_total'];
        $feb_total          = $model['feb_total'];
        $mar_total          = $model['mar_total'];
        $apr_total          = $model['apr_total'];
        $may_total          = $model['may_total'];
        $jun_total          = $model['jun_total'];
        $jul_total          = $model['jul_total'];
        $aug_total          = $model['aug_total'];
        $sep_total          = $model['sep_total'];
        $oct_total          = $model['oct_total'];
        $nov_total          = $model['nov_total'];
        $dec_total          = $model['dec_total'];
        $jan                = $by_month['jan'];
        $feb                = $by_month['feb'];
        $mar                = $by_month['mar'];
        $apr                = $by_month['apr'];
        $may                = $by_month2['may'];
        $jun                = $by_month2['jun'];
        $jul                = $by_month2['jul'];
        $aug                = $by_month2['aug'];
        $sep                = $by_month3['sep'];
        $oct                = $by_month3['oct'];
        $nov                = $by_month3['nov'];
        $dec                = $by_month3['dec'];


        $pages              = 'production_report/total';
        $main_view          = 'production_report/total';
        $this->load->view('template', compact(
            'main_view',
            'pages',
            'jan_total',
            'feb_total',
            'mar_total',
            'apr_total',
            'may_total',
            'jun_total',
            'jul_total',
            'aug_total',
            'sep_total',
            'oct_total',
            'nov_total',
            'dec_total',
            'jan',
            'feb',
            'mar',
            'apr',
            'may',
            'jun',
            'jul',
            'aug',
            'sep',
            'oct',
            'nov',
            'dec'
        ));
    }

    public function detail()
    {
        $filters = [
            'date_year'     => $this->input->get('date_year', true),
            'date_month'    => $this->input->get('date_month', true)
        ];

        // GET DATA
        $model              = $this->production_report->filter_detail($filters);
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

    public function get_data_by_month($date_year = null, $date_month = null)
    {
        $filters = [
            'date_year'     => $date_year,
            'date_month'    => $date_month
        ];

        return json_encode($this->production_report->total_by_month($filters));
    }
}

/* End of file Production_report.php */