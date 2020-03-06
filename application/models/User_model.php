<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends MY_Model
{
    protected $per_page = 10;
    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'username',
                'label' => 'username',
                'rules' => 'trim|required|min_length[4]|max_length[256]|callback_unique_username',
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|callback_is_password_required|min_length[4]|max_length[30]',
            ],
            [
                'field' => 'level',
                'label' => 'Level',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'is_blocked',
                'label' => 'Block Status',
                'rules' => 'trim|required',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'username'   => '',
            'password'   => '',
            'level'      => '',
            'is_blocked' => '',
        ];
    }

    public function get_draft_staffs($draft_id, $staff_level)
    {
        return $this->select(['username', 'level', 'responsibility_id', 'responsibility.user_id'])
            ->join_table('responsibility', 'user', 'user')
            ->join_table('draft', 'responsibility', 'draft')
            ->where('responsibility.draft_id', $draft_id)
            ->where('level', $staff_level)
            ->get_all();
    }
}