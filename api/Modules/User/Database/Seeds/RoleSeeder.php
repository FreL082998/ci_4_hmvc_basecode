<?php

namespace Modules\User\Database\Seeds;

use Modules\User\Entities\RoleEntity;
use Modules\User\Models\RoleModel;
use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    protected $model;

    public function __construct()
    {
        $this->model = new RoleModel();
    }

    public function run()
    {
        $data = [
            new RoleEntity(['role' => 'Administrator']),
            new RoleEntity(['role' => 'Customer']),
        ];
        
        $this->model->insertBatch($data);
    }
}
