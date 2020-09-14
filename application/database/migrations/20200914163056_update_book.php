<?php

        class Migration_update_book extends CI_Migration {

            public function up() {
                $this->dbforge->add_column('book', [
                    'stock_warehouse' => [
                        'type' => 'INT',
                        'constraint' => 10,
                        'null' => true
                    ]
                ]);
            }

            public function down() {
                $this->dbforge->drop_column('book', [
                    'stock_warehouse'
                ]);
            }

        }