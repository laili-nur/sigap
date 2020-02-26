<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Work_unit extends Operator_Controller {

    public function __construct() {
        parent::__construct();
        $this->pages = 'work_unit';
        //khusus admin
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel == 'author' || $ceklevel == 'reviewer' || $ceklevel == 'editor' || $ceklevel == 'layouter') {
            redirect('home');
        }
    }

    public function index($page = null) {
        $work_units = $this->work_unit->orderBy('work_unit_name')->getAll();
        $total = count($work_units);
        $pages = $this->pages;
        $main_view = 'workunit/index_work_unit';
        $this->load->view('template', compact('pages', 'main_view', 'work_units', 'total'));
    }

    public function add() {
        if (!$_POST) {
            $input = (object)$this->work_unit->getDefaultValues();
        } else {
            $input = (object)$this->input->post(null, true);
        }
        if (!$this->work_unit->validate()) {
            $pages = $this->pages;
            $main_view = 'workunit/form_work_unit';
            $form_action = 'work_unit/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->work_unit->insert($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }
        redirect('workunit');
    }

    public function edit($id = null) {
        $work_unit = $this->work_unit->where('work_unit_id', $id)->get();
        if (!$this) {
            $this->session->set_flashdata('warning', 'Work Unit data were not available');
            redirect('workunit');
        }
        if (!$_POST) {
            $input = (object)$work_unit;
        } else {
            $input = (object)$this->input->post(null, true);
        }
        if (!$this->work_unit->validate()) {
            $pages = $this->pages;
            $main_view = 'workunit/form_work_unit';
            $form_action = "work_unit/edit/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->work_unit->where('work_unit_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }
        redirect('workunit');
    }

    public function delete($id = null) {
        $code = $this->work_unit->where('work_unit_id', $id)->get();
        if (!$code) {
            $this->session->set_flashdata('warning', 'Work Unit data were not available');
            redirect('workunit');
        }
        if ($this->work_unit->where('work_unit_id', $id)->delete()) {
            $this->session->set_flashdata('success', 'Data deleted');
        } else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }
        redirect('workunit');
    }
   
    public function unique_work_unit_name() {
        $work_unit_name = $this->input->post('work_unit_name');
        $work_unit_id = $this->input->post('work_unit_id');
        $this->work_unit->where('work_unit_name', $work_unit_name);
        !$work_unit_id || $this->work_unit->where('work_unit_id !=', $work_unit_id);
        $work_unit = $this->work_unit->get();
        if (count($work_unit)) {
            $this->form_validation->set_message('unique_work_unit_name', '%s has been used');
            return false;
        }
        return true;
    }
}
