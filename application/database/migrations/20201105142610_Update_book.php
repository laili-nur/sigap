<?php

class Migration_Update_book extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('book', [
            'stock_warehouse' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'from_outside' => [
                'type' => 'INT',
                'constraint' => 1,
                'default' => 0
            ]
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('book', 'stock_warehouse');
        $this->dbforge->drop_column('book',  'from_outside');
    }
}
