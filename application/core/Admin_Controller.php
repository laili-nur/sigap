<?php
class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->is_login) {
            redirect('login');
        }

        if (!is_admin()) {
            $this->session->set_flashdata('error', $this->lang->line('toast_error_not_authorized'));
            redirect();
        }
    }
}