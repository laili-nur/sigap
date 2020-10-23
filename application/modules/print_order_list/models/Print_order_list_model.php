<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_order_list_model extends CI_Model
{
    public $table    = 'print_order';
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

    public function select($columns)
    {
        $this->db->select($columns);
        return $this;
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

    public function where($column, $condition)
    {
        $this->db->where($column, $condition);
        return $this;
    }

    public function join_table($table_to, $table_from, $column, $type = 'left')
    {
        $this->db->join($table_to, "$table_to.{$column}_id = $table_from.{$column}_id", $type);
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

    public function get_all($table = "")
    {
        $table = $this->check_table($table);
        return $this->db->get($table)->result();
    }

    public function check_table($table)
    {
        if ($table == "") {
            $table = $this->table;
        }

        return $table;
    }

    public function or_where($column, $condition)
    {
        $this->db->or_where($column, $condition);
        return $this;
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

    public function or_like($column, $condition)
    {
        $this->db->or_like($column, $condition);
        return $this;
    }
}
