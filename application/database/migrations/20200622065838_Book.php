<?php

class Migration_Book extends CI_Migration
{
    public function up()
    {
        $this->dbforge->modify_column('book', [
            'published_date' => [
                'type' => 'DATE',
                'null' => TRUE
            ],
        ]);
    }

    public function down()
    {
        $this->dbforge->modify_column('book', [
            'published_date' => [
                'type' => 'DATE',
                'null' => FALSE
            ],
        ]);
    }
}
