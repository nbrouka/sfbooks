<?php

declare(strict_types=1);

namespace App\Model\OpenApi;

use OpenApi\Attributes\Parameter;

#[
    \Attribute(\Attribute::TARGET_CLASS |
    \Attribute::TARGET_METHOD |
    \Attribute::TARGET_PROPERTY |
     \Attribute::IS_REPEATABLE)
]
final class OAParameterQuery extends Parameter
{
    public function __construct(
        ?string $name = null,
        ?string $description = null,
    ) {
        parent::__construct(
            name: $name,
            description: $description ?? 'param',
            in: 'query',
        );
    }
}
