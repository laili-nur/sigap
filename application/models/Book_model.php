<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Book_model extends MY_Model
{
   protected $perPage = 10;
   
   public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'draft_id',
                'label' => 'Draft ID',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'book_code',
                'label' => 'Book Code',
                'rules' => 'trim'
            ],
            [
                'field' => 'book_title',
                'label' => 'Book Title',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_book_title'
            ],
            [
                'field' => 'book_edition',
                'label' => 'Book Edition',
                'rules' => 'trim|min_length[1]|max_length[256]'
            ],
            [
                'field' => 'isbn',
                'label' => 'ISBN',
                'rules' => 'trim|min_length[1]|max_length[256]'
            ],
            [
                'field' => 'eisbn',
                'label' => 'EISBN',
                'rules' => 'trim|min_length[1]|max_length[256]'
            ],
            [
                'field' => 'published_date',
                'label' => 'Published Date',
                'rules' => 'trim|callback_is_date_format_valid'
            ],            
            [
                'field' => 'printing_type',
                'label' => 'Printing Type',
                'rules' => 'trim'
            ],
            [
                'field' => 'serial_num',
                'label' => 'Serial Number',
                'rules' => 'trim|numeric'
            ],
            [
                'field' => 'serial_num_per_year',
                'label' => 'Serial Number Per Year',
                'rules' => 'trim|numeric'
            ],
            [
                'field' => 'copies_num',
                'label' => 'Copies Number',
                'rules' => 'trim|numeric'
            ],
            [
                'field' => 'book_notes',
                'label' => 'Book Note',
                'rules' => 'trim'
            ],
            [
                'field' => 'is_reprint',
                'label' => 'Is Reprint',
                'rules' => 'trim'
            ],
            [
                'field' => 'nomor_hak_cipta',
                'label' => 'Nomor Hak Cipta',
                'rules' => 'trim'
            ],
            [
                'field' => 'status_hak_cipta',
                'label' => 'Status Hak Cipta',
                'rules' => 'trim'
            ]
            
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'draft_id'                   => '',
            'book_code'                      => '',
            'book_title'                   => '',
//            'cover'                    => '',
            'book_edition'                 => '',
            'isbn'                 => '',
            'eisbn'                 => '',
//            'book_file'                    => '',
            'published_date'                   => '',
            'printing_type'                    => 'p',
            'serial_num'                   => '',
            'serial_num_per_year'                  => '',
            'copies_num'                    => '',
            'book_notes'                  => '',
            'is_reprint'                     => 'n',
            'nomor_hak_cipta'                  => '',
            'status_hak_cipta'                  => ''
        ];
    }
   
    public function uploadBookfile($bookfieldname, $bookFileName)
    {
        $config = [
            'upload_path'      => './bookfile/',
            'file_name'        => $bookFileName ,
            'allowed_types'    => 'docx|doc|pdf',    // docx only
            'max_size'         => 15360,     // 15MB
            'overwrite'        => true,
            'file_ext_tolower' => true,
        ];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload($bookfieldname)) {
            // Upload OK, return uploaded file info.
            return $this->upload->data();
        } else {
            // Add error to $_error_array
            $this->form_validation->add_to_error_array($bookfieldname, $this->upload->display_errors('', ''));
            return false;
        }
    }

    public function deleteBookfile($bookFile)
    {
        if (file_exists("./bookfile/$bookFile")) {
            unlink("./bookfile/$bookFile");
        }
    }

    public function uploadHCfile($HCfieldname, $HCFileName)
    {
        $config = [
            'upload_path'      => './hakcipta/',
            'file_name'        => $HCFileName,
            'allowed_types'    => 'jpg|png|jpeg|pdf',    // file types allowed
            'max_size'         => 15360,     // 15MB
            'overwrite'        => true,
            'file_ext_tolower' => true,
        ];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload($HCfieldname)) {
            // Upload OK, return uploaded file info.
            return $this->upload->data();
        } else {
            // Add error to $_error_array
            $this->form_validation->add_to_error_array($HCfieldname, $this->upload->display_errors('', ''));
            return false;
        }
    }    
    
        public function deleteHCfile($HCfile)
    {
           if (file_exists("./hakcipta/$HCfile")) {
                unlink("./hakcipta/$HCfile");
            } 
        
    }
    
    
    
//     public function uploadCover($coverfieldname, $coverFileName)
//    {
//        $config = [
//            'upload_path'      => './cover/',
//            'file_name'        => $coverFileName,
//            'allowed_types'    => 'jpg|jpeg|png',    //  *.jpg only
//            'max_size'         => 10240,     // 10MB
//            'max_width'        => 0,
//            'max_height'       => 0,
//            'overwrite'        => true,
//            'file_ext_tolower' => true,
//        ];
//
//        $this->load->library('upload', $config);
//        if ($this->upload->do_upload($coverfieldname)) {
//            // Upload OK, return uploaded file info.
//            return $this->upload->data();
//        } else {
//            // Add error to $_error_array
//            $this->form_validation->add_to_error_array($coverfieldname, $this->upload->display_errors('', ''));
//            return false;
//        }
//    }
//
//
//    public function coverResize($coverfieldname, $source_path, $width, $height)
//    {
//        $config = [
//            'image_library'  => 'gd2',
//            'source_image'   => $source_path,
//            'maintain_ratio' => true,
//            'width'          => $width,
//            'height'         => $height,
//        ];
//
//        $this->load->library('image_lib', $config);
//
//        if ($this->image_lib->resize()) {
//            return true;
//        } else {
//            $this->form_validation->add_to_error_array($coverfieldname, $this->image_lib->display_errors('', ''));
//            return false;
//        }
//    }
//
//    public function deleteCover($imgFile)
//    {
//        if (file_exists("./cover/$imgFile")) {
//            unlink("./cover/$imgFile");
//        }
//    }

}