<?php defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Operator_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'home';
    }

    public function index($page = null)
    {
        $tulisan_dashboard = $this->home->get('setting');

        // menampilkan kategori yang open saja
        $current_date   = strtotime(date('Y-m-d'));
        $all_categories = $this->home->order_by('category_name')->get_all_where("category_status = 'y'", 'category');
        foreach ($all_categories as $key) {
            $close_date = $key->date_close;
            $close_date = strtotime($close_date);

            if ($current_date >= $close_date) {
                $data = array('category_status' => 'n');
                $this->home->where('category_id', $key->category_id)->update($data, 'category');
            }
        }

        $drafts        = array();
        $count         = array();
        $categories    = '';
        $drafts_newest = '';

        // menampilkan info sesuai level
        if (is_admin()) {
            // total data
            $count['total_category'] = $this->home->count('category');
            $count['total_draft']    = $this->home->count('draft');
            $count['total_book']     = $this->home->count('book');
            $count['total_author']   = $this->home->count('author');
            $count['total_reviewer'] = $this->home->count('reviewer');

            //  desk screening dan lolos desk screening
            $count['draft_desk'] = $this->home->count_progress('desk_screening');
            // review
            $count['draft_review'] = $this->home->count_progress('review');
            // edit
            $count['draft_edit'] = $this->home->count_progress('edit');
            // layout
            $count['draft_layout'] = $this->home->count_progress('layout');
            // proofread
            $count['draft_proofread'] = $this->home->count_progress('proofread');
            // cetak
            $count['draft_print'] = $this->home->count_progress('print');
            //final
            $count['draft_final'] = $this->home->count_progress('final');
            // cetak ulang
            $count['draft_reprint'] = $this->home->where('is_reprint', 'y')->count('draft');

            //$count['draft_approved'] = $count['draft_desk_lolos']+$count['draft_review_lolos'];
            $count['draft_in_progress']    = $count['draft_edit'] + $count['draft_layout'] + $count['draft_proofread'] + $count['draft_print'];
            $count['draft_rejected_total'] = $this->home->count_progress('reject');
        } elseif ($this->level == 'reviewer') {
            $drafts        = $this->home->join_table('draft_reviewer', 'draft', 'draft')->join_table('reviewer', 'draft_reviewer', 'reviewer')->join_table('user', 'reviewer', 'user')->where('user.username', $this->username)->get_all('draft');
            $drafts_newest = $this->home->join_table('draft_reviewer', 'draft', 'draft')->join_table('reviewer', 'draft_reviewer', 'reviewer')->join_table('user', 'reviewer', 'user')->where('user.username', $this->username)->limit(5)->order_by('entry_date', 'desc')->get_all('draft');

            foreach ($drafts_newest as $key => $value) {
                $rev        = $this->home->get_id_and_name('reviewer', 'draft_reviewer', $value->draft_id, 'draft');
                $value->rev = key(array_filter(
                    $rev,
                    function ($e) {
                        return $e->reviewer_id == $this->session->userdata('role_id');
                    }
                ));

                if ($value->rev == 0) {
                    if (!empty($value->review1_deadline)) {
                        $value->deadline = $value->review1_deadline;
                        $value->flag     = $value->review1_flag;
                    }
                } elseif ($value->rev == 1) {
                    if (!empty($value->review2_deadline)) {
                        $value->deadline = $value->review2_deadline;
                        $value->flag     = $value->review2_flag;
                    }
                }
            }

            $count_sudah  = 0;
            $count_belum  = 0;
            $count_sedang = 0;
            $count_total  = count($drafts);

            foreach ($drafts as $key => $value) {
                $rev        = $this->home->get_id_and_name('reviewer', 'draft_reviewer', $value->draft_id, 'draft');
                $value->rev = key(array_filter(
                    $rev,
                    function ($e) {
                        return $e->reviewer_id == $this->session->userdata('role_id');
                    }
                ));

                if ($value->rev == 0) {
                    if ($value->review1_flag != '') {
                        $count_sudah++;
                    } elseif ($value->review1_notes == '') {
                        $count_belum++;
                    } else {
                        $count_sedang++;
                    }
                }
                if ($value->rev == 1) {
                    if ($value->review2_flag != '') {
                        $count_sudah++;
                    } elseif ($value->review2_notes == '') {
                        $count_belum++;
                    } else {
                        $count_sedang++;
                    }
                }
            }

            $count['count_sudah']  = $count_sudah;
            $count['count_sedang'] = $count_sedang;
            $count['count_belum']  = $count_belum;
            $count['count_total']  = $count_total;
        } elseif ($this->level == 'author') {
            $categories               = $this->home->order_by('category_name')->get_all_where("category_status = 'y'", 'category');
            $count['draft_total']     = $this->home->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')->join_table('user', 'author', 'user')->where('user.username', $this->username)->count('draft');
            $count['draft_desk']      = $this->home->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')->join_table('user', 'author', 'user')->where('user.username', $this->username)->where('draft_status', '0')->count('draft');
            $count['draft_review']    = $this->home->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')->join_table('user', 'author', 'user')->where('user.username', $this->username)->where('draft_status', '4')->where('is_review', 'n')->count('draft');
            $count['draft_edit']      = $this->home->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')->join_table('user', 'author', 'user')->where('user.username', $this->username)->where('is_review', 'y')->where('is_edit', 'n')->where_not('draft_status', '99')->count('draft');
            $count['draft_layout']    = $this->home->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')->join_table('user', 'author', 'user')->where('user.username', $this->username)->where('is_edit', 'y')->where('is_layout', 'n')->where_not('draft_status', '99')->count('draft');
            $count['draft_proofread'] = $this->home->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')->join_table('user', 'author', 'user')->where('user.username', $this->username)->where('is_layout', 'y')->where('is_proofread', 'n')->where_not('draft_status', '99')->count('draft');
            $count['draft_approved']  = $this->home->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')->join_table('user', 'author', 'user')->where_not('draft_status', '99')->where_not('draft_status', '2')->where('user.username', $this->username)->count('draft');
            $count['draft_rejected']  = $this->home->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')->join_table('user', 'author', 'user')->where('draft_status', '99')->where('user.username', $this->username)->count('draft');
            $count['draft_book']      = $this->home->join_table('draft', 'book', 'draft')->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')->join_table('user', 'author', 'user')->where('user.username', $this->username)->count('book');
        } elseif ($this->level == 'editor') {
            $count['draft_total']    = $this->home->join_table('responsibility', 'draft', 'draft')->join_table('user', 'responsibility', 'user')->where('user.username', $this->username)->count('draft');
            $count['draft_desk']     = $this->home->where('draft_status', 0)->count('draft');
            $count['draft_sudah']    = $this->home->join_table('responsibility', 'draft', 'draft')->join_table('user', 'responsibility', 'user')->where_not('edit_notes', '')->where('user.username', $this->username)->count('draft');
            $count['draft_belum']    = $this->home->join_table('responsibility', 'draft', 'draft')->join_table('user', 'responsibility', 'user')->where('edit_notes', '')->where_not('draft_status', 99)->where('user.username', $this->username)->count('draft');
            $count['draft_approved'] = $this->home->join_table('responsibility', 'draft', 'draft')->join_table('user', 'responsibility', 'user')->where('is_edit', 'y')->where('user.username', $this->username)->count('draft');
            $count['draft_rejected'] = $this->home->join_table('responsibility', 'draft', 'draft')->join_table('user', 'responsibility', 'user')->where('is_edit', 'n')->where('draft_status', 99)->where('user.username', $this->username)->count('draft');
        } elseif ($this->level == 'layouter') {
            $count['draft_total']    = $this->home->join_table('responsibility', 'draft', 'draft')->join_table('user', 'responsibility', 'user')->where('user.username', $this->username)->count('draft');
            $count['draft_desk']     = $this->home->where('draft_status', 0)->count('draft');
            $count['draft_sudah']    = $this->home->join_table('responsibility', 'draft', 'draft')->join_table('user', 'responsibility', 'user')->where_not('layout_notes', '')->where('user.username', $this->username)->count('draft');
            $count['draft_belum']    = $this->home->join_table('responsibility', 'draft', 'draft')->join_table('user', 'responsibility', 'user')->where('layout_notes', '')->where_not('draft_status', 99)->where('user.username', $this->username)->count('draft');
            $count['draft_approved'] = $this->home->join_table('responsibility', 'draft', 'draft')->join_table('user', 'responsibility', 'user')->where('is_layout', 'y')->where('user.username', $this->username)->count('draft');
            $count['draft_rejected'] = $this->home->join_table('responsibility', 'draft', 'draft')->join_table('user', 'responsibility', 'user')->where('is_layout', 'n')->where('draft_status', 99)->where('user.username', $this->username)->count('draft');
        }

        $pages     = $this->pages;
        $main_view = 'home/index';
        $this->load->view('template', compact('tulisan_dashboard', 'categories', 'count', 'drafts_newest', 'drafts', 'pages', 'main_view'));
    }
}
