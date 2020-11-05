<?php

class Migration_Add_print_order_user extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field([
            'print_order_user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'auto_increment' => TRUE
            ],
            'print_order_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => TRUE
            ],
            'progress' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('print_order_user_id', TRUE);
        $this->dbforge->create_table('print_order_user');
    }

    public function down()
    {
        $this->dbforge->drop_table('print_order_user');
    }
}
