<?php

declare(strict_types=1);

namespace OSM\Core\Services;

use OSM\Core\Collections\RegistryCollection;
use OSM\Core\Models\Registry;
use OSM\Core\Repositories\RegistryRepository;

class RegistryService
{
    private RegistryRepository $repository;
    private RegistryCollection $registries;

    public function __construct(RegistryRepository $repository)
    {
        $this->repository = $repository;

        $this->registries = $this->repository->findAll();
    }

    public function getValue(string $key, $default = null): ?string
    {
        $registry = $this->getByKey($key);

        return $registry ? $registry->value : $default;
    }

    public function setValue(string $key, string $value)
    {
        if (!in_array($key, Registry::REGISTRY_KEYS)) {
            throw new \InvalidArgumentException('Bad registry key');
        }

        $registry = $this->getByKey($key);
        if (!$registry) {
            $this->createRegistry($key, $value);
            return;
        }

        $this->registries->transform(function (Registry $registry) use ($value, $key) {
            if ($registry->key === $key) {
                $registry->value = $value;

                $this->repository->saveModel($registry);
            }
        });
    }

    public function createRegistry(string $key, $value = ''): Registry
    {
        $registry = new Registry();
        $registry->key = $key;
        $registry->value = $value;

        $registry = $this->repository->saveModel($registry);
        $this->registries->add($registry);

        return $registry;
    }

    protected function getByKey(string $key): ?Registry
    {
        return $this->registries->firstWhere('key', $key);
    }
}
