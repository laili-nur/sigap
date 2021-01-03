<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_order_list_model extends CI_Model
{
    public $table    = 'print_order';
    public function get_print_order_list()
    {
        return $this->select(['print_order_id', 'print_order.book_id', 'book.draft_id', 'CONCAT_WS(" - ", NULLIF(print_order.name,""), book.book_title) AS title', 'category_name', 'draft.is_reprint', 'print_order.*'])
            ->where('print_order_status !=', 'finish')
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
            ->order_by('CASE WHEN UNIX_TIMESTAMP(deadline_date) IS NOT NULL THEN UNIX_TIMESTAMP(deadline_date) ELSE "str" END', 'ASC')
            ->order_by('title', 'ASC')
            ->limit(10)
            ->get_all();
    }

    public function select($columns)
    {
        $this->db->select($columns);
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
