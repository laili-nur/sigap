<?php defined('BASEPATH') or exit('No direct script access allowed');

class Institute_model extends MY_Model
{
    public function get_validation_rules()
    {
        $validationRules = [
            [
                'field' => 'institute_name',
                'label' => 'Insitute Name',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_institute_name',
            ],
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'institute_name' => '',
        ];
    }
}
