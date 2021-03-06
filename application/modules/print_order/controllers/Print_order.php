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

    public function add()
    {
        // khusus admin
        if (!is_admin()) {
            redirect();
        }

        if (!$_POST) {
            $input = (object) $this->print_order->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);
            // catat orang yang menginput order cetak
            $input->input_by = $this->username;
        }

        if (!$this->print_order->validate() || $this->form_validation->error_array()) {
            $pages       = $this->pages;
            $main_view   = 'print_order/form_print_order';
            $form_action = 'print_order/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        // memastikan konsistensi data
        $this->db->trans_begin();

        // insert print order
        $print_order_id = $this->print_order->insert($input);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
        }

        redirect('print_order/view/' . $print_order_id);
    }

    public function view($print_order_id)
    {
        if ($print_order_id == null) {
            redirect($this->pages);
        }

        $print_order = $this->print_order->get_print_order($print_order_id);


        if (!$print_order) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        $pages       = $this->pages;
        $main_view   = 'print_order/view/overview';
        $form_action = "print_order/edit/$print_order_id";
        $this->load->view('template', compact('form_action', 'main_view', 'pages', 'print_order'));
    }
}

/* End of file Print_order.php */
