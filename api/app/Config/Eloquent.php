<?php

namespace Config;

use Illuminate\Database\Capsule\Manager as Capsule;

class Eloquent
{
    public static function initialize()
    {
        $capsule = new Capsule;

        $db = config('Database')->default;

        $capsule->addConnection([
            'driver'    => 'mysql', // Change this if using PostgreSQL, SQLite, etc.
            'host'      => $db['hostname'],
            'database'  => $db['database'],
            'username'  => $db['username'],
            'password'  => $db['password'],
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ]);

        // Make the connection globally available
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
