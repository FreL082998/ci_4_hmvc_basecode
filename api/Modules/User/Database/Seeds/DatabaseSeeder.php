<?php

namespace Modules\User\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('Modules\User\Database\Seeds\UserSeeder');
        $this->call('Modules\User\Database\Seeds\RoleSeeder');
        $this->call('Modules\User\Database\Seeds\UserRoleSeeder');
    }
}
