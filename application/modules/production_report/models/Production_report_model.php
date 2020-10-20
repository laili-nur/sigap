<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Production_report_model extends MY_Model
{
    protected $table    = 'print_order';
    public function filter_total($filters)
    {
        $filter = $this->select(['print_order_id', 'print_order.book_id', 'book.draft_id', 'book_title', 'CONCAT_WS(" - ", print_order.name, book.book_title) AS title', 'category_name', 'draft.is_reprint', 'print_order.*', '(CASE WHEN total_postprint IS NOT NULL THEN total_postprint ELSE total_print END) AS total_new'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
            ->order_by('title', 'ASC');

        return [
            'jan_total' => $filter->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 1)->where('print_order.print_order_status', 'finish')->count(),
            'feb_total' => $filter->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 2)->where('print_order.print_order_status', 'finish')->count(),
            'mar_total' => $filter->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 3)->where('print_order.print_order_status', 'finish')->count(),
            'apr_total' => $filter->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 4)->where('print_order.print_order_status', 'finish')->count(),
            'may_total' => $filter->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 5)->where('print_order.print_order_status', 'finish')->count(),
            'jun_total' => $filter->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 6)->where('print_order.print_order_status', 'finish')->count(),
            'jul_total' => $filter->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 7)->where('print_order.print_order_status', 'finish')->count(),
            'aug_total' => $filter->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 8)->where('print_order.print_order_status', 'finish')->count(),
            'sep_total' => $filter->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 9)->where('print_order.print_order_status', 'finish')->count(),
            'oct_total' => $filter->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 10)->where('print_order.print_order_status', 'finish')->count(),
            'nov_total' => $filter->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 11)->where('print_order.print_order_status', 'finish')->count(),
            'dec_total' => $filter->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 12)->where('print_order.print_order_status', 'finish')->count()
        ];
    }

    public function total_by_month($filters)
    {
        return $this->select(['print_order_id', 'print_order.book_id', 'book.draft_id', 'book_title', 'CONCAT_WS(" - ", print_order.name, book.book_title) AS title', 'category_name', 'draft.is_reprint', 'print_order.*', '(CASE WHEN total_postprint IS NOT NULL THEN total_postprint ELSE total_print END) AS total_new'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
            ->order_by('title', 'ASC')
            ->when('date_year', $filters['date_year'])
            ->where('MONTH(print_order.entry_date)', $filters['date_month'])
            ->where('print_order.print_order_status', 'finish')
            ->get_all();
    }

    public function total_exemplar($filters)
    {
        $total = $this->select(['total', '(CASE WHEN total_postprint IS NOT NULL THEN total_postprint ELSE total_print END) AS total_new'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category');

        return [
            'jan' => $total->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 1)->where('print_order.print_order_status', 'finish')->get_all(),
            'feb' => $total->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 2)->where('print_order.print_order_status', 'finish')->get_all(),
            'mar' => $total->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 3)->where('print_order.print_order_status', 'finish')->get_all(),
            'apr' => $total->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 4)->where('print_order.print_order_status', 'finish')->get_all()
        ];
    }

    public function total_exemplar2($filters)
    {
        $total = $this->select(['total', '(CASE WHEN total_postprint IS NOT NULL THEN total_postprint ELSE total_print END) AS total_new'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category');

        return [
            'may' => $total->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 5)->where('print_order.print_order_status', 'finish')->get_all(),
            'jun' => $total->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 6)->where('print_order.print_order_status', 'finish')->get_all(),
            'jul' => $total->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 7)->where('print_order.print_order_status', 'finish')->get_all(),
            'aug' => $total->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 8)->where('print_order.print_order_status', 'finish')->get_all()
        ];
    }

    public function total_exemplar3($filters)
    {
        $total = $this->select(['total', '(CASE WHEN total_postprint IS NOT NULL THEN total_postprint ELSE total_print END) AS total_new'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category');

        return [
            'sep' => $total->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 9)->where('print_order.print_order_status', 'finish')->get_all(),
            'oct' => $total->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 10)->where('print_order.print_order_status', 'finish')->get_all(),
            'nov' => $total->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 11)->where('print_order.print_order_status', 'finish')->get_all(),
            'dec' => $total->when('date_year', $filters['date_year'])->where('MONTH(print_order.entry_date)', 12)->where('print_order.print_order_status', 'finish')->get_all()
        ];
    }

    public function filter_detail($filters)
    {
        $filter = $this->select(['print_order_id', 'print_order.book_id', 'book.draft_id', 'book_title', 'CONCAT_WS(" - ", print_order.name, book.book_title) AS title', 'category_name', 'draft.is_reprint', 'print_order.*', '(CASE WHEN total_postprint IS NOT NULL THEN total_postprint ELSE total_print END) AS total_new'])
            ->join_table('book', 'print_order', 'book')
            ->join_table('draft', 'book', 'draft')
            ->join_table('category', 'draft', 'category')
            ->order_by('title', 'ASC');

        return [
            'data'              => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->get_all(), //all data
            'total'             => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->count(), //count all data
            'new'               => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.category', 'new')->count(), // cetak baru
            'revise'            => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.category', 'revise')->count(), // cetak ulang revisi
            'reprint'           => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.category', 'reprint')->count(), // cetak ulang non revisi
            'nonbook'           => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.category', 'nonbook')->count(), // cetak non buku
            'outsideprint'      => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.category', 'outsideprint')->count(), // cetak di luar
            'from_outside'      => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.category', 'from_outside')->count(), // cetak dari luar
            'pod'               => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.type', 'pod')->count(), // cetak pod
            'offset'            => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.type', 'offset')->count(), // cetak offset
            'laminate_inside'   => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.location_laminate', 'inside')->count(), // laminasi dalam
            'laminate_outside'  => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.location_laminate', 'outside')->count(), // laminasi luar
            'laminate_partial'  => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.location_laminate', 'partial')->count(), // laminasi parsial
            'binding_inside'    => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.location_binding', 'inside')->count(), // jilid dalam
            'binding_outside'   => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.location_binding', 'outside')->count(), // jilid luar
            'binding_partial'   => $filter->when('date_year', $filters['date_year'])->when('date_month', $filters['date_month'])->where('print_order.print_order_status', 'finish')->where('print_order.location_binding', 'partial')->count(), // jilid parsial
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
}


/* End of file Production_report_model.php */