<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_order_list extends MX_Controller
{
    public function index()
    {
        $this->load->model('print_order_list_model', 'print_order_list');
        $filters = [
            'keyword'               => $this->input->get('keyword', true),
            'category'              => $this->input->get('category', true),
            'type'                  => $this->input->get('type', true),
            'mode'                  => $this->input->get('mode', true),
            'print_order_status'    => $this->input->get('print_order_status', true),
            'date_year'             => $this->input->get('date_year', true),
            'date_month'            => $this->input->get('date_month', true)
        ];

        $print_orders   = $this->print_order_list->filter_print_order($filters);
        $pages          = 'print_order_list';
        $this->load->view('print_order_list/index', compact('pages', 'print_orders'));
    }
}
