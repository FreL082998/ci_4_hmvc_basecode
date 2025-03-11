<?php

namespace Modules\User\Entities;

use CodeIgniter\Entity\Entity;

class UserRoleEntity extends Entity
{
    protected $attributes = [
        'id'            =>  null,
        'user_id'       =>  null,
        'role_id'       =>  null,
        'created_at'    =>  null,
        'updated_at'    =>  null,
    ];
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id'            =>  'integer',
        'user_id'       =>  'integer',
        'role_id'       =>  'integer',
        'created_at'    =>  'datetime',
        'updated_at'    =>  'datetime',
    ];
}
