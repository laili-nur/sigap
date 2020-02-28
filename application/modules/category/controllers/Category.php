<?php defined('BASEPATH') or exit('No direct script access allowed');

class Category extends Operator_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'category';

        // akses khusus admin
        check_if_admin();

        // load modules model
        $this->load->model('Category_model', 'category');
    }

    public function index($page = null)
    {
        $cat = $this->category->order_by('category_name')->order_by('date_close', 'desc')->get_all();

        $categories = array_map(function ($v) {
            $v->sisa_waktu_buka  = ceil((strtotime($v->date_open) - strtotime(date('Y-m-d H:i:s'))) / 86400);
            $v->sisa_waktu_tutup = ceil((strtotime($v->date_close) - strtotime(date('Y-m-d H:i:s'))) / 86400);

            return $v;
        }, $cat);

        $total     = count($categories);
        $pages     = $this->pages;
        $main_view = 'category/index_category';
        $this->load->view('template', compact('pages', 'main_view', 'categories', 'total'));
    }

    public function add()
    {
        if (!$_POST) {
            $input = (object) $this->category->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->category->validate()) {
            $pages       = $this->pages;
            $main_view   = 'category/form_category';
            $form_action = 'category/add';

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->category->insert($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
        }

        redirect('category');
    }

    public function edit($id = null)
    {
        $category = $this->category->where('category_id', $id)->get();
        if (!$this) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect('category');
        }

        if (!$_POST) {
            $input = (object) $category;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->category->validate()) {
            $pages       = $this->pages;
            $main_view   = 'category/form_category';
            $form_action = "category/edit/$id";

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->category->where('category_id', $id)->update($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        }

        redirect('category');
    }

    public function delete($id = null)
    {
        $category = $this->category->where('category_id', $id)->get();
        if (!$category) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect('category');
        }

        if ($this->category->where('category_id', $id)->delete()) {
            $this->session->set_flashdata('success', $this->lang->line('toast_delete_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_delete_fail'));
        }

        redirect('category');
    }

    // validasi format nama
    // public function alpha_numeric_coma_dash_dot_space($str)
    // {
    //    if ( !preg_match('/^[a-zA-Z0-9 .,\-]+$/i',$str) )
    //    {
    //        $this->form_validation->set_message('alpha_numeric_coma_dash_dot_space', 'Can only be filled with letters, numbers, dash(-), dot(.), and comma(,).');
    //        return false;
    //    }
    // }

    // validasi nama unik
    public function unique_category_name()
    {
        $category_name = $this->input->post('category_name');
        $category_id   = $this->input->post('category_id');

        $this->category->where('category_name', $category_name);
        !$category_id || $this->category->where('category_id !=', $category_id);
        $category = $this->category->get();

        if ($category) {
            $this->form_validation->set_message('unique_category_name', $this->lang->line('toast_data_duplicate'));
            return false;
        }

        return true;
    }

    // validasi format tanggal
    public function is_date_format_valid($str)
    {
        if (!preg_match('/([0-9]{4})-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/', $str)) {
            $this->form_validation->set_message('is_date_format_valid', $this->lang->line('toast_data_date_invalid') . ' Format (yyyy-mm-dd)');
            return false;
        }

        return true;
    }

    // validasi cek tanggal
    public function check_date()
    {
        $date_close = $this->input->post('date_close');
        $date_open  = $this->input->post('date_open');

        $dateTimestamp1 = strtotime($date_close);
        $dateTimestamp2 = strtotime($date_open);

        if ($dateTimestamp1 < $dateTimestamp2) {
            $this->form_validation->set_message('check_date', $this->lang->line('form_category_error_date_invalid'));
            return false;
        }
        return true;
    }
}