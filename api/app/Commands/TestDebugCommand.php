<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Autoload;

class TestDebugCommand extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Debug';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'test:debug';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Custom automated debugging tool. Note: Still POC under development.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'test:debug [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        switch ($params[0]) {
            case 'Autoload':
                $autoload = new Autoload();
                CLI::write(print_r($autoload->psr4, true), 'yellow');
                break;
            
            default:
                # code...
                break;
        }
    }

}
