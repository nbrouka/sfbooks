<?php

declare(strict_types=1);

namespace App\Model\OpenApi;

use Symfony\Component\HttpFoundation\Response;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class OAResponseCreated extends OAResponse
{
    /** @param string|array<mixed>|null $model */
    public function __construct(
        string|array|null $model = null,
        ?string $description = null,
    ) {
        parent::__construct(
            model: $model,
            description: $description ?? 'Created item',
            response: Response::HTTP_CREATED,
        );
    }
}
