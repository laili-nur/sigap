<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends MY_Model
{
    public $table = 'user';

    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'username',
                'label' => $this->lang->line('form_user_name'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'password',
                'label' => $this->lang->line('form_user_password'),
                'rules' => 'required',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'username' => null,
            'password' => null,
        ];
    }

    public function login($input)
    {
        $input->password = md5($input->password);

        $user = $this->where('username', $input->username)
            ->where('password', $input->password)
            ->where('is_blocked', 'n')
            ->get();

        if ($user) {
            return $this->update_session($user->username);
        } else {
            return false;
        }
    }

    public function logout()
    {
        $this->session->unset_userdata([
            'username',
            'level',
            'is_login',
            'user_id',
            'role_id',
        ]);
        $this->session->sess_destroy();
    }
}