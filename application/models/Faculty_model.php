<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty_model extends MY_Model
{    
    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'faculty_name',
                'label' => 'Faculty Name',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_faculty_name'
            ],
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'faculty_name'    => ''
        ];
    }
}