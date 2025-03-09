<?php

namespace App\Eloquents;

use App\Models\TestModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Class TestEloquent
 *
 * This class serves as an Eloquent model that extends Laravel's Eloquent ORM.
 * It dynamically loads configuration from a CodeIgniter model (`TestModel`)
 * and sets up the corresponding database properties.
 *
 * Features:
 * - Loads table configuration from CodeIgniter model.
 * - Dynamically enables SoftDeletes if configured.
 * - Uses Laravel’s Eloquent ORM for database interactions.
 */
class TestEloquent extends Model
{
    /**
     * Constructor.
     *
     * This initializes the Eloquent model by fetching database configurations 
     * from the corresponding CodeIgniter model.
     *
     * @param array $attributes The model attributes.
     */
    public function __construct(array $attributes = [])
    {
        // Load values from the CodeIgniter Model
        $ciModel = new TestModel();
        $config = $ciModel->getEloquentConfig();

        // Assign table-related properties
        $this->table = $config['table'];
        $this->primaryKey = $config['primaryKey'];
        $this->fillable = $config['fillable'];
        $this->dates = $config['dates'];

        // Dynamically enable SoftDeletes trait if configured
        if ($config['useSoftDeletes']) {
            $this->initSoftDeletes();
        }

        parent::__construct($attributes);
    }

    /**
     * Initialize SoftDeletes feature dynamically.
     *
     * This method enables the SoftDeletes trait for the model by setting 
     * the `deleted_at` field and applying the `SoftDeletingScope`.
     *
     * @return void
     */
    protected function initSoftDeletes()
    {
        // Dynamically add SoftDeletes support
        $this->forceFill([
            'deleted_at' => null
        ]);

        // Add deleted_at to date fields
        $this->dates[] = 'deleted_at';

        // Apply SoftDeletingScope globally
        static::addGlobalScope(new SoftDeletingScope());
    }
}
