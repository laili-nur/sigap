<?php defined('BASEPATH') or exit('No direct script access allowed');
class Document extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'document';

        $this->load->model('document_model', 'document');
    }

    public function index($page = null)
    {
        $filters = [
            'year'    => $this->input->get('year', true),
            'keyword' => $this->input->get('keyword', true),
        ];

        $get_data = $this->document->filter_document($filters, $page);

        $documents  = $get_data['documents'];
        $total      = $get_data['total'];
        $pages      = $this->pages;
        $main_view  = 'document/index_document';
        $pagination = $this->document->make_pagination(site_url('document'), 2, $total);
        $this->load->view('template', compact('pagination', 'pages', 'main_view', 'documents', 'total'));
    }

    public function add()
    {
        if (!$_POST) {
            $input = (object) $this->document->get_default_values();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if ($this->document->validate()) {
            if (!empty($_FILES) && $_FILES['document_file']['size'] > 0) {
                $getextension     = explode(".", $_FILES['document_file']['name']);
                $document_file_name = str_replace(" ", "_", $input->document_name . '_' . date('YmdHis') . "." . $getextension[1]);  // document file name
                $upload           = $this->document->upload_document_file('document_file', $document_file_name);
                if ($upload) {
                    $input->document_file = $document_file_name;  // Data for column "document".
                }
            }
        }
        if (!$this->document->validate() || $this->form_validation->error_array()) {
            $pages       = $this->pages;
            $main_view   = 'document/form_document';
            $form_action = 'document/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->document->insert($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
        }
        redirect($this->pages);
    }

    public function edit($doc_id = null)
    {
        $document = $this->document->where('document_id', $doc_id)->get();
        if (!$document) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }
        if (!$_POST) {
            $input = (object) $document;
        } else {
            $input = (object) $this->input->post(null);
        }

        if ($this->document->validate()) {
            if (!empty($_FILES) && $_FILES['document_file']['size'] > 0) {
                $getextension     = explode(".", $_FILES['document_file']['name']);
                $document_file_name = str_replace(" ", "_", $input->document_name . '_' . date('YmdHis') . "." . $getextension[1]);  // document file name
                $upload           = $this->document->upload_document_file('document_file', $document_file_name);
                if ($upload) {
                    $input->document_file = $document_file_name;  // Data for column "document".
                    // Delete old draft file
                    if ($document->document_file) {
                        $this->document->delete_document_file($document->document_file);
                    }
                }
            }
        }

        if (!$this->document->validate()) {
            $pages       = $this->pages;
            $main_view   = 'document/form_document';
            $form_action = "document/edit/$doc_id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if (empty($input->document_year)) {
            $input->document_year = date('Y');
        }

        if ($this->document->where('document_id', $doc_id)->update($input)) {
            $this->session->set_flashdata('success', $this->lang->line('toast_edit_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_edit_fail'));
        }

        redirect($this->pages);
    }

    public function delete($doc_id = null)
    {
        $document = $this->document->where('document_id', $doc_id)->get();
        if (!$document) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }
        if ($this->document->where('document_id', $doc_id)->delete()) {
            $this->document->delete_document_file($document->document_file);
            $this->session->set_flashdata('success', $this->lang->line('toast_delete_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_delete_fail'));
        }

        redirect($this->pages);
    }
}
