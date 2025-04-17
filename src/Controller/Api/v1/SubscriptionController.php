<?php

declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Domain\Subscription\SubscriptionFacade;
use App\Model\Dto\SubscriptionDto;
use App\Model\OpenApi\OARequest;
use App\Model\OpenApi\OAResponseCreated;
use App\Model\OpenApi\OAResponseValidation;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/v1/subscription', name: 'subscription')]
#[OA\Tag('Subscription')]
final class SubscriptionController extends ApiController
{
    public function __construct(
        private SubscriptionFacade $subscriptionFacade,
    ) {
    }

    #[Route('', name: 'create', methods: [Request::METHOD_POST])]
    #[OARequest(SubscriptionDto::class), OAResponseCreated(SubscriptionDto::class), OAResponseValidation]
    public function create(#[MapRequestPayload] SubscriptionDto $subscription): JsonResponse
    {
        return $this->createdResponse(
            $this->subscriptionFacade->create($subscription)
        );
    }
}
