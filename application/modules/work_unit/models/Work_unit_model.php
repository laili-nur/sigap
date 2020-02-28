<?php defined('BASEPATH') or exit('No direct script access allowed');

class Work_unit_model extends MY_Model
{
    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'work_unit_name',
                'label' => $this->lang->line('form_work_unit_name'),
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_work_unit_name',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'work_unit_name' => '',
        ];
    }
}