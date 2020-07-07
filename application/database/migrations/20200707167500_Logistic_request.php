<?php

class Migration_Logistic_request extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field([
            'logistic_request_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'auto_increment' => TRUE
            ],
            'logistic_id' => [
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
            'type' => [
                'type' => 'INT',
                'constraint' => 1,
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
        $this->dbforge->add_key('logistic_request_id', TRUE);
        $this->dbforge->create_table('logistic_request');
    }

    public function down()
    {
        $this->dbforge->drop_table('logistic_request');
    }
}
