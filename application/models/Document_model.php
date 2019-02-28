<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Document_model extends MY_Model
{
    protected $perPage = 10;
    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'document_name',
                'label' => 'document_name',
                'rules' => 'trim|max_length[255]|required'
            ],
            [
                'field' => 'document_file',
                'label' => 'document_file',
                'rules' => 'trim'
            ],
            [
                'field' => 'document_file_link',
                'label' => 'document_file_link',
                'rules' => 'trim'
            ],
            [
                'field' => 'document_notes',
                'label' => 'document_notes',
                'rules' => 'trim'
            ]
            
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'document_name'  => '',
            'document_file'  => '',
            'document_file_link'     => '',
            'document_year' => date('Y'),
            'document_notes' => ''
        ];
    }

    public function uploadDocumentfile($fieldname, $documentFileName)
    {
        $config = [
            'upload_path'      => './documentfile/',
            'file_name'        => $documentFileName,
            'allowed_types'    => 'docx|doc|pdf|jpeg|jpg|png|xls|xlsx|zip|rar',   
            'max_size'         => 51200,     // 50MB
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
    
    
    public function deleteDocumentfile($documentFile)
    {
        if($documentFile != "") {
            if (file_exists("./documentfile/$documentFile")) {
                unlink("./documentfile/$documentFile");
            }    
        }
    }
}
