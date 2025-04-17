<?php

declare(strict_types=1);

namespace App\Domain\Subscription;

use App\Exception\SubscriptionAlreadyExistsException;
use App\Model\Dto\SubscriptionDto;
use App\Model\TranslationHelper;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;

class SubscriptionManager
{
    public function __construct(
        private SubscriptionRepository $subscriptionRepository,
        private EntityManagerInterface $entityManager,
        private SubscriptionMapper $subscriptionMapper,
        private TranslationHelper $translationHelper,
    ) {
    }

    public function create(SubscriptionDto $subscriptionDto): SubscriptionDto
    {
        if ($this->subscriptionRepository->existsByEmail($subscriptionDto->getEmail())) {
            throw new SubscriptionAlreadyExistsException(
                $this->translationHelper->getSubscriptionAlreadyExistsMessage()
            );
        }

        $subscription = $this->subscriptionMapper->createSubscription($subscriptionDto);
        $this->entityManager->persist($subscription);
        $this->entityManager->flush();

        return $this->subscriptionMapper->createSubscriptionDto($subscription);
    }
}
