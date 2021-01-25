<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use Opis\Database\Database;
use samdark\hydrator\Hydrator;

abstract class AbstractModelRepository
{
    private Database $database;
    private Hydrator $hydrator;

    public function __construct(
        Database $database,
        Hydrator $hydrator
    ) {
        $this->database = $database;
        $this->hydrator = $hydrator;
    }

    abstract protected function getCollectionClassName(): string;
    abstract protected function getModelClassName(): string;
}
