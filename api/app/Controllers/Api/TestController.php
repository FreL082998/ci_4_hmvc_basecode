<?php

namespace App\Controllers\Api;

use App\Controllers\ApiController;
use App\Entities\TestEntity;
use App\Enums\LogTypesEnum;
use Exception;

/**
 * Class TestController
 *
 * Controller for handling API requests related to Test model.
 */
class TestController extends ApiController
{
    /**
     * @var string $modelName Model class name
     */
    protected $modelName = 'App\Models\TestModel';

    /**
     * @var string $format Response format
     */
    protected $format = 'json';

    /**
     * @var CommonService $commonService Handles common variable, function, and etc.
     */
    protected $commonService;
    
    /**
     * @var DatabaseService $databaseService Handles database transactions
     */
    protected $databaseService;

    /**
     * @var TestService $testService Handles business logic for Test
     */
    protected $testService;

    /**
     * Constructor
     * Initializes services, helpers, etc.
     */
    public function __construct()
    {
		$this->commonService = service('commonService');
        $this->databaseService = service('databaseService');
        $this->testService = service('testService');
    }

    /**
     * Retrieve all records
     *
     * @return mixed JSON response with all records
     */
    public function index()
    {
		$data = $this->request->getVar();
        $data['page'] = (int) ($data['page'] ?? 1);
        $data['pageSize'] = (int) ($data['pageSize'] ?? config('Pager')->perPage);
        
        $result = [
            'list' => $this->testService->getTests($this->model, $data),
            'pagination' => $this->commonService->pagination($this->model, $data['page'], $data['pageSize']),
        ];

        return $this->success(
            message: 'Retrieve successfully.',
            data: $result,
        );
    }

    /**
     * Retrieve a specific record
     *
     * @param int|null $id Record ID
     * @return mixed JSON response with the record or error
     */
    public function show($id = null)
    {
        try {
            // Find $id
            $data = $this->model->find($id);
    
            // Check if $data exists
            if (!$data) {
                // return not found
                throw new Exception("No data found with ID $id");
            }
    
            return $this->success(
                message: 'Fetch successfully.',
                data: $data,
            );
        } catch (Exception $ex) {
            return $this->handleException($ex, 'Retrieved delete.', false);
        }
    }

    /**
     * Create a new record
     *
     * @return mixed JSON response with success or failure message
     */
    public function create()
    {
        try {
            // Decode JSON safely
            $data = $this->request->getJSON(true);

            // Set entity value
            $testEntity = new TestEntity();
            $testEntity->title = $data['title'] ?? null;
            $testEntity->description = $data['description'] ?? null;

            $this->databaseService->db->transBegin(); // Begin Transaction

            // Insert data into model
            if (!$this->model->insert($testEntity)) {
                throw new Exception(implode(", ", $this->model->errors())); // Get validation errors
            }

            // Check transaction status
            if (!$this->databaseService->db->transStatus()) {
                throw new Exception('Transaction failed.');
            }

            $this->databaseService->db->transCommit(); // Commit Transaction

            return $this->success(
                message: 'Save successfully.',
                data: $testEntity, // Return saved data
            );
        } catch (Exception $ex) {
            return $this->handleException($ex, 'Saved delete.', true);
        }
    }

    /**
     * Update an existing record
     *
     * @param int|null $id Record ID
     * @return mixed JSON response with success or failure message
     */
    public function update($id = null)
    {
        try {
            // Find $id
            $model = $this->model->find($id);

            // Check if $model exists
            if (!$model) {
                // return not found
                throw new Exception("No data found with ID $id");
            }

            // Decode JSON safely
            $data = $this->request->getJSON(true);

            // Set entity value
            $testEntity = new TestEntity();
            $testEntity->title = $data['title'] ?? null;
            $testEntity->description = $data['description'] ?? null;
    
            $this->databaseService->db->transBegin(); // Begin Transaction

            // Update data into model
            if (!$this->model->update($id, $testEntity)) {
                throw new Exception(implode(", ", $this->model->errors())); // Get validation errors
            }

            // Check transaction status
            if ($this->databaseService->db->transStatus() === false) {
                throw new Exception('Transaction failed.');
            }

            $this->databaseService->db->transCommit(); // Commit Transaction

            return $this->success(
                message: 'Update successfully.',
                data: $testEntity, // Return saved data
            );
        } catch (Exception $ex) {
            return $this->handleException($ex, 'Saved delete.', true);
        }
    }

    /**
     * Delete a record
     *
     * @param int|null $id Record ID
     * @return mixed JSON response with success or failure message
     */
    public function delete($id = null)
    {
        try {
            // Find $id
            $model = $this->model->find($id);

            // Check if $model exists
            if (!$model) {
                // return not found
                throw new Exception("No data found with ID $id");
            }

            $this->databaseService->db->transBegin(); // Begin Transaction

            // Delete data into Model
            $this->model->delete($id);

            // Check transaction status
            if ($this->databaseService->db->transStatus() === false) {
                throw new Exception('Transaction failed.');
            }

            $this->databaseService->db->transCommit(); // Commit Transaction

            return $this->success(
                message: 'Delete successfully.',
            );
        } catch (Exception $ex) {
            return $this->handleException($ex, 'Failed delete.', true);
        }
    }

    /**
     * Handles exceptions by logging the error and optionally performing a rollback.
     *
     * @param Exception $ex       The exception instance that was thrown.
     * @param string    $message  A custom error message to log.
     * @param bool      $rollback Whether to perform a rollback operation (default: false).
     *
     * @return Response
     */
    private function handleException(Exception $ex, string $message, bool $rollback = false)
    {
        if($rollback) {
            $this->databaseService->db->transRollback(); // Rollback Transaction
        }

        $errors = $this->commonService->log(LogTypesEnum::ERROR, $ex, null, null);
        
        return $this->error(
            message: $message,
            errors: $errors,
        );
    }
}
