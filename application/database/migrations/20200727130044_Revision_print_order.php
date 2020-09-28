<?php

class Migration_Revision_print_order extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('print_order', [
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'order_code' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'print_order_file' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'print_order_notes' => [
                'type' => 'TEXT',
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
        ]);

        $this->dbforge->modify_column('print_order', [
            'order_number' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'book_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('print_order', 'category');
        $this->dbforge->drop_column('print_order', 'order_code');
        $this->dbforge->drop_column('print_order', 'print_order_file');
        $this->dbforge->drop_column('print_order', 'print_order_notes');
        $this->dbforge->modify_column('print_order', [
            'order_number' => [
                'type' => 'VARCHAR',
                'constraint' => 15
            ],
        ]);
        $this->dbforge->drop_column('print_order', 'name');
        $this->dbforge->modify_column('print_order', [
            'book_id' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
        ]);
    }
}
