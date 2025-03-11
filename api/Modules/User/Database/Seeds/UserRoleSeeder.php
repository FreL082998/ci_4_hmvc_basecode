<?php

namespace Modules\User\Database\Seeds;

use Modules\User\Entities\UserRoleEntity;
use Modules\User\Models\UserModel;
use Modules\User\Models\RoleModel;
use Modules\User\Models\UserRoleModel;
use CodeIgniter\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    protected $userModel;
    protected $roleModel;
    protected $userRoleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->userRoleModel = new UserRoleModel();
    }

    public function run()
    {
        $admin = $this->userModel->select('id')->where('username', 'admin')->first();
        $customer = $this->userModel->select('id')->where('username', 'customer')->first();
        $adminRole = $this->roleModel->select('id')->where('role', 'Administrator')->first();
        $customerRole = $this->roleModel->select('id')->where('role', 'Customer')->first();

        $data = [
            new UserRoleEntity(['user_id' => $admin->id, 'role_id' => $adminRole->id]),
            new UserRoleEntity(['user_id' => $customer->id, 'role_id' => $customerRole->id]),
        ];

        $this->userRoleModel->insertBatch($data);
    }
}
