<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('draft/draft_model', 'draft');
    }


    public function count_progress($progress)
    {
        return $this
            ->when('progress', $progress)
            ->count('draft');
    }

    public function when($params, $data)
    {
        // ambil logic dari model draft
        return $this->draft->when($params, $data);
    }

    public function count_progress_author($progress = '')
    {
        $filters['progress'] = $progress;
        $filters['keyword'] = '';

        $filter_draft_for_author = $this->draft->filter_draft_for_author($filters, $this->session->userdata('username'), 1);
        return $filter_draft_for_author['total'];
    }

    public function count_progress_staff($progress = '')
    {
        $filters['progress'] = $progress;
        $filters['keyword'] = '';
        $filters['status'] = '';
        $filters['reprint'] = '';
        $filters['category'] = '';
        $username = $this->session->userdata('username');

        if ($progress == 'wait') {
            $filters['status'] = 'n';
        } elseif ($progress == 'done') {
            $filters['status'] = 'y';
        } elseif ($progress == 'approve') {
            $filters['status'] = 'approve';
        } elseif ($progress == 'reject') {
            $filters['status'] = 'reject';
        }

        $filter_draft_for_staff = $this->draft->filter_draft_for_staff($filters, $username, 1);
        return $filter_draft_for_staff['total'];
    }
}

/* End of file Home_model.php */
/* Location: ./application/models/Home_model.php */
