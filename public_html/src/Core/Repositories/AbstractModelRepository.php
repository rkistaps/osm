<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use Opis\Database\Database;
use Opis\Database\ResultSet;
use Opis\Database\SQL\BaseStatement;
use Opis\Database\SQL\Query;
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
        return $this->buildQuery($conditions)->select();
    }

    protected function buildQuery(array $conditions = []): Query
    {
        $query = $this
            ->database
            ->from($this->getTableName());

        $this->addConditionsToStatement($query, $conditions);

        return $query;
    }

    protected function delete(array $conditions = []): int
    {
        return $this->buildQuery($conditions)->delete();
    }

    public function deleteModel(AbstractModel $model): int
    {
        return $this->delete($this->buildPrimaryKeyCondition($model));
    }

    /**
     * @param AbstractModel $model
     * @param array $properties
     * @return bool|int
     */
    public function saveModel(AbstractModel $model, array $properties = [])
    {
        return $model->isNew()
            ? $this->insertModel($model)
            : $this->updateModel($model, $properties);
    }

    protected function updateModel(AbstractModel $model, array $properties = []): int
    {
        $modelData = $this->hydrator->extract($model);

        $query = $this
            ->database
            ->update($this->getTableName());

        $this->addConditionsToStatement(
            $query,
            $this->buildPrimaryKeyCondition($model)
        );

        $updateData = $modelData;
        if ($properties) {
            $updateData = [];
            foreach ($modelData as $key => $value) {
                if (in_array($key, $properties)) {
                    $updateData[$key] = $value;
                }
            }
        }

        return $query->set($updateData);
    }

    protected function insertModel(AbstractModel $model): bool
    {
        $data = $this->hydrator->extract($model);

        return $this->insert($data);
    }

    protected function insert(array $data): bool
    {
        return $this->database->insert($data)->into($this->getTableName());
    }

    protected function addConditionsToStatement(BaseStatement $statement, array $conditions = [])
    {
        foreach ($conditions as $key => $value) {
            if (is_array($value)) {
                $statement->andWhere($key)->in($value);
            } else {
                $statement->andWhere($key)->is($value);
            }
        }
    }

    protected function buildPrimaryKeyCondition(AbstractModel $model): array
    {
        $condition = [];
        foreach ($model->getPrimaryKey() as $column) {
            $condition[$column] = $model->$column;
        }

        return $condition;
    }
}
