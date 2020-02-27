<?php defined('BASEPATH') or exit('No direct script access allowed');

class Theme_model extends MY_Model
{
    public function get_validation_rules()
    {
        $validationRules = [
            [
                'field' => 'theme_name',
                'label' => 'Theme Name',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_theme_name',
            ],
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'theme_name' => '',
        ];
    }
}
