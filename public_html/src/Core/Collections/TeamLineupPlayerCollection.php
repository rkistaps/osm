<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\Player;
use OSM\Core\Models\TeamLineupPlayer;


/**
 * @method TeamLineupPlayerCollection filter(callable $callback = null)
 */
class TeamLineupPlayerCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return TeamLineupPlayer::class;
    }

    public function containsPlayer(Player $player): bool
    {
        return !!$this->first(fn(TeamLineupPlayer $lineupPlayer) => $lineupPlayer->playerId === $player->id);
    }

    public function getPlayerIds(): array
    {
        return $this->map(fn(TeamLineupPlayer $lineupPlayer) => $lineupPlayer->playerId)->all();
    }
}
