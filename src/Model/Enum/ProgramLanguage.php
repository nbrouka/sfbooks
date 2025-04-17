<?php

declare(strict_types=1);

namespace App\Model\Enum;

enum ProgramLanguage: string
{
    case RUST = 'rust';
    case C = 'c';
    case C_PLUS_PLUS = 'c++';
    case C_SHARP = 'c#';
    case JAVA = 'java';
    case PYTHON = 'python';
    case JAVASCRIPT = 'javascript';
    case RUBY = 'ruby';
    case PHP = 'php';
    case GO = 'go';
    case SWIFT = 'swift';
    case KOTLIN = 'kotlin';

    /** @return array<string> */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
