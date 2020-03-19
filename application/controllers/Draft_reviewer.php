<?php defined('BASEPATH') or exit('No direct script access allowed');

class Draft_reviewer extends Operator_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'draft_reviewer';
    }

    // public function index($page = null)
    // {
    //     $draft_reviewers = $this->draft_reviewer->join('draft')->join('reviewer')->order_by('draft.draft_id')->order_by('reviewer.reviewer_id')->order_by('draft_reviewer_id')->paginate($page)->get_all();
    //     $tot             = $this->draft_reviewer->join('draft')->join('reviewer')->order_by('draft.draft_id')->order_by('reviewer.reviewer_id')->order_by('draft_reviewer_id')->get_all();
    //     $total           = count($tot);
    //     $pages           = $this->pages;
    //     $main_view       = 'draftreviewer/index_draft_reviewer';
    //     $pagination      = $this->draft_reviewer->make_pagination(site_url('draftreviewer'), 2, $total);

    //     $this->load->view('template', compact('pages', 'main_view', 'draft_reviewers', 'pagination', 'total'));
    // }

    public function add()
    {
        $input = (object) $this->input->post(null, true);

        if (!$input->draft_id || !$input->reviewer_id) {
            return $this->send_json_output(false, $this->lang->line('toast_data_not_available'));
        }

        if (!$this->draft_reviewer->validate()) {
            return $this->send_json_output(false, $this->lang->line('toast_data_duplicate'), 422);
        }

        $count_reviewers = count($this->draft_reviewer->get_all_where(['draft_id' => $input->draft_id]));

        if ($count_reviewers == 2) {
            return $this->send_json_output(false, 'Reviewer maksimal 2 orang', 422);
        }

        if ($this->draft_reviewer->insert($input)) {
            return $this->send_json_output(true, $this->lang->line('toast_add_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_add_fail'));
        }
    }

// -- add --
    // public function add()
    // {
    //     $data = array();
    //     if (!$_POST) {
    //         $input = (object) $this->draft_reviewer->get_default_values();
    //     } else {
    //         $input = (object) $this->input->post(null, true);
    //     }

    //     if (!$this->draft_reviewer->validate()) {
    //         $data['validasi'] = false;
    //         echo json_encode($data);
    //         // $pages     = $this->pages;
    //         // $main_view   = 'draftreviewer/form_draft_reviewer';
    //         // $form_action = 'draftreviewer/add';
    //         // $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
    //         return;
    //     }
    //     $datax               = array('draft_id' => $input->draft_id);
    //     $data['jmlreviewer'] = count($this->draft_reviewer->get_all_where($datax));

    //     if ($data['jmlreviewer'] > 1) {
    //         $data['validasi'] = 'max';
    //         echo json_encode($data);
    //         return;
    //     }

    //     if ($this->draft_reviewer->insert($input)) {
    //         $status = array('draft_status' => 4);
    //         $this->draft_reviewer->edit_draft_date($input->draft_id, 'review_start_date');
    //         $this->draft_reviewer->update_draft_status($input->draft_id, $status);
    //         $current_date = strtotime(date('Y-m-d H:i:s'));
    //         $end_date     = 60 * 24 * 60 * 60;
    //         $deadline     = date('Y-m-d H:i:s', ($current_date + $end_date));
    //         $this->draft_reviewer->edit_draft_date($input->draft_id, 'review1_deadline', $deadline);
    //         $this->draft_reviewer->edit_draft_date($input->draft_id, 'review2_deadline', $deadline);
    //         $data['validasi'] = true;
    //         $data['status']   = true;
    //         //$this->session->set_flashdata('success', 'Data saved');
    //     } else {
    //         $data['validasi'] = true;
    //         $data['status']   = false;
    //         //$this->session->set_flashdata('error', 'Data failed to save');
    //     }
    //     echo json_encode($data);
    // }

// -- edit --
    // public function edit($id = null)
    // {
    //     $draft_reviewer = $this->draft_reviewer->where('draft_reviewer_id', $id)->get();
    //     if (!$draft_reviewer) {
    //         $this->session->set_flashdata('warning', 'Draft Reviewer data were not available');
    //         redirect('draftreviewer');
    //     }

    //     if (!$_POST) {
    //         $input = (object) $draft_reviewer;
    //     } else {
    //         $input = (object) $this->input->post(null, true);
    //     }

    //     if (!$this->draft_reviewer->validate()) {
    //         $pages       = $this->pages;
    //         $main_view   = 'draftreviewer/form_draft_reviewer';
    //         $form_action = "draftreviewer/edit/$id";

    //         $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
    //         return;
    //     }

    //     unset($input->search_reviewer);

    //     if ($this->draft_reviewer->where('draft_reviewer_id', $id)->update($input)) {
    //         $this->session->set_flashdata('success', 'Data updated');
    //     } else {
    //         $this->session->set_flashdata('error', 'Data failed to update');
    //     }

    //     redirect('draftreviewer');
    // }

    public function delete($id = null)
    {
        $draft_reviewer = $this->draft_reviewer->where('draft_reviewer_id', $id)->get();
        if (!$draft_reviewer) {
            $message = $this->lang->line('toast_data_not_available');
            return $this->send_json_output(false, $message, 404);
        }

        if ($this->draft_reviewer->where('draft_reviewer_id', $id)->delete()) {
            return $this->send_json_output(true, $this->lang->line('toast_delete_success'));
        } else {
            return $this->send_json_output(false, $this->lang->line('toast_delete_fail'));
        }
    }

    public function unique_draft_reviewer_match()
    {
        $reviewer_id       = $this->input->post('reviewer_id');
        $draft_id          = $this->input->post('draft_id');
        $draft_reviewer_id = $this->input->post('draft_reviewer_id');

        $this->draft_reviewer->where('reviewer_id', $reviewer_id);
        $this->draft_reviewer->where('draft_id', $draft_id);
        !$draft_reviewer_id || $this->draft_reviewer->where_not('draft_reviewer_id', $draft_reviewer_id);
        $draft_reviewer = $this->draft_reviewer->get();

        if ($draft_reviewer) {
            $this->form_validation->set_message('unique_draft_reviewer_match', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }

}