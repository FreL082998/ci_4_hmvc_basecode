<?php

namespace App\Services;

use Config\Database;

/**
 * Class DatabaseService
 *
 * This service class is responsible for handling business logic related to DatabaseService.
 */
class DatabaseService
{
    public $db;

    /**
     * Constructor for DatabaseService.
     */
    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Connect to a database group.
     *
     * @param string $group The database group to connect to.
     * @param bool $getShared Whether to get a shared connection.
     * @return \CodeIgniter\Database\BaseConnection
     */
    public function dbConnect(string $group, bool $getShared = true)
    {
        return Datebase::connect($group, $getShared);
    }
}
