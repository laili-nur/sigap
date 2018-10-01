<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reviewer_model extends MY_Model
{
   protected $perPage = 10;
   
       public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'reviewer_nip',
                'label' => 'Reviewer NIP',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_reviewer_nip'
            ],
            [
                'field' => 'reviewer_name',
                'label' => 'Reviewer Name',
                'rules' => 'trim|required|min_length[1]|max_length[256]'
            ],
            [
                'field' => 'faculty_id',
                'label' => 'Reviewer ID',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'user_id',
                'label' => 'User ID',
                'rules' => 'trim|required|callback_unique_reviewer_username'
            ],
            [
                'field' => 'expert',
                'label' => 'Expert',
                'rules' => 'trim'
            ]
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'reviewer_nip'           => '',
            'reviewer_name'           => '',
            'faculty_id'              => '',
            'user_id'              => '',
            'expert'              => ''
        ];
    }
}