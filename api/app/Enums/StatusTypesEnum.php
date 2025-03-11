<?php

namespace App\Enums;

/**
 * Enum StatusTypesEnum
 *
 * This enum is responsible for safe type StatusTypesEnum.
 */
enum StatusTypesEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}