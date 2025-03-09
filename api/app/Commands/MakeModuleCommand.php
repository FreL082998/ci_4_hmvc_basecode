<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeModuleCommand extends BaseCommand
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
    protected $name = 'make:module';

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
    protected $usage = 'make:module [arguments] [options]';

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
        '--hmvc'   => 'Generate the class files inside a module.',
    ];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $moduleName = $params[0] ?? null;
        $isHmvc = CLI::getOption('hmvc') !== null;

        if (!$moduleName) {
            CLI::error('You must provide a moduleName for the API module.');
            return;
        }

        if($isHmvc) {
            $this->generateHmvcModuleFiles($moduleName);
        } else {
            $this->generateNonHmvcFiles($moduleName);
        }
    }

    /**
     * @param string|null $moduleName
     * @return void
     */
    private function generateHmvcModuleFiles(string|null $moduleName): void
    {
        if($moduleName) {
            $directives = [
                'api_controller'    =>  [
                    'type'  =>  'Controller',
                    'path'  =>  APPPATH . "Modules/{$moduleName}/Controllers/Api/{$moduleName}Controller.php",
                    'stub'  =>  'hmvc/api_controller.stub',
                ],
                'web_controller'    =>  [
                    'type'  =>  'Controller',
                    'path'  =>  APPPATH . "Modules/{$moduleName}/Controllers/Web/{$moduleName}Controller.php",
                    'stub'  =>  'hmvc/web_controller.stub',
                ],
                'entity'            =>  [
                    'type'  =>  'Entity',
                    'path'  =>  APPPATH . "Modules/{$moduleName}/Entities/{$moduleName}Entity.php",
                    'stub'  =>  'hmvc/entity.stub',
                ],
                'model'             =>  [
                    'type'  =>  'Model',
                    'path'  =>  APPPATH . "Modules/{$moduleName}/Models/{$moduleName}Model.php",
                    'stub'  =>  'hmvc/model.stub',
                ],
                'service'           =>  [
                    'type'  =>  'Service',
                    'path'  =>  APPPATH . "Modules/{$moduleName}/Services/{$moduleName}Service.php",
                    'stub'  =>  'hmvc/service.stub',
                ],
                'view'              =>  [
                    'type'  =>  'View',
                    'path'  =>  APPPATH . "Modules/{$moduleName}/Views/index.php",
                    'stub'  =>  'hmvc/view.stub',
                ],
                'route'             =>  [
                    'type'  =>  'Routes',
                    'path'  =>  APPPATH . "Modules/{$moduleName}/Config/Routes.php",
                    'stub'  =>  'hmvc/route.stub',
                ],
                'services'          =>  [
                    'type'  =>  'Service Registry',
                    'path'  =>  APPPATH . "Modules/{$moduleName}/Config/Services.php",
                    'stub'  =>  'hmvc/services.stub',
                ],
            ];
            
            foreach ($directives as $directive) {
                $this->generateFile($directive['type'], $directive['path'], $directive['stub'], $moduleName, true);
            }

            command('make:migration Create' . $moduleName . 'Table');
            command('make:seeder ' . $moduleName . 'Seeder');
        }
    }

    /**
     * @param string|null $moduleName
     * @return void
     */
    private function generateNonHmvcFiles(string|null $moduleName): void
    {
        if($moduleName) {
            $this->generateFile('Controller', APPPATH . "Controllers/Api", 'controller.stub', $moduleName);
            
            command('make:controller Web/' . $moduleName . 'Controller');
            command('make:entity ' . $moduleName . 'Entity');
            command('make:model ' . $moduleName . 'Model');
            command('make:migration Create' . $moduleName . 'Table');
            command('make:seeder ' . $moduleName . 'Seeder');
    
            CLI::write('API Module generated successfully!', 'green');
        }
    }

    /**
     * @param string $type
     * @param string $path
     * @param string $stubFile
     * @param string $moduleName
     * @param bool $isHmvc = false
     * @return void
     */
    private function generateFile(string $type, string $path, string $stubFile, string $moduleName, bool $isHmvc = false): void
    {
        $stubPath = WRITEPATH . "stubs/{$stubFile}";
        if (!file_exists($stubPath)) {
            CLI::error("Stub file {$stubFile} not found.");
            return;
        }
        
        $filePath = $isHmvc ? $path : "$path/$moduleName$type.php";

        // Ensure the directory exists before writing the file
        $directory = $isHmvc ? dirname($filePath) : $path;
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($filePath)) {
            CLI::error("$type '{$moduleName}' already exists.");
            return;
        }

        $content = file_get_contents($stubPath);
        $content = str_replace('{{moduleName}}', $moduleName, $content);
        $content = str_replace('{{entityName}}', toCamelCase($moduleName), $content);
        $content = str_replace('{{moduleNameCamelCase}}', toCamelCase($moduleName), $content);
        $content = str_replace('{{moduleNameToLower}}', strtolower($moduleName), $content);
        $content = str_replace('{{serviceName}}', $moduleName, $content);
        $content = str_replace('{{enumName}}', $moduleName, $content);

        file_put_contents($filePath, $content);
        CLI::write("Created {$type}: {$filePath}", 'yellow');
    }
}
