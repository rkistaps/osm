<?php

namespace OSM\Modules\MatchEngine\Services;

use OSM\Core\Helpers\RandomHelper;
use OSM\Modules\MatchEngine\Helpers\MatchHelper;
use OSM\Modules\MatchEngine\Structures\Injury;
use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\MatchEngine\Structures\MatchEvent;
use OSM\Modules\MatchEngine\Structures\MatchSettings;
use OSM\Modules\MatchEngine\Structures\Player;

/**
 * This service provides injury processing functionality for a match
 */
class InjuryService
{
    /**
     * Process injuries for a lineup
     * @param Lineup $lineup
     * @param MatchSettings $settings
     * @return MatchEvent[]
     */
    public function processLineup(Lineup $lineup, MatchSettings $settings): array
    {
        $events = [];

        for ($x = $settings->injuryChances; $x != 0; $x--) {
            if (!RandomHelper::chance($settings->injuryPercentage)) {
                continue;
            }

            $minute = MatchHelper::getRandomMinute();
            $player = $this->getPlayerForInjury($lineup, $minute);

            if (!$player) {
                continue;
            }

            $substitute = $this->processInjuredPlayer($player, $minute, $lineup);

            $type = $substitute ? MatchEvent::TYPE_INJURY_WITH_SUB : MatchEvent::TYPE_INJURY;
            $eventData = [
                'injuredPlayerId' => $player->id,
            ];

            if ($substitute) {
                $eventData['substitutePlayerId'] = $substitute->id;
            }
            $events[] = new MatchEvent($type, $minute, $eventData);
        }

        return $events;
    }

    /**
     * @param Player $player
     * @param int $minute
     * @param Lineup $lineup
     * @return Player|null
     */
    public function processInjuredPlayer(Player $player, $minute, Lineup $lineup)
    {
        // setting up injury
        $injury = new Injury();
        $injury->minute = $minute;
        $injury->severity = $this->getRandomSeverity();
        $player->injury = $injury;

        $substitute = $this->getSubstitute($player, $lineup);
        if ($substitute) {
            $this->substitutePlayers($player, $substitute, $minute);
        }

        return $substitute;
    }

    /**
     * @return mixed|null
     */
    public function getRandomSeverity()
    {
        return RandomHelper::getOneByChance([
            30 => Injury::SEVERITY_MINIMAL,
            40 => Injury::SEVERITY_LOW,
            20 => Injury::SEVERITY_AVERAGE,
            10 => Injury::SEVERITY_HIGH,
        ]);
    }

    /**
     * @param Player $playerOff
     * @param Player $playerOn
     * @param int $minute
     */
    public function substitutePlayers(Player $playerOff, Player $playerOn, $minute)
    {
        $playerOff->performance->playedToMin = $minute;

        $playerOn->status = Player::STATUS_STARTING;
        $playerOn->performance->playedFromMin = $minute;
        $playerOn->performance->playedToMin = MatchHelper::MATCH_LENGTH;
    }

    /**
     * @param Lineup $lineup
     * @param int $minute
     * @return Player|null;
     */
    public function getPlayerForInjury(Lineup $lineup, $minute)
    {
        return collect($lineup->players)
            ->filter(function (Player $player) use ($minute) {
                // injured and sent off players cant get injury
                if ($player->isInjured() || $player->isSentOff()) {
                    return false;
                }

                return $player->wasOnField($minute);
            })
            ->random();
    }

    /**
     * @param Player $player
     * @param Lineup $lineup
     * @return Player|null
     */
    public function getSubstitute(Player $player, Lineup $lineup)
    {
        return collect($lineup->getSubstitutes())
            ->first(function (Player $sub) use ($player) {
                return $sub->position === $player->position;
            });
    }
}
