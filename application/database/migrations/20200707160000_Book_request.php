<?php

class Migration_Book_request extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field([
            'book_request_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'auto_increment' => TRUE
            ],
            'book_id' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'user_entry' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'entry_date' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'finish_date' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'order_number' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'total' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'notes' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
            'flag' => [
                'type' => 'INT',
                'constraint' => 1,
            ],

            // request progress
            'request_user' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'request_date' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'request_notes_admin' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
            ],
            'request_status' => [
                'type' => 'INT',
                'constraint' => 1,
            ],

            // final progress
            'final_user' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'final_date' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'final_notes_admin' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
            ],
            'final_status' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
        ]);
        $this->dbforge->add_key('book_request_id', TRUE);
        $this->dbforge->create_table('book_request');
    }

    public function down()
    {
        $this->dbforge->drop_table('book_request');
    }
}
