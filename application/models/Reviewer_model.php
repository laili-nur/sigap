<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reviewer_model extends MY_Model
{
    protected $perPage = 10;

    public function get_validation_rules()
    {
        $validationRules = [
            [
                'field' => 'reviewer_nip',
                'label' => 'Reviewer NIP',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_reviewer_nip',
            ],
            [
                'field' => 'reviewer_name',
                'label' => 'Reviewer Name',
                'rules' => 'trim|required|min_length[1]|max_length[256]',
            ],
            [
                'field' => 'reviewer_degree_front',
                'label' => 'Reviewer Degree Front',
                'rules' => 'trim|min_length[2]|max_length[256]',
            ],
            [
                'field' => 'reviewer_degree_back',
                'label' => 'Reviewer Degree Back',
                'rules' => 'trim|min_length[2]|max_length[256]',
            ],
            [
                'field' => 'faculty_id',
                'label' => 'Reviewer ID',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'reviewer_contact',
                'label' => 'Reviewer Contact',
                'rules' => 'trim|max_length[20]|callback_unique_reviewer_contact',
            ],
            [
                'field' => 'reviewer_email',
                'label' => 'Reviewer Email',
                'rules' => 'trim|valid_email|callback_unique_reviewer_email',
            ],
            [
                'field' => 'user_id',
                'label' => 'User ID',
                'rules' => 'trim|required|callback_unique_reviewer_username',
            ],
            [
                'field' => 'reviewer_expert',
                'label' => 'Reviewer Expert',
                'rules' => 'trim',
            ],
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'reviewer_nip'          => '',
            'reviewer_name'         => '',
            'reviewer_degree_front' => '',
            'reviewer_degree_back'  => '',
            'faculty_id'            => '',
            'reviewer_contact'      => '',
            'reviewer_email'        => '',
            'user_id'               => '',
            'reviewer_expert'       => '',
        ];
    }
}
