<?php defined('BASEPATH') or exit('No direct script access allowed');
class Institute extends Operator_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'institute';
        //khusus admin
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel == 'author' || $ceklevel == 'reviewer' || $ceklevel == 'editor' || $ceklevel == 'layouter') {
            redirect('home');
        }
    }

    public function index($page = null)
    {
        $institutes = $this->institute->orderBy('institute_name')->getAll();
        $total      = count($institutes);
        $pages      = $this->pages;
        $main_view  = 'institute/index_institute';
        $this->load->view('template', compact('pages', 'main_view', 'institutes', 'total'));
    }

    public function add()
    {
        if (!$_POST) {
            $input = (object) $this->institute->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }
        if (!$this->institute->validate()) {
            $pages       = $this->pages;
            $main_view   = 'institute/form_institute';
            $form_action = 'institute/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->institute->insert($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }
        redirect('institute');
    }

    public function edit($id = null)
    {
        $institute = $this->institute->where('institute_id', $id)->get();
        if (!$this) {
            $this->session->set_flashdata('warning', 'Institute data were not available');
            redirect('institute');
        }
        if (!$_POST) {
            $input = (object) $institute;
        } else {
            $input = (object) $this->input->post(null, true);
        }
        if (!$this->institute->validate()) {
            $pages       = $this->pages;
            $main_view   = 'institute/form_institute';
            $form_action = "institute/edit/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->institute->where('institute_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }
        redirect('institute');
    }

    public function delete($id = null)
    {
        $institute = $this->institute->where('institute_id', $id)->get();
        if (!$institute) {
            $this->session->set_flashdata('warning', 'Institute data were not available');
            redirect('institute');
        }
        if ($this->institute->where('institute_id', $id)->delete()) {
            $this->session->set_flashdata('success', 'Data deleted');
        } else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }
        redirect('institute');
    }

    public function unique_institute_name()
    {
        $institute_name = $this->input->post('institute_name');
        $institute_id   = $this->input->post('institute_id');
        $this->institute->where('institute_name', $institute_name);
        !$institute_id || $this->institute->where('institute_id !=', $institute_id);
        $institute = $this->institute->get();
        if ($institute) {
            $this->form_validation->set_message('unique_institute_name', '%s has been used');
            return false;
        }
        return true;
    }
}