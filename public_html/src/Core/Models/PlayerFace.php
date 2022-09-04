<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class PlayerFace extends AbstractModel
{
    public int $playerId;
    public int $skinTone;
    public int $facialHairType;
    public int $hairType;
    public int $hairColor;
    public int $eyeType;
    public int $eyeColor;
    public int $mouthType;
    public int $mouthColor;
    public int $shirtColor;

    public function getHash(): string
    {
        $parts = [];
        $parts[] = $this->skinTone;
        $parts[] = $this->facialHairType;
        $parts[] = $this->hairType;
        $parts[] = $this->hairColor;
        $parts[] = $this->eyeType;
        $parts[] = $this->eyeColor;
        $parts[] = $this->mouthType;
        $parts[] = $this->shirtColor;

        return md5(implode("|", $parts));
    }
}
