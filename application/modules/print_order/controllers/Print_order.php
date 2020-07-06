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
        if (!$this->_is_printing_admin()) {
            redirect($this->pages);
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

    public function view($print_order_id = null)
    {
        if (!$this->_is_printing_admin()) {
            redirect($this->pages);
        }

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

    public function api_start_progress($print_order_id)
    {
        // apakah order cetak tersedia
        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        // hanya untuk user yang berkaitan dengan draft ini
        if (!$this->_is_printing_admin()) {
            $message = $this->lang->line('toast_error_not_authorized');
            return $this->send_json_output(false, $message);
        }

        // berisi 'progress' untuk conditional dibawah
        $input = (object) $this->input->post(null, false);

        $is_start_progress = $this->print_order->start_progress($print_order_id, $input->progress);

        if ($is_start_progress) {
            return $this->send_json_output(true, $this->lang->line('toast_edit_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_edit_fail'));
        }
    }

    public function api_finish_progress($print_order_id)
    {
        // apakah order cetak tersedia
        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        // hanya untuk admin
        if (!$this->_is_printing_admin()) {
            $message = $this->lang->line('toast_error_not_authorized');
            return $this->send_json_output(false, $message);
        }

        // berisi 'progress' untuk conditional dibawah
        $input = (object) $this->input->post(null, false);

        $is_finish_progress = $this->print_order->finish_progress($print_order_id, $input->progress);

        if ($is_finish_progress) {
            return $this->send_json_output(true, $this->lang->line('toast_edit_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_edit_fail'));
        }
    }

    // update draft, kirim update via post
    public function api_update($print_order_id = null)
    {
        // cek data
        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        // // hanya untuk admin
        // if (!$this->_is_printing_admin()) {
        //     $message = $this->lang->line('toast_error_not_authorized');
        //     return $this->send_json_output(false, $message);
        // }

        $input = (object) $this->input->post(null, false);

        if ($this->print_order->where('print_order_id', $print_order_id)->update($input)) {
            return $this->send_json_output(true, $this->lang->line('toast_edit_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_edit_fail'));
        }
    }

    // update draft, kirim update via post
    public function api_action_progress($print_order_id)
    {
        // cek data
        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        // hanya untuk admin
        if (!$this->_is_printing_admin()) {
            $message = $this->lang->line('toast_error_not_authorized');
            return $this->send_json_output(false, $message);
        }

        $input = (object) $this->input->post(null, false);

        // cek status apakah akan direvert
        if ($input->revert) {
            $input->{"is_$input->progress"} = 0;

            // kembali ke status 'sedang diproses'
            if ($input->progress == 'preprint') {
                $input->print_order_status = 'preprint';
            } elseif ($input->progress == 'print') {
                $input->print_order_status = 'print';
            } elseif ($input->progress == 'postprint') {
                $input->print_order_status = 'posprint';
            }
        } else {
            $input->{"is_$input->progress"} = $input->accept;

            // update draft status ketika selesai progress
            if ($input->progress == 'preprint') {
                $input->print_order_status = $input->accept ? 'preprint_finish' : 'reject';
            } elseif ($input->progress == 'print') {
                $input->print_order_status = $input->accept ? 'print_finish' : 'reject';
            } elseif ($input->progress == 'postprint') {
                $input->print_order_status = $input->accept ? 'postprint_finish' : 'reject';
            }
        }

        // hilangkan property pembantu yang tidak ada di db
        unset($input->progress);
        unset($input->accept);
        unset($input->revert);

        if ($this->print_order->where('print_order_id', $print_order_id)->update($input)) {
            return $this->send_json_output(true, $this->lang->line('toast_edit_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_edit_fail'));
        }
    }

    private function _is_printing_admin()
    {
        if ($this->level == 'superadmin' || $this->level == 'admin_percetakan') {
            return true;
        } else {
            $this->session->set_flashdata('error', 'Hanya admin percetakan dan superadmin yang dapat mengakses.');
            return false;
        }
    }

    private function _is_superadmin()
    {
        if ($this->level == 'superadmin') {
            return TRUE;
        } else {
            $this->session->set_flashdata('error', 'Hanya superadmin yang dapat mengakses.');
            redirect(base_url(), 'refresh');
        }
    }
}

/* End of file Print_order.php */
