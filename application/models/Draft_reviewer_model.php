<?php defined('BASEPATH') or exit('No direct script access allowed');

class Draft_reviewer_model extends MY_Model
{
    protected $per_page = 10;

    public function get_validation_rules()
    {
        $validation_rules = [
            [
                'field' => 'draft_id',
                'label' => 'Draft ID',
                'rules' => 'trim|required|callback_unique_draft_reviewer_match',
            ],
//            [   // Fake input, just for live search
            //                'field' => 'search_reviewer',
            //                'label' => 'Reviewer ID',
            //                'rules' => 'trim|required'
            //            ],
            [
                'field' => 'reviewer_id',
                'label' => 'reviewer ID',
                'rules' => 'trim|required|callback_unique_draft_reviewer_match',
            ],
        ];

        return $validation_rules;
    }

    public function get_default_values()
    {
        return [
            'draft_id'    => '',
            'reviewer_id' => '',
//            'search_reviewer'   => '', // Fake, just for search
        ];
    }
//
    //        public function liveSearchReviewer($key)
    //    {
    //        return $this->db->select('reviewer_id, reviewer_nip, reviewer_name')
    //                        ->like('reviewer_nip', $key)
    //                        ->or_like('reviewer_name', $key)
    //                        ->limit(10)
    //                        ->get('reviewer')
    //                        ->result();
    //    }

}
