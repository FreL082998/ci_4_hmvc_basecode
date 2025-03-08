<?php

namespace App\Traits;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Trait ApiResponseTrait
 *
 * This trait provides reusable methods for ApiResponseTrait functionality.
 */
trait ApiResponseTrait
{
    use ResponseTrait;

    /**
     * Success response
     * 
     * @param mixed $data The response data.
     * @param string $message The success message (default: 'Success').
     * @param int $statusCode The HTTP status code (default: 200 - OK).
     * @return \CodeIgniter\HTTP\Response
     */
    protected function success(
        mixed $data = null, 
        string $message = 'Success', 
        int $statusCode = ResponseInterface::HTTP_OK
    ) {
        $response = [
            'status'    =>  'success',
            'code'      =>  $statusCode,
            'message'   =>  $message,
        ];

        if (isset($data)) {
            $response['data'] = $data;
        }
        
        return $this->respond($response, $statusCode);
    }

    /**
     * Success file response
     * 
     * @param string $filePath Path to the file.
     * @param string|null $fileName Optional custom file name for download.
     * @param string $mimeType MIME type of the file (default: 'application/octet-stream').
     * @return \CodeIgniter\HTTP\Response
     */
    protected function file(string $filePath, string $fileName = null, string $mimeType = 'application/octet-stream')
    {
        if (!is_file($filePath)) {
            throw PageNotFoundException::forPageNotFound("File not found: {$filePath}");
        }

        $downloadName = $fileName ?? basename($filePath);

        return $this->response->download($filePath, null)->setHeader('Content-Type', $mimeType);
    }

    /**
     * Success image response
     *
     * @param string $imagePath The full path to the image file.
     * @param string $mimeType The MIME type of the image (default: 'image/png').
     * @return \CodeIgniter\HTTP\Response
     *
     * @throws PageNotFoundException If the image file does not exist.
     */
    protected function image(string $imagePath, string $mimeType = 'image/png')
    {
        if (!is_file($imagePath)) {
            throw PageNotFoundException::forPageNotFound("Image not found: {$imagePath}");
        }

        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setBody(file_get_contents($imagePath));
    }

    /**
     * Error response
     *
     * Returns a standardized error response in JSON format.
     *
     * @param mixed $errors An optional array of additional error details.
     * @param string $message The error message (default: 'An error occurred').
     * @param int $statusCode The HTTP status code (default: 400 - Bad Request).
     * @return \CodeIgniter\HTTP\Response
     */
    protected function error(mixed $errors = null, string $message = 'An error occurred', int $statusCode = ResponseInterface::HTTP_BAD_REQUEST)
    {
        $response = [
            'status'    =>  'error',
            'code'      =>  $statusCode,
            'message'   =>  $message,
        ];

        if(isset($errors) && config('App')->debug) {
            $response['errors'] = $errors;
        }

        return $this->respond($response, $statusCode);
    }

    /**
     * Validation error response
     *
     * Returns a standardized validation error response in JSON format.
     *
     * @param array $errors An array containing validation error messages.
     * @param string $message A custom validation failure message (default: 'Validation failed').
     * @return \CodeIgniter\HTTP\Response
     */
    protected function validationError(array $errors, string $message = 'Validation failed')
    {
        return $this->error($message, ResponseInterface::HTTP_UNPROCESSABLE_ENTITY, $errors);
    }
}
