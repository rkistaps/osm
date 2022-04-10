<?php

declare(strict_types=1);

namespace OSM\Core\Services;

use Exception;
use OSM\Core\Collections\AbstractModelCollection;
use OSM\Core\Components\ArrayCache;
use OSM\Core\Factories\ArrayCacheFactory;
use OSM\Core\Interfaces\MetaOwnerInterface;
use OSM\Core\Models\Meta;

class MetaService
{
    private ArrayCache $cache;

    public function __construct(
        ArrayCacheFactory $arrayCacheFactory
    ) {
        $this->cache = $arrayCacheFactory->getForClass(self::class);
    }

    public function getMetaValue(MetaOwnerInterface $metaOwner, string $metaKey, $default = null)
    {
        /** @var Meta $meta */
        $meta = $this->getMetas($metaOwner)
            ->first(function (Meta $model) use ($metaKey) {
                return $model->key === $metaKey;
            });

        return $meta ? $meta->value : $default;
    }

    public function setMetaValue(
        MetaOwnerInterface $metaOwner,
        string $metaKey,
        string $value
    ) {
        if (!in_array($metaKey, $metaOwner->getAvailableMetas())) {
            throw new Exception('Unregistered meta: ' . $metaKey);
        }

        $metas = $this->getMetas($metaOwner);

        $meta = $this->getMetaByKey($metaOwner, $metaKey);
        if (!$meta) {
            $meta = $metaOwner->getMetaRepository()->addMeta(
                $metaOwner->getMetaIdentity(),
                $metaKey,
                $value
            );

            $metas->add($meta);

            $this->setMetas($metaOwner, $metas);
            return;
        }

        $this->getMetas($metaOwner)->transform(function (Meta $meta) use ($metaKey, $value, $metaOwner) {
            if ($meta->key === $metaKey) {
                $meta->value = $value;

                $metaOwner->getMetaRepository()->updateMeta(
                    $metaOwner->getMetaIdentity(),
                    $metaKey,
                    $value
                );
            }
        });
    }

    protected function getMetaByKey(MetaOwnerInterface $owner, string $key): ?Meta
    {
        return $this->getMetas($owner)->first(function (Meta $meta) use ($key) {
            return $meta->key === $key;
        });
    }

    protected function setMetas(MetaOwnerInterface $metaOwner, AbstractModelCollection $collection)
    {
        $key = $this->getCacheKey($metaOwner);

        $this->cache->set($key, $collection);
    }

    protected function getMetas(MetaOwnerInterface $metaOwner): AbstractModelCollection
    {
        $key = $this->getCacheKey($metaOwner);

        return $this->cache->getOrSet($key, function () use ($metaOwner) {
            return $metaOwner->getMetaRepository()->getMetaCollectionByIdentity($metaOwner->getMetaIdentity());
        });
    }

    protected function getCacheKey(MetaOwnerInterface $metaOwner): string
    {
        return $metaOwner->getMetaType() . ':' . $metaOwner->getMetaIdentity();
    }
}
