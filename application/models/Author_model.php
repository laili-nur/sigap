<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Author_model extends MY_Model
{
   protected $perPage = 10;
   
       public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'work_unit_id',
                'label' => 'Work Unit ID',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'institute_id',
                'label' => 'Institute ID',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'author_nip',
                'label' => 'Author NIP',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_author_nip'
            ],
            [
                'field' => 'author_name',
                'label' => 'Author Name',
                'rules' => 'trim|required|min_length[1]|max_length[256]'
            ],
            [
                'field' => 'author_degree_front',
                'label' => 'Author Degree Front',
                'rules' => 'trim|min_length[2]|max_length[256]'
            ],
            [
                'field' => 'author_degree_back',
                'label' => 'Author Degree Back',
                'rules' => 'trim|min_length[2]|max_length[256]'
            ],
            [
                'field' => 'author_latest_education',
                'label' => 'Author Latest Education',
                'rules' => 'trim'
            ],
            [
                'field' => 'author_address',
                'label' => 'Author Address',
                'rules' => 'trim|max_length[256]'
            ],
            [
                'field' => 'author_contact',
                'label' => 'Author Contact',
                'rules' => 'trim|max_length[20]|callback_unique_author_contact'
            ],
            [
                'field' => 'author_email',
                'label' => 'Author Email',
                'rules' => 'trim|valid_email|callback_unique_author_email'
            ],
            [
                'field' => 'bank_id',
                'label' => 'Author Bank',
                'rules' => 'trim|max_length[100]'
            ],
            [
                'field' => 'author_saving_num',
                'label' => 'Author Saving Number',
                'rules' => 'trim|max_length[30]|callback_unique_author_saving_num'
            ],
            [
                'field' => 'heir_name',
                'label' => 'Heir Name',
                'rules' => 'trim|max_length[256]'
            ],
            [
                'field' => 'user_id',
                'label' => 'User ID',
                'rules' => 'trim|callback_unique_author_username'
            ]
            
            
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'work_unit_id'           => '',
            'institute_id'              => '',
            'author_nip'              => '',
            'author_name'           => '',
            'author_degree_front'              => '',
            'author_degree_back'              => '',
            'author_latest_education'              => '',
            'author_address'           => '',
            'author_contact'              => '',
            'author_email'           => '',
            'bank_id'              => '',
            'author_saving_num'           => '',
            'heir_name'              => '',
            'user_id'              => '',
            //'author_ktp'              => '',
        ];
    }
    
    
    public function uploadAuthorKTP($ktpfieldname, $authorKTP)
    {
        $config = [
            'upload_path'      => './authorktp/',
            'file_name'        => $authorKTP,
            'allowed_types'    => 'jpg|png|jpeg|pdf',    // file types allowed
            'max_size'         => 15360,     // 15MB
            'overwrite'        => true,
            'file_ext_tolower' => true,
        ];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload($ktpfieldname)) {
            // Upload OK, return uploaded file info.
            return $this->upload->data();
        } else {
            // Add error to $_error_array
            $this->form_validation->add_to_error_array($ktpfieldname, $this->upload->display_errors('', ''));
            return false;
        }
    }

    public function deleteAuthorKTP($authorKTP)
    {
        if($authorKTP != "") {
           if (file_exists("./authorktp/$authorKTP")) {
                unlink("./authorktp/$authorKTP");
            } 
        }
    }
}