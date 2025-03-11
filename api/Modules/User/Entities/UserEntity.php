<?php

namespace Modules\User\Entities;

use CodeIgniter\Entity\Entity;

class UserEntity extends Entity
{
    protected $attributes = [
        'id'         => null,
        'username'   => null,
        'password'   => null,
        'status'     => 'active',
        'is_reset'   => true,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null,
    ];
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'id'         => 'integer',
        'username'   => 'string',
        'password'   => 'string',
        'status'     => 'string',
        'is_reset'   => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
