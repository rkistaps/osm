<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

abstract class AbstractModelCollection
{
    abstract public function getModelClassName(): string;
}
