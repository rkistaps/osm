<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\Option;

/**
 * @method Option[] all()
 */
class OptionCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return Option::class;
    }
}
