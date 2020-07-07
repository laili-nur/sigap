<?php

class Migration_Logistic_stock extends CI_Migration
{

    public function up()
    {
        // book stock
        $this->dbforge->add_field([
            'logistic_stock_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'auto_increment' => TRUE
            ],
            'logistic_id' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'stock_warehouse' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'stock_production' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'stock_other' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'input_type' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
            'input_user' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'input_date' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'input_notes' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
            ],
        ]);
        $this->dbforge->add_key('logistic_stock_id', TRUE);
        $this->dbforge->create_table('logistic_stock');
    }

    public function down()
    {
        $this->dbforge->drop_table('logistic_stock');
    }
}
