<?php defined('BASEPATH') or exit('No direct script access allowed');

class Draft_reviewer extends Operator_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'draft_reviewer';
    }

    public function index($page = null)
    {
        $draft_reviewers = $this->draft_reviewer->join('draft')->join('reviewer')->order_by('draft.draft_id')->order_by('reviewer.reviewer_id')->order_by('draft_reviewer_id')->paginate($page)->get_all();
        $tot             = $this->draft_reviewer->join('draft')->join('reviewer')->order_by('draft.draft_id')->order_by('reviewer.reviewer_id')->order_by('draft_reviewer_id')->get_all();
        $total           = count($tot);
        $pages           = $this->pages;
        $main_view       = 'draftreviewer/index_draft_reviewer';
        $pagination      = $this->draft_reviewer->make_pagination(site_url('draftreviewer'), 2, $total);

        $this->load->view('template', compact('pages', 'main_view', 'draft_reviewers', 'pagination', 'total'));
    }

// -- add --
    public function add()
    {
        $data = array();
        if (!$_POST) {
            $input = (object) $this->draft_reviewer->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->draft_reviewer->validate()) {
            $data['validasi'] = false;
            echo json_encode($data);
            // $pages     = $this->pages;
            // $main_view   = 'draftreviewer/form_draft_reviewer';
            // $form_action = 'draftreviewer/add';
            // $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        $datax               = array('draft_id' => $input->draft_id);
        $data['jmlreviewer'] = count($this->draft_reviewer->get_all_where($datax));

        if ($data['jmlreviewer'] > 1) {
            $data['validasi'] = 'max';
            echo json_encode($data);
            return;
        }

        if ($this->draft_reviewer->insert($input)) {
            $status = array('draft_status' => 4);
            $this->draft_reviewer->edit_draft_date($input->draft_id, 'review_start_date');
            $this->draft_reviewer->update_draft_status($input->draft_id, $status);
            $current_date = strtotime(date('Y-m-d H:i:s'));
            $end_date     = 60 * 24 * 60 * 60;
            $deadline     = date('Y-m-d H:i:s', ($current_date + $end_date));
            $this->draft_reviewer->edit_draft_date($input->draft_id, 'review1_deadline', $deadline);
            $this->draft_reviewer->edit_draft_date($input->draft_id, 'review2_deadline', $deadline);
            $data['validasi'] = true;
            $data['status']   = true;
            //$this->session->set_flashdata('success', 'Data saved');
        } else {
            $data['validasi'] = true;
            $data['status']   = false;
            //$this->session->set_flashdata('error', 'Data failed to save');
        }
        echo json_encode($data);

    }

// -- edit --
    public function edit($id = null)
    {
        $draft_reviewer = $this->draft_reviewer->where('draft_reviewer_id', $id)->get();
        if (!$draft_reviewer) {
            $this->session->set_flashdata('warning', 'Draft Reviewer data were not available');
            redirect('draftreviewer');
        }

        if (!$_POST) {
            $input = (object) $draft_reviewer;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->draft_reviewer->validate()) {
            $pages       = $this->pages;
            $main_view   = 'draftreviewer/form_draft_reviewer';
            $form_action = "draftreviewer/edit/$id";

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        unset($input->search_reviewer);

        if ($this->draft_reviewer->where('draft_reviewer_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data updated');
        } else {
            $this->session->set_flashdata('error', 'Data failed to update');
        }

        redirect('draftreviewer');
    }

// -- delete --
    public function delete($id = null)
    {
        $draft_reviewer = $this->draft_reviewer->where('draft_reviewer_id', $id)->get();
        if (!$draft_reviewer) {
            $this->session->set_flashdata('warning', 'Draft Reviewer data were not available');
            redirect('draftreviewer');
        }

        if ($this->draft_reviewer->where('draft_reviewer_id', $id)->delete()) {
            $this->session->set_flashdata('success', 'Data deleted');
        } else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }

        redirect('draftreviewer');
    }

////-- auto complete --
    //    public function reviewer_auto_complete()
    //    {
    //        $key = $this->input->post('key');
    //        $reviewers = $this->draft_reviewer->liveSearchReviewer($key);
    //
    //        foreach ($reviewers as $reviewer) {
    //            // Put in bold the written text.
    //            $reviewer_nip        = str_replace($key, '<strong>'.$key.'</strong>', $reviewer->reviewer_nip );
    //            $reviewer_name = preg_replace("#($key)#i", "<strong>$1</strong>", $reviewer->reviewer_name);
    //
    //            // Add new option.
    //            $str  = '<li onclick="setItemReviewer(\''.$reviewer->reviewer_name.'\'); makeHiddenIdReviewer(\''.$reviewer->reviewer_id.'\')">';
    //            $str .= "$reviewer_nip - $reviewer_name";
    //            $str .= "</li>";
    //
    //            echo $str;
    //        }
    //    }

// -- search --
    public function search($page = null)
    {
        $keywords        = $this->input->get('keywords', true);
        $draft_reviewers = $this->draft_reviewer->like('draft_reviewer_id', $keywords)
            ->or_like('draft_title', $keywords)
            ->or_like('reviewer_name', $keywords)
            ->or_like('reviewer_nip', $keywords)
            ->join('draft')
            ->join('reviewer')
            ->order_by('draft_reviewer_id')
            ->order_by('draft.draft_title')
            ->order_by('reviewer.reviewer_name')
            ->order_by('reviewer.reviewer_nip')
            ->paginate($page)
            ->get_all();
        $tot = $this->draft_reviewer->like('draft_reviewer_id', $keywords)
            ->or_like('draft_title', $keywords)
            ->or_like('reviewer_name', $keywords)
            ->or_like('reviewer_nip', $keywords)
            ->join('draft')
            ->join('reviewer')
            ->order_by('draft_reviewer_id')
            ->order_by('draft.draft_title')
            ->order_by('reviewer.reviewer_name')
            ->order_by('reviewer.reviewer_nip')
            ->get_all();
        $total = count($tot);

        $pagination = $this->draft_reviewer->make_pagination(site_url('draft_reviewer/search/'), 3, $total);

        if (!$draft_reviewers) {
            $this->session->set_flashdata('warning', 'Data were not found');
            redirect('draftreviewer');
        }

        $pages     = $this->pages;
        $main_view = 'draftreviewer/index_draft_reviewer';
        $this->load->view('template', compact('pages', 'main_view', 'draft_reviewers', 'pagination', 'total'));
    }

    /*
    |-----------------------------------------------------------------
    | Callback
    |-----------------------------------------------------------------
     */
//    public function alpha_coma_dash_dot_space($str)
    //    {
    //        if ( !preg_match('/^[a-zA-Z .,\-]+$/i',$str) )
    //        {
    //            $this->form_validation->set_message('alpha_coma_dash_dot_space', 'Can only be filled with letters, numbers, dash(-), dot(.), and comma(,).');
    //            return false;
    //        }
    //    }
    //
    public function unique_draft_reviewer_match()
    {
        $reviewer_id       = $this->input->post('reviewer_id');
        $draft_id          = $this->input->post('draft_id');
        $draft_reviewer_id = $this->input->post('draft_reviewer_id');

        $this->draft_reviewer->where('reviewer_id', $reviewer_id);
        $this->draft_reviewer->where('draft_id', $draft_id);
        !$draft_reviewer_id || $this->draft_reviewer->where('draft_reviewer_id !=', $draft_reviewer_id);
        $draft_reviewer = $this->draft_reviewer->get();

        if (count($draft_reviewer)) {
            $this->form_validation->set_message('unique_draft_reviewer_match', 'Both of %s has been used');
            return false;
        }
        return true;
    }

}
