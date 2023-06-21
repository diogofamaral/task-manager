<?php

namespace App\Enum;

enum TaskPriority: string
{
    use EnumToArray;

    case HIGH = 'high';
    case MODERATE = 'moderate';
    case LOW = 'low';
}
