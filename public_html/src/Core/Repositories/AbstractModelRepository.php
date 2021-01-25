<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use Opis\Database\Database;
use Opis\Database\ResultSet;
use OSM\Core\Collections\AbstractModelCollection;
use OSM\Core\Interfaces\ModelDataHydratorInterface;

abstract class AbstractModelRepository
{
    protected Database $database;
    protected ModelDataHydratorInterface $hydrator;

    public function __construct(
        Database $database,
        ModelDataHydratorInterface $hydrator
    ) {
        $this->database = $database;
        $this->hydrator = $hydrator;
    }

    abstract protected function getTableName(): string;

    abstract protected function getModelClassName(): string;

    abstract protected function getCollectionClassName(): string;

    public function findAll(array $condition = []): AbstractModelCollection
    {
        $rows = $this->buildSelect($condition)->fetchAssoc()->all();

        $modelClassName = $this->getModelClassName();
        $collectionClassName = $this->getCollectionClassName();

        /** @var AbstractModelCollection $collection */
        $collection = new $collectionClassName;

        foreach ($rows as $row) {
            $model = $this->hydrator->hydrate(new $modelClassName, $row);

            $collection->add($model);
        }

        return $collection;
    }

    protected function buildSelect(array $conditions = []): ResultSet
    {
        $query = $this
            ->database
            ->from($this->getTableName());

        foreach ($conditions as $key => $value) {
            $query->andWhere($key)->is($value);
        }

        return $query->select();
    }
}
