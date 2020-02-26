# Codeigniter Migration Seed Boilerplate

Ready to use laravel-like codeigniter.

## Feature
- Database migration
- Database seeding
- Auth library
- HMVC modules
- Env loader

## Requirements
- Install composer and PHP
- You can run PHP and composer on terminal
- Create `.env.development` from `.env.example` and fill those credentials
- Admin credential
  - email = admin@admin.com
  - password = admin

## Usage
- Run `composer install`
- Testing CLI
  - Run this command `php index.php tools message "Hello world"` and `php index.php tools help`
- Create pre-built auth table structure `php index.php tools migrate`
- Fill auth table with admin credential `php index.php tools seed Auth`

## Tutorial

### Migration Tutorial
- Assume we are going to migrate *Brands* table, make sure using capital case
- Create migration file ,run `php index.php tools migration Name_of_entity`
- Edit generated migration file in `APPPATH/database/migrations`
- Execute migration, run `php index.php tools migrate`
- Migrate command will execute the latest migration

### Seeding Tutorial
- Create seed file, run `php index.php tools seeder Name_of_entity`
- Edit generated seeder file in `APPPATH/database/seeds`
- Execute seeding, run `php index.php tools seed Name_of_entity`

### Migration management UI
- Open YOUR_BASE_URL/migrate

## Credit
- https://github.com/natanfelles/codeigniter-migrate
- https://kode-blog.io/codeigniter-migration
- https://github.com/agungjk/phpdotenv-for-codeigniter
- https://github.com/emreakay/CodeIgniter-Aauth
