<?php

declare(strict_types=1);

namespace App\Model\Enum;

enum BookLevel: string
{
    case BEGINNER = 'beginner';
    case INTERMEDIATE = 'intermediate';
    case ADVANCED = 'advanced';

    /** @return array<string> */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
