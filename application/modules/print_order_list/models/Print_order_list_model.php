<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_order_list_model extends CI_Model
{
    public $table    = 'print_order';

    public function check_table($table)
    {
        if ($table == "") {
            $table = $this->table;
        }

        return $table;
    }

    public function query($sql)
    {
        return $this->db->query($sql);
    }

    public function group_start()
    {
        $this->db->group_start();
        return $this;
    }

    public function group_end()
    {
        $this->db->group_end();
        return $this;
    }

    public function count($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->count_all_results($table);
    }

    public function get_only($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get($table);
    }

    public function get($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get($table)->row();
    }

    public function get_row_array($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get($table)->row_array();
    }

    public function get_all($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get($table)->result();
    }

    public function get_all_array($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get($table)->result_array();
    }

    public function get_where($data, $table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get_where($table, $data)->row();
    }

    public function get_all_where($data, $table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get_where($table, $data)->result();
    }

    public function select($columns)
    {
        $this->db->select($columns);
        return $this;
    }

    public function from($table)
    {
        $this->db->from($table);
        return $this;
    }

    public function where($column, $condition)
    {
        $this->db->where($column, $condition);
        return $this;
    }

    public function where_not($column, $condition)
    {
        $this->db->where($column . ' !=', $condition);
        return $this;
    }

    public function or_where($column, $condition)
    {
        $this->db->or_where($column, $condition);
        return $this;
    }

    // public function or_where_not($column, $condition)
    // {
    //     $this->db->or_where($column . ' !=', $condition);
    //     return $this;
    // }

    public function where_not_in($column, $condition)
    {
        $this->db->where_not_in($column, $condition);
        return $this;
    }

    public function where_relation($table_middle, $condition, $table_from = "")
    {
        $table = $this->check_table($table_from);
        $this->db->where("$table_middle.{$table}_id", $condition);
        return $this;
    }

    // public function or_where_relation($table_middle, $condition, $table_from = "")
    // {
    //     $table = $this->check_table($table_from);
    //     $this->db->or_where("$table_middle.{$table}_id", $condition);
    //     return $this;
    // }

    public function having($column, $condition = "")
    {
        $this->db->having($column, $condition);
        return $this;
    }

    public function or_having($column, $condition)
    {
        $this->db->or_having($column, $condition);
        return $this;
    }

    public function group_by($column)
    {
        $this->db->group_by($column);
        return $this;
    }

    public function like($column, $condition)
    {
        $this->db->like($column, $condition);
        return $this;
    }

    public function or_like($column, $condition)
    {
        $this->db->or_like($column, $condition);
        return $this;
    }

    public function validate($validation_rules = null)
    {
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');

        if (is_null($validation_rules)) {
            // get default validations rules in child model
            $validation_rules = $this->get_validation_rules();
        }

        $this->form_validation->set_rules($validation_rules);
        return $this->form_validation->run();
    }

    public function insert($data, $table = "")
    {
        $table = $this->check_table($table);
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update($data, $table = "")
    {
        $table = $this->check_table($table);
        return $this->db->update($table, $data);
    }

    public function delete($table = "")
    {
        $table = $this->check_table($table);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    public function join($table, $type = 'left')
    {
        $this->db->join($table, "$this->table.{$table}_id = $table.{$table}_id", $type);
        return $this;
    }

    /**
     * Menggabungkan tabel secara fleksibel
     *
     * contoh:
     * input:  join_table('draft_author', 'author', 'author')
     * output: join('draft_author','draft_author.author_id == author.author_id')
     *
     * @param string $table_dest
     * @param string $table_middle
     * @return this
     **/
    public function join_table($table_to, $table_from, $column, $type = 'left')
    {
        $this->db->join($table_to, "$table_to.{$column}_id = $table_from.{$column}_id", $type);
        return $this;
    }

    /**
     * Menggabungkan tabel middle
     *
     * contoh:
     * input: join_relation_middle('user', 'reviewer')
     * output: join('reviewer','reviewer.user_id == user.user_id')
     *
     * @param string $table_dest
     * @param string $table_middle
     * @return this
     **/
    public function join_relation_middle($table_dest, $table_middle)
    {
        $this->db->join($table_middle, "$table_dest.{$table_dest}_id = $table_middle.{$table_dest}_id", "left");
        return $this;
    }

    /**
     * Menggabungkan tabel destination
     *
     * contoh:
     * input: join_relation_dest('reviewer', 'user')
     * output: join('reviewer','reviewer.user_id == user.user_id')
     *
     * @param string $table_dest
     * @param string $table_middle
     * @return this
     **/
    public function join_relation_dest($table_dest, $table_middle)
    {
        $this->db->join($table_dest, "$table_middle.{$table_dest}_id = $table_dest.{$table_dest}_id", "left");
        return $this;
    }

    public function order_by($column_name, $order = 'asc')
    {
        $this->db->order_by($column_name, $order);
        return $this;
    }

    public function limit($limit)
    {
        $this->db->limit($limit);
        return $this;
    }

    /**
     * Mencari id dan nama dari entitas $table_dest
     *
     * @param string $table_dest 'author', 'reviewer'
     * @param string $table_middle 'draft_author','draft_reviewer'
     * @param int $table_middle_id 'draft_id
     * @param string $table_from
     * @return void
     */
    public function get_id_and_name($table_dest, $table_middle, $table_middle_id, $table_from = "")
    {
        // return $this->select("$table_dest.{$table_dest}_id")
        // ->select("$table_dest.{$table_dest}_name")
        // ->join_relation_middle($table_dest, $table_middle)
        // ->where_relation($table_middle, $table_middle_id, $table)
        // ->get_all($table_dest);

        $table = $this->check_table($table_from);
        return $this->select("$table_dest.{$table_dest}_id")
            ->select("$table_dest.{$table_dest}_name")
            ->join_table($table_middle, $table_dest, $table_dest)
            ->where("$table_middle.{$table}_id", $table_middle_id)
            ->get_all($table_dest);
    }

    public function update_draft_status($draft_id, $status)
    {
        $this->where('draft_id', $draft_id)
            ->update($status, 'draft');
    }

    // public function get_draft_from_relation($table_dest, $table_middle)
    // {
    //     return $this->join_relation_middle('draft', $table_middle)
    //         ->join_relation_dest($table_dest, $table_middle);
    // }

    public function get_pk_table_id($table_dest, $table_from, $table_middle, $id_table_dest, $id_table_from)
    {
        $query = $this->select("{$table_middle}_id")
            ->where("{$table_dest}_id", $id_table_dest)
            ->where("{$table_from}_id", $id_table_from)
            ->get_row_array($table_middle);

        if ($query) {
            $data = $query;

            return $data["{$table_middle}_id"];
        } else {
            return 0;
        }
    }

    public function edit_draft_date($id, $column, $date = '')
    {
        if ($date == "") {
            $date = date('Y-m-d H:i:s');
        }

        $data = array($column => $date);
        if ($this->where('draft_id', $id)->update($data, 'draft')) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_print_order_date($id, $column, $date = '')
    {
        if ($date == "") {
            $date = date('Y-m-d H:i:s');
        }

        $data = array($column => $date);
        if ($this->where('print_order_id', $id)->update($data, 'print_order')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Mencari reviewer_id atau author_id berdasarkan user_id dan tipe role
     *
     * @param int $user_id
     * @param string $role ('reviewer' or 'author')
     * @return int
     **/
    public function get_role_id_from_user_id($user_id, $role)
    {
        // $data = $this->select($role . '_id')
        //     ->join_relation_dest('user', $role)
        //     ->where_relation($role, $user_id, 'user')
        //     ->get_row_array($role);

        $data = $this->select($role . '_id')
            ->join_table('user', $role, 'user')
            ->where('user.user_id', $user_id)
            ->get_row_array($role);

        return $data ? $data[$role . '_id'] : null;
    }

    // public function get_id_draft_from_draft_id($draft_id, $role)
    // {
    //     $id = 0;

    //     $data = $this->select($role . '_id')
    //         ->join_relation_dest('draft', $role)
    //         ->where_relation($role, $draft_id, 'draft')
    //         ->get_row_array($role);

    //     if ($data) {
    //         $id = $data[$role . '_id'];
    //     }

    //     return $id;
    // }

    public function update_session(String $username)
    {
        // cari user yang login
        $user = $this->where('username', $username)->get('user');

        if ($user) {
            // default role_id = user_id
            // untuk author -> role_id = author_id
            // untuk reviewer -> role_id = reviewer_id
            $role_id = $user->user_id;
            if ($user->level == "author" || $user->level == "reviewer") {
                $role_id = $this->get_role_id_from_user_id($user->user_id, $user->level);
            }

            $this->session->set_userdata([
                'username'     => $user->username,
                'level'        => $user->level,
                'level_native' => $user->level,
                'is_login'     => true,
                'user_id'      => $user->user_id,
                'role_id'      => $role_id,
                'email'        => isset($user->email) ? $user->email : null,
            ]);
            return true;
        }
        return false;
    }

    public function send_mail($to, $subject, $message)
    {
        $email_config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.googlemail.com',
            'smtp_port' => '587',
            'smtp_user' => getenv('EMAIL_ADDRESS'),
            'smtp_pass' => getenv('EMAIL_PASSWORD'),
            'mailtype'  => 'html',
            'smtp_crypto' => 'tls',
            'newline'   => "\r\n",
        );

        $this->load->library('email', $email_config);
        $this->email->from('sigap.ugmpress@gmail.com', 'SIGAP UGM Press');
        $this->email->to($to);

        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            return [
                'status'  => true,
                'message' => null,
            ];
        } else {
            return [
                'status'  => false,
                'message' => $this->email->print_debugger(),
            ];
        }
    }




    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'order_number',
                'label' => $this->lang->line('form_print_order_number'),
                'rules' => 'trim|required',
            ],
            // [
            //     'field' => 'category',
            //     'label' => $this->lang->line('form_print_order_category'),
            //     'rules' => 'trim|required',
            // ],
            [
                'field' => 'order_code',
                'label' => $this->lang->line('form_print_order_code'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'type',
                'label' => $this->lang->line('form_print_order_type'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'total',
                'label' => $this->lang->line('form_print_order_total'),
                'rules' => 'trim|required|integer',
            ],
            [
                'field' => 'paper_content',
                'label' => $this->lang->line('form_print_order_paper_content'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'paper_cover',
                'label' => $this->lang->line('form_print_order_paper_cover'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'paper_size',
                'label' => $this->lang->line('form_print_order_paper_size'),
                'rules' => 'trim|required',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'book_id'           => '',
            'category'          => '',
            'order_number'      => '',
            'order_code'        => '',
            'total'             => '',
            'print_number'      => '',
            'paper_content'     => '',
            'paper_cover'       => '',
            'paper_size'        => '',
            'type'              => 'pod',
            'date_year'          => '',
            'date_month'          => '',
            'print_order_notes' => '',
            'name'              => '',
            'print_mode'              => 'book',
        ];
    }

    public function filter_print_order($filters)
    {
        return $this->select(['print_order_id', 'print_order.book_id', 'book.draft_id', 'CONCAT_WS("", book.book_title, print_order.name) AS title', 'category_name', 'draft.is_reprint', 'print_order.*'])
            ->when('keyword', $filters['keyword'])
            ->when('category', $filters['category'])
            ->when('type', $filters['type'])
            ->when('print_order_status', $filters['print_order_status'])
            ->when('date_year', $filters['date_year'])
            ->when('date_month', $filters['date_month'])
            ->where('print_order_status !=', 'finish')
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
            ->order_by('UNIX_TIMESTAMP(print_order.entry_date)', 'ASC')
            ->order_by('title', 'ASC')
            ->limit(10)
            ->get_all();
    }

    public function when($params, $data)
    {
        // jika data null, maka skip
        if ($data) {
            if ($params == 'category') {
                $this->where('category', $data);
            }

            if ($params == 'type') {
                $this->where('type', $data);
            }

            if ($params == 'date_year') {
                $this->where('YEAR(print_order.entry_date)', $data);
            }

            if ($params == 'date_month') {
                $this->where('MONTH(print_order.entry_date)', $data);
            }

            if ($params == 'keyword') {
                $this->group_start();
                $this->or_like('title', $data);
                $this->or_like('order_number', $data);
                $this->or_like('order_code', $data);
                $this->group_end();
            }

            if ($params == 'print_order_status') {
                if ($data == 'preprint' || $data == 'print' || $data == 'postprint') {
                    $this->where('print_order_status', $data);
                    $this->or_where('print_order_status', "{$data}_approval");
                    $this->or_where('print_order_status', "{$data}_finish");
                } else {
                    $this->where('print_order_status', $data);
                }
            }
        }
        return $this;
    }
}
