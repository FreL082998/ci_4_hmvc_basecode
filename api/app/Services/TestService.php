<?php

namespace App\Services;

use CodeIgniter\Model;

/**
 * Class TestService
 *
 * This service class is responsible for handling business logic related to TestService.
 */
class TestService
{
    /**
     * Constructor for TestService.
     */
    public function __construct()
    {
        // Constructor logic
    }

    /**
     * Example method in TestService.
     *
     * @param Model $model
     * @param array $data
     * @return string
     */
    public function getTests(Model $model, array $data): array
    {
        $test = $model;

        $filters = ['title', 'description', 'created_at'];
        foreach ($filters as $filter) {
            if(isset($data[$filter])) {
                $test->like($filter, $data[$filter]);
            }
        }
        
        $result = $test->orderBy(
            $data['orderBy'] ?? 'created_at',
            $data['sortBy'] ?? 'DESC',
        )
        ->limit($data['pageSize'], ($data['page'] - 1) * $data['pageSize'])
        ->get()
        ->getResultArray();

        return $result;
    }
}
