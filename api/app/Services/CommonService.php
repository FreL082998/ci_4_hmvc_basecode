<?php

namespace App\Services;

use App\Enums\LogTypesEnum;
use CodeIgniter\Model;
use Exception;

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

    /**
     * Logs messages with a specified log level.
     *
     * @param LogTypesEnum         $logType The type of log (e.g., 'info', 'error').
     * @param Exception|null $ex      The exception to log (if available).
     *
     * @return array|null Returns an array for errors, otherwise null.
     */
    public function log(LogTypesEnum $logType = LogTypesEnum::ERROR, ?Exception $ex, ?string $message, ?array $context): ?array
    {
        switch ($logType) {
            case LogTypesEnum::INFO:
                $message = $message ?? "";
                $context = $context ?? [];
                logger()->info($message, json_encode($context, JSON_PRETTY_PRINT));
                return null;
            
            case LogTypesEnum::ERROR:
                if ($ex) {
                    $errors = [
                        'message' => $ex->getMessage(),
                        'trace'   => $ex->getTrace(),
                    ];
                    logger()->error(json_encode($errors, JSON_PRETTY_PRINT));
                    
                    return $errors;
                }
                return null;

            default:
                return null;
        }
    }
}
