<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Psy\Shell;

class PsyshCommand extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'psysh';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Start an interactive PsySH shell for CodeIgniter 4.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'psysh [arguments] [options]';

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
        if (!class_exists(Shell::class)) {
            CLI::error('PsySH is not installed. Run: composer require --dev psy/psysh');
            return;
        }

        $shell = new Shell();
        $shell->run();
    }
}
