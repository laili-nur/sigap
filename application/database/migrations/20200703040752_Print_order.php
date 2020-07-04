<?php

class Migration_Print_order extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'print_order_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'auto_increment' => TRUE
            ],
            'book_id' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'total' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            // 'category' => [
            //     'type' => 'INT',
            //     'constraint' => 1,
            // ],
            // 'edition' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => 100
            // ],
            'paper_content' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'print_cover' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'paper_size' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'print_priority' => [
                'type' => 'INT',
                'constraint' => 1
            ],
            'order_number' => [
                'type' => 'VARCHAR',
                'constraint' => 15
            ],
            'entry_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'finish_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'input_by' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'print_order_status' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],

            // preprint
            'is_preprint' => [
                'type' => 'INT',
                'constraint' => 1
            ],
            'preprint_start_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'preprint_end_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'preprint_deadline' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'preprint_notes' => [
                'type' => 'TEXT',
            ],
            'preprint_notes_admin' => [
                'type' => 'TEXT',
            ],
            'preprint_user' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],

            // print
            'is_print' => [
                'type' => 'INT',
                'constraint' => 1
            ],
            'print_start_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'print_end_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'print_deadline' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'print_notes' => [
                'type' => 'TEXT',
            ],
            'print_notes_admin' => [
                'type' => 'TEXT',
            ],
            'print_user' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],

            // postprint
            'is_postprint' => [
                'type' => 'INT',
                'constraint' => 1
            ],
            'postprint_start_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'postprint_end_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'postprint_deadline' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'postprint_notes' => [
                'type' => 'TEXT',
            ],
            'postprint_notes_admin' => [
                'type' => 'TEXT',
            ],
            'postprint_user' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
        ]);
        $this->dbforge->add_key('print_order_id', TRUE);
        $this->dbforge->create_table('print_order');
    }

    public function down()
    {
        $this->dbforge->drop_table('print_order');
    }
}
