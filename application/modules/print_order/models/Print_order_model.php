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
                'field' => 'priority',
                'label' => $this->lang->line('form_print_order_priority'),
                'rules' => 'trim|required|integer',
            ],
            [
                'field' => 'mode',
                'label' => $this->lang->line('form_print_order_mode'),
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
            'priority'          => '',
            'mode'              => '',
            'print_order_notes' => '',
            'name'              => ''
        ];
    }

    public function get_print_order($print_order_id)
    {
        return $this->select(['print_order.book_id', 'book.draft_id', 'book_title', 'book_file', 'book_file_link', 'cover_file', 'cover_file_link', 'book_notes',  'is_reprint', 'book_edition', 'nomor_hak_cipta', 'status_hak_cipta', 'file_hak_cipta', 'file_hak_cipta_link', 'print_order.*'])
            ->join('book')
            ->join_table('draft', 'book', 'draft')
            ->where('print_order_id', $print_order_id)
            ->get();
    }

    public function filter_print_order($filters, $page)
    {
        $print_orders = $this->select(['print_order_id', 'print_order.book_id', 'book.draft_id', 'book_title', 'category_name', 'draft.is_reprint', 'print_order.*'])
            ->when('keyword', $filters['keyword'])
            ->when('category', $filters['category'])
            ->when('type', $filters['type'])
            ->when('priority', $filters['priority'])
            ->when('mode', $filters['mode'])
            ->when('print_order_status', $filters['print_order_status'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
            ->order_by('status_hak_cipta')
            ->order_by('published_date')
            ->order_by('book_title')
            ->order_by('UNIX_TIMESTAMP(print_order.entry_date)', 'DESC')
            ->paginate($page)
            ->get_all();

        $total = $this->select('draft.draft_id')
            ->when('keyword', $filters['keyword'])
            ->when('category', $filters['category'])
            ->when('type', $filters['type'])
            ->when('priority', $filters['priority'])
            ->when('mode', $filters['mode'])
            ->when('print_order_status', $filters['print_order_status'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
            ->order_by('status_hak_cipta')
            ->order_by('published_date')
            ->order_by('book_title')
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

            if ($params == 'priority') {
                $this->where('priority', $data);
            }

            if ($params == 'mode') {
                $this->where('mode', $data);
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
            "{$progress}_start_date" => date('Y-m-d H:i:s'),
            "{$progress}_user" => $this->session->userdata('username')
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
            "{$progress}_end_date" => date('Y-m-d H:i:s'),
            "{$progress}_user" => $this->session->userdata('username')
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

    public function delete_print_order_file($file)
    {
        if ($file && file_exists("./printorderfile/$file")) {
            unlink("./printorderfile/$file");
        }
    }

    public function upload_preprint_file($field_name, $file_name)
    {
        $config = [
            'upload_path'      => './preprintfile/',
            'file_name'        => $file_name,
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

    public function delete_preprint_file($file)
    {
        if ($file && file_exists("./preprintfile/$file")) {
            unlink("./preprintfile/$file");
        }
    }
}

/* End of file Print_order_model.php */
