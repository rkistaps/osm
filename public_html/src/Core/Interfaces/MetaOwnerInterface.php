<?php

declare(strict_types=1);

namespace OSM\Core\Interfaces;

interface MetaOwnerInterface
{
    public function getMetaType(): string;

    public function getMetaIdentity(): int;

    public function getAvailableMetas(): array;

    public function getMetaRepository(): MetaOwnerRepositoryInterface;
}
