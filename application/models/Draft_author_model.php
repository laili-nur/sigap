<?php defined('BASEPATH') or exit('No direct script access allowed');

class Draft_author_model extends MY_Model
{
    protected $per_page = 10;

    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'draft_id',
                'label' => 'Draft ID',
                'rules' => 'trim|required|callback_unique_draft_author_match',
            ],
            [
                'field' => 'author_id',
                'label' => 'Author ID',
                'rules' => 'trim|required|callback_unique_draft_author_match',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'draft_id'  => '',
            'author_id' => '',
        ];
    }
}
