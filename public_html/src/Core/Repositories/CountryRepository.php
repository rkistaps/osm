<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\CountryCollection;
use OSM\Core\Collections\PlayerCollection;
use OSM\Core\Models\Country;
use OSM\Core\Models\Player;

/**
 * @method Country findOne(array $condition = [])
 * @method CountryCollection findAll(array $condition = [])
 * @method Country findById(int $id)
 */
class CountryRepository extends AbstractModelRepository
{
    public function getCollectionClassName(): string
    {
        return CountryCollection::class;
    }

    protected function getModelClassName(): string
    {
        return Country::class;
    }

    protected function getTableName(): string
    {
        return 'countries';
    }

    public function findByName(string $name): ?Country
    {
        return $this->findOne(['name' => $name]);
    }

    public function findForPlayers(PlayerCollection $playerCollection): CountryCollection
    {
        $countryIds = $playerCollection->getCountryIds();

        if (empty($countryIds)) {
            return new CountryCollection();
        }

        return $this->findAll(['id' => $countryIds]);
    }

    public function findForPlayer(Player $player): ?Country
    {
        return $this->findById($player->countryId);
    }
}
