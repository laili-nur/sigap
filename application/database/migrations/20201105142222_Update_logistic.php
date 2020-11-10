<?php

class Migration_Update_logistic extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('logistic', [
            'stock_warehouse' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'stock_production' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'stock_other' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
        ]);

        $this->dbforge->modify_column('logistic', [
            'notes' => [
                'type' => 'TEXT',
            ],
            'date_created' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'date_edited' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'user_edited' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
                'null' => true
            ],
        ]);
    }

    public function down()
    {
        $this->dbforge->modify_column('logistic', [
            'notes' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'date_created' => [
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

        $this->dbforge->drop_column('logistic', 'stock_warehouse');
        $this->dbforge->drop_column('logistic', 'stock_production');
        $this->dbforge->drop_column('logistic', 'stock_other');
    }
}
