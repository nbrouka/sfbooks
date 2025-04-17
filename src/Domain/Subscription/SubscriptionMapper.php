<?php

declare(strict_types=1);

namespace App\Domain\Subscription;

use App\Entity\Subscription;
use App\Model\Dto\SubscriptionDto;

class SubscriptionMapper
{
    public function createSubscription(SubscriptionDto $subscriptionDto): Subscription
    {
        return (new Subscription())
            ->setId($subscriptionDto->getId())
            ->setEmail($subscriptionDto->getEmail())
            ->setCreatedAt($subscriptionDto->getCreatedAt());
    }

    public function createSubscriptionDto(Subscription $subscription): SubscriptionDto
    {
        return new SubscriptionDto(
            $subscription->getId(),
            $subscription->getEmail(),
            true,
            $subscription->getCreatedAt()
        );
    }
}
