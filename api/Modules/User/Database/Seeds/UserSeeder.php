<?php

namespace Modules\User\Database\Seeds;

use Modules\User\Entities\UserEntity;
use Modules\User\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function run()
    {
        $data = [
            new UserEntity(['username' => 'admin', 'password' => password_hash('admin', PASSWORD_BCRYPT), 'status' => 'active', 'is_reset' => 0]),
            new UserEntity(['username' => 'customer', 'password' => password_hash('customer', PASSWORD_BCRYPT), 'status' => 'active', 'is_reset' => 0]),
        ];

        $this->model->insertBatch($data);
    }
}
