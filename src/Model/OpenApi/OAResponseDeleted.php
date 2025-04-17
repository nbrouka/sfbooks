<?php

declare(strict_types=1);

namespace App\Model\OpenApi;

use Symfony\Component\HttpFoundation\Response;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class OAResponseDeleted extends OAResponse
{
    public function __construct()
    {
        parent::__construct(
            description: 'Item has been deleted',
            response: Response::HTTP_NO_CONTENT,
        );
    }
}
