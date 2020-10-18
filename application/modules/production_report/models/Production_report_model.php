<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Production_report_model extends MY_Model
{
    public function filter_print_order($filters, $page)
    {
        $print_orders = $this->select(['print_order_id', 'print_order.book_id', 'book.draft_id', 'CONCAT_WS(" - ", print_order.name, book.book_title) AS title', 'category_name', 'draft.is_reprint', 'print_order.*'])
            ->when('keyword', $filters['keyword'])
            ->when('category', $filters['category'])
            ->when('type', $filters['type'])
            ->when('print_order_status', $filters['print_order_status'])
            ->when('date_year', $filters['date_year'])
            ->when('date_month', $filters['date_month'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
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
            ->order_by('UNIX_TIMESTAMP(print_order.entry_date)', 'ASC')
            ->order_by('title', 'ASC')
            ->paginate($page)

            ->get_all();

        $total = $this->select('draft.draft_id')
            ->when('keyword', $filters['keyword'])
            ->when('category', $filters['category'])
            ->when('type', $filters['type'])
            ->when('print_order_status', $filters['print_order_status'])
            ->when('date_year', $filters['date_year'])
            ->when('date_month', $filters['date_month'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
            ->count();

        return [
            'print_orders' => $print_orders,
            'total'        => $total,
        ];
    }

    public function when($params, $data)
    {
        // jika data null, maka skip
        if ($data) {
            if ($params == 'date_year') {
                $this->where('YEAR(print_order.entry_date)', $data);
            }

            if ($params == 'date_month') {
                $this->where('MONTH(print_order.entry_date)', $data);
            }
        }
        return $this;
    }

    public function detail_data($year, $month) {
        // $this->db->select('book.book_title', 'print_order.total', 'print_order.total_postprint');
        // $this->db->from('print_order');
        // $this->db->join('book', 'print_order.book_id = book.book_id', 'left');
        $query = $this->db->query("SELECT po.print_order_id, b.book_title, po.category ,po.total , po.total_postprint from print_order po left join book b on po.book_id = b.book_id WHERE YEAR(po.entry_date) = '" . $year . "' AND MONTH(po.entry_date) = '". $month . "'");

        //$query = $this->db->get();
        return $query->result_array();
    }
}


/* End of file Production_report_model.php */


