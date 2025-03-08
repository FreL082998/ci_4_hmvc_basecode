<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\TestModel;

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
            ['title' => 'Hello', 'description' => 'lorem ipsum bla bla bla...'],
            ['title' => 'World', 'description' => 'lorem ipsum bla bla bla...'],
        ];

        $this->model->insertBatch($data);
    }
}
