<?php

require APPPATH . 'database/Seeder.php';

class Tools extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        // can only be called from the command line
        if (!$this->input->is_cli_request()) {
            exit('Direct access is not allowed. This is a command line tool, use the terminal');
        }

        $this->load->dbforge();

        // initiate faker
        $this->faker = Faker\Factory::create();
    }

    public function message($to = 'World')
    {
        echo "Hello {$to}!" . PHP_EOL;
    }

    public function help()
    {
        $result = "The following are the available command line interface commands\n\n";
        $result .= "php index.php tools migration \"file_name\"         Create new migration file\n";
        $result .= "php index.php tools migrate [\"version_number\"]    Run all migrations. The version number is optional.\n";
        $result .= "php index.php tools seeder \"file_name\"            Creates a new seed file.\n";
        $result .= "php index.php tools seed \"file_name\"              Run the specified seed file.\n";

        echo $result . PHP_EOL;
    }

    public function migration($name)
    {
        $this->make_migration_file($name);
    }

    public function migrate($version = null)
    {
        $this->load->library('migration');

        if ($version != null) {
            if ($this->migration->version($version) === false) {
                show_error($this->migration->error_string());
            } else {
                echo "Migrations run successfully" . PHP_EOL;
            }

            return;
        }

        if ($this->migration->latest() === false) {
            show_error($this->migration->error_string());
        } else {
            echo "Migrations run successfully" . PHP_EOL;
        }
    }

    public function seeder($name)
    {
        $this->make_seed_file($name);
    }

    public function seed($name)
    {
        $seeder = new Seeder();

        $seeder->call($name);
    }

    protected function make_migration_file($name)
    {
        $date      = new DateTime();
        $timestamp = $date->format('YmdHis');

        $table_name = strtolower($name);

        $path = APPPATH . "database/migrations/$timestamp" . "_" . "$name.php";

        $my_migration = fopen($path, "w") or die("Unable to create migration file!");

        $migration_template = "<?php

        class Migration_$name extends CI_Migration {

            public function up() {
                \$this->dbforge->add_field('id');
                \$this->dbforge->add_field(array(
                    'name' => array(
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    )
                ));
                \$this->dbforge->create_table('$table_name');
            }

            public function down() {
                \$this->dbforge->drop_table('$table_name');
            }

        }";

        fwrite($my_migration, $migration_template);

        fclose($my_migration);

        echo "$path migration has successfully been created." . PHP_EOL;
    }

    protected function make_seed_file($name)
    {
        $path = APPPATH . "database/seeds/$name.php";

        $my_seed = fopen($path, "w") or die("Unable to create seed file!");

        $seed_template = "<?php

        class $name extends Seeder {

            private \$table = '" . strtolower($name) . "';

            public function run() {
                \$this->db->truncate(\$this->table);

                //seed records manually
                \$data = [
                    'name' => 'admin',
                ];
                \$this->db->insert(\$this->table, \$data);

                //seed many records using faker
                \$limit = 33;
                echo \"seeding \$limit " . strtolower($name) . "\";

                for (\$i = 0; \$i < \$limit; \$i++) {
                    echo \".\";

                    \$data = array(
                        'name' => \$this->faker->unique()->word,
                    );

                    \$this->db->insert(\$this->table, \$data);
                }

                echo PHP_EOL;
            }
        }
        ";

        fwrite($my_seed, $seed_template);

        fclose($my_seed);

        echo "$path seeder has successfully been created." . PHP_EOL;
    }

}