<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_order_list extends MX_Controller
{
    public function index()
    {
        $this->load->helper('ugmpress_helper');
        $this->load->model('print_order_list_model', 'print_order_list');
        $print_orders   = $this->print_order_list->get_print_order_list();
        $i              = 0;
        $this->load->view('print_order_list/index', compact('print_orders', 'i'));
    }
}
