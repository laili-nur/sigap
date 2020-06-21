<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'auth';
    }

    public function index()
    {
        // jika sudah punya sesi, tidak bisa ke halaman login
        if ($this->is_login) {
            $this->session->set_flashdata('success', "You are logged in");
            redirect();
        }

        if (!$_POST) {
            $input = (object) $this->auth->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->auth->validate()) {
            $this->load->view('login_form', compact('input'));
            return;
        }

        if ($this->auth->login($input)) {
            if ($this->level == 'author_reviewer') {
                redirect('auth/multilevel/');
            } else {
                redirect();
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('form_login_error_cannot_login'));
        }

        redirect('auth');
    }

    public function logout()
    {
        $this->auth->logout();
        redirect();
    }

    public function multilevel($sesi = '')
    {
        if ($this->session->userdata('level_native') == 'author_reviewer') {
            if (!$sesi) {
                $this->load->view('multilevel');
            } else {
                $cekuserid = $this->session->userdata('user_id');
                $role_id   = $this->auth->get_role_id_from_user_id($cekuserid, $sesi);
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

    public function change_password()
    {
        $user = $this->auth->where('user_id', $this->user_id)->get();
        if (!$user) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect();
        }

        if (!$_POST) {
            $input           = (object) $user;
            $input->password = null;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        // custom validation for change password only
        $validation_state = $this->auth->validate([
            [
                'field' => 'password',
                'label' => 'Password lama',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'new_password',
                'label' => 'Password baru',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Konfirmasi password baru',
                'rules' => 'trim|required',
            ]
        ]);

        if (!$validation_state) {
            $pages       = $this->pages;
            $main_view   = 'auth/form_change_password';
            $form_action = "auth/change_password";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if (!$input->password || !$input->new_password || !$input->confirm_password) {
            $this->session->set_flashdata('error', 'Kolom password tidak boleh kosong');
            redirect('auth/change_password');
        }

        $input->password         = md5($input->password);
        $input->new_password     = md5($input->new_password);
        $input->confirm_password = md5($input->confirm_password);

        if ($input->password === $user->password) {
            // jika password lama benar
            if ($input->password != $input->new_password) {
                // jika password baru, beda dari password lama
                if ($input->new_password === $input->confirm_password) {
                    // jika konfirmasi password sesuai
                    $input->password = $input->new_password;
                } else {
                    $this->session->set_flashdata('error', 'Konfirmasi password tidak sesuai');
                    redirect('auth/change_password');
                }
            } else {
                $this->session->set_flashdata('error', 'Password baru harus berbeda dari password lama');
                redirect('auth/change_password');
            }
        } else {
            $this->session->set_flashdata('error', 'Password lama tidak sesuai');
            redirect('auth/change_password');
        }

        unset($input->new_password);
        unset($input->confirm_password);

        if ($this->auth->where('user_id', $this->user_id)->update($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        }

        redirect('auth/change_password');
    }

    public function change_email()
    {
        $user = $this->auth->where('user_id', $this->user_id)->get();
        if (!$user) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect();
        }

        if (!$_POST) {
            $input = (object) $user;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        // custom validation for change email only
        $validation_state = $this->auth->validate([
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email|callback_unique_data[email]',
            ],
        ]);

        if (!$validation_state) {
            $pages       = $this->pages;
            $main_view   = 'auth/form_change_email';
            $form_action = "auth/change_email";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->auth->where('user_id', $this->user_id)->update($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        }

        redirect('auth/change_email');
    }

    public function unique_data($str, $data_key)
    {
        $author_id = $this->input->post('user_id');
        if (!$str) {
            return true;
        }
        $this->auth->where($data_key, $str);
        !$author_id || $this->auth->where_not('user_id', $author_id);
        $user = $this->auth->get();
        if ($user) {
            $this->form_validation->set_message('unique_data', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }
}
