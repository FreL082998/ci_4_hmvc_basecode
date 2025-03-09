<?php

namespace App\Enums;

/**
 * Enum LogTypeEnum
 *
 * This enum is responsible for safe type LogTypeEnum.
 */
enum LogTypeEnum: string
{
    case INFO = 'info';
    case ERROR = 'error';
}