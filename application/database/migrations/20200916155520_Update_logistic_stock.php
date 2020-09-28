<?php

class Migration_Update_logistic_stock extends CI_Migration
{
    public function up()
    {
        $this->dbforge->modify_column('logistic_stock', [
            'stock_warehouse' => [
                'name' => 'stock_warehouse',
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            'stock_production' => [
                'name' => 'stock_production',
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            'stock_other' => [
                'name' => 'stock_other',
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            'input_type' => [
                'name' => 'input_type',
                'type' => 'VARCHAR',
                'constraint' => 15
            ],
            'input_date' => [
                'name' => 'input_date',
                'type' => 'TIMESTAMP'
            ],
            'input_notes' => [
                'name' => 'input_notes',
                'type' => 'TEXT'
            ],
        ]);
    }

    public function down()
    {
        $this->dbforge->modify_column('logistic_stock', [
            'stock_warehouse' => [
                'name' => 'stock_warehouse',
                'type' => 'INT',
                'constraint' => 10
            ],
            'stock_production' => [
                'name' => 'stock_production',
                'type' => 'INT',
                'constraint' => 10
            ],
            'stock_other' => [
                'name' => 'stock_other',
                'type' => 'INT',
                'constraint' => 10
            ],
            'input_type' => [
                'name' => 'input_type',
                'type' => 'INT',
                'constraint' => 1
            ],
            'input_date' => [
                'name' => 'input_date',
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            'input_notes' => [
                'name' => 'input_notes',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
        ]);
    }
}
