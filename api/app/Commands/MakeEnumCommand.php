<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeEnumCommand extends BaseCommand
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
    protected $name = 'make:enum';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Generates a new enum file.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:enum [arguments] [options]';

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
        '--hmvc'   => 'Generate the enum inside a module.',
        '--module' => 'Specify the module name (required if using --hmvc).',
    ];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $enumName = $params[0] ?? null;
        $isHmvc = CLI::getOption('hmvc') !== null;
        $moduleName = CLI::getOption('module') ?? $enumName;

        if (!$enumName) {
            CLI::error('You must provide an enum name.');
            return;
        }

        $filePath = $isHmvc 
            ? APPPATH . "Modules/{$moduleName}/Enums/{$enumName}Enum.php"
            : APPPATH . "Enums/{$enumName}Enum.php";

        // Ensure the directory exists before writing the file
        $directory = dirname($filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($filePath)) {
            CLI::error("Enum '{$enumName}Enum' already exists.");
            return;
        }

        $stubPath = $isHmvc ? WRITEPATH . 'stubs/hmvc/enum.stub' : WRITEPATH . 'stubs/enum.stub';
        if (!file_exists($stubPath)) {
            CLI::error('Stub file not found.');
            return;
        }

        // Load the stub and replace placeholder
        $stubContent = file_get_contents($stubPath);
        $enumContent = str_replace('{{enumName}}', $enumName, $stubContent);
        $enumContent = str_replace('{{moduleName}}', $moduleName, $enumContent);

        file_put_contents($filePath, $enumContent);

        CLI::write("Enum '{$enumName}Enum' created successfully!", 'green');
    }
}
