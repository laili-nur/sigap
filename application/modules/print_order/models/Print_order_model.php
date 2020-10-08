<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_order_model extends MY_Model
{
    public $per_page = 10;

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
            'date_year'         => '',
            'date_month'        => '',
            'print_order_notes' => '',
            'name'              => '',
            'print_mode'        => 'book',
        ];
    }

    public function get_print_order($print_order_id)
    {
        return $this->select(['print_order.book_id', 'book.draft_id', 'stock_warehouse', 'book_title', 'book_file', 'book_file_link', 'cover_file', 'cover_file_link', 'book_notes',  'is_reprint', 'book_edition', 'nomor_hak_cipta', 'status_hak_cipta', 'file_hak_cipta', 'file_hak_cipta_link', 'print_order.*'])
            ->join('book')
            ->join_table('draft', 'book', 'draft')
            ->where('print_order_id', $print_order_id)
            ->get();
    }

    public function get_book($book_id)
    {
        return $this->select('book.*')
            ->where('book_id', $book_id)
            ->get('book');
    }

    public function filter_print_order($filters, $page)
    {
        $print_orders = $this->select(['print_order_id', 'print_order.book_id', 'book.draft_id', 'book_title', 'category_name', 'draft.is_reprint', 'print_order.*'])
            ->when('keyword', $filters['keyword'])
            ->when('category', $filters['category'])
            ->when('type', $filters['type'])
            ->when('print_order_status', $filters['print_order_status'])
            ->when('date_year', $filters['date_year'])
            ->when('date_month', $filters['date_month'])
            ->when('hide', $filters['hide'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
            ->order_by('UNIX_TIMESTAMP(print_order.entry_date)', 'ASC')
            // ->order_by("CASE WHEN print_order.print_order_status = 'finish' THEN 1 ELSE 2 END, print_order.print_order_status", "DESC")
            ->order_by("CASE WHEN print_order.print_order_status = 'waiting' THEN 1
                             WHEN print_order.print_order_status = 'preprint' THEN 2
                             WHEN print_order.print_order_status = 'preprint_approval' THEN 3
                             WHEN print_order.print_order_status = 'preprint_finish' THEN 4
                             WHEN print_order.print_order_status = 'print' THEN 5
                             WHEN print_order.print_order_status = 'print_approval' THEN 6
                             WHEN print_order.print_order_status = 'print_finish' THEN 7
                             WHEN print_order.print_order_status = 'postprint' THEN 8
                             WHEN print_order.print_order_status = 'postprint_approval' THEN 9
                             WHEN print_order.print_order_status = 'postprint_finish' THEN 10
                             WHEN print_order.print_order_status = 'reject' THEN 11
                             WHEN print_order.print_order_status = 'finish' THEN 12
                             ELSE 13 END, print_order.print_order_status", "ASC")
            // ->order_by("CASE WHEN print_order.category = 'nonbook' THEN 1 ELSE 2 END, print_order.category", "DESC")
            // ->order_by('UNIX_TIMESTAMP(print_order.deadline_date)', 'ASC')
            // ->order_by('book_title', 'ASC')
            // ->order_by('name','ASC')
            // ->order_by('book_title','ASC')
            // ->order_by('status_hak_cipta')
            // ->order_by('published_date')          
            // ->order_by('UNIX_TIMESTAMP(print_order.entry_date)', 'DESC')
            ->paginate($page)
            ->get_all();

        // pengennya order by
        // 1. deadline yg mendekati, berarti asc
        // 2. prioritas tinggi ke rendah, desc
        // 3. judul dan name sesuai alpabet, asc

        $total = $this->select('draft.draft_id')
            ->when('keyword', $filters['keyword'])
            ->when('category', $filters['category'])
            ->when('type', $filters['type'])
            ->when('print_order_status', $filters['print_order_status'])
            ->when('date_year', $filters['date_year'])
            ->when('date_month', $filters['date_month'])
            ->when('hide', $filters['hide'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
            // ->order_by('name','ASC')
            // ->order_by('book_title','ASC')
            // ->order_by('status_hak_cipta')
            // ->order_by('published_date')
            ->count();

        // get authors
        // foreach ($print_orders as $b) {
        //     if ($b->draft_id) {
        //         $b->authors = $this->get_id_and_name('author', 'draft_author', $b->draft_id, 'draft');
        //     } else {
        //         $b->authors = [];
        //     }
        // }

        return [
            'print_orders' => $print_orders,
            'total'        => $total,
        ];
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

            if ($params == 'hide') {
                if ($data == 1) {
                    $this->where('print_order_status !=', 'finish');
                } elseif ($data == 0) {
                    // gadiapa2in
                }
            }

            if ($params == 'date_year') {
                if ($data == '2020') {
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) >=', strtotime("01 January 2020"));
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) <=', strtotime("31 December 2020"));
                } elseif ($data == '2019') {
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) >=', strtotime("01 January 2019"));
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) <=', strtotime("31 December 2019"));
                } elseif ($data == '2018') {
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) >=', strtotime("01 January 2018"));
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) <=', strtotime("31 December 2018"));
                } elseif ($data == '2017') {
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) >=', strtotime("01 January 2017"));
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) <=', strtotime("31 December 2017"));
                } elseif ($data == '2016') {
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) >=', strtotime("01 January 2016"));
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) <=', strtotime("31 December 2016"));
                } elseif ($data == '2015') {
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) >=', strtotime("01 January 2015"));
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) <=', strtotime("31 December 2015"));
                }
            }

            if ($params == 'date_month') {
                if ($data == '0') {
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) >=', strtotime("01 December 2020"));
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) <=', strtotime("31 December 2020"));
                } elseif ($data == '1') {
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) >=', strtotime("01 November 2020"));
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) <=', strtotime("30 November 2020"));
                } elseif ($data == '2') {
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) >=', strtotime("01 October 2020"));
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) <=', strtotime("31 October 2020"));
                } elseif ($data == '3') {
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) >=', strtotime("01 September 2020"));
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) <=', strtotime("30 September 2020"));
                } elseif ($data == '4') {
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) >=', strtotime("01 August 2020"));
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) <=', strtotime("31 August 2020"));
                } elseif ($data == '5') {
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) >=', strtotime("01 July 2020"));
                    $this->where('UNIX_TIMESTAMP(print_order.entry_date) <=', strtotime("31 July 2020"));
                }
            }

            if ($params == 'keyword') {
                $this->group_start();
                $this->or_like('book_title', $data);
                $this->or_like('order_number', $data);
                $this->or_like('order_code', $data);
                $this->or_like('name', $data);
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

    public function start_progress($print_order_id, $progress)
    {
        // transaction data agar konsisten
        $this->db->trans_begin();

        $input = [
            'print_order_status' => $progress,
            "{$progress}_start_date" => date('Y-m-d H:i:s')
        ];

        $this->print_order->where('print_order_id', $print_order_id)->update($input);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function finish_progress($print_order_id, $progress)
    {
        $input = [
            'print_order_status' => "{$progress}_approval",
            "{$progress}_end_date" => date('Y-m-d H:i:s')
        ];

        $update_state = $this->print_order->where('print_order_id', $print_order_id)->update($input);

        if ($update_state) {
            return true;
        } else {
            return false;
        }
    }

    public function finish_print_postprint($print_order_id)
    {
        $date   =   date('Y-m-d H:i:s');
        $input = [
            'print_order_status' => "print_approval",
            "print_end_date" => $date,
            "postprint_end_date" => $date
        ];

        $update_state = $this->print_order->where('print_order_id', $print_order_id)->update($input);

        if ($update_state) {
            return true;
        } else {
            return false;
        }
    }

    public function upload_print_order_file($field_name, $file_name)
    {
        $config = [
            'upload_path'      => './printorderfile/',
            'file_name'        => $file_name,
            'allowed_types'    => get_allowed_file_types('print_order_file')['types'],
            'max_size'         => 51200,                                           // 50MB
            'overwrite'        => true,
            'file_ext_tolower' => true,
        ];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($field_name)) {
            // Upload OK, return uploaded file info.
            return $this->upload->data();
        } else {
            // Add error to $_error_array
            $this->form_validation->add_to_error_array($field_name, $this->upload->display_errors('', ''));
            return false;
        }
    }

    public function delete_print_order_file($print_order_file)
    {
        if ($print_order_file) {
            if (file_exists("./printorderfile/$print_order_file")) {
                unlink("./printorderfile/$print_order_file");
                return true;
            }
            return false;
        }
    }

    public function delete_letter_file($letter_file)
    {
        if ($letter_file) {
            if (file_exists("./printorderletter/$letter_file")) {
                unlink("./printorderletter/$letter_file");
                return true;
            }
            return false;
        }
    }

    public function delete_preprint_file($preprint_file)
    {
        if ($preprint_file) {
            if (file_exists("./preprintfile/$preprint_file")) {
                unlink("./preprintfile/$preprint_file");
                return true;
            }
            return false;
        }
    }

    public function upload_preprint_file($field_name, $print_order_file_name)
    {
        $config = [
            'upload_path'      => './preprintfile/',
            'file_name'        => $print_order_file_name,
            'allowed_types'    => get_allowed_file_types('preprint_file')['types'],
            'max_size'         => 51200,                                           // 50MB
            'overwrite'        => true,
            'file_ext_tolower' => true,
        ];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload($field_name)) {
            // Upload OK, return uploaded file info.
            return $this->upload->data();
        } else {
            // Add error to $_error_array
            $this->form_validation->add_to_error_array($field_name, $this->upload->display_errors('', ''));
            return false;
        }
    }

    public function get_admin_percetakan()
    {
        return $this->select(['user_id', 'username', 'level', 'email'])
            ->where('level', 'admin_percetakan')
            ->where('is_blocked', 'n')
            ->order_by('username', 'ASC')
            ->get_all('user');
    }

    public function get_admin_percetakan_by_progress($progress, $print_order_id)
    {
        return $this->db->select(['print_order_user_id', 'print_order_user.user_id', 'print_order_id', 'progress', 'username', 'email'])
            ->from('user')
            ->join('print_order_user', 'user.user_id = print_order_user.user_id')
            ->where('print_order_id', $print_order_id)
            ->where('progress', $progress)
            ->get()->result();
    }

    public function check_row_admin_percetakan($print_order_id, $user_id, $progress)
    {
        return $this->db
            ->where(['print_order_id' => $print_order_id, 'user_id' => $user_id, 'progress' => $progress])
            ->get('print_order_user')
            ->num_rows();
    }

    // if(check_row_admin_percetakan($print_order_id, $user_id, $progress) > 0){
    //     jalanin fungsi
    // } else {
    //     tidak diijinkan toastr
    // }

    // cekin admin cetak
    // 1. Cek session(user_id)
    // 2. cek print_order_id
    // 3. cek progress
    // 4. cek row, misal > 0, return true, misal ! > 0  =, return false
    // 5. di controller misal true dia bisa lakuin fungsi, misal ngga dia gabisa lakuin fungsi
}

/* End of file Print_order_model.php */
