<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\User;

class UserCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return User::class;
    }
}
