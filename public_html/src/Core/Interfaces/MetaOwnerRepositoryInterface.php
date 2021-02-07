<?php

declare(strict_types=1);

namespace OSM\Core\Interfaces;

use OSM\Core\Collections\AbstractModelCollection;

interface MetaOwnerRepositoryInterface
{
    public function getMetaCollectionByIdentity(int $id): AbstractModelCollection;

    public function updateMeta(int $id, string $metaName, string $value);

    public function addMeta(int $identity, string $metaName, string $value);
}
