<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login_model extends MY_Model
{
    public $table = 'user';

    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'username' => '',
            'password' => '',
        ];
    }

    public function login($input)
    {
        $input->password = md5($input->password);

        $user = $this->db->where('username', $input->username)
            ->where('password', $input->password)
            ->where('is_blocked', 'n')
            ->limit(1)
            ->get($this->table)
            ->row();

        if (count($user)) {
            $role_id = $user->user_id;
            if ($user->level == "author" || $user->level == "reviewer") {
                $role_id = $this->login->get_role_id_from_user_id($user->user_id, $user->level);
            }
            $data = [
                'username'   => $user->username,
                'level'      => $user->level,
                'level_asli' => $user->level,
                'is_login'   => true,
                'user_id'    => $user->user_id,
                'role_id'    => $role_id,
            ];

            $this->session->set_userdata($data);
            return true;
        }

        return false;
    }

    public function logout()
    {
        $data = [
            'username' => null,
            'level'    => null,
            'is_login' => null,
            'user_id'  => null,
            'role_id'  => null,
        ];
        $this->session->unset_userdata($data);
        $this->session->sess_destroy();
    }
}
