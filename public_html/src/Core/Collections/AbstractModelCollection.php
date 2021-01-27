<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Exceptions\InvalidArgumentException;
use OSM\Core\Models\AbstractModel;
use Tightenco\Collect\Support\Collection;

abstract class AbstractModelCollection
{
    private Collection $collection;

    public function __construct(array $data = [])
    {
        $this->collection = collect($data);
    }

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
}
