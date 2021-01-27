<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\UserCollection;
use OSM\Core\Models\User;

/**
 * @method User findOne(array $condition = [])
 * @method UserCollection findAll(array $condition = [])
 * @method User createModel(array $properties = [], bool $persistent = false)
 */
class UserRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'users';
    }

    protected function getModelClassName(): string
    {
        return User::class;
    }

    protected function getCollectionClassName(): string
    {
        return UserCollection::class;
    }

    public function findByUsername(string $username): ?User
    {
        return $this->findOne(['username' => $username]);
    }
}
