<?php

declare(strict_types=1);

namespace OSM\Modules\User\Services;

use OSM\Core\Models\User;
use OSM\Core\Repositories\UserRepository;
use OSM\Modules\User\Exceptions\UserCreationException;

class UserCreationService
{
    private const PASSWORD_HASH_COST = 12;

    private UserRepository $repository;

    public function __construct(
        UserRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function create(string $username, string $password): User
    {
        $existingUser = $this->repository->findByUsername($username);
        if ($existingUser) {
            throw new UserCreationException('Username already taken');
        }

        return $this->repository->createModel([
            'username' => $username,
            'password' => $this->hashPassword($password),
        ], true);
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => self::PASSWORD_HASH_COST]);
    }
}
