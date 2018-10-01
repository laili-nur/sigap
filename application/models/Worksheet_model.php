<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Worksheet_model extends MY_Model
{
   protected $perPage = 10;
   
       public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'draft_id',
                'label' => 'Draft ID',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_worksheet_draft'
            ],
            [
                'field' => 'worksheet_num',
                'label' => 'Worksheet Number',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_worksheet_num'
            ],
            [
                'field' => 'worksheet_notes',
                'label' => 'Worksheet Number',
                'rules' => 'trim'
            ],
            [
                'field' => 'is_reprint',
                'label' => 'Reprint Status',
                'rules' => 'trim|required'
            ]

        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'draft_id'           => '',
            'worksheet_num'           => '',
            'worksheet_notes'           => '',
            'is_reprint'              => 'n'
        ];
    }
}