<?php defined('BASEPATH') or exit('No direct script access allowed');

class Theme_model extends MY_Model
{
    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'theme_name',
                'label' => $this->lang->line('form_theme_name'),
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_theme_name',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'theme_name' => '',
        ];
    }
}
