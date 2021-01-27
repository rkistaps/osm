<?php

namespace OSM\Modules\MatchEngine\Helpers;

use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\MatchEngine\Structures\Player;

/**
 * Class LineupHelper
 * @package OSM\Modules\MatchEngine\helpers
 */
class LineupHelper
{
    public static function getRandomPlayerInPosition(Lineup $lineup, string $position, int $minute): ?Player
    {
        $players = self::getPlayersInPosition($lineup, $minute, $position);

        return $players ? collect($players)->random() : null;
    }

    /**
     * @param Lineup $lineup
     * @param int $minute
     * @param string $position
     * @return Player[]
     */
    public static function getPlayersInPosition(Lineup $lineup, int $minute, string $position): array
    {
        return collect($lineup->players)
            ->filter(function (Player $player) use ($position, $minute) {
                if (!$player->isInPosition($position)) {
                    return false;
                }

                return $player->wasOnField($minute);
            })
            ->all();
    }

    public static function getRandomPlayerByPositions(
        Lineup $lineup,
        int $minute,
        array $positionOrder,
        int $excludeId = null
    ): ?Player {
        // loop through positions and try to find a player in exact position
        foreach ($positionOrder as $position) {
            $players = LineupHelper::getPlayersInPosition($lineup, $minute, $position);

            if ($excludeId) { // if we have someone excluded, filter him out
                $players = collect($players)
                    ->filter(function (Player $player) use ($excludeId) {
                        return $player->id !== $excludeId;
                    })
                    ->all();
            }

            if ($players) { // if we have players in position, pick one
                return collect($players)->random();
            }
        }

        return null;
    }

    public static function getByIdFromLineup(int $id, Lineup $lineup): ?Player
    {
        return collect($lineup->players)->first(function (Player $player) use ($id) {
            return $player->id == $id;
        });
    }
}
