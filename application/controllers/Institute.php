<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Institute extends Operator_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->pages = 'institute';
    }
//--index--
	public function index($page = null)
	{
        $institutes     = $this->institute->orderBy('institute_id')->getAll();
        $total    = count($institutes);
        $pages    = $this->pages;
        $main_view  = 'institute/index_institute';
		$this->load->view('template', compact('pages', 'main_view', 'institutes', 'total'));
	}
        
//--add--
        public function add()
	{                     
        if (!$_POST) {
            $input = (object) $this->institute->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->institute->validate()) {
            $pages   = $this->pages;
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
        
//--edit--        
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
            $pages     = $this->pages;
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
        
//--delete--        
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
    
        public function unique_institute_name()
    {
        $institute_name = $this->input->post('institute_name');
        $institute_id   = $this->input->post('institute_id');

        $this->institute->where('institute_name', $institute_name);
        !$institute_id || $this->institute->where('institute_id !=', $institute_id);
        $institute = $this->institute->get();

        if (count($institute)) {
            $this->form_validation->set_message('unique_institute_name', '%s has been used');
            return false;
        }
        return true;
    }
}