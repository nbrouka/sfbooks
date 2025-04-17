<?php

declare(strict_types=1);

namespace App\Tests\Fixture\Json;

class BookJsonResponseSchema
{
    /** @return array<string, mixed> */
    public static function getOne(): array
    {
        return [
            'type' => 'object',
            'required' => [
                'id',
                'title',
                'description',
                'type',
                'level',
                'language',
                'isbn',
                'published',
                'meap',
                'coverFileName',
                'categoryIds',
                'createdAt',
            ],
            'properties' => [
                'id' => ['type' => 'integer'],
                'title' => ['type' => ['string', 'null']],
                'description' => ['type' => ['string', 'null']],
                'type' => ['type' => ['string', 'null']],
                'level' => ['type' => ['string', 'null']],
                'language' => ['type' => ['string', 'null']],
                'isbn' => ['type' => ['string', 'null']],
                'published' => ['type' => ['string', 'null']],
                'meap' => ['type' => ['boolean', 'null']],
                'coverFileName' => ['type' => ['string', 'null']],
                'categoryIds' => ['type' => 'array', 'items' => ['type' => 'integer']],
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
