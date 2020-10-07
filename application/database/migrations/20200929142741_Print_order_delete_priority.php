<?php

class Migration_Print_order_delete_priority extends CI_Migration
{

    public function up()
    {
        $this->dbforge->drop_column('print_order',  'priority');
    }

    public function down()
    {
        $this->dbforge->add_column('print_order', [
            'priority' => [
                'type' => 'INT',
                'constraint' => 1
            ],
        ]);
    }
}
