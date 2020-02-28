<?php defined('BASEPATH') or exit('No direct script access allowed');

class Worksheet_model extends MY_Model
{
    protected $perPage = 10;

    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'draft_id',
                'label' => 'Draft ID',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_worksheet_draft',
            ],
            [
                'field' => 'worksheet_num',
                'label' => 'Worksheet Number',
                'rules' => 'trim|required|min_length[1]|max_length[256]|callback_unique_worksheet_num',
            ],
            [
                'field' => 'worksheet_notes',
                'label' => 'Worksheet Number',
                'rules' => 'trim',
            ],
            [
                'field' => 'is_reprint',
                'label' => 'Reprint Status',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'is_revise',
                'label' => 'Revise Status',
                'rules' => 'trim|required',
            ],

        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'draft_id'           => '',
            'worksheet_num'      => '',
            'worksheet_notes'    => '',
            'is_reprint'         => 'n',
            'is_revise'          => 'n',
            'worksheet_status'   => '0',
            'worksheet_deadline' => '0',
            'worksheet_end_date' => '0',
        ];
    }
}
