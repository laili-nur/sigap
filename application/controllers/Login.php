<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login extends MY_Controller
{
    public function index()
    {
        //jika sudah punya sesi, tidak bisa ke halaman login
        $ceklogin = $this->session->userdata('is_login');
        if ($ceklogin) {
            redirect(base_url('home'));
        }
        if (!$_POST) {
            $input = (object) $this->login->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->login->validate()) {
            $this->load->view('login_form', compact('input'));
            return;
        }

        if ($this->login->login($input)) {
            $ceklevel = $this->session->userdata('level');
            if ($ceklevel == 'author_reviewer') {
                redirect('login/multilevel/');
            } else {
                redirect(base_url());
            }
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah, atau akun anda sedang diblokir.');
        }

        redirect('login');
    }

    public function logout()
    {
        $this->login->logout();
        redirect(base_url());
    }

    public function multilevel($sesi = '')
    {
        if ($this->session->userdata('level_asli') == 'author_reviewer') {
            if (!$sesi) {
                $this->load->view('multilevel');
            } else {
                $cekuserid = $this->session->userdata('user_id');
                $role_id   = $this->login->get_id_role_from_user_id($cekuserid, $sesi);
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
