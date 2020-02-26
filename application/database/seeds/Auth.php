<?php

class Auth extends Seeder
{
    private $group_table         = 'aauth_groups';
    private $user_table          = 'aauth_users';
    private $user_to_group_table = 'aauth_user_to_group';

    public function run()
    {
        $this->db->truncate($this->group_table);
        $this->db->truncate($this->user_table);
        $this->db->truncate($this->user_to_group_table);

        $this->load->library("Aauth");

        // Create groups
        $this->aauth->create_group("admin", "Super Admin Group");
        $this->aauth->create_group("public", "Public Access Group");
        $this->aauth->create_group("default", "Default Access Group");
        echo "Groups created" . PHP_EOL;

        // Create admin
        $user_id = $this->aauth->create_user("admin@mail.com", "admin", "admin");
        if ($user_id) {
            echo "Success create user admin";
        } else {
            echo "Failed seed";
        }
        echo PHP_EOL;

        // Assign admin to group admin
        $a = $this->aauth->add_member($user_id, "admin");
        echo $a ? 'Success assign admin' : 'Failed assign';
        echo PHP_EOL;

        $this->aauth->print_errors();
        echo PHP_EOL;
    }
}