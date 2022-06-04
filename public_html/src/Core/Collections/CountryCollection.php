<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\Country;
use OSM\Core\Models\Player;

/**
 * @method Country|null getById(int $id)
 */
class CountryCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return Country::class;
    }

    public function getForPlayer(Player $player): ?Country
    {
        return $this->getById($player->countryId);
    }
}
