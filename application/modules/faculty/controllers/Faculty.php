<?php defined('BASEPATH') or exit('No direct script access allowed');
class Faculty extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'faculty';

        $this->load->model('Faculty_model', 'faculty');
    }

    public function index($page = null)
    {
        $faculties = $this->faculty->order_by('faculty_name')->get_all();
        $total     = count($faculties);
        $pages     = $this->pages;
        $main_view = 'faculty/index_faculty';
        $this->load->view('template', compact('pages', 'main_view', 'faculties', 'total'));
    }

    public function add()
    {
        if (!$_POST) {
            $input = (object) $this->faculty->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);
        }
        if (!$this->faculty->validate()) {
            $pages       = $this->pages;
            $main_view   = 'faculty/form_faculty';
            $form_action = 'faculty/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->faculty->insert($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
        }

        redirect($this->pages);
    }

    public function edit($id = null)
    {
        $faculty = $this->faculty->where('faculty_id', $id)->get();
        if (!$this) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }
        if (!$_POST) {
            $input = (object) $faculty;
        } else {
            $input = (object) $this->input->post(null, true);
        }
        if (!$this->faculty->validate()) {
            $pages       = $this->pages;
            $main_view   = 'faculty/form_faculty';
            $form_action = "faculty/edit/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->faculty->where('faculty_id', $id)->update($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        }

        redirect($this->pages);
    }

    public function delete($id = null)
    {
        $faculty = $this->faculty->where('faculty_id', $id)->get();
        if (!$faculty) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }
        if ($this->faculty->where('faculty_id', $id)->delete()) {
            $this->session->set_flashdata('success', $this->lang->line('toast_delete_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_delete_fail'));
        }

        redirect($this->pages);
    }

    public function unique_faculty_name($faculty_name)
    {
        $faculty_id = $this->input->post('faculty_id');
        $this->faculty->where('faculty_name', $faculty_name);
        !$faculty_id || $this->faculty->where_not('faculty_id', $faculty_id);
        $faculty = $this->faculty->get();
        if ($faculty) {
            $this->form_validation->set_message('unique_faculty_name', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }
}