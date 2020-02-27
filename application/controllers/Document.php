<?php defined('BASEPATH') or exit('No direct script access allowed');
class Document extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'document';
    }

    public function index($page = null)
    {
        $documents  = $this->document->paginate($page)->order_by('document_year', 'desc')->order_by('document_name')->get_all();
        $total      = $this->document->count();
        $pages      = $this->pages;
        $main_view  = 'document/index_document';
        $pagination = $this->document->make_pagination(site_url('document'), 2, $total);
        $this->load->view('template', compact('pagination', 'pages', 'main_view', 'documents', 'total'));
    }

    public function filter($page = null)
    {
        $filter = $this->input->get('filter', true);
        if ($filter != '') {
            $documents = $this->document->where('document_year', $filter)->paginate($page)->order_by('document_year', 'desc')->order_by('document_name')->get_all();
            $total     = $this->document->where('document_year', $filter)->count();
        } else {
            $documents = $this->document->paginate($page)->order_by('document_year', 'desc')->order_by('document_name')->get_all();
            $total     = $this->document->count();
        }

        $pages      = $this->pages;
        $main_view  = 'document/index_document';
        $pagination = $this->document->make_pagination(site_url('document/filter'), 3, $total);
        $this->load->view('template', compact('pagination', 'pages', 'main_view', 'documents', 'total'));
    }

    public function add()
    {
        if (!$_POST) {
            $input = (object) $this->document->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if ($this->document->validate()) {
            if (!empty($_FILES) && $_FILES['document_file']['size'] > 0) {
                $getextension     = explode(".", $_FILES['document_file']['name']);
                $documentFileName = str_replace(" ", "_", $input->document_name . '_' . date('YmdHis') . "." . $getextension[1]); // document file name
                $upload           = $this->document->uploadDocumentfile('document_file', $documentFileName);
                if ($upload) {
                    $input->document_file = "$documentFileName"; // Data for column "document".

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
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }
        redirect('document');
    }

    public function edit($id = null)
    {
        $document = $this->document->where('document_id', $id)->get();
        if (!$document) {
            $this->session->set_flashdata('warning', 'document data were not available');
            redirect('document');
        }
        if (!$_POST) {
            $input = (object) $document;
        } else {
            $input = (object) $this->input->post(null);
        }

        if ($this->document->validate()) {
            if (!empty($_FILES) && $_FILES['document_file']['size'] > 0) {
                $getextension     = explode(".", $_FILES['document_file']['name']);
                $documentFileName = str_replace(" ", "_", $input->document_name . '_' . date('YmdHis') . "." . $getextension[1]); // document file name
                $upload           = $this->document->uploadDocumentfile('document_file', $documentFileName);
                if ($upload) {
                    $input->document_file = "$documentFileName"; // Data for column "document".
                    // Delete old draft file
                    if ($document->document_file) {
                        $this->document->deleteDocumentfile($document->document_file);
                    }
                }
            }
        }

        if (!$this->document->validate()) {
            $pages       = $this->pages;
            $main_view   = 'document/form_document';
            $form_action = "document/edit/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if (empty($input->document_year)) {
            $input->document_year = date('Y');
        }

        if ($this->document->where('document_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }
        redirect('document');
    }

    public function delete($id = null)
    {
        $document = $this->document->where('document_id', $id)->get();
        if (!$document) {
            $this->session->set_flashdata('warning', 'document data were not available');
            redirect('document');
        }
        if ($this->document->where('document_id', $id)->delete()) {
            $this->document->deleteDocumentfile($document->document_file);
            $this->session->set_flashdata('success', 'Data deleted');
        } else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }
        redirect('document');
    }

    public function search($page = null)
    {
        $keywords   = $this->input->get('keywords', true);
        $documents  = $this->document->like('document_name', $keywords)->or_like('document_year', $keywords)->paginate($page)->get_all();
        $tot        = $this->document->like('document_name', $keywords)->or_like('document_year', $keywords)->get_all();
        $total      = count($tot);
        $pagination = $this->document->make_pagination(site_url('document/search/'), 3, $total);
        if (!$documents) {
            $this->session->set_flashdata('warning', 'Data were not found');
        }
        $pages     = $this->pages;
        $main_view = 'document/index_document';
        $this->load->view('template', compact('pages', 'main_view', 'documents', 'pagination', 'total'));
    }

    public function download($path, $file_name)
    {
        $this->load->helper('download');
        force_download('./' . $path . '/' . $file_name, null);
    }

}
