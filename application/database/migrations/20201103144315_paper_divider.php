<?php

class Migration_paper_divider extends CI_Migration
{


    public function up()
    {
        $this->dbforge->add_column('print_order', [
            'paper_divider' => [
                'type' => 'INT',
                'constraint' => 2,
                'null' => true
            ],
            'paper_estimation' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true
            ],
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('print_order',  'paper_divider');
        $this->dbforge->drop_column('print_order',  'paper_estimation');
    }
}
