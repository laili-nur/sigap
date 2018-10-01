<?php
class Operator_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->username = $this->session->userdata('username');
        $this->level    = $this->session->userdata('level');
        $this->is_login = $this->session->userdata('is_login');
        $this->user_id = $this->session->userdata('user_id');


        if (!$this->is_login) {
            redirect(base_url());
            return;
        }
    }
}
