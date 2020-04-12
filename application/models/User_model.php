<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends MY_Model
{
    // set public if want to override per_page
    public $per_page;

    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'username',
                'label' => $this->lang->line('form_user_name'),
                'rules' => 'trim|required|min_length[4]|max_length[256]|callback_unique_data[username]',
            ],
            [
                'field' => 'password',
                'label' => $this->lang->line('form_user_password'),
                'rules' => 'trim|callback_required_on[add]|min_length[4]|max_length[30]',
            ],
            [
                'field' => 'email',
                'label' => $this->lang->line('form_user_email'),
                'rules' => 'trim|required|valid_email|callback_unique_data[email]',
            ],
            [
                'field' => 'level',
                'label' => $this->lang->line('form_user_level'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'is_blocked',
                'label' => $this->lang->line('form_user_is_blocked'),
                'rules' => 'trim|callback_required_on[edit]',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'username'   => null,
            'password'   => null,
            'email'      => null,
            'level'      => null,
            'is_blocked' => 'n',
        ];
    }

    public function filter_data($filters, $page = null)
    {
        $query = $this->select('user_id,username,email,level,is_blocked')
            ->when('keyword', $filters['keyword'])
            ->when('level', $filters['level'])
            ->when('status', $filters['status'])
            ->order_by('username')
            ->order_by('level');

        return [
            'data'  => $query->paginate($page)->get_all(),
            'count' => $this->select('user_id')
                ->when('keyword', $filters['keyword'])
                ->when('level', $filters['level'])
                ->when('status', $filters['status'])
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

            if ($params == 'status') {
                $this->where('is_blocked !=', $data);
            }
        }
        return $this;
    }

    public function insert_data($input)
    {
        // clone data untuk dikirimkan via email
        $send_mail  = $input->send_mail;
        $email_data = clone $input;

        $input->password = md5($input->password);

        unset($input->send_mail);
        if ($this->insert($input)) {
            // jika sukses input data, kirim email ke user
            if ($send_mail) {
                $this->send_user_mail($email_data, 'email/create_user_email', 'Registrasi berhasil');
            }
            return true;
        } else {
            return false;
        }
    }

    public function update_data($input, $user_id)
    {
        // clone data untuk dikirimkan vie email
        $send_mail  = $input->send_mail;
        $email_data = clone $input;

        // jika update password
        if (!empty($input->password)) {
            $input->password = md5($input->password);
        } else {
            unset($input->password);
        }

        unset($input->send_mail);
        if ($this->where('user_id', $user_id)->update($input)) {
            if ($send_mail) {
                $this->send_user_mail($email_data, 'email/update_user_email', 'Update Data Akun');
            }
            return true;
        } else {
            return false;
        }
    }

    public function send_user_mail($input, $email_content, $subject)
    {
        $email_subject = $subject;
        $data          = [
            'preheader'     => null,
            'username'      => $input->username,
            'level'         => ucwords(str_replace('_', ' ', $input->level)),
            'password'      => $input->password,
            'status'        => $input->is_blocked == 'y' ? 'Nonaktif' : 'Aktif',
            'email_content' => $email_content,
        ];
        $email_message = $this->load->view('email/main_email_template', $data, true);

        $mail = $this->send_mail($input->email, $email_subject, $email_message);
        if (!$mail['status']) {
            return false;
        } else {
            return true;
        }
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

    public function get_all_staffs($level)
    {
        return $this->select('user_id,username,level')
            ->where('level', $level)
            ->order_by('username')
            ->get_all();
    }
}
