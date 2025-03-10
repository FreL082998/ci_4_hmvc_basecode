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
    protected $options = [
        '--hmvc'   => 'Generate the service class inside a module.',
        '--module' => 'Specify the module name (required if using --hmvc).',
    ];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $serviceName = $params[0] ?? null;
        $isHmvc = CLI::getOption('hmvc') !== null;
        $moduleName = CLI::getOption('module') ?? $serviceName;

        if (!$serviceName) {
            CLI::error('You must provide a service name.');
            return;
        }

        $filePath = $isHmvc 
            ? ROOTPATH . "Modules/{$moduleName}/Services/{$serviceName}Service.php" 
            : APPPATH . "Services/{$serviceName}Service.php";

        // Ensure the directory exists before writing the file
        $directory = dirname($filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($filePath)) {
            CLI::error("Service '{$serviceName}Service' already exists.");
            return;
        }

        $stubPath = $isHmvc ? WRITEPATH . 'stubs/hmvc/service.stub' : WRITEPATH . 'stubs/service.stub';
        if (!file_exists($stubPath)) {
            CLI::error('Stub file not found.');
            return;
        }

        // Load the stub and replace placeholder
        $stubContent = file_get_contents($stubPath);
        $serviceContent = str_replace('{{serviceName}}', $serviceName, $stubContent);
        $serviceContent = str_replace('{{moduleName}}', $moduleName, $serviceContent);

        file_put_contents($filePath, $serviceContent);

        CLI::write("Service '{$serviceName}Service' created successfully!", 'green');
    }
}
