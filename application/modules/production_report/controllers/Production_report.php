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
        $yearly = [];
        for ($month = 1; $month <= 12; $month++) {
            # code...
            $filters['date_month'] = $month;
            $monthly = $this->production_report->total_by_month($filters);

            $count_total = 0;
            foreach ($monthly as $value) {
                if (isset($value->total)) {
                    $count_total += $value->total;
                }
            }

            $count_total_new = 0;
            foreach ($monthly as $value) {
                if (isset($value->total_new)) {
                    $count_total_new += $value->total_new;
                }
            }

            $count_order = count($monthly);

            array_push($yearly, [
                'month' => $month,
                'data' => $monthly,
                'count_total' => $count_total,
                'count_total_new' => $count_total_new,
                'count_order' => $count_order
            ]);
        }

        // echo '<pre>';
        // // print_r($yearly[9]['data']);->data di bulan oktober
        // print_r($yearly[9]['count_month']);
        // echo '</pre>';
        // die();

        $pages              = 'production_report/total';
        $main_view          = 'production_report/total';
        $this->load->view('template', compact('main_view', 'pages', 'yearly'));
    }

    public function detail()
    {
        $filters = [
            'date_year'     => $this->input->get('date_year', true),
            'date_month'    => $this->input->get('date_month', true)
        ];

        // GET 1 DATA TRS DIOLAH DIPHP

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
        echo '<pre>';
        print_r(json_encode($this->production_report->total_by_month($filters)));
        echo '</pre>';
    }
}

/* End of file Production_report.php */