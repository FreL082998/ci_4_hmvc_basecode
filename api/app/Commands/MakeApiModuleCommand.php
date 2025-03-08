<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeApiModuleCommand extends BaseCommand
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
    protected $name = 'make:api-module';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Generates an API Controller, Model, Migration, and Seeder file.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:api-module [arguments] [options]';

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
        $moduleName = $params[0] ?? null;

        if (!$moduleName) {
            CLI::error('You must provide a moduleName for the API module.');
            return;
        }

        $controllerFilePath = APPPATH . "Controllers/Api";
        $this->generateFile('Controller', $controllerFilePath, 'controller.stub', $moduleName);
        
        command('make:entity ' . $moduleName);
        command('make:model ' . $moduleName . 'Model');
        command('make:migration Create' . $moduleName . 'Table');
        command('make:seeder ' . $moduleName . 'Seeder');

        CLI::write('API Module generated successfully!', 'green');
    }

    private function generateFile($type, $dirPath, $stubFile, $moduleName)
    {
        $stubPath = WRITEPATH . "stubs/{$stubFile}";
        if (!file_exists($stubPath)) {
            CLI::error("Stub file {$stubFile} not found.");
            return;
        }
        
        $filePath = "$dirPath/$moduleName$type.php";

        if (file_exists($filePath)) {
            CLI::error("$type '{$moduleName}' already exists.");
            return;
        }

        $content = file_get_contents($stubPath);
        $content = str_replace('{{moduleName}}', $moduleName, $content);
        $content = str_replace('{{entityName}}', toCamelCase($moduleName), $content);

        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
        }

        file_put_contents($filePath, $content);
        CLI::write("Created {$type}: {$filePath}", 'yellow');
    }
}
