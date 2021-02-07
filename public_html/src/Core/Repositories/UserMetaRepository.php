<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\AbstractModelCollection;
use OSM\Core\Collections\UserMetaCollection;
use OSM\Core\Interfaces\MetaOwnerRepositoryInterface;
use OSM\Core\Models\AbstractModel;
use OSM\Core\Models\UserMeta;


/**
 * @method UserMeta|null findOne(array $condition = [])
 * @method UserMeta saveModel(AbstractModel $model, array $properties = [])
 */
class UserMetaRepository extends AbstractModelRepository implements MetaOwnerRepositoryInterface
{
    protected function getTableName(): string
    {
        return 'user_metas';
    }

    protected function getModelClassName(): string
    {
        return UserMeta::class;
    }

    protected function getCollectionClassName(): string
    {
        return UserMetaCollection::class;
    }

    public function getMetaCollectionByIdentity(int $id): AbstractModelCollection
    {
        return $this->findAll(['user_id' => $id]);
    }

    public function updateMeta(int $id, string $metaName, string $value): ?UserMeta
    {
        $model = $this->findOne([
            'user_id' => $id,
            'key' => $metaName,
        ]);

        if (!$model) {
            return null;
        }

        $model->value = $value;
        return $this->saveModel($model);
    }

    public function addMeta(int $identity, string $metaName, string $value): UserMeta
    {
        $meta = new UserMeta();

        $meta->userId = $identity;
        $meta->key = $metaName;
        $meta->value = $value;

        return $this->saveModel($meta);
    }
}
