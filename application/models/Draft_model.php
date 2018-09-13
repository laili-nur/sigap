<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Draft_model extends MY_Model
{
   protected $perPage = 10;
   
   public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'category_id',
                'label' => 'Category ID',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'theme_id',
                'label' => 'Theme ID',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'draft_title',
                'label' => 'Draft Title',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_draft_title'
            ],
            [
                'field' => 'proposed_fund',
                'label' => 'Proposed Fund',
                'rules' => 'trim|required|numeric|min_length[3]|max_length[13]'
            ],
            [
                'field' => 'approved_fund',
                'label' => 'Approved Fund',
                'rules' => 'min_length[3]|max_length[13]'
            ],
            [
                'field' => 'entry_date',
                'label' => 'Entry Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'finish_date',
                'label' => 'Finish Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'print_date',
                'label' => 'Print Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'is_reviewed',
                'label' => 'Is Reviewed',
                'rules' => 'trim'
            ],
            [
                'field' => 'review_notes',
                'label' => 'Review Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'author_review_notes',
                'label' => 'Author Review Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'review_start_deadline',
                'label' => 'Review Start Deadline',
                'rules' => 'trim'
            ],
            [
                'field' => 'review_upload_date',
                'label' => 'Review Upload Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'review_end_deadline',
                'label' => 'Review End Deadline',
                'rules' => 'trim'
            ],
            [
                'field' => 'is_revised',
                'label' => 'Is Revised',
                'rules' => 'trim'
            ],
            [
                'field' => 'revise_notes',
                'label' => 'Revise Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'is_edited',
                'label' => 'Is Edited',
                'rules' => 'trim'
            ],
            [
                'field' => 'edit_notes',
                'label' => 'Edit Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'author_edit_notes',
                'label' => 'Author Edit Notes',
                'rules' => 'trim'
            ],

            [
                'field' => 'edit_start_deadline',
                'label' => 'Edit Start Deadline',
                'rules' => 'trim'
            ],
            [
                'field' => 'author_upload_date',
                'label' => 'Author Upload Date',
                'rules' => 'trim'
            ],            
            [
                'field' => 'edit_end_deadline',
                'label' => 'Edit End Deadline',
                'rules' => 'trim'
            ],            
            [
                'field' => 'is_layouted',
                'label' => 'Is Layouted',
                'rules' => 'trim'
            ],
            [
                'field' => 'layout_notes',
                'label' => 'Layout Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'author_layout_notes',
                'label' => 'Author Layout Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'layout_start_deadline',
                'label' => 'Layout Start Deadline',
                'rules' => 'trim'
            ],
            [
                'field' => 'layout_upload_date',
                'label' => 'Layout Upload Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'layout_end_deadline',
                'label' => 'Layout End Deadline',
                'rules' => 'trim'
            ],
            [
                'field' => 'is_reprint',
                'label' => 'Is Reprint',
                'rules' => 'trim'
            ],
            [
                'field' => 'draft_notes',
                'label' => 'Draft Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'proofread_notes',
                'label' => 'Proofread Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'author_proofread_notes',
                'label' => 'Author Proofread Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'proofread_start_deadline',
                'label' => 'Proofread Start Deadline',
                'rules' => 'trim'
            ],
            [
                'field' => 'proofread_upload_date',
                'label' => 'Proofread Upload Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'proofread_end_deadline',
                'label' => 'Proofread End Deadline',
                'rules' => 'trim'
            ]
            
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'category_id'                   => '',
            'theme_id'                      => '',
            'draft_title'                   => '',
//            'draft_file'                    => '',
            'proposed_fund'                 => '',
            'approved_fund'                 => '',
            'entry_date'                    => '',
            'finish_date'                   => '',
            'print_date'                    => '',
            'is_reviewed'                   => '',
            'review_notes'                  => '',
            'author_review_notes'           => '',
            'review_start_deadline'             => '',
            'review_upload_date'          => '',
            'review_end_deadline'               => '',
            'is_revised'                    => '',
            'revise_notes'                  => '',
            'is_edited'                     => '',
            'edit_notes'                    => '',
            'author_edit_notes'             => '',
            'edit_start_deadline'               => '',
            'edit_upload_date'          => '',
            'edit_end_deadline'                 => '',
            'is_layouted'                   => '',
            'layout_notes'                  => '',
            'author_layout_notes'           => '',
            'layout_start_deadline'             => '',
            'layout_upload_date'          => '',
            'layout_end_deadline'               => '',
            'is_reprint'                    => '',
            'draft_notes'                   => '',
            'proofread_notes'               => '',
            'author_proofread_notes'        => '',
            'proofread_start_deadline'          => '',
            'proofread_upload_date'          => '',
            'proofread_end_deadline'            => ''
        ];
    }
   
    public function uploadDraftfile($fieldname, $draftFileName)
    {
        $config = [
            'upload_path'      => './draftfile/',
            'file_name'        => $draftFileName,
            'allowed_types'    => 'docx|doc',    // docx only
            'max_size'         => 15360,     // 15MB
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

    public function deleteDraftfile($draftFile)
    {
        if (file_exists("./draftfile/$draftFile")) {
            unlink("./draftfile/$draftFile");
        }
    }


}