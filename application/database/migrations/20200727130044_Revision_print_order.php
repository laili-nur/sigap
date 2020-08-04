<?php

class Migration_Revision_print_order extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('print_order', [
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
        ]);
        $this->dbforge->modify_column('print_order', [
            'book_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('print_order', 'name');
        $this->dbforge->modify_column('print_order', [
            'book_id' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
        ]);
    }
}
