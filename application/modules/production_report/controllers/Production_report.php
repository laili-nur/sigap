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
        redirect('production_report/total?date_year=' . date('Y'));
    }

    public function total()
    {
        $filters['date_year'] = $this->input->get('date_year', true);
        $model = [];
        for ($month = 1; $month <= 12; $month++) {
            $filters['date_month'] = $month;
            $monthly = $this->production_report->filter_total($filters);

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

            array_push($model, [
                'month'             => $month,
                'data'              => $monthly,
                'count_total'       => $count_total,
                'count_total_new'   => $count_total_new,
                'count_order'       => $count_order
            ]);
        }

        $pages      = 'production_report/total';
        $main_view  = 'production_report/total';
        $this->load->view('template', compact('main_view', 'pages', 'model'));
    }

    public function detail()
    {
        $filters = [
            'date_year'     => $this->input->get('date_year', true),
            'date_month'    => $this->input->get('date_month', true)
        ];
        $model = [];
        $data = $this->production_report->filter_detail($filters);

        $category = [];
        foreach ($data as $value) {
            if (isset($value->category)) {
                array_push($category, $value->category);
            }
        }
        $type = [];
        foreach ($data as $value) {
            if (isset($value->type)) {
                array_push($type, $value->type);
            }
        }
        $location_laminate = [];
        foreach ($data as $value) {
            if (isset($value->location_laminate)) {
                array_push($location_laminate, $value->location_laminate);
            }
        }
        $location_binding = [];
        foreach ($data as $value) {
            if (isset($value->location_binding)) {
                array_push($location_binding, $value->location_binding);
            }
        }

        $new                = array_count_values($category)['new'] ?? null;
        $revise             = array_count_values($category)['revise'] ?? null;
        $reprint            = array_count_values($category)['reprint'] ?? null;
        $nonbook            = array_count_values($category)['nonbook'] ?? null;
        $outsideprint       = array_count_values($category)['outsideprint'] ?? null;
        $from_outside       = array_count_values($category)['from_outside'] ?? null;
        $pod                = array_count_values($type)['pod'] ?? null;
        $offset             = array_count_values($type)['offset'] ?? null;
        $laminate_inside    = array_count_values($location_laminate)['inside'] ?? null;
        $laminate_outside   = array_count_values($location_laminate)['outside'] ?? null;
        $laminate_partial   = array_count_values($location_laminate)['partial'] ?? null;
        $binding_inside     = array_count_values($location_binding)['inside'] ?? null;
        $binding_outside    = array_count_values($location_binding)['outside'] ?? null;
        $binding_partial    = array_count_values($location_binding)['partial'] ?? null;

        array_push($model, [
            'total'             => count($data),
            'new'               => $new,
            'revise'            => $revise,
            'reprint'           => $reprint,
            'nonbook'           => $nonbook,
            'outsideprint'      => $outsideprint,
            'from_outside'      => $from_outside,
            'pod'               => $pod,
            'offset'            => $offset,
            'laminate_inside'   => $laminate_inside,
            'laminate_outside'  => $laminate_outside,
            'laminate_partial'  => $laminate_partial,
            'binding_inside'    => $binding_inside,
            'binding_outside'   => $binding_outside,
            'binding_partial'   => $binding_partial
        ]);

        $pages      = 'production_report/detail';
        $main_view  = 'production_report/detail';
        $this->load->view('template', compact('main_view', 'pages', 'model'));
    }
}
/* End of file Production_report.php */