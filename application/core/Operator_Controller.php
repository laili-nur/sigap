<?php
class Operator_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->username = $this->session->userdata('username');
        $this->level    = $this->session->userdata('level');
        $this->level_asli    = $this->session->userdata('level_asli');
        $this->is_login = $this->session->userdata('is_login');
        $this->user_id = $this->session->userdata('user_id');
        $this->role_id = $this->session->userdata('role_id');


        if (!$this->is_login) {
            redirect(base_url('login'));
            return;
        }

        //jika belum milih level,gabisa masuk sistem
        if ($this->level == 'author_reviewer') {
            redirect(base_url('login/multilevel'));
        }
    }
}
