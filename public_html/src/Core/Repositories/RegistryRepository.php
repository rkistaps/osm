<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\RegistryCollection;
use OSM\Core\Models\AbstractModel;
use OSM\Core\Models\Registry;

/**
 * @method RegistryCollection findAll(array $condition = [])
 * @method Registry saveModel(AbstractModel $model, array $properties = [])
 */
class RegistryRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'registry';
    }

    protected function getModelClassName(): string
    {
        return Registry::class;
    }

    protected function getCollectionClassName(): string
    {
        return RegistryCollection::class;
    }
}
