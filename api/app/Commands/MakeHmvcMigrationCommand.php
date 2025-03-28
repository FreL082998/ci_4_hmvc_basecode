<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeHmvcMigrationCommand extends BaseCommand
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
    protected $name = 'hmvc:migration';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Generates a new hmvc module migration file.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'hmvc:migration [arguments] [options]';

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
        $migrationFileName = $params[0] ?? null;
        $moduleName = CLI::getOption('module');

        if (!$migrationFileName) {
            CLI::error('You must provide an migration file name.');
            return;
        }

        if (!$moduleName) {
            CLI::error('You must provide an module name.'); 
            return;
        }

        $createAt = date('Y-m-d-His');
        $filePath = ROOTPATH . "Modules/{$moduleName}/Database/Migrations/{$createAt}_{$migrationFileName}.php";

        // Ensure the directory exists before writing the file
        $directory = dirname($filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($filePath)) {
            CLI::error("Migration file '{$migrationFileName}' already exists.");
            return;
        }

        $stubPath = WRITEPATH . 'stubs/hmvc/migration.stub';
        if (!file_exists($stubPath)) {
            CLI::error('Stub file not found.');
            return;
        }

        // Load the stub and replace placeholder
        $stubContent = file_get_contents($stubPath);
        $migrationContent = str_replace('{{migrationFileName}}', $migrationFileName, $stubContent);
        $migrationContent = str_replace('{{moduleName}}', $moduleName, $migrationContent);

        file_put_contents($filePath, $migrationContent);

        CLI::write("Migration file '{$migrationFileName}' created successfully!", 'green');
    }
}
