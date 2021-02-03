<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\PlayerNameCollection;
use OSM\Core\Models\PlayerName;

/**
 * @method PlayerNameCollection findAll(array $condition = [])
 */
class PlayerNameRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'player_names';
    }

    protected function getModelClassName(): string
    {
        return PlayerName::class;
    }

    protected function getCollectionClassName(): string
    {
        return PlayerNameCollection::class;
    }

    public function findForCountryId(int $countryId): PlayerNameCollection
    {
        return $this->findAll(['country_id' => $countryId]);
    }
}
