<?php

declare(strict_types=1);

namespace App\Tests\Fixture\Json;

class PaginationJsonResponseSchema
{
    /** @return array<string, mixed> */
    public static function get(): array
    {
        return [
            'type' => 'object',
            'required' => [
                'total',
                'count',
                'offset',
                'items_per_page',
                'total_pages',
                'current_page',
                'has_next_page',
                'has_previous_page',
            ],
            'properties' => [
                'total' => ['type' => 'integer'],
                'count' => ['type' => 'integer'],
                'offset' => ['type' => 'integer'],
                'items_per_page' => ['type' => 'integer'],
                'total_pages' => ['type' => 'integer'],
                'current_page' => ['type' => 'integer'],
                'has_next_page' => ['type' => 'boolean'],
                'has_previous_page' => ['type' => 'boolean'],
            ],
        ];
    }
}
