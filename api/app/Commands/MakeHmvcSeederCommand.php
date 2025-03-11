<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeHmvcSeederCommand extends BaseCommand
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
    protected $name = 'hmvc:seeder';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Generates a new hmvc module seeder file.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'hmvc:seeder [arguments] [options]';

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
        $seederName = $params[0] ?? null;
        $moduleName = CLI::getOption('module');

        if (!$seederName) {
            CLI::error('You must provide an seeder name.');
            return;
        }

        if (!$moduleName) {
            CLI::error('You must provide an module name.');
            return;
        }

        $filePath = ROOTPATH . "Modules/{$moduleName}/Database/Seeds/{$seederName}.php";

        // Ensure the directory exists before writing the file
        $directory = dirname($filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($filePath)) {
            CLI::error("Seeder file '{$seederName}' already exists.");
            return;
        }

        $stubPath = WRITEPATH . 'stubs/hmvc/seeder.stub';
        if (!file_exists($stubPath)) {
            CLI::error('Stub file not found.');
            return;
        }

        // Load the stub and replace placeholder
        $stubContent = file_get_contents($stubPath);
        $seederContent = str_replace('{{seederName}}', $seederName, $stubContent);
        $seederContent = str_replace('{{moduleName}}', $moduleName, $seederContent);

        file_put_contents($filePath, $seederContent);

        CLI::write("Seeder file '{$seederName}' created successfully!", 'green');
    }
}
