<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Production_report extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('production_report_model', 'production_report');
    }

    public function index()
    {
        redirect('production_report/total?date_year=' . date('Y'));
    }

    public function total()
    {
        $filters = [
            'date_year'     => $this->input->get('date_year', true),
            'excel'         => $this->input->get('excel', true)
        ];
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

        if ($filters['excel'] == 1) {
            $this->generate_excel($filters, 'total');
        }
    }

    public function detail()
    {
        $filters = [
            'date_year'     => $this->input->get('date_year', true),
            'date_month'    => $this->input->get('date_month', true),
            'excel'         => $this->input->get('excel', true),
        ];
        if (empty($this->input->get('date_month', true))) {
            $filters['date_month'] = date('n');
        }
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

        if ($filters['excel'] == 1) {
            $this->generate_excel($filters, 'detail');
        }
    }

    // public function coba()
    // {
    //     $filters['date_year'] = "2020";
    //     $data = $this->production_report->filter_excel_total($filters);
    //     echo "<pre>";
    //     foreach ($data as $da) {
    //         processing_time(strtotime($da->entry_date), strtotime($da->finish_date));
    //         echo "<br>";
    //     }
    //     echo "</pre>";
    // }

    public function generate_excel($filters, $menu)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        if ($menu == 'total') {
            $filename = 'Order_Cetak_Tahun_' . $filters['date_year'];
            $get_data = $this->production_report->filter_excel_total($filters);
        } else {
            $filename = 'Order_Cetak_' . date('F', mktime(0, 0, 0, $filters['date_month'], 10)) . '_' . $filters['date_year'];
            $get_data = $this->production_report->filter_excel_detail($filters);
        }
        $i = 2;
        $no = 1;
        // Column Content
        foreach ($get_data as $data) {
            foreach (range('A', 'U') as $v) {
                switch ($v) {
                    case 'A': {
                            $value = $no++;
                            break;
                        }
                    case 'B': {
                            $value = $data->title;
                            break;
                        }
                    case 'C': {
                            $value = get_print_order_category()[$data->category];
                            break;
                        }
                    case 'D': {
                            $value = strtoupper($data->type);
                            break;
                        }
                    case 'E': {
                            $value = date('d F Y H:i:s', strtotime($data->entry_date));
                            break;
                        }
                    case 'F': {
                            $value = date('d F Y H:i:s', strtotime($data->finish_date));
                            break;
                        }
                    case 'G': {
                            $value = '';
                            break;
                        }
                    case 'H': {
                            $value = $data->total;
                            break;
                        }
                    case 'I': {
                            $value = $data->total_new;
                            break;
                        }
                    case 'J': {
                            $staff = "";
                            $staff_percetakan   = $this->production_report->get_staff_percetakan_by_progress("preprint", $data->id);
                            foreach ($staff_percetakan as $val) {
                                $staff .= $val->username . ", ";
                            }
                            $value = $staff;
                            break;
                        }
                    case 'K': {
                            $value = date('d F Y H:i:s', strtotime($data->preprint_start_date));
                            break;
                        }
                    case 'L': {
                            $value = date('d F Y H:i:s', strtotime($data->preprint_end_date));
                            break;
                        }
                    case 'M': {
                            $value = '';
                            break;
                        }
                    case 'N': {
                            $staff = "";
                            $staff_percetakan   = $this->production_report->get_staff_percetakan_by_progress("print", $data->id);
                            foreach ($staff_percetakan as $val) {
                                $staff .= $val->username . ", ";
                            }
                            $value = $staff;
                            break;
                        }
                    case 'O': {
                            $value = date('d F Y H:i:s', strtotime($data->print_start_date));
                            break;
                        }
                    case 'P': {
                            $value = date('d F Y H:i:s', strtotime($data->print_end_date));
                            break;
                        }
                    case 'Q': {
                            $value = '';
                            break;
                        }
                    case 'R': {
                            $staff = "";
                            $staff_percetakan   = $this->production_report->get_staff_percetakan_by_progress("postprint", $data->id);
                            foreach ($staff_percetakan as $val) {
                                $staff .= $val->username . ", ";
                            }
                            $value = $staff;
                            break;
                        }
                    case 'S': {
                            $value = date('d F Y H:i:s', strtotime($data->postprint_start_date));
                            break;
                        }
                    case 'T': {
                            $value = date('d F Y H:i:s', strtotime($data->postprint_end_date));
                            break;
                        }
                    case 'U': {
                            $value = '';
                            break;
                        }
                }
                $sheet->setCellValue($v . $i, $value);
            }
            $i++;
        }
        // Column Title
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Judul');
        $sheet->setCellValue('C1', 'Kategori');
        $sheet->setCellValue('D1', 'Tipe Cetak');
        $sheet->setCellValue('E1', 'Tanggal Mulai');
        $sheet->setCellValue('F1', 'Tanggal Selesai');
        $sheet->setCellValue('G1', 'Waktu Pengerjaan');
        $sheet->setCellValue('H1', 'Jumlah Pesanan');
        $sheet->setCellValue('I1', 'Jumlah Hasil Cetak');
        $sheet->setCellValue('J1', 'PIC Pracetak');
        $sheet->setCellValue('K1', 'Tanggal Mulai Pracetak');
        $sheet->setCellValue('L1', 'Tanggal Selesai Pracetak');
        $sheet->setCellValue('M1', 'Waktu Pengerjaan Pracetak');
        $sheet->setCellValue('N1', 'PIC Cetak');
        $sheet->setCellValue('O1', 'Tanggal Mulai Cetak');
        $sheet->setCellValue('P1', 'Tanggal Selesai Cetak');
        $sheet->setCellValue('Q1', 'Waktu Pengerjaan Cetak');
        $sheet->setCellValue('R1', 'PIC Jilid');
        $sheet->setCellValue('S1', 'Tanggal Mulai Jilid');
        $sheet->setCellValue('T1', 'Tanggal Selesai Jilid');
        $sheet->setCellValue('U1', 'Waktu Pengerjaan Jilid');
        // Auto width
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);
        $sheet->getColumnDimension('U')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        die();
    }
}
/* End of file Production_report.php */