<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Draft_model extends MY_Model
{
   protected $perPage = 25;
   
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
                'field' => 'author_id[]',
                'label' => 'Author ID',
                'rules' => 'trim|required'
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
            //review
            [
                'field' => 'is_review',
                'label' => 'Is Review',
                'rules' => 'trim'
            ],
            [
                'field' => 'review_start_date',
                'label' => 'Review Start Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'review_end_date',
                'label' => 'Review End Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'review1_file',
                'label' => 'Review 1 File',
                'rules' => 'trim'
            ],
            [
                'field' => 'review1_template',
                'label' => 'Review 1 template',
                'rules' => 'trim'
            ],
            [
                'field' => 'review1_upload_date',
                'label' => 'Review 1 Upload Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'review1_notes',
                'label' => 'Review 1 Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'review1_notes_author',
                'label' => 'Author Review 1 Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'review1_deadline',
                'label' => 'Review 1 Deadline',
                'rules' => 'trim'
            ],
            [
                'field' => 'review2_file',
                'label' => 'Review 2 File',
                'rules' => 'trim'
            ],
            [
                'field' => 'review2_template',
                'label' => 'Review 2 template',
                'rules' => 'trim'
            ],
            [
                'field' => 'review2_upload_date',
                'label' => 'Review 2 Upload Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'review2_notes',
                'label' => 'Review 2 Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'review2_notes_author',
                'label' => 'Author Review 2 Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'review2_deadline',
                'label' => 'Review 2 Deadline',
                'rules' => 'trim'
            ],
            //edit
            [
                'field' => 'is_edit',
                'label' => 'Is Edit',
                'rules' => 'trim'
            ],
            [
                'field' => 'edit_start_date',
                'label' => 'Edit Start Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'edit_end_date',
                'label' => 'Edit End Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'edit_file',
                'label' => 'Edit File',
                'rules' => 'trim'
            ],
            [
                'field' => 'edit_upload_date',
                'label' => 'Edit Upload Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'edit_notes',
                'label' => 'Edit Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'edit_notes_author',
                'label' => 'Author Edit Notes',
                'rules' => 'trim'
            ],
            //layout
            [
                'field' => 'is_layout',
                'label' => 'Is Layout',
                'rules' => 'trim'
            ],
            [
                'field' => 'layout_start_date',
                'label' => 'Layout Start Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'layout_end_date',
                'label' => 'Layout End Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'layout_file',
                'label' => 'Layout File',
                'rules' => 'trim'
            ],
            [
                'field' => 'layout_upload_date',
                'label' => 'Layout Upload Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'layout_notes',
                'label' => 'Layout Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'layout_notes_author',
                'label' => 'Author Layout Notes',
                'rules' => 'trim'
            ],
            //cover
            [
                'field' => 'cover_file',
                'label' => 'Cover File',
                'rules' => 'trim'
            ],
            [
                'field' => 'cover_upload_date',
                'label' => 'Cover Upload Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'cover_notes',
                'label' => 'Cover Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'cover_notes_author',
                'label' => 'Author Cover Notes',
                'rules' => 'trim'
            ],
            //proofread
            [
                'field' => 'is_proofread',
                'label' => 'Is Proofread',
                'rules' => 'trim'
            ],
            [
                'field' => 'proofread_start_date',
                'label' => 'Proofread Start Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'proofread_end_date',
                'label' => 'Proofread End Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'proofread_file',
                'label' => 'Proofread File',
                'rules' => 'trim'
            ],
            [
                'field' => 'proofread_upload_date',
                'label' => 'Proofread Upload Date',
                'rules' => 'trim'
            ],
            [
                'field' => 'proofread_notes',
                'label' => 'Proofread Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'proofread_notes_author',
                'label' => 'Author Proofread Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'draft_status',
                'label' => 'Draft Status',
                'rules' => 'trim'
            ],
            [
                'field' => 'draft_notes',
                'label' => 'Draft Notes',
                'rules' => 'trim'
            ],
            [
                'field' => 'reviewer1_file_link',
                'label' => 'Reviewer1 File Link',
                'rules' => 'trim'
            ],
            [
                'field' => 'reviewer2_file_link',
                'label' => 'Reviewer2 File Link',
                'rules' => 'trim'
            ],
            [
                'field' => 'editor_file_link',
                'label' => 'Editor File Link',
                'rules' => 'trim'
            ],
            [
                'field' => 'layouter_file_link',
                'label' => 'Layouter File Link',
                'rules' => 'trim'
            ],
            [
                'field' => 'cover_file_link',
                'label' => 'Cover File Link',
                'rules' => 'trim'
            ],
            [
                'field' => 'proofread_file_link',
                'label' => 'Proofread File Link',
                'rules' => 'trim'
            ],
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'category_id'                   => '',
            'theme_id'                      => '',
            'draft_title'                   => '',
            'author_id'                     => '',
            'draft_file'                    => '',
            'entry_date'                    => '',
            'finish_date'                   => '',
            'print_date'                    => '',
            'is_review'                     => '',
            'review_start_date'             => '',
            'review_end_date'               => '',
            'review1_file'                  => '',
            'review1_upload_date'           => '',
            'review1_notes'                 => '',
            'review1_notes_author'          => '',
            'review1_deadline'              => '',
            'review2_file'                  => '',
            'review2_upload_date'           => '',
            'review2_notes'                 => '',
            'review2_notes_author'          => '',
            'review2_deadline'              => '',
            'is_edit'                       => '',
            'edit_start_date'               => '',
            'edit_end_date'                 => '',
            'edit_file'                     => '',
            'edit_upload_date'              => '',
            'edit_notes'                    => '',
            'edit_notes_author'             => '',
            'is_layout'                     => '',
            'layout_start_date'             => '',
            'layout_end_date'               => '',
            'layout_file'                   => '',
            'layout_upload_date'            => '',
            'layout_notes'                  => '',
            'layout_notes_author'           => '',
            'cover_file'                    => '',
            'cover_upload_date'             => '',
            'cover_notes'                   => '',
            'cover_notes_author'            => '',
            'is_proofread'                  => '',
            'proofread_start_date'          => '',
            'proofread_end_date'            => '',
            'proofread_file'                => '',
            'proofread_upload_date'         => '',
            'proofread_notes'               => '',
            'proofread_notes_author'        => '',
            'draft_status'                  => '',
            'draft_notes'                   => '',
            'reviewer1_file_link'                => '',
            'reviewer2_file_link'         => '',
            'editor_file_link'               => '',
            'cover_file_link'        => '',
            'layouter_file_link'                  => '',
            'proofread_file_link'                   => '',
        ];
    }

    public function uploadDraftfile($fieldname, $draftFileName)
    {
        $config = [
            'upload_path'      => './draftfile/',
            'file_name'        => $draftFileName,
            'allowed_types'    => 'docx|doc|pdf',    // docx only
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
    
    
    public function deleteDraftfile($draftFile)
    {
        if($draftFile != "") {
            if (file_exists("./draftfile/$draftFile")) {
                unlink("./draftfile/$draftFile");
            }    
        }
    }
        public function deleteCoverfile($draftFile)
    {
        if($draftFile != "") {
            if (file_exists("./coverfile/$draftFile")) {
                unlink("./coverfile/$draftFile");
            }    
        }
    }
   

    public function uploadProgress($fieldname, $draftFileName)
    {
        $config = [
            'upload_path'      => './draftfile/',
            'file_name'        => $draftFileName,
            'allowed_types'    => 'docx|doc|pdf',    // docx only
            'max_size'         => 151200,     // 50MB
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

        public function uploadProgressCover($fieldname, $draftFileName)
    {
        $config = [
            'upload_path'      => './coverfile/',
            'file_name'        => $draftFileName,
            'allowed_types'    => 'pdf|jpg|jpeg|png',    // image only
            'max_size'         => 20480,     // 20MB
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
    
    public function deleteProgress($draftFile)
    {
        if($draftFile != "") {
            if (file_exists("./draftfile/$draftFile")) {
                unlink("./draftfile/$draftFile");
            }    
        }
        
    }

public function deleteProgressCover($draftFile)
    {
        if($draftFile != "") {
            if (file_exists("./coverfile/$draftFile")) {
                unlink("./coverfile/$draftFile");
            }    
        }
        
    }

}