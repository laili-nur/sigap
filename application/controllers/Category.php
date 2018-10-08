<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Operator_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->pages = 'category';
    }
//--index--
	public function index($page = null)
	{
        $categories     = $this->category->orderBy('category_id')->getAll();
        $total    = count($categories);
        $pages    = $this->pages;
        $main_view  = 'category/index_category';
		$this->load->view('template', compact('pages', 'main_view', 'categories', 'total'));
	}
        
//--add--
        public function add()
	{       
            $ceklevel = $this->session->userdata('level');
            if ($ceklevel == 'admin_penerbitan' || $ceklevel == 'superadmin'){
        if (!$_POST) {
            $input = (object) $this->category->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->category->validate()) {
            $pages   = $this->pages;
            $main_view   = 'category/form_category';
            $form_action = 'category/add';

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->category->insert($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }

        redirect('category');
            }
            else{
                redirect('category');
            }
	}
        
//--edit--        
        public function edit($id = null)
	{
            $ceklevel = $this->session->userdata('level');
            if ($ceklevel == 'admin_penerbitan' || $ceklevel == 'superadmin'){
        $category = $this->category->where('category_id', $id)->get();
        if (!$this) {
            $this->session->set_flashdata('warning', 'Category data were not available');
            redirect('category');
        }

        if (!$_POST) {
            $input = (object) $category;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->category->validate()) {
            $pages     = $this->pages;
            $main_view   = 'category/form_category';
            $form_action = "category/edit/$id";

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->category->where('category_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }

        redirect('category');
            }
            else{
                redirect('category');
            }
	}
        
//--delete--        
        	public function delete($id = null)
	{
                    $ceklevel = $this->session->userdata('level');
            if ($ceklevel == 'admin_penerbitan' || $ceklevel == 'superadmin'){
		$category = $this->category->where('category_id', $id)->get();
        if (!$category) {
            $this->session->set_flashdata('warning', 'Category data were not available');
            redirect('category');
        }

        if ($this->category->where('category_id', $id)->delete()) {
            $this->session->set_flashdata('success', 'Data deleted');
        } else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }

        redirect('category');
            }
            else{
                redirect('category');
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
    
        public function unique_category_name()
    {
        $category_name = $this->input->post('category_name');
        $category_id   = $this->input->post('category_id');

        $this->category->where('category_name', $category_name);
        !$category_id || $this->category->where('category_id !=', $category_id);
        $category = $this->category->get();

        if (count($category)) {
            $this->form_validation->set_message('unique_category_name', '%s has been used');
            return false;
        }
        return true;
    }
    
        public function is_date_format_valid($str)
    {
        if(!preg_match('/([0-9]{4})-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/', $str)) {
                //if(!preg_match('/(0[1-9]|1[0-9]|2[0-9]|3[01]-([0-9]{4})-(0[1-9]|1[012]))/', $str)) {    
            $this->form_validation->set_message('is_date_format_valid', 'Invalid date format (yyyy-mm-dd)');
            return FALSE;
        }

        return TRUE;
    }
    
        public function check_date()
    {
        $date_close = $this->input->post('date_close');
        $date_open   = $this->input->post('date_open');
        
        $dateTimestamp1 = strtotime($date_close);
        $dateTimestamp2 = strtotime($date_open);
        
        if($dateTimestamp1 < $dateTimestamp2){
            $this->form_validation->set_message('check_date', 'Date close can not be before date open');   
            return FALSE;
        }
        return TRUE;
    }
}