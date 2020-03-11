<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // jika sudah punya sesi, tidak bisa ke halaman login
        if ($this->is_login) {
            $this->session->set_flashdata('success', "You are logged in");
            redirect();
        }

        if (!$_POST) {
            $input = (object) $this->login->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->login->validate()) {
            $this->load->view('login_form', compact('input'));
            return;
        }

        if ($this->login->login($input)) {
            if ($this->level == 'author_reviewer') {
                redirect('login/multilevel/');
            } else {
                redirect();
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('form_login_error_cannot_login'));
        }

        redirect('login');
    }

    public function logout()
    {
        $this->login->logout();
        redirect();
    }

    public function multilevel($sesi = '')
    {
        if ($this->session->userdata('level_asli') == 'author_reviewer') {
            if (!$sesi) {
                $this->load->view('multilevel');
            } else {
                $cekuserid = $this->session->userdata('user_id');
                $role_id   = $this->login->get_role_id_from_user_id($cekuserid, $sesi);
                if ($sesi == 'author') {
                    $data = [
                        'level'   => $sesi,
                        'role_id' => $role_id,
                    ];
                    $this->session->set_userdata($data);
                    redirect('home');
                }
                if ($sesi == 'reviewer') {
                    $data = [
                        'level'   => $sesi,
                        'role_id' => $role_id,
                    ];
                    $this->session->set_userdata($data);
                    redirect('home');
                }
            }
        } else {
            redirect('home');
        }
    }
}