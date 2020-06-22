<?php

class Migration_User extends CI_Migration
{

    public function up()
    {
        $this->dbforge->modify_column('user', [
            'level' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
        ]);

        $this->dbforge->add_column('user', [
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ]
        ]);
    }

    public function down()
    {
        $this->dbforge->modify_column('user', [
            'level' => [
                'type' => "ENUM('superadmin','admin_penerbitan','staff_penerbitan','editor','layouter','admin_pemasaran','admin_percetakan','admin_gudang','author','reviewer','author_reviewer')",
            ],
        ]);

        $this->dbforge->drop_column('user', 'email');
    }
}
