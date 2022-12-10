<?php

declare(strict_types=1);

namespace OSM\Modules\Players\Structures;

class PlayerFaceImage
{
    public string $imageUrl;

    public function __construct(string $imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }
}
