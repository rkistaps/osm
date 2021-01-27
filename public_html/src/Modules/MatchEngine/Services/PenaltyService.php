<?php

namespace OSM\Modules\MatchEngine\Services;

use OSM\Core\Helpers\RandomHelper;
use OSM\Modules\MatchEngine\Helpers\MatchHelper;
use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\MatchEngine\Structures\MatchEvent;
use OSM\Modules\MatchEngine\Structures\MatchSettings;
use OSM\Modules\MatchEngine\Structures\Penalty;
use OSM\Modules\MatchEngine\Structures\Player;

/**
 * This service provides player penalty(yellow&red cards) functionality for Match engine
 */
class PenaltyService
{
    /**
     * @param Lineup $lineup
     * @param MatchSettings $settings
     * @return MatchEvent[]
     */
    public function processLineup(Lineup $lineup, MatchSettings $settings): array
    {
        $yellowCardEvents = $this->processYellowCards($lineup, $settings);
        $redCardEvents = $this->processRedCards($lineup, $settings);

        return array_merge($yellowCardEvents, $redCardEvents);
    }

    /**
     * @param Lineup $lineup
     * @param MatchSettings $settings
     * @return MatchEvent[]
     */
    public function processYellowCards(Lineup $lineup, MatchSettings $settings): array
    {
        $events = [];
        for ($x = $settings->yellowCardChances; $x != 0; $x--) {
            if (!RandomHelper::chance($settings->yellowCardPercentage)) {
                continue;
            }

            $minute = MatchHelper::getRandomMinute();
            $player = $this->getPlayerForPenalty($lineup, $minute);

            if (!$player) {
                continue;
            }

            $events[] = $this->giveYellowCard($player, $minute);
        }

        return $events;
    }

    /**
     * @param Player $player
     * @param int $minute
     * @return MatchEvent
     */
    public function giveYellowCard(Player $player, int $minute): MatchEvent
    {
        $currentYellowCard = $player->getYellowCard();

        $data = [
            'playerId' => $player->id,
        ];

        $eventType = MatchEvent::TYPE_YELLOW_CARD;
        if ($currentYellowCard) { // this will be second yellow
            $eventType = MatchEvent::TYPE_SECOND_YELLOW_CARD;

            $minute = rand($currentYellowCard->minute, MatchHelper::MATCH_LENGTH);

            $this->sendPlayerOff($player, $minute);
        }

        $penalty = new Penalty();
        $penalty->type = Penalty::TYPE_YELLOW_CARD;
        $penalty->minute = $minute;

        $player->penalties[] = $penalty;

        return new MatchEvent(
            $eventType,
            $minute,
            $data
        );
    }

    public function sendPlayerOff(Player $player, int $minute)
    {
        $player->performance->playedToMin = $minute;
        $player->status = Player::STATUS_SENT_OFF;
    }

    /**
     * @param Lineup $lineup
     * @param int $minute
     * @return Player
     */
    public function getPlayerForPenalty(Lineup $lineup, int $minute): Player
    {
        return collect($lineup->players)
            ->filter(function (Player $player) use ($minute) {
                // injured and sent off players cant get more penalties
                if ($player->isInjured() || $player->isSentOff()) {
                    return false;
                }

                return $player->wasOnField($minute);
            })
            ->random();
    }

    /**
     * @param Lineup $lineup
     * @param MatchSettings $settings
     * @return MatchEvent[]
     */
    public function processRedCards(Lineup $lineup, MatchSettings $settings): array
    {
        $events = [];
        for ($x = $settings->redCardChances; $x != 0; $x--) {
            if (!RandomHelper::chance($settings->redCardPercentage)) {
                continue;
            }

            $minute = MatchHelper::getRandomMinute();
            $player = $this->getPlayerForPenalty($lineup, $minute);

            if (!$player) {
                continue;
            }

            $events[] = $this->giveRedCard($player, $minute);
        }

        return $events;
    }

    /**
     * @param Player $player
     * @param int $minute
     * @return MatchEvent
     */
    public function giveRedCard(Player $player, int $minute): MatchEvent
    {
        $this->sendPlayerOff($player, $minute);

        $penalty = new Penalty();
        $penalty->type = Penalty::TYPE_RED_CARD;
        $penalty->minute = $minute;

        $player->penalties[] = $penalty;

        return new MatchEvent(
            MatchEvent::TYPE_RED_CARD,
            $minute,
            ['playerId' => $player->id]
        );
    }
}
