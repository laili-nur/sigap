<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Work_unit_model extends MY_Model
{    
    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'work_unit_name',
                'label' => 'Work Unit Name',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_work_unit_name'
            ],
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'work_unit_name'    => ''
        ];
    }
}