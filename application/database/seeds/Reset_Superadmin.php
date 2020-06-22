<?php

class Reset_Superadmin extends Seeder
{
    private $table = 'user';

    public function run()
    {
        $this->db->where('username', 'superadmin');
        $superadmin = $this->db->get($this->table)->row();

        if ($superadmin) {
            $this->db->update($this->table, ['password' => md5('superadmin')], ['username' => 'superadmin']);
            echo 'Superadmin password resetted.';
        } else {
            $this->db->insert($this->table, [
                'username'   => 'superadmin',
                'password'   => md5('superadmin'),
                'level'      => 'superadmin',
                'is_blocked' => 'n',
                'email'      => getenv('EMAIL_ADDRESS')
            ]);
            echo 'Superadmin password created.';
        }

        echo ' Login using username=superadmin, password=superadmin';
        echo PHP_EOL;
    }
}
