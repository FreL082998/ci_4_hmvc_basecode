<?php

namespace Modules\User\Entities;

use CodeIgniter\Entity\Entity;

class RoleEntity extends Entity
{
    protected $attributes = [
        'id'            =>  null,
        'role'          =>  null,
        'created_at'    =>  null,
        'updated_at'    =>  null,
        'deleted_at'    =>  null,
    ];
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'id'            =>  'integer',
        'role'          =>  'string',
        'created_at'    =>  'datetime',
        'updated_at'    =>  'datetime',
        'deleted_at'    =>  'datetime',
    ];
}
