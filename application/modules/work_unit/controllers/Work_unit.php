<?php defined('BASEPATH') or exit('No direct script access allowed');
class Work_unit extends Operator_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'work_unit';

        // akses khusus admin
        check_if_admin();

        $this->load->model('Work_unit_model', 'work_unit');
    }

    public function index($page = null)
    {
        $work_units = $this->work_unit->order_by('work_unit_name')->get_all();
        $total      = count($work_units);
        $pages      = $this->pages;
        $main_view  = 'work_unit/index_work_unit';
        $this->load->view('template', compact('pages', 'main_view', 'work_units', 'total'));
    }

    public function add()
    {
        if (!$_POST) {
            $input = (object) $this->work_unit->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);
        }
        if (!$this->work_unit->validate()) {
            $pages       = $this->pages;
            $main_view   = 'work_unit/form_work_unit';
            $form_action = 'work_unit/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->work_unit->insert($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
        }

        redirect('workunit');
    }

    public function edit($id = null)
    {
        $work_unit = $this->work_unit->where('work_unit_id', $id)->get();
        if (!$this) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect('workunit');
        }
        if (!$_POST) {
            $input = (object) $work_unit;
        } else {
            $input = (object) $this->input->post(null, true);
        }
        if (!$this->work_unit->validate()) {
            $pages       = $this->pages;
            $main_view   = 'work_unit/form_work_unit';
            $form_action = "work_unit/edit/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->work_unit->where('work_unit_id', $id)->update($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        }

        redirect('workunit');
    }

    public function delete($id = null)
    {
        $code = $this->work_unit->where('work_unit_id', $id)->get();
        if (!$code) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect('workunit');
        }
        if ($this->work_unit->where('work_unit_id', $id)->delete()) {
            $this->session->set_flashdata('success', $this->lang->line('toast_delete_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_delete_fail'));
        }

        redirect('workunit');
    }

    public function unique_work_unit_name()
    {
        $work_unit_name = $this->input->post('work_unit_name');
        $work_unit_id   = $this->input->post('work_unit_id');
        $this->work_unit->where('work_unit_name', $work_unit_name);
        !$work_unit_id || $this->work_unit->where('work_unit_id !=', $work_unit_id);
        $work_unit = $this->work_unit->get();
        if ($work_unit) {
            $this->form_validation->set_message('unique_work_unit_name', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }
}