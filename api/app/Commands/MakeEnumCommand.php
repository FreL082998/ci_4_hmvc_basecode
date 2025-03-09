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
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $enumName = $params[0] ?? null;

        if (!$enumName) {
            CLI::error('You must provide a enum name.');
            return;
        }

        $filePath = APPPATH . "Enums/{$enumName}Enum.php";

        if (file_exists($filePath)) {
            CLI::error("Enum '{$enumName}Enum' already exists.");
            return;
        }

        $stubPath = WRITEPATH . 'stubs/enum.stub';
        if (!file_exists($stubPath)) {
            CLI::error('Stub file not found.');
            return;
        }

        // Load the stub and replace placeholder
        $stubContent = file_get_contents($stubPath);
        $enumContent = str_replace('{{enumName}}', $enumName, $stubContent);

        if (!is_dir(APPPATH . 'Enums')) {
            mkdir(APPPATH . 'Enums', 0755, true);
        }

        file_put_contents($filePath, $enumContent);

        CLI::write("Enum '{$enumName}Enum' created successfully!", 'green');
    }
}
