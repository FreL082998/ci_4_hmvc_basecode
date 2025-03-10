<?php

namespace App\Enums;

/**
 * Enum DirectivesEnum
 *
 * This enum is responsible for safe type DirectivesEnum.
 */
enum DirectivesEnum: string
{
    case API_CONTROLLER = 'api_controller';
    case WEB_CONTROLLER = 'web_controller';
    case ENTITY = 'entity';
    case MODEL = 'model';
    case SERVICE = 'service';
    case VIEW = 'view';
    case ROUTE = 'route';
    case SERVICES = 'services';
    case MIGRATION = 'migration';
    case SEEDER = 'seeder';

    public function get(string $moduleName, bool $isHmvc = false): array
    {
        $prefixPath = $isHmvc ? ROOTPATH . "Modules/{$moduleName}/" : APPPATH;
        $createdAt = date('Y-m-d-His');
        return match ($this) {
            self::API_CONTROLLER => [
                'type'  => 'Controller',
                'path'  => $prefixPath . "Controllers/Api/{$moduleName}Controller.php",
                'stub'  => 'hmvc/api_controller.stub',
            ],
            self::WEB_CONTROLLER => [
                'type'  => 'Controller',
                'path'  => $prefixPath . "Controllers/Web/{$moduleName}Controller.php",
                'stub'  => 'hmvc/web_controller.stub',
            ],
            self::ENTITY => [
                'type'  => 'Entity',
                'path'  => $prefixPath . "Entities/{$moduleName}Entity.php",
                'stub'  => 'hmvc/entity.stub',
            ],
            self::MODEL => [
                'type'  => 'Model',
                'path'  => $prefixPath . "Models/{$moduleName}Model.php",
                'stub'  => 'hmvc/model.stub',
            ],
            self::SERVICE => [
                'type'  => 'Service',
                'path'  => $prefixPath . "Services/{$moduleName}Service.php",
                'stub'  => 'hmvc/service.stub',
            ],
            self::VIEW => [
                'type'  => 'View',
                'path'  => $prefixPath . "Views/index.php",
                'stub'  => 'hmvc/view.stub',
            ],
            self::ROUTE => [
                'type'  => 'Routes',
                'path'  => $prefixPath . "Config/Routes.php",
                'stub'  => 'hmvc/route.stub',
            ],
            self::SERVICES => [
                'type'  => 'Service Registry',
                'path'  => $prefixPath . "Config/Services.php",
                'stub'  => 'hmvc/services.stub',
            ],
            self::MIGRATION => [
                'type'  => 'Migration',
                'path'  => $prefixPath . "Database/Migrations/{$createdAt}_Create{$moduleName}Table.php",
                'stub'  => 'hmvc/migration.stub',
            ],
            self::SEEDER => [
                'type'  => 'Seeder',
                'path'  => $prefixPath . "Database/Seeds/{$moduleName}Seeder.php",
                'stub'  => 'hmvc/seeder.stub',
            ],
        };
    }

    public static function all(string $moduleName, bool $isHmvc = false): array
    {
        return array_map(fn($directive) => $directive->get($moduleName, $isHmvc), self::cases());
    }
}

