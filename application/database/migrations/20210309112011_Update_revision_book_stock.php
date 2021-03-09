<?php

class Migration_update_revision_book_stock extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('book_stock', 
        [
            'library_present' => [
                'type' => 'INT',
                'constraint' => 10 
            ],
            'showroom_present' => [
                'type' => 'INT',
                'constraint' => 10 
            ],           
            'selling' => [
                'type' => 'VARCHAR', 
                'constraint' => 20, 
                'default' => 'laris'
            ]
        ]);
    }

    public function down(){
        $this->dbforge->drop_column('book_stock', 'library_present');
        $this->dbforge->drop_column('book_stock', 'showroom_present');
        $this->dbforge->drop_column('book_stock', 'selling');
    }
}