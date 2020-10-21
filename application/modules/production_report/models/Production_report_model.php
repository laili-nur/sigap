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
}
/* End of file Production_report_model.php */