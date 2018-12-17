<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends MY_Model
{
    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'dashboard_head',
                'label' => 'dashboard_head',
                'rules' => 'trim'
            ],
            [
                'field' => 'dashboard_content_author',
                'label' => 'dashboard_content_author',
                'rules' => 'trim'
            ],
            [
                'field' => 'dashboard_content_reviewer',
                'label' => 'dashboard_content_reviewer',
                'rules' => 'trim'
            ],
            [
                'field' => 'dashboard_content_editor',
                'label' => 'dashboard_content_editor',
                'rules' => 'trim'
            ],
            [
                'field' => 'dashboard_content_layouter',
                'label' => 'dashboard_content_layouter',
                'rules' => 'trim'
            ],
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'dashboard_head'  => '',
            'dashboard_content_author'  => '',
            'dashboard_content_reviewer'  => '',
            'dashboard_content_editor'  => '',
            'dashboard_content_layouter'  => '',
        ];
    }

    public function insert_setting($data, $table = "")
    {
        $table = $this->checkTable($table);
        $this->db->insert($table, $data);
        return true;
    }

    public function update_setting($data, $table = "")
    {
        $table = $this->checkTable($table);
        return $this->db->update($table, $data);
    }
}
