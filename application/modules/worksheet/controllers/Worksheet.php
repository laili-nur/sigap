<?php defined('BASEPATH') or exit('No direct script access allowed');
class Worksheet extends Operator_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'worksheet';

        // author dan reviewer tidak boleh akses halaman ini
        if ($this->level == 'author' || $this->level == 'reviewer') {
            redirect();
        }

        $this->load->model('draft/draft_model', 'draft');
        // load model
        $this->load->model('worksheet_model', 'worksheet');
    }

    public function index($page = null)
    {
        $filters = [
            'keyword' => $this->input->get('keyword', true),
            'status'  => $this->input->get('status', true),
            'reprint' => $this->input->get('reprint', true),
            'revise'  => $this->input->get('revise', true),
        ];

        // custom per page
        $this->worksheet->per_page = $this->input->get('per_page', true) ?? 10;

        $get_data = $this->worksheet->filter_data($filters, $page);

        $worksheets = $get_data['data'];
        $total      = $get_data['count'];
        $pages      = $this->pages;
        $main_view  = 'worksheet/index_worksheet';
        $pagination = $this->worksheet->make_pagination(site_url('worksheet'), 2, $total);
        $this->load->view('template', compact('pages', 'main_view', 'worksheets', 'pagination', 'total'));
    }

    public function edit($id = null)
    {
        $worksheet = $this->worksheet->where('worksheet_id', $id)->get();

        $draft = $this->draft->get_where(['draft_id' => $worksheet->draft_id]);

        if (!$worksheet) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }
        if (!$_POST) {
            $input = (object) $worksheet;
        } else {
            $input = (object) $this->input->post(null, true);

            $input->worksheet_deadline = empty_to_null($input->worksheet_deadline);
            $input->worksheet_end_date = empty_to_null($input->worksheet_end_date);
        }

        if (!$this->worksheet->validate()) {
            $pages       = $this->pages;
            $main_view   = 'worksheet/form_worksheet';
            $form_action = "worksheet/edit/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input', 'draft'));
            return;
        }

        // pic merupakan user yang login
        $input->worksheet_pic = $this->username;
        // jika diterima atau ditolak, simpan tanggal selesai
        if ($input->worksheet_status == 1 || $input->worksheet_status == 2) {
            $input->worksheet_end_date = now();
        }

        $this->db->trans_begin();

        // update lembar kerja
        $this->worksheet->where('worksheet_id', $id)->update($input);

        // update draft status
        // worksheet_status berisi 0 | 1 | 2 sesuai dengan draft status
        $this->worksheet->update_draft_status($worksheet->draft_id, ['draft_status' => $input->worksheet_status]);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        }

        redirect($this->pages);
    }

    // untuk menyetujui atau menolak draft
    public function action($id, $worksheet_status)
    {
        $worksheet = $this->worksheet->where('worksheet_id', $id)->get();
        if (!$worksheet) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        $this->db->trans_begin();

        // update lembar kerja
        $this->worksheet->where('worksheet_id', $id)->update([
            'worksheet_status' => $worksheet_status,
            'worksheet_pic'    => $this->username,
            'worksheet_end_date' => now()
        ]);

        // update draft status
        // worksheet_status berisi 0 | 1 | 2 sesuai dengan draft status
        $this->worksheet->update_draft_status($worksheet->draft_id, ['draft_status' => $worksheet_status]);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        }

        redirect($this->pages);
    }

    public function unique_data($str, $data_key)
    {
        $worksheet_id = $this->input->post('worksheet_id');
        if (!$str) {
            return true;
        }
        $this->worksheet->where($data_key, $str);
        !$worksheet_id || $this->worksheet->where_not('worksheet_id', $worksheet_id);
        $worksheet = $this->worksheet->get();
        if ($worksheet) {
            $this->form_validation->set_message('unique_data', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }
}
