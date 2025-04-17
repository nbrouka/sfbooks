<?php

declare(strict_types=1);

namespace App\Domain\Subscription;

use App\Model\Dto\SubscriptionDto;

final class SubscriptionFacade
{
    public function __construct(
        private SubscriptionManager $manager,
    ) {
    }

    public function create(SubscriptionDto $subscriptionDto): SubscriptionDto
    {
        return $this->manager->create($subscriptionDto);
    }
}
