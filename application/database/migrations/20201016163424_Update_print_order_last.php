<?php

class Migration_Update_print_order_last extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('print_order', [
            'total_print' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true
            ],
            'total_postprint' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true
            ],
            'location_binding' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true
            ],
            'location_laminate' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true
            ],
        ]);
        $this->dbforge->add_column('book', [
            'from_outside' => [
                'type' => 'INT',
                'constraint' => 1,
                'default' => 0
            ]
        ]);
        $this->dbforge->drop_column('print_order',  'total_success');
        $this->dbforge->drop_column('print_order',  'letter_file');
    }

    public function down()
    {
        $this->dbforge->drop_column('print_order',  'total_print');
        $this->dbforge->drop_column('print_order',  'total_postprint');
        $this->dbforge->drop_column('print_order',  'location_binding');
        $this->dbforge->drop_column('print_order',  'location_laminate');
        $this->dbforge->drop_column('book',  'from_outside');
        $this->dbforge->add_column('print_order', [
            'total_success' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true
            ],
            'letter_file' => [
                'type' => 'TEXT',
                'null' => true
            ],
        ]);
    }
}
