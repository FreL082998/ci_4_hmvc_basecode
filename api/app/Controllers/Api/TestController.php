<?php

namespace App\Controllers\Api;

use App\Controllers\ApiController;
use App\Services\DatabaseService;
use App\Services\TestService;
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
        $data = $this->model->findAll();

        return $this->success(
            message: 'Retrieve successfully.',
            data: $data,
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
            return $this->error(
                message: 'Retrieve failed.',
                errors: [
                    'messages' => $ex->getMessage(),
                    'trace'    => $ex->getTrace(),
                ],
            );
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

            $this->databaseService->db->transBegin(); // Begin Transaction

            // Insert data into model
            if (!$this->model->insert($data)) {
                throw new Exception(implode(", ", $this->model->errors())); // Get validation errors
            }

            // Check transaction status
            if (!$this->databaseService->db->transStatus()) {
                throw new Exception('Transaction failed.');
            }

            $this->databaseService->db->transCommit(); // Commit Transaction

            return $this->success(
                message: 'Save successfully.',
                data: $data, // Return saved data
            );
        } catch (Exception $ex) {
            $this->databaseService->db->transRollback(); // Rollback Transaction

            return $this->error(
                message: 'Save failed.',
                errors: [
                    'messages' => $ex->getMessage(),
                    'trace'    => $ex->getTrace(),
                ],
            );
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
    
            $this->databaseService->db->transBegin(); // Begin Transaction

            // Update data into model
            if (!$this->model->update($id, $data)) {
                throw new Exception(implode(", ", $this->model->errors())); // Get validation errors
            }

            // Check transaction status
            if ($this->databaseService->db->transStatus() === false) {
                throw new Exception('Transaction failed.');
            }

            $this->databaseService->db->transCommit(); // Commit Transaction

            return $this->success(
                message: 'Update successfully.',
                data: $data, // Return saved data
            );
        } catch (Exception $ex) {
            $this->databaseService->db->transRollback(); // Rollback Transaction

            return $this->error(
                message: 'Save failed.',
                errors: [
                    'messages' => $ex->getMessage(),
                    'trace'    => $ex->getTrace(),
                ],
            );
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
            $this->databaseService->db->transRollback(); // Rollback Transaction

            return $this->error(
                message: 'Failed delete.',
                errors: [
                    'messages' => $ex->getMessage(),
                    'trace'    => $ex->getTrace(),
                ],
            );
        }
    }
}
