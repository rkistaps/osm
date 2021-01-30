<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\OptionCollection;
use OSM\Core\Models\Option;

/**
 * @method OptionCollection findAll(array $condition = [])
 */
class OptionRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'options';
    }

    protected function getModelClassName(): string
    {
        return Option::class;
    }

    protected function getCollectionClassName(): string
    {
        return OptionCollection::class;
    }
}
