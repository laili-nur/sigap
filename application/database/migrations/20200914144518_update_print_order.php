<?php

        class Migration_update_print_order extends CI_Migration {

            public function up() {
                $this->dbforge->add_column('print_order', [
                    'preprint_file' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255
                    ],
                    'preprint_file_link' => [
                        'type' => 'TEXT'
                    ],
                    'preprint_upload_date' => [
                        'type' => 'TIMESTAMP'
                    ],
                    'preprint_upload_by' => [
                        'type' => 'VARCHAR',
                        'constraint' => 25
                    ],
                    'total_success' => [
                        'type' => 'INT',
                        'constraint' => 5
                    ],
                ]);

                $this->dbforge->modify_column('print_order', [
                    'input_by' => [
                        'name' => 'user_id',
                        'type' => 'INT',
                        'constraint' => 10
                    ],
                ]);
                
                $this->dbforge->drop_column('print_order', [
                    'preprint_user',
                    'print_user',
                    'postprint_user'
                ]);
            }

            public function down() {
                $this->dbforge->add_column('print_order', [
                    'preprint_user' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255
                    ],
                    'print_user' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255
                    ],
                    'postprint_user' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255
                    ],
                ]);

                $this->dbforge->modify_column('print_order', [
                    'user_id' => [
                        'name' => 'input_by',
                        'type' => 'VARCHAR',
                        'constraint' => 255
                    ],
                ]);

                $this->dbforge->drop_column('print_order', [
                    'preprint_file',
                    'preprint_file_link',
                    'preprint_upload_date',
                    'preprint_upload_by',
                    'total_success'
                ]);
            }

        }