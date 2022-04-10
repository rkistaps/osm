<?php

declare(strict_types=1);

namespace Tests\Modules\MatchEngine\Helpers;

use OSM\Core\Helpers\RandomHelper;
use OSM\Core\Models\Player as PlayerModel;
use OSM\Modules\MatchEngine\Structures\Coach;
use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\MatchEngine\Structures\Player;

class MatchEngineTestDataHelper
{
    public static function getLineup($teamId): Lineup
    {
        $lineup = new Lineup();

        $lineup->teamId = $teamId;
        $lineup->coach = new Coach();

        $lineup->players[] = self::getPlayer(['position' => PlayerModel::POSITION_G]);

        $lineup->players[] = self::getPlayer(['position' => PlayerModel::POSITION_D]);
        $lineup->players[] = self::getPlayer(['position' => PlayerModel::POSITION_D]);
        $lineup->players[] = self::getPlayer(['position' => PlayerModel::POSITION_D]);
        $lineup->players[] = self::getPlayer(['position' => PlayerModel::POSITION_D]);

        $lineup->players[] = self::getPlayer(['position' => PlayerModel::POSITION_M]);
        $lineup->players[] = self::getPlayer(['position' => PlayerModel::POSITION_M]);
        $lineup->players[] = self::getPlayer(['position' => PlayerModel::POSITION_M]);
        $lineup->players[] = self::getPlayer(['position' => PlayerModel::POSITION_M]);

        $lineup->players[] = self::getPlayer(['position' => PlayerModel::POSITION_F]);
        $lineup->players[] = self::getPlayer(['position' => PlayerModel::POSITION_F]);

        return $lineup;
    }

    public static function getPlayer(array $data = [])
    {
        $player = new Player();

        $player->id = $data['id'] ?? 1;
        $player->speciality = $data['speciality'] ?? PlayerModel::SPECIALITY_NONE;
        $player->skill = $data['skill'] ?? RandomHelper::between(50, 150);
        $player->position = $data['position'] ?? Player::POS_M;
        $player->energy = $data['energy'] ?? 100;
        $player->experience = $data['experience'] ?? 0;
        $player->age = $data['age'] ?? 20;
        $player->status = Player::STATUS_STARTING;

        return $player;
    }
}
