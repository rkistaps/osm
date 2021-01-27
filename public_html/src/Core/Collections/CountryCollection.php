<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\CountryModel;

class CountryCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return CountryModel::class;
    }
}
