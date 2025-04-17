<?php

declare(strict_types=1);

namespace App\Model\OpenApi;

use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::TARGET_PARAMETER)]
final class OARequest extends RequestBody
{
    /** @param string|array<mixed> $model */
    public function __construct(
        string|array $model,
        ?string $description = null,
    ) {
        if (is_string($model)) {
            parent::__construct(
                description: $description,
                content: new JsonContent(
                    ref: new Model(
                        type: $model
                    )
                )
            );
        }

        if (is_iterable($model)) {
            parent::__construct(
                description: $description,
                content: new JsonContent(
                    type: 'array',
                    items: new Items(
                        ref: new Model(
                            type: $model[(int) array_key_first($model)]
                        )
                    )
                ),
            );
        }
    }
}
