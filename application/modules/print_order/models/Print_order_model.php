<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_order_model extends MY_Model
{

    public $per_page = 10;


    public function filter_print_order($filters, $page)
    {
        $print_orders = $this->select(['print_order_id', 'print_order.book_id', 'book.draft_id', 'book_title', 'category_name', 'author_name', 'order_number', 'copies', 'type', 'priority', 'print_order.entry_date'])
            ->when('keyword', $filters['keyword'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
            ->join_table('draft_author', 'draft', 'draft')
            ->join_table('author', 'draft_author', 'author')
            ->join_table('work_unit', 'author', 'work_unit')
            ->order_by('status_hak_cipta')
            ->order_by('published_date')
            ->order_by('book_title')
            ->group_by('draft.draft_id')
            ->paginate($page)
            ->get_all();

        $total = $this->select('draft.draft_id')
            ->when('keyword', $filters['keyword'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
            ->join_table('draft_author', 'draft', 'draft')
            ->join_table('author', 'draft_author', 'author')
            ->join_table('work_unit', 'author', 'work_unit')
            ->order_by('status_hak_cipta')
            ->order_by('published_date')
            ->order_by('book_title')
            ->group_by('draft.draft_id')
            ->count();

        // get authors
        foreach ($print_orders as $b) {
            if ($b->draft_id) {
                $b->authors = $this->get_id_and_name('author', 'draft_author', $b->draft_id, 'draft');
            } else {
                $b->authors = [];
            }
        }

        return [
            'print_orders' => $print_orders,
            'total'  => $total,
        ];
    }

    public function when($params, $data)
    {
        // jika data null, maka skip
        if ($data) {
            if ($params == 'reprint') {
                $this->where('is_reprint', $data);
            }

            if ($params == 'category') {
                $this->where('draft.category_id', $data);
            }

            if ($params == 'status') {
                $this->where('book.status_hak_cipta', $data == 'done' ? 2 : 1);
            }

            if ($params == 'published_year') {
                $this->where('year(published_date)', $data);
            }

            if ($params == 'keyword') {
                $this->group_start();
                // $this->like('draft_title', $data);
                $this->or_like('book_title', $data);
                // if ($this->session->userdata('level') != 'reviewer') {
                $this->or_like('author_name', $data);
                // }
                $this->group_end();
            }
        }
        return $this;
    }
}

/* End of file Print_order_model.php */
