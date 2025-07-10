<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Security\UserRoles;
use App\Repository\UserRepository;
use App\Model\Dto\SignUpRequestDto;
use Doctrine\ORM\EntityManagerInterface;
use App\Exception\UserAlreadyExistsException;
use App\Service\Translation\ExceptionMessage;
use App\Service\Translation\TranslationHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;

class AuthService
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly UserRepository $userRepository,
        private readonly AuthenticationSuccessHandler $successHandler,
        private readonly TranslationHelper $translationHelper,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function signUp(SignUpRequestDto $signUpRequestDto): Response
    {
        if ($this->userRepository->existsByEmail($signUpRequestDto->getEmail())) {
            $exception = new UserAlreadyExistsException(
                $this->translationHelper->getTranslation(
                    new ExceptionMessage(
                        UserAlreadyExistsException::MESSAGE,
                        ['email' => $signUpRequestDto->getEmail()]
                    )
                )
            );

            throw $exception;
        }

        $user = (new User())
            ->setRoles([UserRoles::ROLE_USER])
            ->setEmail($signUpRequestDto->getEmail())
            ->setFirstName($signUpRequestDto->getFirstName())
            ->setLastName($signUpRequestDto->getLastName());

        $user->setPassword($this->hasher->hashPassword($user, $signUpRequestDto->getPassword()));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->successHandler->handleAuthenticationSuccess($user);
    }
}
