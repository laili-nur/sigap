<?php

class Migration_Update_revision_datetime extends CI_Migration
{
    private function _get_columns()
    {
        // datetime column
        // set null instead 0000-00-00
        return ['revision_start_date', 'revision_end_date', 'revision_deadline'];
    }

    public function up()
    {
        $this->dbforge->modify_column('revision', [
            'revision_start_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'revision_end_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'revision_deadline' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
        ]);

        foreach ($this->_get_columns() as $column) {
            $this->db->update('revision', [$column => null], [$column => '0000-00-00 00:00:00']);
        }
    }

    public function down()
    {
        $this->dbforge->modify_column('revision', [
            'revision_start_date' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'revision_end_date' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'revision_deadline' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
        ]);

        foreach ($this->_get_columns() as $column) {
            $this->db->update('revision', [$column => '0000-00-00 00:00:00'], [$column => null]);
        }
    }
}
