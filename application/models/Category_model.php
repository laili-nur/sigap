<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model
{    
    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'category_name',
                'label' => 'Category Name',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_category_name'
            ],
            [
                'field' => 'category_year',
                'label' => 'Category Year',
                'rules' => 'trim|required|exact_length[4]'
            ],
            [
                'field' => 'category_note',
                'label' => 'Category Note',
                'rules' => 'trim|min_length[1]'
            ],
            [
                'field' => 'date_open',
                'label' => 'Date Open',
                'rules' => 'trim|required|callback_is_date_format_valid'
            ],
            [
                'field' => 'date_close',
                'label' => 'Date Close',
                'rules' => 'trim|required|callback_is_date_format_valid|callback_check_date'
            ],
            [
                'field' => 'category_status',
                'label' => 'Category Status',
                'rules' => 'trim|required'
            ],
            
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'category_name'    => '',
            'category_year'    => '',
            'category_note'    => '',
            'date_open'    => '',
            'date_close'    => '',
            'category_status'    => 'y',
        ];
    }
}