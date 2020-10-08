<?php

class Migration_Print_order_update extends CI_Migration
{

    public function up()
    {
        $this->dbforge->drop_column('print_order',  'priority');
        $this->dbforge->add_column('print_order', [
            'letter_file' => [
                'type' => 'TEXT',
                'null' => true
            ],
        ]);
    }

    public function down()
    {
        $this->dbforge->add_column('print_order', [
            'priority' => [
                'type' => 'INT',
                'constraint' => 1
            ],
        ]);
        $this->dbforge->drop_column('print_order',  'letter_file');
    }
}
