<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeHmvcModelCommand extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'HMVC';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'hmvc:model';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Generates a new hmvc module model file.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'hmvc:model [arguments] [options]';

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
        '--module' => 'Specify the module name required for HMVC.',
    ];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $modelName = $params[0] ?? null;
        $moduleName = CLI::getOption('module');

        if (!$modelName) {
            CLI::error('You must provide an model name.');
            return;
        }

        if (!$moduleName) {
            CLI::error('You must provide an module name.');
            return;
        }

        $modelFilePath = ROOTPATH . "Modules/{$moduleName}/Models/{$modelName}Model.php";
        $entityFilePath = ROOTPATH . "Modules/{$moduleName}/Entities/{$modelName}Entity.php";

        // Ensure the directory exists before writing the file
        $directory = dirname($modelFilePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($modelFilePath)) {
            CLI::error("Model file '{$modelName}Model' already exists.");
            return;
        }

        $directory = dirname($entityFilePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($entityFilePath)) {
            CLI::error("Entity file '{$modelName}Entity' already exists.");
            return;
        }

        $modelStubPath = WRITEPATH . 'stubs/hmvc/model_copy.stub';
        if (!file_exists($modelStubPath)) {
            CLI::error('Stub file not found.');
            return;
        }

        $entityStubPath = WRITEPATH . 'stubs/hmvc/entity.stub';
        if (!file_exists($entityStubPath)) {
            CLI::error('Stub file not found.');
            return;
        }

        // Load the stub and replace placeholder
        $modelStubContent = file_get_contents($modelStubPath);
        $modelContent = str_replace('{{modelName}}', $modelName, $modelStubContent);
        $modelContent = str_replace('{{moduleName}}', $moduleName, $modelContent);

        file_put_contents($modelFilePath, $modelContent);

        CLI::write("Model file '{$modelName}Model' created successfully!", 'green');

        $entityStubContent = file_get_contents($entityStubPath);
        $entityContent = str_replace('{{moduleName}}', $modelName, $entityStubContent);

        file_put_contents($entityFilePath, $entityContent);

        CLI::write("Entity file '{$modelName}Entity' created successfully!", 'green');
    }
}
