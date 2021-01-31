<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Abstracts\AbstractCollection;
use OSM\Core\Exceptions\InvalidArgumentException;
use OSM\Core\Models\AbstractModel;

abstract class AbstractModelCollection extends AbstractCollection
{
    /**
     * @param array $data
     * @return self
     */
    public static function collect(array $data = [])
    {
        $calledClass = get_called_class();

        return $calledClass($data);
    }

    abstract public function getModelClassName(): string;

    public function all(): array
    {
        return $this->collection->all();
    }

    public function add(AbstractModel $item): AbstractModelCollection
    {
        if (!is_a($item, $this->getModelClassName())) {
            throw new InvalidArgumentException(get_class($item) . ' is not ' . $this->getModelClassName());
        }

        $this->collection->add($item);

        return $this;
    }

    public function firstWhere(string $key, $operator = null, $value = null): ?AbstractModel
    {
        return parent::firstWhere($key, $operator, $value);
    }
}
