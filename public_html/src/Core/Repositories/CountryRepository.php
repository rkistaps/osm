<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\CountryCollection;
use OSM\Core\Models\CountryModel;

class CountryRepository extends AbstractModelRepository
{
    public function getCollectionClassName(): string
    {
        return CountryCollection::class;
    }

    protected function getModelClassName(): string
    {
        return CountryModel::class;
    }

    protected function getTableName(): string
    {
        return 'countries';
    }
}
