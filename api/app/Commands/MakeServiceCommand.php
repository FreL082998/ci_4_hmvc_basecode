<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeServiceCommand extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Generators';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'make:service';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Generates a new service file.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:service [arguments] [options]';

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
        $serviceName = $params[0] ?? null;

        if (!$serviceName) {
            CLI::error('You must provide a service name.');
            return;
        }

        $filePath = APPPATH . "Services/{$serviceName}.php";

        if (file_exists($filePath)) {
            CLI::error("Service '{$serviceName}' already exists.");
            return;
        }

        $stubPath = WRITEPATH . 'stubs/service.stub';
        if (!file_exists($stubPath)) {
            CLI::error('Stub file not found.');
            return;
        }

        // Load the stub and replace placeholder
        $stubContent = file_get_contents($stubPath);
        $serviceContent = str_replace('{{serviceName}}', $serviceName, $stubContent);

        if (!is_dir(APPPATH . 'Services')) {
            mkdir(APPPATH . 'Services', 0755, true);
        }

        file_put_contents($filePath, $serviceContent);

        CLI::write("Service '{$serviceName}' created successfully!", 'green');
    }
}
