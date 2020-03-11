<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends MY_Model
{
    // set public if want to ovveride per_page
    public $per_page;

    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'username',
                'label' => $this->lang->line('form_user_name'),
                'rules' => 'trim|required|min_length[4]|max_length[256]|callback_unique_username',
            ],
            [
                'field' => 'password',
                'label' => $this->lang->line('form_user_password'),
                'rules' => 'trim|callback_is_password_required|min_length[4]|max_length[30]',
            ],
            [
                'field' => 'level',
                'label' => $this->lang->line('form_user_level'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'is_blocked',
                'label' => $this->lang->line('form_user_is_blocked'),
                'rules' => 'trim|required',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'username'   => null,
            'password'   => null,
            'level'      => null,
            'is_blocked' => null,
        ];
    }

    public function filter_data($filters, $page = null)
    {
        $query = $this->select('user_id,username,level,is_blocked')
            ->when('keyword', $filters['keyword'])
            ->when('level', $filters['level'])
            ->order_by('username')
            ->order_by('level');

        return [
            'data'  => $query->paginate($page)->get_all(),
            'count' => $this->select('user_id')
                ->when('keyword', $filters['keyword'])
                ->when('level', $filters['level'])
                ->count(),
        ];
    }

    public function when($params, $data)
    {
        // jika data null, maka skip
        if ($data) {
            if ($params == 'level') {
                $this->where('level', $data);
            }

            if ($params == 'keyword') {
                $this->group_start();
                $this->like('username', $data);
                $this->group_end();
            }
        }
        return $this;
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