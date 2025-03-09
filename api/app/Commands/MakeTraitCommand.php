<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeTraitCommand extends BaseCommand
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
    protected $name = 'make:trait';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Generates a new trait file.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:trait [arguments] [options]';

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
        $traitName = $params[0] ?? null;

        if (!$traitName) {
            CLI::error('You must provide a trait name.');
            return;
        }

        $filePath = APPPATH . "Traits/{$traitName}.php";

        if (file_exists($filePath)) {
            CLI::error("Trait '{$traitName}' already exists.");
            return;
        }

        $stubPath = WRITEPATH . 'stubs/trait.stub';
        if (!file_exists($stubPath)) {
            CLI::error('Stub file not found.');
            return;
        }

        // Load the stub and replace placeholder
        $stubContent = file_get_contents($stubPath);
        $traitContent = str_replace('{{traitName}}', $traitName, $stubContent);

        if (!is_dir(APPPATH . 'Traits')) {
            mkdir(APPPATH . 'Traits', 0755, true);
        }

        file_put_contents($filePath, $traitContent);

        CLI::write("Trait '{$traitName}' created successfully!", 'green');
    }
}
