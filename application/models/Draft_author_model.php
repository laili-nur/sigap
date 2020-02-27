<?php defined('BASEPATH') or exit('No direct script access allowed');

class Draft_author_model extends MY_Model
{
    protected $perPage = 10;

    public function get_validation_rules()
    {
        $validationRules = [
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

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'draft_id'  => '',
            'author_id' => '',
        ];
    }
}
