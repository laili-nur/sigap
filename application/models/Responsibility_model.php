<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Responsibility_model extends MY_Model
{
   protected $perPage = 10;
   
       public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'user_id',
                'label' => 'User ID',
                'rules' => 'trim|required|callback_unique_responsibility_match'
            ],  
            [
                'field' => 'draft_id',
                'label' => 'Draft ID',
                'rules' => 'trim|required|callback_unique_responsibility_match'
            ],
                                 
            
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            
            'user_id'              => '',
            'draft_id'           => ''
        ];
    }
}