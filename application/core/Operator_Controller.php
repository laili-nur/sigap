<?php
class Operator_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $username = $this->session->userdata('username');
        $level    = $this->session->userdata('level');
        $is_login = $this->session->userdata('is_login');

        if (!$is_login) {
            redirect(base_url());
            return;
        }
    }
}
