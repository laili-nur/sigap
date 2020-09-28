<?php

class Migration_Update_book_stock extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('book_stock', [
            'stock_warehouse' => [
                'type' => 'VARCHAR',
                'constraint' => 25
            ]
        ]);

        $this->dbforge->modify_column('book_stock', [
            'stock_input_type' => [
                'name' => 'stock_input_type',
                'type' => 'VARCHAR',
                'constraint' => 15
            ],
            'stock_input_date' => [
                'name' => 'stock_input_date',
                'type' => 'TIMESTAMP'
            ],
            'stock_input_notes' => [
                'name' => 'stock_input_notes',
                'type' => 'TEXT'
            ],
        ]);

        $this->dbforge->drop_column('book_stock',  'stock_in_warehouse');
        $this->dbforge->drop_column('book_stock',  'stock_out_warehouse');
        $this->dbforge->drop_column('book_stock',  'stock_marketing');
    }

    public function down()
    {
        $this->dbforge->add_column('book_stock', [
            'stock_in_warehouse' => [
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            'stock_out_warehouse' => [
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            'stock_marketing' => [
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
        ]);

        $this->dbforge->modify_column('book_stock', [
            'stock_input_type' => [
                'name' => 'stock_input_type',
                'type' => 'INT',
                'constraint' => 1
            ],
            'stock_input_date' => [
                'name' => 'stock_input_date',
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            'stock_input_notes' => [
                'name' => 'stock_input_notes',
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
        ]);

        $this->dbforge->drop_column('book_stock', 'stock_warehouse');
    }
}
