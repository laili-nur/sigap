<?php defined('BASEPATH') or exit('No direct script access allowed');

class Responsibility_model extends MY_Model
{
    protected $perPage = 10;

    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'user_id',
                'label' => 'User ID',
                'rules' => 'trim|required|callback_unique_responsibility_match',
            ],
            [
                'field' => 'draft_id',
                'label' => 'Draft ID',
                'rules' => 'trim|required|callback_unique_responsibility_match',
            ],

        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [

            'user_id'  => '',
            'draft_id' => '',
        ];
    }
}
