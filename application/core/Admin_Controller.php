<?php
class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->username   = $this->session->userdata('username');
        $this->level      = $this->session->userdata('level');
        $this->level_asli = $this->session->userdata('level_asli');
        $this->is_login   = $this->session->userdata('is_login');
        $this->user_id    = $this->session->userdata('user_id');
        $this->role_id    = $this->session->userdata('role_id');

        if (!$this->is_login) {
            redirect('login');
        }

        if ($this->level === 'author' || $this->level === 'reviewer' || $this->level === 'editor' || $this->level === 'layouter') {
            redirect('');
        }
    }
}