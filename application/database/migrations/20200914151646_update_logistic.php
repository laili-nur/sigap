<?php

        class Migration_update_logistic extends CI_Migration {

            public function up() {
                $this->dbforge->add_column('logistic', [
                    'stock_warehouse' => [
                        'type' => 'INT',
                        'constraint' => 10,
                        'null' => true
                    ],
                    'stock_production' => [
                        'type' => 'INT',
                        'constraint' => 10,
                        'null' => true
                    ],
                    'stock_other' => [
                        'type' => 'INT',
                        'constraint' => 10,
                        'null' => true
                    ],
                ]);

                $this->dbforge->modify_column('logistic', [
                    'notes' => [
                        'name' => 'notes',
                        'type' => 'TEXT',
                        'null' => true
                    ],
                    'date_created' => [
                        'name' => 'date_created',
                        'type' => 'TIMESTAMP',
                        'null' => true
                    ],
                    'user_created' => [
                        'name' => 'user_created',
                        'null' => true
                    ],
                    'date_edited' => [
                        'name' => 'date_edited',
                        'type' => 'TIMESTAMP',
                        'null' => true
                    ],
                    'user_edited' => [
                        'name' => 'user_edited',
                        'null' => true
                    ],
                ]);
            }

            public function down() {
                $this->dbforge->modify_column('print_order', [
                    'notes' => [
                        'name' => 'notes',
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                        'null' => false
                    ],
                    'date_created' => [
                        'name' => 'date_created',
                        'type' => 'VARCHAR',
                        'constraint' => 25,
                        'null' => false
                    ],
                    'user_created' => [
                        'name' => 'user_created',
                        'null' => false
                    ],
                    'date_edited' => [
                        'name' => 'date_edited',
                        'type' => 'VARCHAR',
                        'constraint' => 25,
                        'null' => false
                    ],
                    'user_edited' => [
                        'name' => 'user_edited',
                        'null' => false
                    ],
                ]);

                $this->dbforge->drop_column('print_order', [
                    'stock_warehouse',
                    'stock_production',
                    'stock_other'
                ]);
            }

        }