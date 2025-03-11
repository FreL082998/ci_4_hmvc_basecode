<?php

namespace Modules\User\Services;

use CodeIgniter\Model;

/**
 * Class UserService
 *
 * This service class is responsible for handling business logic related to UserService.
 */
class UserService
{
    /**
     * Constructor for UserService.
     */
    public function __construct()
    {
        // Constructor logic
    }

    /**
     * Retrieve user master list.
     *
     * @param Model $model
     * @param array $data
     * @return string
     */
    public function getUsers(Model $model, array $data): array
    {
        $query = $model;

        $filters = ['username', 'status', 'is_reset', 'created_at'];
        foreach ($filters as $filter) {
            if(isset($data[$filter])) {
                $query->like($filter, $data[$filter]);
            }
        }
        
        $result = $query->orderBy(
            $data['orderBy'] ?? 'created_at',
            $data['sortBy'] ?? 'DESC',
        )
        ->limit($data['pageSize'], ($data['page'] - 1) * $data['pageSize'])
        ->get()
        ->getResultArray();

        return $result;
    }
}
