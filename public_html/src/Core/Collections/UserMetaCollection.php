<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\UserMeta;

class UserMetaCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return UserMeta::class;
    }
}
