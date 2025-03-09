<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * The model instance for interacting with the database.
     * 
     * @var \App\Models\Home
     */
    protected $model;

    /**
     * The database connection instance.
     *
     * @var \CodeIgniter\Database\BaseConnection
     */
    protected $db;

    /**
     * --------------------------------------------------------------------------
     * Pagination Service
     * --------------------------------------------------------------------------
     * 
     * This property holds an instance of the CodeIgniter pagination service.
     * It is used to handle pagination throughout the application.
     * 
     * @var \CodeIgniter\Pager\Pager
     */
    protected $pager;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->db = Database::connect();
        $this->pager = service('pager');
        // E.g.: $this->session = service('session');
    }
}
