<?php

declare(strict_types=1);

namespace App\Domain\Subscription;

use App\Model\Dto\SubscriptionDto;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubscriptionRepository;
use App\Service\Translation\ExceptionMessage;
use App\Service\Translation\TranslationHelper;
use App\Exception\SubscriptionAlreadyExistsException;

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
            $exception = new SubscriptionAlreadyExistsException(
                $this->translationHelper->getTranslation(
                    new ExceptionMessage(
                        SubscriptionAlreadyExistsException::MESSAGE
                    )
                )
            );

            throw $exception;
        }

        $subscription = $this->subscriptionMapper->createSubscription($subscriptionDto);
        $this->entityManager->persist($subscription);
        $this->entityManager->flush();

        return $this->subscriptionMapper->createSubscriptionDto($subscription);
    }
}
