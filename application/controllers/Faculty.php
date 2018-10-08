<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends Operator_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->pages = 'faculty';
    }
//--index--
	public function index($page = null)
	{
        $faculties     = $this->faculty->orderBy('faculty_id')->getAll();
        $total    = count($faculties);
        $pages    = $this->pages;
        $main_view  = 'faculty/index_faculty';
		$this->load->view('template', compact('pages', 'main_view', 'faculties', 'total'));
	}
        
//--add--
        public function add()
	{                   
            $ceklevel = $this->session->userdata('level');
            if ($ceklevel == 'admin_penerbitan' || $ceklevel == 'superadmin'){
        if (!$_POST) {
            $input = (object) $this->faculty->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->faculty->validate()) {
            $pages   = $this->pages;
            $main_view   = 'faculty/form_faculty';
            $form_action = 'faculty/add';

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->faculty->insert($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }

        redirect('faculty');
        }
        else{
            redirect('faculty');
        }
	}
        
//--edit--        
        public function edit($id = null)
	{
            $ceklevel = $this->session->userdata('level');
            if ($ceklevel == 'admin_penerbitan' || $ceklevel == 'superadmin'){
        
        $faculty = $this->faculty->where('faculty_id', $id)->get();
        if (!$this) {
            $this->session->set_flashdata('warning', 'Faculty data were not available');
            redirect('faculty');
        }

        if (!$_POST) {
            $input = (object) $faculty;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->faculty->validate()) {
            $pages     = $this->pages;
            $main_view   = 'faculty/form_faculty';
            $form_action = "faculty/edit/$id";

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->faculty->where('faculty_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }

        redirect('faculty');
        }
        else{
            redirect('faculty');
        }
	}
        
//--delete--        
        	public function delete($id = null)
	{
                    $ceklevel = $this->session->userdata('level');
            if ($ceklevel == 'admin_penerbitan' || $ceklevel == 'superadmin'){
                
		$faculty = $this->faculty->where('faculty_id', $id)->get();
        if (!$faculty) {
            $this->session->set_flashdata('warning', 'Faculty data were not available');
            redirect('faculty');
        }

        if ($this->faculty->where('faculty_id', $id)->delete()) {
            $this->session->set_flashdata('success', 'Data deleted');
        } else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }

        redirect('faculty');
        }
        else{
            redirect('faculty');
        }
	}
        

    /*
    |-----------------------------------------------------------------
    | Callback
    |-----------------------------------------------------------------
    */        
        

//            public function alpha_numeric_coma_dash_dot_space($str)
//    {
//        if ( !preg_match('/^[a-zA-Z0-9 .,\-]+$/i',$str) )
//        {
//            $this->form_validation->set_message('alpha_numeric_coma_dash_dot_space', 'Can only be filled with letters, numbers, dash(-), dot(.), and comma(,).');
//            return false;
//        }
//    }
    
        public function unique_faculty_name()
    {
        $faculty_name = $this->input->post('faculty_name');
        $faculty_id   = $this->input->post('faculty_id');

        $this->faculty->where('faculty_name', $faculty_name);
        !$faculty_id || $this->faculty->where('faculty_id !=', $faculty_id);
        $faculty = $this->faculty->get();

        if (count($faculty)) {
            $this->form_validation->set_message('unique_faculty_name', '%s has been used');
            return false;
        }
        return true;
    }
}