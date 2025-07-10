<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Exception\InstanceUnsupportedException as AppInstanceUnsupportedException;
use App\Exception\UserNotFoundException;
use App\Service\Translation\ExceptionMessage;
use App\Service\Translation\TranslationHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly TranslationHelper $translationHelper,
    ) {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
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

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function existsByEmail(string $email): bool
    {
        return null !== $this->findOneBy(['email' => $email]);
    }

    public function getUserById(int $userId): User
    {
        $user = $this->find($userId);

        if (null === $user) {
            $exception = new UserNotFoundException(
                $this->translationHelper->getTranslation(
                    new ExceptionMessage(
                        UserNotFoundException::MESSAGE,
                        ['id' => $userId]
                    )
                )
            );

            throw $exception;
        }

        return $user;
    }

    public function grantRole(int $userId, string $role): void
    {
        /** @var User $user */
        $user = $this->getUserById($userId);
        $user->addRole($role);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
