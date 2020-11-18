<?php
class Printing_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->is_login) {
            redirect('auth');
        }

        if (!is_admin() && $_SESSION['level'] == "admin_percetakan" && $_SESSION['level'] == "staff_percetakan") {
            $this->session->set_flashdata('error', $this->lang->line('toast_error_not_authorized'));
            redirect();
        }
    }
}
