<?php

class Migration_Update_print_order extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('print_order', [
            'preprint_file' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'preprint_file_link' => [
                'type' => 'TEXT'
            ],
            'preprint_upload_date' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'preprint_upload_by' => [
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            // 'total_success' => [
            //     'type' => 'INT',
            //     'constraint' => 5
            // ],
            'deadline_date' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ],
            // 'letter_file' => [
            //     'type' => 'TEXT',
            //     'null' => true
            // ],
            'total_print' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true
            ],
            'total_postprint' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true
            ],
            'location_binding' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true
            ],
            'location_laminate' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true
            ],
            'location_binding_outside' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true
            ],
            'location_laminate_outside' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true
            ],
            'additional_notes' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'paper_divider' => [
                'type' => 'INT',
                'constraint' => 2,
                'null' => true
            ],
            'paper_estimation' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true
            ],
        ]);

        $this->dbforge->modify_column('print_order', [
            'input_by' => [
                'name' => 'user_id',
                'type' => 'INT',
                'constraint' => 10
            ],
        ]);

        $this->dbforge->drop_column('print_order',  'preprint_user');
        $this->dbforge->drop_column('print_order',  'print_user');
        $this->dbforge->drop_column('print_order',  'postprint_user');
        $this->dbforge->drop_column('print_order',  'priority');
        // $this->dbforge->drop_column('print_order',  'total_success');
        // $this->dbforge->drop_column('print_order',  'letter_file');
    }

    public function down()
    {
        $this->dbforge->drop_column('print_order',  'preprint_file');
        $this->dbforge->drop_column('print_order',  'preprint_file_link');
        $this->dbforge->drop_column('print_order', 'preprint_upload_date');
        $this->dbforge->drop_column('print_order', 'preprint_upload_by');
        // $this->dbforge->drop_column('print_order', 'total_success');
        $this->dbforge->drop_column('print_order', 'deadline_date');
        // $this->dbforge->drop_column('print_order',  'letter_file');
        $this->dbforge->drop_column('print_order',  'total_print');
        $this->dbforge->drop_column('print_order',  'total_postprint');
        $this->dbforge->drop_column('print_order',  'location_binding');
        $this->dbforge->drop_column('print_order',  'location_laminate');
        $this->dbforge->drop_column('print_order',  'location_binding_outside');
        $this->dbforge->drop_column('print_order',  'location_laminate_outside');
        $this->dbforge->drop_column('print_order',  'additional_notes');
        $this->dbforge->drop_column('print_order',  'paper_divider');
        $this->dbforge->drop_column('print_order',  'paper_estimation');

        $this->dbforge->modify_column('print_order', [
            'user_id' => [
                'name' => 'input_by',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
        ]);

        $this->dbforge->add_column('print_order', [
            'preprint_user' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'print_user' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'postprint_user' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'priority' => [
                'type' => 'INT',
                'constraint' => 1
            ],
            // 'total_success' => [
            //     'type' => 'INT',
            //     'constraint' => 5,
            //     'null' => true
            // ],
            // 'letter_file' => [
            //     'type' => 'TEXT',
            //     'null' => true
            // ],
        ]);
    }
}
