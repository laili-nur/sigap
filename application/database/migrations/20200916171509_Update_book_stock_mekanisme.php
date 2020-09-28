<?php

class Migration_Update_book_stock_mekanisme extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('book_stock', [
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 15
            ],
            'date' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ],
            'notes' => [
                'type' => 'TEXT'
            ],
            'warehouse_past' => [
                'type' => 'INT',
                'constraint' => 10
            ],
            'warehouse_modifier' => [
                'type' => 'INT',
                'constraint' => 10
            ],
            'warehouse_present' => [
                'type' => 'INT',
                'constraint' => 10
            ],
            'warehouse_operator' => [
                'type' => 'VARCHAR',
                'constraint' => 1
            ],
        ]);

        $this->dbforge->add_column('print_order', [
            'deadline_date' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ]
        ]);

        $this->dbforge->drop_column('book_stock', 'stock_warehouse');
        $this->dbforge->drop_column('book_stock', 'stock_input_type');
        $this->dbforge->drop_column('book_stock', 'stock_input_user');
        $this->dbforge->drop_column('book_stock', 'stock_input_date');
        $this->dbforge->drop_column('book_stock', 'stock_input_notes');
    }

    public function down()
    {
        $this->dbforge->add_column('book_stock', [
            'stock_warehouse' => [
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            'stock_input_type' => [
                'type' => 'VARCHAR',
                'constraint' => 15
            ],
            'stock_input_user' => [
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            'stock_input_date' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ],
            'stock_input_notes' => [
                'type' => 'TEXT'
            ]
        ]);

        $this->dbforge->drop_column('book_stock', 'user_id');
        $this->dbforge->drop_column('book_stock', 'type');
        $this->dbforge->drop_column('book_stock', 'date');
        $this->dbforge->drop_column('book_stock', 'notes');
        $this->dbforge->drop_column('book_stock', 'warehouse_past');
        $this->dbforge->drop_column('book_stock', 'warehouse_modifier');
        $this->dbforge->drop_column('book_stock', 'warehouse_present');
        $this->dbforge->drop_column('book_stock', 'warehouse_operator');
        $this->dbforge->drop_column('print_order', 'deadline_date');
    }
}
