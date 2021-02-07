<?php

declare(strict_types=1);

namespace OSM\Core\Models;

use OSM\Core\Interfaces\MetaOwnerInterface;
use OSM\Core\Interfaces\MetaOwnerRepositoryInterface;
use OSM\Core\Repositories\UserMetaRepository;

class User extends AbstractModel implements MetaOwnerInterface
{
    public string $username;
    public string $password;

    public function getMetaType(): string
    {
        return Meta::META_TYPE_USER;
    }

    public function getMetaIdentity(): int
    {
        return $this->id;
    }

    public function getAvailableMetas(): array
    {
        return UserMeta::METAS;
    }

    public function getMetaRepository(): MetaOwnerRepositoryInterface
    {
        return getContainer()->get(UserMetaRepository::class);
    }
}
