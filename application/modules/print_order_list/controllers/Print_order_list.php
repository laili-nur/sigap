<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_order_list extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'print_order_list';

        // load model
        $this->load->model('print_order_list_model', 'print_order_list');
    }

    public function index($page = null)
    {
        // all filter
        $filters = [
            'keyword'            => $this->input->get('keyword', true),
            'category'            => $this->input->get('category', true),
            'type'               => $this->input->get('type', true),
            'priority'           => $this->input->get('priority', true),
            'mode'           => $this->input->get('mode', true),
            'print_order_status' => $this->input->get('print_order_status', true),
            'date_year' => $this->input->get('date_year', true),
            'date_month' => $this->input->get('date_month', true)
        ];

        // custom per page
        $this->print_order_list->per_page = $this->input->get('per_page', true) ?? 10;

        $get_data = $this->print_order_list->filter_print_order($filters, $page);

        $print_orders = $get_data['print_orders'];
        $total        = $get_data['total'];
        $pagination   = $this->print_order_list->make_pagination(site_url('print_order'), 2, $total);
        $pages        = $this->pages;
        $this->load->view('print_order_list/index', compact('pages', 'print_orders', 'pagination', 'total'));
    }
}
