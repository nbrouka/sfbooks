<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Exception\InstanceUnsupportedException as AppInstanceUnsupportedException;
use App\Exception\UserNotFoundException as AppUserNotFoundException;
use App\Repository\UserRepository;
use App\Service\Translation\ExceptionMessage;
use App\Service\Translation\TranslationHelper;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\PayloadAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class JwtUserProvider implements PayloadAwareUserProviderInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TranslationHelper $translationHelper,
    ) {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->getUser('email', $identifier);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function loadUserByIdentifierAndPayload(string $identifier, array $payload): UserInterface
    {
        return $this->getUser('id', $payload['id']);
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            $exception = new UnsupportedUserException(
                $this->translationHelper->getTranslation(
                    new ExceptionMessage(
                        AppInstanceUnsupportedException::MESSAGE,
                        ['class' => $user::class]
                    )
                )
            );

            throw $exception;
        }

        return $this->getUser('id', $user->getId());
    }

    private function getUser(string $key, mixed $value): UserInterface
    {
        $user = $this->userRepository->findOneBy([$key => $value]);

        if (null === $user) {
            $exception = new UserNotFoundException(
                $this->translationHelper->getTranslation(
                    new ExceptionMessage(
                        AppUserNotFoundException::MESSAGE,
                        ['id' => json_encode($value, JSON_THROW_ON_ERROR)]
                    )
                )
            );
            $exception->setUserIdentifier(json_encode($value, JSON_THROW_ON_ERROR));

            throw $exception;
        }

        return $user;
    }
}
