<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeEloquentCommand extends BaseCommand
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
    protected $name = 'make:eloquent';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Generates a new eloquent file.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:eloquent [arguments] [options]';

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
        $eloquentName = $params[0] ?? null;

        if (!$eloquentName) {
            CLI::error('You must provide a eloquent name.');
            return;
        }

        $filePath = APPPATH . "Eloquents/{$eloquentName}Eloquent.php";

        if (file_exists($filePath)) {
            CLI::error("Eloquent '{$eloquentName}Eloquent' already exists.");
            return;
        }

        $stubPath = WRITEPATH . 'stubs/eloquent.stub';
        if (!file_exists($stubPath)) {
            CLI::error('Stub file not found.');
            return;
        }

        // Load the stub and replace placeholder
        $stubContent = file_get_contents($stubPath);
        $eloquentContent = str_replace('{{eloquentName}}', $eloquentName, $stubContent);

        if (!is_dir(APPPATH . 'Eloquents')) {
            mkdir(APPPATH . 'Eloquents', 0755, true);
        }

        file_put_contents($filePath, $eloquentContent);

        CLI::write("Eloquent '{$eloquentName}Eloquent' created successfully!", 'green');
    }
}
