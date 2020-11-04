<?php defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Operator_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'home';

        // load model
        $this->load->model('home_model', 'home');
    }

    public function index($page = null)
    {
        $dashboard_text = $this->home->get('setting');

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

            // status draft
            $count['draft_desk'] = $this->home->count_progress('desk_screening');
            $count['draft_review'] = $this->home->count_progress('review');
            $count['draft_edit'] = $this->home->count_progress('edit');
            $count['draft_layout'] = $this->home->count_progress('layout');
            $count['draft_proofread'] = $this->home->count_progress('proofread');
            $count['draft_final'] = $this->home->count_progress('final');
            $count['draft_reprint'] = $this->home->where('is_reprint', 'y')->count('draft');

            //$count['draft_approved'] = $count['draft_desk_lolos']+$count['draft_review_lolos'];
            $count['draft_in_progress']    = $count['draft_edit'] + $count['draft_layout'] + $count['draft_proofread'];
            $count['draft_rejected_total'] = $this->home->count_progress('reject');

            // PRINT ORDER
            $print_order = $this->home->print_order();

            $status = [];
            foreach ($print_order as $value) {
                if (isset($value->category)) {
                    array_push($status, $value->print_order_status);
                }
            }

            $category = [];
            foreach ($print_order as $value) {
                if (isset($value->category)) {
                    array_push($category, $value->category);
                }
            }

            $count["total_print_order"] = count($print_order);
            $count["total_preprint"] = ((array_count_values($status)['preprint'] ?? 0) + (array_count_values($status)['preprint_approval'] ?? 0) + (array_count_values($status)['preprint_finish'] ?? 0)) ?? 0;
            $count["total_print"] = ((array_count_values($status)['print'] ?? 0) + (array_count_values($status)['print_approval'] ?? 0) + (array_count_values($status)['print_finish'] ?? 0)) ?? 0;
            $count["total_postprint"] = ((array_count_values($status)['postprint'] ?? 0) + (array_count_values($status)['postprint_approval'] ?? 0) + (array_count_values($status)['postprint_finish'] ?? 0)) ?? 0;
            $count["total_new"] = array_count_values($category)['new'] ?? 0;
            $count["total_revise"] = array_count_values($category)['revise'] ?? 0;
            $count["total_reprint"] = array_count_values($category)['reprint'] ?? 0;
            $count["total_nonbook"] = array_count_values($category)['nonbook'] ?? 0;
            $count["total_outsideprint"] = array_count_values($category)['outsideprint'] ?? 0;
            $count["total_from_outside"] = array_count_values($category)['from_outside'] ?? 0;
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
            $categories = $this->home->order_by('category_name')->get_all_where("category_status = 'y'", 'category');
            $count['draft_total'] = $this->home->count_progress_author();
            $count['draft_desk'] = $this->home->count_progress_author('desk_screening');
            $count['draft_review'] = $this->home->count_progress_author('review');
            $count['draft_edit'] = $this->home->count_progress_author('edit');
            $count['draft_layout'] = $this->home->count_progress_author('layout');
            $count['draft_proofread'] = $this->home->count_progress_author('proofread');
            $count['draft_reject'] = $this->home->count_progress_author('reject');
            $count['draft_approve'] = $this->home->count_progress_author('approve');
            $count['draft_book']      = $this->home->join_table('draft', 'book', 'draft')
                ->join_table('draft_author', 'draft', 'draft')
                ->join_table('author', 'draft_author', 'author')
                ->join_table('user', 'author', 'user')
                ->where('user.username', $this->username)
                ->count('book');
        } elseif ($this->level == 'editor' || $this->level == 'layouter') {
            $count['total']    = $this->home->count_progress_staff();
            $count['desk_screening']     = $this->home->where('draft_status', 0)->count('draft');
            $count['done']    = $this->home->count_progress_staff('done');
            $count['wait']    = $this->home->count_progress_staff('wait');
            $count['approve'] = $this->home->count_progress_staff('approve');
            $count['reject'] = $this->home->count_progress_staff('reject');
        } elseif ($this->level == 'staff_percetakan') {
            // PRINT ORDER
            $print_order = $this->home->print_order();

            $status = [];
            foreach ($print_order as $value) {
                if (isset($value->category)) {
                    array_push($status, $value->print_order_status);
                }
            }

            $count["total_print_order"] = count($print_order);
            $count["total_ongoing"] = ((array_count_values($status)['preprint'] ?? 0) + (array_count_values($status)['preprint_approval'] ?? 0) + (array_count_values($status)['preprint_finish'] ?? 0) + (array_count_values($status)['preprint'] ?? 0) + (array_count_values($status)['preprint_approval'] ?? 0) + (array_count_values($status)['preprint_finish'] ?? 0) + (array_count_values($status)['preprint'] ?? 0) + (array_count_values($status)['preprint_approval'] ?? 0) + (array_count_values($status)['preprint_finish'] ?? 0)) ?? 0;
            $count["total_waiting"] = array_count_values($status)['waiting'] ?? 0;
            $count["total_finish"] = array_count_values($status)['reject'] ?? 0;
            $count["total_reject"] = array_count_values($status)['finish'] ?? 0;
        }

        $pages     = $this->pages;
        $main_view = 'home/index';
        $this->load->view('template', compact('dashboard_text', 'categories', 'count', 'drafts_newest', 'drafts', 'pages', 'main_view'));
    }
}
