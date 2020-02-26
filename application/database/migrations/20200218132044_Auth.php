<?php

class Migration_Auth extends CI_Migration
{

    public function up()
    {
        // USERS
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'email'             => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'pass'              => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
            ],
            'username'          => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'default'    => null,
            ],
            'banned'            => [
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => true,
                'default'    => 0,
            ],
            'last_login'        => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'last_activity'     => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'date_created'      => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'forgot_exp'        => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'remember_time'     => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'remember_exp'      => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'verification_code' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'totp_secret'       => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
                'null'       => true,
                'default'    => null,
            ],
            'ip_address'        => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->dbforge->create_table('aauth_users');

        // GROUPS
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'name'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'default'    => null,
            ],
            'definition' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->dbforge->create_table('aauth_groups');

        // PERMISSIONS
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'name'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'default'    => null,
            ],
            'definition' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->dbforge->create_table('aauth_perms');

        // LOGIN ATTEMPTS
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'ip_address'     => [
                'type'       => 'VARCHAR',
                'constraint' => 39,
                'null'       => true,
                'default'    => 0,
            ],
            'timestamp'      => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'login_attempts' => [
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => true,
                'default'    => 0,
            ],
        ]);
        $this->dbforge->create_table('aauth_login_attempts');

        // USER VARIABLES
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'user_id'  => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'data_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'value'    => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->dbforge->add_key('user_id');
        $this->dbforge->create_table('aauth_user_variables');

        // PMS
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'sender_id'           => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'receiver_id'         => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'title'               => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'message'             => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'date_sent'           => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'date_read'           => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'pm_deleted_sender'   => [
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => true,
                'default'    => null,
            ],
            'pm_deleted_receiver' => [
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => true,
                'default'    => null,
            ],
        ]);
        $this->dbforge->add_key('id');
        $this->dbforge->add_key('sender_id');
        $this->dbforge->add_key('receiver_id');
        $this->dbforge->add_key('date_read');
        $this->dbforge->create_table('aauth_pms');

        // USER TO GROUP
        $this->dbforge->add_field([
            'user_id'  => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'group_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->dbforge->add_key('user_id', true);
        $this->dbforge->add_key('group_id', true);
        $this->dbforge->create_table('aauth_user_to_group');

        // PERM TO GROUP
        $this->dbforge->add_field([
            'perm_id'  => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'group_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->dbforge->add_key('perm_id', true);
        $this->dbforge->add_key('group_id', true);
        $this->dbforge->create_table('aauth_perm_to_group');

        // PERM TO USER
        $this->dbforge->add_field([
            'perm_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->dbforge->add_key('perm_id', true);
        $this->dbforge->add_key('user_id', true);
        $this->dbforge->create_table('aauth_perm_to_user');

        // GROUP TO GROUP
        $this->dbforge->add_field([
            'group_id'    => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'subgroup_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->dbforge->add_key('group_id', true);
        $this->dbforge->add_key('subgroup_id', true);
        $this->dbforge->create_table('aauth_group_to_group');

    }

    public function down()
    {
        $this->dbforge->drop_table('aauth_users');
        $this->dbforge->drop_table('aauth_groups');
        $this->dbforge->drop_table('aauth_perms');
        $this->dbforge->drop_table('aauth_login_attempts');
        $this->dbforge->drop_table('aauth_user_variables');
        $this->dbforge->drop_table('aauth_pms');
        $this->dbforge->drop_table('aauth_user_to_group');
        $this->dbforge->drop_table('aauth_perm_to_group');
        $this->dbforge->drop_table('aauth_perm_to_user');
        $this->dbforge->drop_table('aauth_group_to_group');
    }

}