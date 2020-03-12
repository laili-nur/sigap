<?php
class Operator_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->is_login) {
            redirect('auth');
        }

        // jika belum milih level,gabisa masuk sistem
        if ($this->level == 'author_reviewer') {
            redirect('auth/multilevel');
        }
    }
}