<?php defined('BASEPATH') or exit('No direct script access allowed');
class Theme extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'theme';

        // load modules model
        $this->load->model('Theme_model', 'theme');
    }

    public function index($page = null)
    {
        $themes    = $this->theme->order_by('theme_name')->get_all();
        $total     = count($themes);
        $pages     = $this->pages;
        $main_view = 'theme/index_theme';
        $this->load->view('template', compact('pages', 'main_view', 'themes', 'total'));
    }

    public function add()
    {
        if (!$_POST) {
            $input = (object) $this->theme->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);
        }
        if (!$this->theme->validate()) {
            $pages       = $this->pages;
            $main_view   = 'theme/form_theme';
            $form_action = 'theme/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->theme->insert($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
        }

        redirect($this->pages);
    }

    public function edit($id = null)
    {
        $theme = $this->theme->where('theme_id', $id)->get();
        if (!$this) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }
        if (!$_POST) {
            $input = (object) $theme;
        } else {
            $input = (object) $this->input->post(null, true);
        }
        if (!$this->theme->validate()) {
            $pages       = $this->pages;
            $main_view   = 'theme/form_theme';
            $form_action = "theme/edit/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->theme->where('theme_id', $id)->update($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        }

        redirect($this->pages);
    }

    public function delete($id = null)
    {
        $theme = $this->theme->where('theme_id', $id)->get();
        if (!$theme) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }
        if ($this->theme->where('theme_id', $id)->delete()) {
            $this->session->set_flashdata('success', $this->lang->line('toast_delete_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_delete_fail'));
        }

        redirect($this->pages);
    }

    public function unique_theme_name($theme_name)
    {
        $theme_id = $this->input->post('theme_id');
        $this->theme->where('theme_name', $theme_name);
        !$theme_id || $this->theme->where_not('theme_id', $theme_id);
        $theme = $this->theme->get();
        if ($theme) {
            $this->form_validation->set_message('unique_theme_name', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }
}