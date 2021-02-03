<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\PlayerFace;

class PlayerFaceCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return PlayerFace::class;
    }
}
