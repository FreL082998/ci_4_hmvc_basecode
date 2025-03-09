<?php

namespace App\Services;

use CodeIgniter\Model;

/**
 * Class CommonService
 *
 * This service class is responsible for handling business logic related to CommonService.
 */
class CommonService
{
    public $pager;

    /**
     * Constructor for CommonService.
     */
    public function __construct()
    {
        $this->pager = service('pager');
    }

    /**
     * Generates pagination details for a given model.
     *
     * @param \CodeIgniter\Model $model The model instance to paginate.
     * @param int $page The current page number.
     * @param int $pageSize The number of records per page.
     * @return array The pagination metadata.
     */
    public function pagination(Model $model, int $page, int $pageSize): array
    {
        $total = $model->countAll();

        return [
            'current_page' => $page,
            'per_page' => $pageSize,
            'total' => $total,
            'total_pages' => ceil($total / $pageSize),
            'has_next' => ($page * $pageSize) < $total,
            'has_prev' => $page > 1,
        ];
    }
}
