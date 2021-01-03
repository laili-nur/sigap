<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Production_report_model extends MY_Model
{
    protected $table    = 'print_order';
    public function filter_total($filters)
    {
        return $this->select(['print_order_id AS id', 'category', 'total', 'CONCAT_WS(" - ", NULLIF(print_order.name,""), book.book_title) AS title', '(CASE WHEN total_postprint IS NOT NULL THEN total_postprint ELSE total_print END) AS total_new'])
            ->join_table('book', 'print_order', 'book')
            ->order_by('title', 'ASC')
            ->when('date_year', $filters['date_year'])
            ->where('MONTH(print_order.finish_date)', $filters['date_month'])
            ->where('print_order.print_order_status', 'finish')
            ->get_all();
    }

    public function filter_detail($filters)
    {
        return $this->select(['print_order_id', 'category', 'type', 'location_laminate', 'location_binding'])
            ->when('date_year', $filters['date_year'])
            ->when('date_month', $filters['date_month'])
            ->where('print_order.print_order_status', 'finish')
            ->get_all();
    }

    public function filter_excel_total($filters)
    {
        return $this->select(['print_order_id AS id', 'category', 'total', 'CONCAT_WS(" - ", NULLIF(print_order.name,""), book.book_title) AS title', '(CASE WHEN total_postprint IS NOT NULL THEN total_postprint ELSE total_print END) AS total_new', 'entry_date', 'finish_date', 'type', 'preprint_start_date', 'preprint_end_date', 'print_start_date', 'print_end_date', 'postprint_start_date', 'postprint_end_date'])
            ->when('date_year', $filters['date_year'])
            ->where('print_order.print_order_status', 'finish')
            ->join_table('book', 'print_order', 'book')
            ->order_by('CASE WHEN UNIX_TIMESTAMP(finish_date) IS NOT NULL THEN UNIX_TIMESTAMP(finish_date) ELSE "str" END', 'ASC')
            ->get_all();
    }

    public function filter_excel_detail($filters)
    {
        return $this->select(['print_order_id AS id', 'category', 'total', 'CONCAT_WS(" - ", NULLIF(print_order.name,""), book.book_title) AS title', '(CASE WHEN total_postprint IS NOT NULL THEN total_postprint ELSE total_print END) AS total_new', 'entry_date', 'finish_date', 'type', 'preprint_start_date', 'preprint_end_date', 'print_start_date', 'print_end_date', 'postprint_start_date', 'postprint_end_date'])
            ->when('date_year', $filters['date_year'])
            ->when('date_month', $filters['date_month'])
            ->where('print_order.print_order_status', 'finish')
            ->join_table('book', 'print_order', 'book')
            ->order_by('CASE WHEN UNIX_TIMESTAMP(finish_date) IS NOT NULL THEN UNIX_TIMESTAMP(finish_date) ELSE "str" END', 'ASC')
            ->get_all();
    }

    public function get_staff_percetakan_by_progress($progress, $print_order_id)
    {
        return $this->db->select(['print_order_user_id', 'print_order_user.user_id', 'print_order_id', 'progress', 'username', 'email'])
            ->from('user')
            ->join('print_order_user', 'user.user_id = print_order_user.user_id')
            ->where('print_order_id', $print_order_id)
            ->where('progress', $progress)
            ->get()->result();
    }

    public function when($params, $data)
    {
        // jika data null, maka skip
        if ($data) {
            if ($params == 'date_year') {
                $this->where('YEAR(print_order.finish_date)', $data);
            }

            if ($params == 'date_month') {
                $this->where('MONTH(print_order.finish_date)', $data);
            }
        }
        return $this;
    }
}
/* End of file Production_report_model.php */
