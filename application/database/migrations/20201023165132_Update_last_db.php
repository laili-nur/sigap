<?php

class Migration_Update_last_db extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('print_order', [
            'location_binding_outside' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true
            ],
            'location_laminate_outside' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true
            ],
            'additional_notes' => [
                'type' => 'TEXT',
                'null' => true
            ]
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('print_order',  'location_binding_outside');
        $this->dbforge->drop_column('print_order',  'location_laminate_outside');
        $this->dbforge->drop_column('print_order',  'additional_notes');
    }
}
