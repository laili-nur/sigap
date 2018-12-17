<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends Admin_Controller
{

	public function __construct()
    {
        parent::__construct();
        $this->pages = 'setting';
    }

	public function index()
    {   
        redirect('setting/edit');
    }
  
    public function edit()
	{
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel != 'superadmin'){
            redirect('home');
        }
            
        $setting = $this->setting->get();
        if (!$setting) {
            //redirect('404');
        }

        if (!$_POST) {
            $input = (object) $setting;
        } else {
            $input = (object) $this->input->post(null, false);
        }

        if (!$this->setting->validate()) {
            $pages    = $this->pages;
            $main_view   = 'setting/form_setting';
            $form_action = "setting/edit";

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
         unset($input->files);

        if ($this->setting->update($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }

        redirect('setting/edit');
	}        

}