<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Test extends Entity
{
    protected $attributes = [
        'id'            =>  null,
        'title'         =>  null,
        'description'   =>  null,
        'created_at'    =>  null,
        'updated_at'    =>  null,
        'deleted_at'    =>  null,    
    ];
    protected $datamap = [
        // 'pagkakakilanlan'   =>  'id',
        // 'pamagat'           =>  'title',
        // 'paglalarawan'      =>  'description',
        // 'petsa_nagawa'      =>  'created_at',
        // 'petsa_binago'      =>  'updated_at',
        // 'petsa_tinanggal'   =>  'deleted_at',
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'id'            =>  'integer',
        'title'         =>  'string',
        'description'   =>  'string',
        'created_at'    =>  'datetime',
        'updated_at'    =>  'datetime',
    ];

    /**
     * Entity scope getTitleInUpperCase that return title into uppercase format.
     * 
     * @return string
     */
    public function getTitleInUpperCase(): string
    {
        return strtoupper($this->attributes['title']);
    }
}
