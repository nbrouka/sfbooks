<?php

declare(strict_types=1);

namespace App\Model\Enum;

enum BookType: string
{
    case BOOK = 'book';
    case VIDEO = 'video';
    case AUDIO = 'audio';
    case LIVE_PROJECT = 'live_project';

    public const DEFAULT = self::BOOK;

    /** @return array<string> */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
