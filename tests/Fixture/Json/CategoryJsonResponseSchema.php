<?php

declare(strict_types=1);

namespace App\Tests\Fixture\Json;

class CategoryJsonResponseSchema
{
    /** @return array<string, mixed> */
    public static function getOne(): array
    {
        return [
            'type' => 'object',
            'required' => [
                'id',
                'title',
                'slug',
                'bookIds',
                'createdAt',
            ],
            'properties' => [
                'id' => ['type' => 'integer'],
                'title' => ['type' => ['string', 'null']],
                'slug' => ['type' => ['string', 'null']],
                'bookIds' => ['type' => 'array', 'items' => ['type' => 'integer']],
                'createdAt' => ['type' => ['string', 'null']],
            ],
        ];
    }

    /** @return array<string, mixed> */
    public static function getList(): array
    {
        return [
            'type' => 'object',
            'required' => [
                'data',
                'pagination',
            ],
            'properties' => [
                'data' => [
                    'type' => 'array',
                    'data' => [
                        self::getOne(),
                    ],
                ],
                'pagination' => [
                    PaginationJsonResponseSchema::get(),
                ],
            ],
        ];
    }
}
