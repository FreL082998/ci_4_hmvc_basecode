<?php

namespace App\Database\Seeds;

use App\Entities\Test;
use App\Models\TestModel;
use CodeIgniter\Database\Seeder;

class TestSeeder extends Seeder
{
    protected $model;

    public function __construct()
    {
        $this->model = new TestModel();
    }

    public function run()
    {
        $data = [
            new Test(['title' => 'Hello', 'description' => 'lorem ipsum bla bla bla...']),
            new Test(['title' => 'World', 'description' => 'lorem ipsum bla bla bla...']),
        ];

        $this->model->insertBatch($data);
    }
}
