<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_order extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'print_order';

        // load model
        $this->load->model('print_order_model', 'print_order');
    }

    public function index($page = null)
    {
        // all filter
        $filters = [
            'keyword' => $this->input->get('keyword', true),
        ];

        // custom per page
        $this->print_order->per_page = $this->input->get('per_page', true) ?? 10;

        $get_data = $this->print_order->filter_print_order($filters, $page);

        $print_orders = $get_data['print_orders'];
        $total        = $get_data['total'];
        $pagination   = $this->print_order->make_pagination(site_url('print_order'), 2, $total);
        $pages        = $this->pages;
        $main_view    = 'print_order/index_print_order';
        $this->load->view('template', compact('pages', 'main_view', 'print_orders', 'pagination', 'total'));
    }
}

/* End of file Print.php */
