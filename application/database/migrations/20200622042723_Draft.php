<?php

class Migration_Draft extends CI_Migration
{
    private function _get_columns()
    {
        // datetime column
        // set null instead 0000-00-00
        return ['finish_date', 'review_start_date', 'review_end_date', 'review1_deadline', 'review1_upload_date', 'review2_deadline', 'review2_upload_date', 'edit_start_date', 'edit_end_date', 'edit_deadline', 'edit_upload_date', 'edit_notes_date', 'layout_start_date', 'layout_end_date', 'layout_deadline', 'layout_upload_date', 'cover_upload_date', 'layout_notes_date', 'proofread_start_date', 'proofread_end_date', 'proofread_upload_date'];
    }

    public function up()
    {
        $this->dbforge->modify_column('draft', [
            'review_start_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'review_end_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'catatan_review1_admin' => [
                'name' => 'review1_notes_admin',
                'type' => 'TEXT',
            ],
            'catatan_review2_admin' => [
                'name' => 'review2_notes_admin',
                'type' => 'TEXT',
            ],
            'reviewer1_file_link' => [
                'name' => 'review1_file_link',
                'type' => 'TEXT',
            ],
            'reviewer2_file_link' => [
                'name' => 'review2_file_link',
                'type' => 'TEXT',
            ],
            'review1_last_upload' => [
                'name' => 'review1_upload_by',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'review2_last_upload' => [
                'name' => 'review2_upload_by',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'review1_deadline' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'review2_deadline' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],

            // kriteria
            'kriteria1_reviewer1' => [
                'name' => 'review1_criteria1',
                'type' => 'TEXT',
            ],
            'kriteria2_reviewer1' => [
                'name' => 'review1_criteria2',
                'type' => 'TEXT',
            ],
            'kriteria3_reviewer1' => [
                'name' => 'review1_criteria3',
                'type' => 'TEXT',
            ],
            'kriteria4_reviewer1' => [
                'name' => 'review1_criteria4',
                'type' => 'TEXT',
            ],
            'kriteria1_reviewer2' => [
                'name' => 'review2_criteria1',
                'type' => 'TEXT',
            ],
            'kriteria2_reviewer2' => [
                'name' => 'review2_criteria2',
                'type' => 'TEXT',
            ],
            'kriteria3_reviewer2' => [
                'name' => 'review2_criteria3',
                'type' => 'TEXT',
            ],
            'kriteria4_reviewer2' => [
                'name' => 'review2_criteria4',
                'type' => 'TEXT',
            ],
            'nilai_reviewer1' => [
                'name' => 'review1_score',
                'type' => 'TEXT',
            ],
            'nilai_reviewer2' => [
                'name' => 'review2_score',
                'type' => 'TEXT',
            ],
        ]);

        // edit
        $this->dbforge->modify_column('draft', [
            'edit_start_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'edit_end_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'editor_file_link' => [
                'name' => 'edit_file_link',
                'type' => 'TEXT',
            ],
            'edit_last_upload' => [
                'name' => 'edit_upload_by',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'edit_deadline' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
        ]);

        // layout
        $this->dbforge->modify_column('draft', [
            'layout_start_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'layout_end_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'layouter_file_link' => [
                'name' => 'layout_file_link',
                'type' => 'TEXT',
            ],
            'layout_last_upload' => [
                'name' => 'layout_upload_by',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'cover_last_upload' => [
                'name' => 'cover_upload_by',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'layout_deadline' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
        ]);

        // proofread
        $this->dbforge->modify_column('draft', [
            'proofread_start_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'proofread_end_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'proofread_last_upload' => [
                'name' => 'proofread_upload_by',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
        ]);

        foreach ($this->_get_columns() as $column) {
            $this->db->update('draft', [$column => null], [$column => '0000-00-00 00:00:00']);
        }
    }

    public function down()
    {
        $this->dbforge->modify_column('draft', [
            'review_start_date' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'review_end_date' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'review1_notes_admin' => [
                'name' => 'catatan_review1_admin',
                'type' => 'TEXT',
            ],
            'review2_notes_admin' => [
                'name' => 'catatan_review2_admin',
                'type' => 'TEXT',
            ],
            'review1_file_link' => [
                'name' => 'reviewer1_file_link',
                'type' => 'TEXT',
            ],
            'review2_file_link' => [
                'name' => 'reviewer2_file_link',
                'type' => 'TEXT',
            ],
            'review1_upload_by' => [
                'name' => 'review1_last_upload',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'review2_upload_by' => [
                'name' => 'review2_last_upload',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'review1_deadline' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'review2_deadline' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],

            // kriteria
            'review1_criteria1' => [
                'name' => 'kriteria1_reviewer1',
                'type' => 'TEXT',
            ],
            'review1_criteria2' => [
                'name' => 'kriteria2_reviewer1',
                'type' => 'TEXT',
            ],
            'review1_criteria3' => [
                'name' => 'kriteria3_reviewer1',
                'type' => 'TEXT',
            ],
            'review1_criteria4' => [
                'name' => 'kriteria4_reviewer1',
                'type' => 'TEXT',
            ],
            'review2_criteria1' => [
                'name' => 'kriteria1_reviewer2',
                'type' => 'TEXT',
            ],
            'review2_criteria2' => [
                'name' => 'kriteria2_reviewer2',
                'type' => 'TEXT',
            ],
            'review2_criteria3' => [
                'name' => 'kriteria3_reviewer2',
                'type' => 'TEXT',
            ],
            'review2_criteria4' => [
                'name' => 'kriteria4_reviewer2',
                'type' => 'TEXT',
            ],
            'review1_score' => [
                'name' => 'nilai_reviewer1',
                'type' => 'TEXT',
            ],
            'review2_score' => [
                'name' => 'nilai_reviewer2',
                'type' => 'TEXT',
            ],
        ]);

        // reverse edit
        $this->dbforge->modify_column('draft', [
            'edit_start_date' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'edit_end_date' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'edit_file_link' => [
                'name' => 'editor_file_link',
                'type' => 'TEXT',
            ],
            'edit_upload_by' => [
                'name' => 'edit_last_upload',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'edit_deadline' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
        ]);

        // reverse layout
        $this->dbforge->modify_column('draft', [
            'layout_start_date' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'layout_end_date' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'layout_file_link' => [
                'name' => 'layouter_file_link',
                'type' => 'TEXT',
            ],
            'layout_upload_by' => [
                'name' => 'layout_last_upload',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'cover_upload_by' => [
                'name' => 'cover_last_upload',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'layout_deadline' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
        ]);

        // reverse proofread
        $this->dbforge->modify_column('draft', [
            'proofread_start_date' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'proofread_end_date' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'proofread_upload_by' => [
                'name' => 'proofread_last_upload',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
        ]);

        foreach ($this->_get_columns() as $column) {
            $this->db->update('draft', [$column => '0000-00-00 00:00:00'], [$column => null]);
        }
    }
}
