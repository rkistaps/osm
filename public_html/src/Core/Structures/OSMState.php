<?php

declare(strict_types=1);

namespace OSM\Core\Structures;

class OSMState
{
    private int $season;

    public function getSeason(): int
    {
        return $this->season;
    }

    public function setSeason(int $season): void
    {
        $this->season = $season;
    }

    public function getCurrentDateTime(): string
    {
        return date("d.m.Y H:i:s");
    }
}
