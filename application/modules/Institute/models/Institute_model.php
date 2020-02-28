<?php defined('BASEPATH') or exit('No direct script access allowed');

class Institute_model extends MY_Model
{
    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'institute_name',
                'label' => $this->lang->line('form_institute_name'),
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_institute_name',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'institute_name' => '',
        ];
    }
}