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
     * @var string
     */
    protected $modelName;
    protected $moduleName;

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $this->modelName = $params[0] ?? null;
        $this->moduleName = CLI::getOption('module');
        
        if (!$this->modelName) {
            CLI::error('You must provide an model name.');
            return;
        }
        
        if (!$this->moduleName) {
            CLI::error('You must provide an module name.');
            return;
        }

        /**
         * Generate files
         */
        $this->createModelFile();
        $this->createEntityFile();
        $this->createMigrationFile();
        $this->createSeederFile();
    }

    private function createModelFile()
    {   
        $modelFilePath = ROOTPATH . "Modules/{$this->moduleName}/Models/{$this->modelName}Model.php";

        // Ensure the directory exists before writing the file
        $directory = dirname($modelFilePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($modelFilePath)) {
            CLI::error("Model file '{$this->modelName}Model' already exists.");
            return;
        }
        $modelStubPath = WRITEPATH . 'stubs/hmvc/model_copy.stub';
        if (!file_exists($modelStubPath)) {
            CLI::error('Stub file not found.');
            return;
        }
        
        // Load the stub and replace placeholder
        $modelStubContent = file_get_contents($modelStubPath);
        $modelContent = str_replace('{{modelName}}', $this->modelName, $modelStubContent);
        $modelContent = str_replace('{{moduleName}}', $this->moduleName, $modelContent);

        file_put_contents($modelFilePath, $modelContent);

        CLI::write("Model file '{$this->modelName}Model' created successfully!", 'green');
    }

    private function createEntityFile()
    {
        $filePath = ROOTPATH . "Modules/{$this->moduleName}/Entities/{$this->modelName}Entity.php";

        // Ensure the directory exists before writing the file
        $directory = dirname($filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($filePath)) {
            CLI::error("Entity file '{$this->modelName}Entity' already exists.");
            return;
        }

        $stubPath = WRITEPATH . 'stubs/hmvc/entity.stub';
        if (!file_exists($stubPath)) {
            CLI::error('Stub file not found.');
            return;
        }

        // Load the stub and replace placeholder
        $stubContent = file_get_contents($stubPath);
        $content = str_replace('{{moduleName}}', $this->modelName, $stubContent);

        file_put_contents($filePath, $content);

        CLI::write("Entity file '{$this->modelName}Entity' created successfully!", 'green');
    }

    private function createMigrationFile()
    {
        $createAt = date('Y-m-d-His');
        $migrationFileName = "Create{$this->modelName}Table";
        $filePath = ROOTPATH . "Modules/{$this->moduleName}/Database/Migrations/{$createAt}_{$migrationFileName}.php";

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
        $migrationContent = str_replace('{{moduleName}}', $this->moduleName, $migrationContent);

        file_put_contents($filePath, $migrationContent);

        CLI::write("Migration file '{$migrationFileName}' created successfully!", 'green');
    }

    private function createSeederFile()
    {
        $seederName = "{$this->modelName}Seeder";
        $filePath = ROOTPATH . "Modules/{$this->moduleName}/Database/Seeds/{$seederName}.php";

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
        $seederContent = str_replace('{{moduleName}}', $this->moduleName, $seederContent);

        file_put_contents($filePath, $seederContent);

        CLI::write("Seeder file '{$seederName}' created successfully!", 'green');
    }
}
