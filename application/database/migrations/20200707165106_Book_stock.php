<?php

class Migration_Book_stock extends CI_Migration
{

    public function up()
    {
        // book stock
        $this->dbforge->add_field([
            'book_stock_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'auto_increment' => TRUE
            ],
            'book_id' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'stock_in_warehouse' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'stock_out_warehouse' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'stock_marketing' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'stock_input_type' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
            'stock_input_user' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'stock_input_date' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'stock_input_notes' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
            ],
        ]);
        $this->dbforge->add_key('book_stock_id', TRUE);
        $this->dbforge->create_table('book_stock');
    }

    public function down()
    {
        $this->dbforge->drop_table('book_stock');
    }
}
