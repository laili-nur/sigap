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
                'field' => 'author_degree',
                'label' => 'Author Degree',
                'rules' => 'trim|required|min_length[2]|max_length[256]'
            ],
            [
                'field' => 'author_address',
                'label' => 'Author Address',
                'rules' => 'trim|required|min_length[1]|max_length[256]'
            ],
            [
                'field' => 'author_contact',
                'label' => 'Author Contact',
                'rules' => 'required|min_length[1]|max_length[20]|callback_unique_author_contact'
            ],
            [
                'field' => 'author_email',
                'label' => 'Author Email',
                'rules' => 'trim|required|valid_email|callback_unique_author_email'
            ],
            [
                'field' => 'bank_id',
                'label' => 'Author Bank',
                'rules' => 'trim|required|max_length[100]'
            ],
            [
                'field' => 'author_saving_num',
                'label' => 'Author Saving Number',
                'rules' => 'trim|required|min_length[1]|max_length[30]|callback_unique_author_saving_num'
            ],
            [
                'field' => 'heir_name',
                'label' => 'Heir Name',
                'rules' => 'trim|required|min_length[1]|max_length[256]'
            ],
            [
                'field' => 'user_id',
                'label' => 'User ID',
                'rules' => 'trim|required|callback_unique_author_username'
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
            'author_degree'              => '',
            'author_address'           => '',
            'author_contact'              => '',
            'author_email'           => '',
            'bank_id'              => '',
            'author_saving_num'           => '',
            'heir_name'              => '',
            'user_id'              => ''
        ];
    }
}