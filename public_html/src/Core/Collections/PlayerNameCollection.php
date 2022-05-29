<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\PlayerName;

class PlayerNameCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return PlayerName::class;
    }

    public function getRandomOneByType(string $type): ?PlayerName
    {
        return $this
            ->filter(fn(PlayerName $playerName) => $playerName->type === $type)
            ->random();
    }
}
