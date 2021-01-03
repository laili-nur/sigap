<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Print_order extends Printing_Controller
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
            'keyword'               => $this->input->get('keyword', true),
            'category'              => $this->input->get('category', true),
            'type'                  => $this->input->get('type', true),
            'mode'                  => $this->input->get('mode', true),
            'print_order_status'    => $this->input->get('print_order_status', true),
            'date_year'             => $this->input->get('date_year', true),
            'date_month'            => $this->input->get('date_month', true),
            'excel'                 => $this->input->get('excel', true),
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

        if ($filters['excel'] == 1) {
            $this->generate_excel($filters);
        }
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
            $input->user_id = $_SESSION['user_id'];
            $input->category = 'new';

            // repopulate print_order_file ketika validasi form gagal
            if (!isset($input->print_order_file)) {
                $input->print_order_file = null;
                $this->session->set_flashdata('print_order_file_no_data', $this->lang->line('form_error_file_no_data'));
            }
        }

        // conditional rules, untuk book dan nonbook
        if ($input->print_mode == 'nonbook') {
            $input->category = 'nonbook';
            $this->form_validation->set_rules('name', $this->lang->line('form_print_order_name'), 'required');
        } elseif ($input->print_mode == 'book') {
            $input->category = $this->_check_book($input->book_id);
            $this->form_validation->set_rules('book_id', $this->lang->line('form_book_title'), 'required');
            $this->form_validation->set_rules('name', $this->lang->line('form_print_order_name'), '');
        } elseif ($input->print_mode == 'outsideprint') {
            $input->category = 'outsideprint';
            $this->form_validation->set_rules('book_id', $this->lang->line('form_book_title'), 'required');
        }

        if ($this->print_order->validate()) {
            if (!empty($_FILES) && $file_name = $_FILES['print_order_file']['name']) {
                $generated_name = strip_disallowed_char($this->_generate_file_name($file_name));
                $upload          = $this->print_order->upload_print_order_file('print_order_file', $generated_name);
                if ($upload) {
                    $input->print_order_file = $generated_name;
                }
            }
        }

        if (!$this->print_order->validate() || $this->form_validation->error_array()) {

            $pages       = $this->pages;
            $main_view   = 'print_order/form_print_order_add';
            $form_action = 'print_order/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        // handle book dan nonbook
        if ($input->category == 'nonbook') {
            $input->book_id = null;
        }

        // set status awal
        $input->print_order_status = 'waiting';

        unset($input->print_mode);

        if (empty($input->deadline_date)) {
            $input->deadline_date = empty_to_null($input->deadline_date);
        }

        if (empty($input->location_binding_outside)) {
            $input->location_binding_outside = empty_to_null($input->location_binding_outside);
        }
        if (empty($input->location_laminate_outside)) {
            $input->location_laminate_outside = empty_to_null($input->location_laminate_outside);
        }

        if (empty($input->name)) {
            $input->name = empty_to_null($input->name);
        }

        if (empty($input->book_id)) {
            $input->book_id = empty_to_null($input->book_id);
        }

        if (empty($input->paper_estimation)) {
            if (empty($input->book_id)) {
                $input->paper_estimation = empty_to_null($input->paper_estimation);
            } else {
                $book_pages = $this->print_order->get_book($input->book_id)->book_pages;
                if (empty($input->total) || empty($book_pages) || empty($input->paper_divider)) {
                    $input->paper_estimation = empty_to_null($input->paper_estimation);
                } else {
                    $input->paper_estimation = ($input->total * $book_pages) / $input->paper_divider;
                }
            }
        }

        // insert print order
        $print_order_id = $this->print_order->insert($input);

        if ($print_order_id) {
            $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
        }

        redirect('print_order/view/' . $print_order_id);
    }

    public function edit($print_order_id)
    {
        if (!$this->_is_printing_admin()) {
            redirect($this->pages);
        }

        $print_order = $this->print_order->get_print_order($print_order_id);
        if (!$print_order) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        if (!$_POST) {
            $input = (object)  $print_order;
        } else {
            $input = (object) $this->input->post(null, true);
            // catat orang yang menginput order cetak
            $input->user_id = $_SESSION['user_id'];

            // repopulate print_order_file ketika validasi form gagal
            if (!isset($input->print_order_file)) {
                $input->print_order_file = $print_order->print_order_file;
                $this->session->set_flashdata('print_order_file_no_data', $this->lang->line('form_error_file_no_data'));
            }
        }

        if ($input->category == 'nonbook') {
            $this->form_validation->set_rules('name', $this->lang->line('form_print_order_name'), 'required');
        } else {
            $this->form_validation->set_rules('book_id', $this->lang->line('form_book_title'), 'required');
        }


        if ($this->print_order->validate()) {
            if (!empty($_FILES) && $file_name = $_FILES['print_order_file']['name']) {
                $generated_name = strip_disallowed_char($this->_generate_file_name($file_name));
                $upload          = $this->print_order->upload_print_order_file('print_order_file', $generated_name);
                if ($upload) {
                    $input->print_order_file = $generated_name;
                    if ($print_order->print_order_file) {
                        $this->print_order->delete_print_order_file($print_order->print_order_file);
                    }
                }
            }
        }

        if (!$this->print_order->validate() || $this->form_validation->error_array()) {
            $pages       = $this->pages;
            $main_view   = 'print_order/form_print_order_edit';
            $form_action = "print_order/edit/$print_order_id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        // handle book dan nonbook
        if ($input->category == 'nonbook') {
            $input->book_id = null;
        } elseif ($input->category == 'normal') {
            $input->name = null;
        }

        // memastikan konsistensi data
        $this->db->trans_begin();

        //  hapus order cetak jika check delete_file
        if (isset($input->delete_file) && $input->delete_file == 1) {
            $this->print_order->delete_print_order_file($print_order->print_order_file);
            $this->print_order->delete_print_order_file($input->print_order_file);
            $input->print_order_file = null;
            unset($input->delete_file);
        }

        if (empty($input->deadline_date)) {
            $input->deadline_date = empty_to_null($input->deadline_date);
        }

        if (empty($input->location_binding_outside)) {
            $input->location_binding_outside = empty_to_null($input->location_binding_outside);
        }
        if (empty($input->location_laminate_outside)) {
            $input->location_laminate_outside = empty_to_null($input->location_laminate_outside);
        }

        if (empty($input->name)) {
            $input->name = empty_to_null($input->name);
        }

        if (empty($input->book_id)) {
            $input->book_id = empty_to_null($input->book_id);
        }

        if (empty($input->paper_estimation)) {
            if (empty($input->book_id)) {
                $input->paper_estimation = empty_to_null($input->paper_estimation);
            } else {
                $book_pages = $this->print_order->get_book($input->book_id)->book_pages;
                if (empty($input->total) || empty($book_pages) || empty($input->paper_divider)) {
                    $input->paper_estimation = empty_to_null($input->paper_estimation);
                } else {
                    $input->paper_estimation = ($input->total * $book_pages) / $input->paper_divider;
                }
            }
        }

        // update print order
        $this->print_order->where('print_order_id', $print_order_id)->update($input);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        }

        redirect('print_order/view/' . $print_order_id);
    }

    public function view($print_order_id = null)
    {
        if (!$this->_is_print_order_user()) {
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

        $is_final = $print_order->print_order_status == 'finish';

        $pages       = $this->pages;
        $main_view   = 'print_order/view/overview';
        $form_action = "print_order/edit/$print_order_id";
        $this->load->view('template', compact('form_action', 'main_view', 'pages', 'print_order', 'is_final'));
    }

    public function final($print_order_id = null, $action = null)
    {
        if (!$print_order_id || !$action) {
            $this->session->set_flashdata('error', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        if (!$this->_is_printing_admin()) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        //  ambil data print order
        $data       = $this->print_order->get_print_order($print_order_id);
        $category   = $data->category;

        if ($category !== 'nonbook' && $category !== 'from_outside') {
            // Mekanisme input stok
            $book_id             =   $data->book_id;
            $warehouse_past      =   intval($data->stock_warehouse);

            if ($data->total_postprint) {
                $warehouse_modifier  =   abs($data->total_postprint);
            } else {
                $warehouse_modifier  =   abs($data->total_print);
            }

            $warehouse_operator  =   "+";
            $warehouse_present   =   $warehouse_past + $warehouse_modifier;

            $edit   =   [
                'stock_warehouse'    => $warehouse_present,
            ];

            $add    =   [
                'book_id'               => $book_id,
                'user_id'               => $_SESSION['user_id'],
                'type'                  => 'print_order',
                'date'                  => date('Y-m-d H:i:s'),
                'notes'                 => '<a href="' . base_url('print_order/view/' . $data->print_order_id) . '" target="_blank"> <i class="fa fa-external-link-alt"></i> Link Order Cetak</a>',
                'warehouse_past'        => $warehouse_past,
                'warehouse_modifier'    => $warehouse_modifier,
                'warehouse_present'     => $warehouse_present,
                'warehouse_operator'    => $warehouse_operator
            ];

            $this->db->set($edit)->where('book_id', $book_id)->update('book');
            $this->db->insert('book_stock', $add);
        }

        // memastikan konsistensi data
        $this->db->trans_begin();

        // apakah order cetak tersedia
        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $this->session->set_flashdata('error', $this->lang->line('toast_data_not_available'));
        }

        // update data order cetak
        $this->print_order->where('print_order_id', $print_order_id)->update([
            'print_order_status' => $action,
            'finish_date' => $action == 'finish' ? now() : null
        ]);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        }

        redirect($this->pages . "/view/$print_order_id");
    }

    public function delete($print_order_id = null)
    {
        if (!$this->_is_printing_admin()) {
            redirect($this->pages);
        }

        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        // memastikan konsistensi data
        $this->db->trans_begin();

        if ($this->print_order->where('print_order_id', $print_order_id)->delete()) {
            $this->print_order->delete_print_order_file($print_order->print_order_file);
            $this->print_order->delete_letter_file($print_order->letter_file);
            $this->print_order->delete_preprint_file($print_order->delete_preprint_file);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $this->lang->line('toast_delete_fail'));
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', $this->lang->line('toast_delete_success'));
        }

        redirect($this->pages);
    }

    public function api_start_progress($print_order_id)
    {
        // apakah order cetak tersedia
        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        // berisi 'progress' untuk conditional dibawah
        $input = (object) $this->input->post(null, false);

        // hanya untuk user yang berkaitan dengan print_order ini
        if (!$this->_is_printing_admin()) {
            $message = $this->lang->line('toast_error_not_authorized');
            return $this->send_json_output(false, $message);
        }

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

        // berisi 'progress' untuk conditional dibawah
        $input = (object) $this->input->post(null, false);

        // hanya untuk user yang berkaitan dengan print_order ini
        if (!$this->_is_printing_admin()) {
            $message = $this->lang->line('toast_error_not_authorized');
            return $this->send_json_output(false, $message);
        }

        $is_finish_progress = $this->print_order->finish_progress($print_order_id, $input->progress);

        if ($is_finish_progress) {
            return $this->send_json_output(true, $this->lang->line('toast_edit_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_edit_fail'));
        }
    }

    // update print_order, kirim update via post
    public function api_update($print_order_id = null)
    {
        // cek data
        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        $input = (object) $this->input->post(null, false);

        // hanya untuk user yang berkaitan dengan print_order ini
        if (!$this->_is_printing_admin()) {
            $message = $this->lang->line('toast_error_not_authorized');
            return $this->send_json_output(false, $message);
        }

        // untuk reset deadline
        if (isset($input->preprint_deadline)) {
            $input->preprint_deadline = empty_to_null($input->preprint_deadline);
        }
        if (isset($input->print_deadline)) {
            $input->print_deadline = empty_to_null($input->print_deadline);
        }
        if (isset($input->postprint_deadline)) {
            $input->postprint_deadline = empty_to_null($input->postprint_deadline);
        }

        // hilangkan property pembantu yang tidak ada di db
        unset($input->progress);

        if ($this->print_order->where('print_order_id', $print_order_id)->update($input)) {
            return $this->send_json_output(true, $this->lang->line('toast_edit_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_edit_fail'));
        }
    }

    // update print_order, kirim update via post
    public function api_action_progress($print_order_id)
    {
        // cek data
        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        // hanya untuk superadmin
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

            // update print_order status ketika selesai progress
            if ($input->progress == 'preprint') {
                $input->print_order_status = $input->accept ? 'preprint_finish' : 'reject';
            } elseif ($input->progress == 'print') {
                $input->print_order_status = $input->accept ? 'print_finish' : 'reject';
            } elseif ($input->progress == 'postprint') {
                $input->print_order_status = $input->accept ? 'postprint_finish' : 'reject';
            }
        }

        // jika end date kosong, maka isikan nilai now
        if (!$print_order->{"{$input->progress}_end_date"}) {
            $input->{"{$input->progress}_end_date"} = now();
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

    private function _check_book($book_id)
    {
        $this->load->model('book/book_model', 'book');

        $book = $this->book->join('draft')->get_where(['book_id' => $book_id]);
        $is_reprint_book = $book->is_reprint ?? null;
        $is_outside_book = $this->db->select('*')->from('book')->where('book_id', $book_id)->get()->row()->from_outside ?? null;

        // cek buku apakah pernah order cetak
        $book_order = $this->print_order->get_where(['book_id' => $book_id]);

        if ($is_outside_book) {
            return 'from_outside'; //Cetak dari luar
        }

        if ($book_order && !$is_outside_book) {
            return 'reprint'; //Cetak ulang non revisi
        }

        if (!$book_order) {
            if ($is_reprint_book == 'n' && !$is_outside_book) {
                return 'new'; //Cetak baru
            }
            if ($is_reprint_book == 'y' && !$is_outside_book) {
                return 'revise'; //Cetak ulang revisi
            }
        }

        return null;
    }

    public function api_check_book($book_id)
    {
        return $this->send_json_output(true, $this->_check_book($book_id));
    }

    public function action_print_postprint($print_order_id)
    {
        // cek data
        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        // hanya untuk superadmin
        if (!$this->_is_printing_admin()) {
            $message = $this->lang->line('toast_error_not_authorized');
            return $this->send_json_output(false, $message);
        }

        $input = (object) $this->input->post(null, false);

        // cek status apakah akan direvert
        if ($input->revert) {
            $input->is_print = 0;
            $input->is_postprint = 0;
            $input->print_order_status = 'print';
        } else {
            $input->is_print = $input->accept;
            $input->is_postprint = $input->accept;
            $input->print_order_status = $input->accept ? 'print_finish' : 'reject';
        }

        // jika end date kosong, maka isikan nilai now
        if (empty($print_order->print_end_date) == TRUE || empty($print_order->postprint_end_date) == TRUE) {
            $input->print_end_date = now();
            $input->postprint_end_date = now();
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

    public function finish_print_postprint($print_order_id)
    {
        // apakah order cetak tersedia
        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        // berisi 'progress' untuk conditional dibawah
        $input = (object) $this->input->post(null, false);

        // hanya untuk user yang berkaitan dengan print_order ini
        if (!$this->_is_printing_admin()) {
            $message = $this->lang->line('toast_error_not_authorized');
            return $this->send_json_output(false, $message);
        }

        $is_finish_progress = $this->print_order->finish_print_postprint($print_order_id);

        if ($is_finish_progress) {
            return $this->send_json_output(true, $this->lang->line('toast_edit_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_edit_fail'));
        }
    }

    public function api_upload_preprint_file($print_order_id)
    {
        // apakah print_order tersedia
        $print_order = $this->print_order->join('book')->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        $input = (object) $this->input->post(null, true);

        // hanya untuk user yang berkaitan dengan print_order ini
        if (!$this->_is_printing_admin()) {
            $message = $this->lang->line('toast_error_not_authorized');
            return $this->send_json_output(false, $message);
        }

        $progress = $input->progress;

        // tiap upload, update upload date
        $this->print_order->edit_print_order_date($print_order_id, $progress . '_upload_date');
        $upload_by_field         = $progress . '_upload_by';
        $input->$upload_by_field = $this->username;

        $column = "{$progress}_file";

        if (!empty($_FILES) && $file_name = $_FILES[$column]['name']) {
            $print_order_file_name = strip_disallowed_char($this->_generate_print_order_file_name($file_name, $print_order->book_title, $column));
            $upload = $this->print_order->upload_preprint_file($column, $print_order_file_name);
            if ($upload) {
                $input->$column = $print_order_file_name;
                // Delete old preprint file
                if ($print_order->$column) {
                    $this->print_order->delete_preprint_file($print_order->$column);
                }
            }

            // validasi jenis file sesuai model
            if ($this->upload->display_errors()) {
                return $this->send_json_output(false, $this->upload->display_errors(), 422);
            }
        }

        // unset unnecesary data
        unset($input->progress);

        if ($this->print_order->where('print_order_id', $print_order_id)->update($input)) {
            return $this->send_json_output(true, $this->lang->line('toast_edit_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_edit_fail'));
        }
    }

    // hapus progress draft
    public function api_delete_preprint_file($print_order_id)
    {
        // apakah draft tersedia
        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        $input = (object) $this->input->post(null, true);

        // hanya untuk user yang berkaitan dengan print_order ini
        if (!$this->_is_printing_admin()) {
            $message = $this->lang->line('toast_error_not_authorized');
            return $this->send_json_output(false, $message);
        }

        $progress = $input->progress;
        $file_type = $input->file_type;
        if ($file_type == 'file') {
            if (!$this->print_order->delete_preprint_file($print_order->{$input->progress . "_file"})) {
                return $this->send_json_output(false, $this->lang->line('toast_delete_fail'));
            }

            // ketika hapus file, update upload date, update upload by, delete progress file
            $print_order->{$progress . '_file'} = '';
        } else  if ($file_type == 'link') {
            $print_order->{$progress . '_file_link'} = '';
        }
        $print_order->{$progress . '_upload_date'} = date('Y-m-d H:i:s');
        $upload_by_field         = $progress . '_upload_by';
        $print_order->$upload_by_field = $this->username;

        // unset unnecesary data
        unset($input->progress);

        if ($this->print_order->where('print_order_id', $print_order_id)->update($print_order)) {
            return $this->send_json_output(true, $this->lang->line('toast_delete_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_delete_fail'));
        }
    }

    public function api_set_stock($print_order_id)
    {
        // cek data
        $print_order = $this->print_order->where('print_order_id', $print_order_id)->get();
        if (!$print_order) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        $input = (object) $this->input->post(null, false);

        // hanya untuk user yang berkaitan dengan print_order ini
        if (!$this->_is_printing_admin()) {
            return $this->send_json_output(false, $this->lang->line('toast_error_not_authorized'));
        }

        // hilangkan property pembantu yang tidak ada di db
        unset($input->progress);

        if ($this->print_order->where('print_order_id', $print_order_id)->update($input)) {
            return $this->send_json_output(true, $this->lang->line('toast_edit_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_edit_fail'));
        }
    }

    public function api_get_book($book_id)
    {
        return $this->send_json_output(true, $this->print_order->get_book($book_id));
    }

    public function api_get_staff_percetakan()
    {
        $staff_percetakan = $this->print_order->get_staff_percetakan();
        return $this->send_json_output(true, $staff_percetakan);
    }

    public function api_add_staff_percetakan()
    {
        $input = (object) $this->input->post(null, true);

        if (!$input->print_order_id || !$input->user_id || !$input->progress) {
            return $this->send_json_output(false, $this->lang->line('toast_data_not_available'));
        }

        if (!$this->_is_printing_admin()) {
            $message = $this->lang->line('toast_error_not_authorized');
            return $this->send_json_output(false, $message);
        }

        if ($this->print_order->check_row_staff_percetakan($input->print_order_id, $input->user_id, $input->progress) > 0) {
            return $this->send_json_output(false, $this->lang->line('toast_data_duplicate'), 422);
        }

        if ($this->db->insert('print_order_user', $input)) {
            return $this->send_json_output(true, $this->lang->line('toast_add_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_add_fail'));
        }
    }

    public function api_delete_staff_percetakan($id = null)
    {
        $staff_percetakan = $this->db->where('print_order_user_id', $id)->get('print_order_user')->result();
        if (!$staff_percetakan) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        if (!$this->_is_printing_admin()) {
            $message = $this->lang->line('toast_error_not_authorized');
            return $this->send_json_output(false, $message);
        }

        if ($this->db->delete('print_order_user', ['print_order_user_id' => $id])) {
            return $this->send_json_output(true, $this->lang->line('toast_delete_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_delete_fail'));
        }
    }

    public function generate_excel($filters)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        if (!empty($filters['date_month']) && !empty($filters['date_year'])) {
            $filename = 'Order_Cetak_' . date('F', mktime(0, 0, 0, $filters['date_month'], 10)) . '_' . $filters['date_year'];
        } else if (!empty($filters['date_year'])) {
            $filename = 'Order_Cetak_' . $filters['date_year'];
        } else {
            $filename = 'Order_Cetak';
        }

        $get_data = $this->print_order->filter_excel($filters);
        $i = 2;
        $no = 1;
        // Column Content
        foreach ($get_data as $data) {
            foreach (range('A', 'Q') as $v) {
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
                            $value = date('d/m/Y H:i:s', strtotime($data->entry_date));
                            break;
                        }
                    case 'F': {
                            $value = date('d/m/Y H:i:s', strtotime($data->finish_date));
                            break;
                        }
                    case 'G': {
                            $value = $data->total;
                            break;
                        }
                    case 'H': {
                            $value = $data->total_new;
                            break;
                        }
                    case 'I': {
                            $staff = "";
                            $staff_percetakan   = $this->print_order->get_staff_percetakan_by_progress("preprint", $data->id);
                            foreach ($staff_percetakan as $val) {
                                $staff .= $val->username . ", ";
                            }
                            $value = $staff;
                            break;
                        }
                    case 'J': {
                            $value = date('d/m/Y H:i:s', strtotime($data->preprint_start_date));
                            break;
                        }
                    case 'K': {
                            $value = date('d/m/Y H:i:s', strtotime($data->preprint_end_date));
                            break;
                        }
                    case 'L': {
                            $staff = "";
                            $staff_percetakan   = $this->print_order->get_staff_percetakan_by_progress("print", $data->id);
                            foreach ($staff_percetakan as $val) {
                                $staff .= $val->username . ", ";
                            }
                            $value = $staff;
                            break;
                        }
                    case 'M': {
                            $value = date('d/m/Y H:i:s', strtotime($data->print_start_date));
                            break;
                        }
                    case 'N': {
                            $value = date('d/m/Y H:i:s', strtotime($data->print_end_date));
                            break;
                        }
                    case 'O': {
                            $staff = "";
                            $staff_percetakan   = $this->print_order->get_staff_percetakan_by_progress("postprint", $data->id);
                            foreach ($staff_percetakan as $val) {
                                $staff .= $val->username . ", ";
                            }
                            $value = $staff;
                            break;
                        }
                    case 'P': {
                            $value = date('d/m/Y H:i:s', strtotime($data->postprint_start_date));
                            break;
                        }
                    case 'Q': {
                            $value = date('d/m/Y H:i:s', strtotime($data->postprint_end_date));
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
        $sheet->setCellValue('G1', 'Jumlah Pesanan');
        $sheet->setCellValue('H1', 'Jumlah Hasil Cetak');
        $sheet->setCellValue('I1', 'PIC Pracetak');
        $sheet->setCellValue('J1', 'Tanggal Mulai Pracetak');
        $sheet->setCellValue('K1', 'Tanggal Selesai Pracetak');
        $sheet->setCellValue('L1', 'PIC Cetak');
        $sheet->setCellValue('M1', 'Tanggal Mulai Cetak');
        $sheet->setCellValue('N1', 'Tanggal Selesai Cetak');
        $sheet->setCellValue('O1', 'PIC Jilid');
        $sheet->setCellValue('P1', 'Tanggal Mulai Jilid');
        $sheet->setCellValue('Q1', 'Tanggal Selesai Jilid');
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

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        die();
    }

    public function generate_pdf($print_order_id, $progress)
    {
        $print_order        = $this->print_order->get_print_order($print_order_id);
        $staff_percetakan   = $this->print_order->get_staff_percetakan_by_progress($progress, $print_order_id);
        $staff = '';
        foreach ($staff_percetakan as $val) {
            $staff .= $val->username . ", ";
        }
        // PDF
        $this->load->library('pdf');

        // FORMAT DATA
        if ($progress == 'preprint') {
            $data_format['jobtype'] = 'Pracetak';
            if ($print_order->location_binding == 'inside') {
                $data_format['finishing'] = 'Internal';
                // $data_format['finishinglocation'] = '';
            } elseif ($print_order->location_binding == 'outside') {
                $data_format['finishing'] = 'External';
                // $data_format['finishinglocation'] = $print_order->location_binding_outside;
            } else {
                $data_format['finishing'] = 'Parsial';
                // $data_format['finishinglocation'] = $print_order->location_binding_outside;
            }
        } elseif ($progress == 'print') {
            $data_format['jobtype'] = 'Cetak';
            if ($print_order->location_binding == 'inside') {
                $data_format['finishing'] = 'Internal';
                // $data_format['finishinglocation'] = '';
            } elseif ($print_order->location_binding == 'outside') {
                $data_format['finishing'] = 'External';
                // $data_format['finishinglocation'] = $print_order->location_binding_outside;
            } else {
                $data_format['finishing'] = 'Parsial';
                // $data_format['finishinglocation'] = $print_order->location_binding_outside;
            }
        } elseif ($progress == 'postprint') {
            $data_format['jobtype'] = 'Jilid';
            if ($print_order->location_binding == 'inside') {
                $data_format['finishing'] = 'Internal';
                // $data_format['finishinglocation'] = '';
            } elseif ($print_order->location_binding == 'outside') {
                $data_format['finishing'] = 'External';
                // $data_format['finishinglocation'] = $print_order->location_binding_outside;
            } else {
                $data_format['finishing'] = 'Parsial';
                // $data_format['finishinglocation'] = $print_order->location_binding_outside;
            }
        } else {
            $data_format['jobtype'] = '';
            $data_format['finishing'] = '';
            $data_format['finishinglocation'] = '';
        }
        $data_format['title'] = $print_order->title ?? '';
        $data_format['category'] = get_print_order_category()[$print_order->category] ?? '';
        $data_format['ordernumber'] = $print_order->order_number ?? '';
        $data_format['total'] = $print_order->total ?? '';
        $data_format['entrydate'] = date('d/m/Y', strtotime($print_order->entry_date)) ?? '';
        $data_format['deadline'] = date('d/m/Y', strtotime($print_order->{"{$progress}_deadline"})) ?? '';
        $data_format['staff'] = $staff;
        $data_format['notes'] = $print_order->{"{$progress}_notes"} ?? '';
        $format = $this->load->view('print_order/format_pdf', $data_format, true);
        $this->pdf->loadHtml($format);

        // (Optional) Setup the paper size and orientation
        $this->pdf->set_paper('A4', 'potrait');

        // Render the HTML as PDF
        $this->pdf->render();
        $this->pdf->stream(strtolower($data_format['ordernumber'] . '_' . $data_format['jobtype']));
    }

    public function add_additional_notes($print_order_id)
    {
        if (!$this->_is_printing_admin()) {
            redirect($this->pages);
        }

        if ($this->print_order->where('print_order_id', $print_order_id)->update(['additional_notes' => $_POST['additional_notes']])) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        }

        redirect('print_order/view/' . $print_order_id);
    }

    public function download_book_file($file_name)
    {
        if (!$this->_is_print_order_user()) {
            redirect($this->pages);
        }

        $folder = "bookfile";
        $file = realpath($folder) . "/" . $file_name;
        if (file_exists($file)) {
            $data = file_get_contents($file);
            force_download($file_name, $data);
        } else {
            echo $this->lang->line('toast_error_file_not_found');
            // $this->session->set_flashdata('warning', $this->lang->line('toast_error_file_not_found'));
            // redirect($redirect ?? $this->pages);
        }
    }

    private function _generate_print_order_file_name($print_order_file_name, $print_order_title, $progress = null)
    {
        $get_extension = explode(".", $print_order_file_name)[1];
        if ($progress) {
            return str_replace(" ", "_", $print_order_title . '_' . $progress . '_' . date('YmdHis') . '.' . $get_extension); // progress file name
        } else {
            return str_replace(" ", "_", $print_order_title . '_' . date('YmdHis') . '.' . $get_extension); // draft file name
        }
    }

    private function _is_print_order_user()
    {
        if ($this->level == 'superadmin' || $this->level == 'admin_percetakan' || $this->level == 'staff_percetakan') {
            return true;
        } else {
            $this->session->set_flashdata('error', 'Hanya admin percetakan dan superadmin yang dapat mengakses.');
            return false;
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
            return false;
            // redirect(base_url(), 'refresh');
        }
    }

    private function _generate_file_name($file_name)
    {
        $split_filename = explode(".", $file_name);
        return str_replace(" ", "_", 'Print_order_' . $split_filename[0] . '_' . date('YmdHis') . '.' . $split_filename[1]); // print_order file name
    }
}

/* End of file Print_order.php */
