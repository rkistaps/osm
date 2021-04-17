<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class Championship extends AbstractModel
{
    public string $name;
    public string $type;
    public int $round = 1;

    public function isLeague(): bool
    {
        return $this->type === Match::TYPE_CHAMPIONSHIP_LEAGUE;
    }
}
