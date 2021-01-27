<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\UserCollection;
use OSM\Core\Models\User;

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
}
