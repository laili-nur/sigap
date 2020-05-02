<?php defined('BASEPATH') or exit('No direct script access allowed');

class Document_model extends MY_Model
{
    protected $per_page = 10;

    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'document_name',
                'label' => 'document_name',
                'rules' => 'trim|max_length[255]|required',
            ],
            [
                'field' => 'document_file',
                'label' => 'document_file',
                'rules' => 'trim',
            ],
            [
                'field' => 'document_file_link',
                'label' => 'document_file_link',
                'rules' => 'trim',
            ],
            [
                'field' => 'document_notes',
                'label' => 'document_notes',
                'rules' => 'trim',
            ],

        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'document_name'      => '',
            'document_file'      => '',
            'document_file_link' => '',
            'document_year'      => date('Y'),
            'document_notes'     => '',
        ];
    }

    public function filter_document($filters, $page)
    {
        $documents = $this->select('*')
            ->like('document_name', $filters['keyword'])
            ->or_like('document_notes', $filters['keyword'])
            ->where('document_year', $filters['year'])
            ->order_by('document_year', 'desc')
            ->order_by('document_name')
            ->paginate($page)
            ->get_all();

        $total = $this->select('*')
            ->like('document_name', $filters['keyword'])
            ->or_like('document_notes', $filters['keyword'])
            ->where('document_year', $filters['year'])
            ->order_by('document_year', 'desc')
            ->order_by('document_name')
            ->count();

        return [
            'documents' => $documents,
            'total'  => $total,
        ];
    }

    public function upload_document_file($fieldname, $documentFileName)
    {
        $config = [
            'upload_path'      => './documentfile/',
            'file_name'        => $documentFileName,
            'allowed_types'    => get_allowed_file_types('document_file')['types'],
            'max_size'         => 51200, // 50MB
            'overwrite'        => true,
            'file_ext_tolower' => true,
        ];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($fieldname)) {
            // Upload OK, return uploaded file info.
            return $this->upload->data();
        } else {
            // Add error to $_error_array
            $this->form_validation->add_to_error_array($fieldname, $this->upload->display_errors('', ''));
            return false;
        }
    }

    public function delete_document_file($document_file)
    {
        if ($document_file != "") {
            if (file_exists("./documentfile/$document_file")) {
                unlink("./documentfile/$document_file");
            }
        }
    }
}
