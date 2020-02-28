<?php defined('BASEPATH') or exit('No direct script access allowed');

class Category_model extends MY_Model
{
    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'category_name',
                'label' => $this->lang->line('form_category_name'),
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_category_name',
            ],
            [
                'field' => 'category_type',
                'label' => $this->lang->line('form_category_category'),
                'rules' => 'trim|required',
            ],
            [
                'field' => 'category_year',
                'label' => $this->lang->line('form_category_year'),
                'rules' => 'trim|required|exact_length[4]',
            ],
            [
                'field' => 'category_note',
                'label' => $this->lang->line('form_category_note'),
                'rules' => 'trim|min_length[1]',
            ],
            [
                'field' => 'date_open',
                'label' => $this->lang->line('form_category_date_open'),
                'rules' => 'trim|required|callback_is_date_format_valid',
            ],
            [
                'field' => 'date_close',
                'label' => $this->lang->line('form_category_date_close'),
                'rules' => 'trim|required|callback_is_date_format_valid|callback_check_date',
            ],
            [
                'field' => 'category_status',
                'label' => $this->lang->line('form_category_status'),
                'rules' => 'trim|required',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'category_name'   => '',
            'category_type'   => '',
            'category_year'   => '',
            'category_note'   => '',
            'date_open'       => '',
            'date_close'      => '',
            'category_status' => '',
        ];
    }
}
