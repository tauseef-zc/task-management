<?php

namespace App\Enums;

enum TaskPriorityEnum: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    
    /**
     * getValues
     *
     * @return array
     */
    public static function getValues(): array
    {
        return array_map(fn($enum) => $enum->value, self::cases());
    }
    
    /**
     * getLabels
     *
     * @return array
     */
    public static function getLabels(): array
    {
        return array_map(fn($enum) => $enum->name, self::cases());
    }
}
