<?php

class Migration_Logistic extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field([
            'logistic_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'notes' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
            ],
            'date_created' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'user_created' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'date_edited' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'user_edited' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
        ]);
        $this->dbforge->add_key('logistic_id', TRUE);
        $this->dbforge->create_table('logistic');
    }

    public function down()
    {
        $this->dbforge->drop_table('logistic');
    }
}
