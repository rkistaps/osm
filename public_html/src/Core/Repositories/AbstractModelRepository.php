<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use Opis\Database\Database;
use Opis\Database\ResultSet;
use OSM\Core\Collections\AbstractModelCollection;
use OSM\Core\Interfaces\ModelDataHydratorInterface;
use OSM\Core\Models\AbstractModel;

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
        $modelClassName = $this->getModelClassName();
        $collectionClassName = $this->getCollectionClassName();

        /** @var AbstractModelCollection $collection */
        $collection = new $collectionClassName;

        $rows = $this->buildSelect($condition)->fetchAssoc()->all();
        foreach ($rows as $row) {
            $model = $this->hydrator->hydrate(new $modelClassName, $row);

            $collection->add($model);
        }

        return $collection;
    }

    public function findOne(array $condition = []): ?AbstractModel
    {
        $row = $this->buildSelect($condition)->fetchAssoc()->first();
        if (!$row) {
            return null;
        }

        $modelClass = $this->getModelClassName();
        $model = new $modelClass;

        return $this->hydrator->hydrate($model, $row);
    }

    public function findById(int $id): ?AbstractModel
    {
        return $this->findOne(['id' => $id]);
    }

    protected function buildSelect(array $conditions = []): ResultSet
    {
        $query = $this
            ->database
            ->from($this->getTableName());

        foreach ($conditions as $key => $value) {
            if (is_array($value)) {
                $query->andWhere($key)->in($value);
            } else {
                $query->andWhere($key)->is($value);
            }
        }

        return $query->select();
    }
}
