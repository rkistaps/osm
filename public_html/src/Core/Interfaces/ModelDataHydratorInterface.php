<?php

declare(strict_types=1);

namespace OSM\Core\Interfaces;

use OSM\Core\Models\AbstractModel;

interface ModelDataHydratorInterface
{
    /**
     * Hydrate model with data from array
     * @param AbstractModel $model
     * @param array $data
     * @return AbstractModel
     */
    public function hydrate(AbstractModel $model, array $data): AbstractModel;

    /**
     * Extract data from model to array
     * @param AbstractModel $model
     * @return array
     */
    public function extract(AbstractModel $model): array;
}
