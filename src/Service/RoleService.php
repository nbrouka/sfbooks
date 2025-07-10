<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\UserRepository;
use App\Security\UserRoles;

class RoleService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function grantAdmin(int $userId): void
    {
        $this->grantRole($userId, UserRoles::ROLE_ADMIN);
    }

    public function grantAuthor(int $userId): void
    {
        $this->grantRole($userId, UserRoles::ROLE_AUTHOR);
    }

    private function grantRole(int $userId, string $role): void
    {
        $this->userRepository->grantRole($userId, $role);
    }
}
