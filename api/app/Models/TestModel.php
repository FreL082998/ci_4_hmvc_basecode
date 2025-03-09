<?php

namespace App\Models;

use App\Entities\TestEntity;
use CodeIgniter\Model;

class TestModel extends Model
{
    protected $table            = 'test';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = TestEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'description'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'title'         =>  'required|string|max_length[100]',
        'description'   =>  'required|string',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Eloquent Configuration
    public function getEloquentConfig(): array
    {
        $property = [
            'table'             =>  $this->table,
            'primaryKey'        =>  $this->primaryKey,
            'fillable'          =>  $this->allowedFields,
            'useSoftDeletes'    =>  $this->useSoftDeletes,
            'dates'             =>  [$this->createdField, $this->updatedField],
        ];

        if($this->useSoftDeletes) {
            $property['dates'] = array_merge($property['dates'], [$this->deletedField]);
        }

        return $property;
     }
     
    /**
     * HasOne
     *
     * @param int $id Record ID
     * @return mixed
     */
    public function testChild(int $id)
    {
        $testChildModel = new TestChildModel();
        return $testChildModel->where('test_id', $id)->first();
    }
}
