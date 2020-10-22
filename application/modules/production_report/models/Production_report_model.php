<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Production_report_model extends MY_Model
{
    protected $table    = 'print_order';
    public function filter_total($filters)
    {
        return $this->select(['print_order_id AS id', 'category', 'total', 'CONCAT_WS(" - ", print_order.name, book.book_title) AS title', '(CASE WHEN total_postprint IS NOT NULL THEN total_postprint ELSE total_print END) AS total_new'])
            ->join_table('book', 'print_order', 'book')
            ->order_by('title', 'ASC')
            ->when('date_year', $filters['date_year'])
            ->where('MONTH(print_order.entry_date)', $filters['date_month'])
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
