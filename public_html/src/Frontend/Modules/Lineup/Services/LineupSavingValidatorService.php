<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup\Services;

use OSM\Core\Collections\PlayerCollection;
use OSM\Core\Factories\GenericFactory;
use OSM\Core\Helpers\NumberHelper;
use OSM\Core\Models\Player;
use OSM\Core\Models\TeamLineup;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Core\Translations\Structures\Domains;
use OSM\Frontend\Modules\Lineup\Exceptions\LineupValidationException;
use OSM\Modules\MatchEngine\Services\LineupValidatorService;

class LineupSavingValidatorService
{
    private PlayerRepository $playerRepository;

    public function __construct(GenericFactory $factory)
    {
        $this->playerRepository = $factory->get(PlayerRepository::class);
    }

    /**
     * @throws LineupValidationException
     */
    public function validate(array $playerIds, TeamLineup $lineup): PlayerCollection
    {
        if (!$playerIds) {
            throw new LineupValidationException(_d(Domains::DOMAIN_FRONTEND, 'Too few players selected'));
        }

        $players = $this->playerRepository->findByIdsAndTeam($playerIds, $lineup->teamId);

        if ($players->count() < LineupValidatorService::MIN_REQUIRED_PLAYERS) {
            throw new LineupValidationException(_d(Domains::DOMAIN_FRONTEND, 'Too few players selected'));
        }

        if ($players->count() > LineupValidatorService::MAX_PLAYER_COUNT) {
            throw new LineupValidationException(_d(Domains::DOMAIN_FRONTEND, 'Too many players selected'));
        }

        $goalkeeperCount = $players->getByPosition(Player::POSITION_G)->count();
        if ($goalkeeperCount !== 1) {
            throw new LineupValidationException(_d(Domains::DOMAIN_FRONTEND, 'Incorrect number of goalkeepers'));
        }

        $defenderCount = $players->getByPosition(Player::POSITION_D)->count();
        if (NumberHelper::isNotBetween($defenderCount, LineupValidatorService::MIN_DEFENDERS, LineupValidatorService::MAX_DEFENDERS)) {
            throw new LineupValidationException(_d(Domains::DOMAIN_FRONTEND, 'Incorrect number of defenders'));
        }

        $midfielderCount = $players->getByPosition(Player::POSITION_M)->count();
        if (NumberHelper::isNotBetween($midfielderCount, LineupValidatorService::MIN_MIDFIELDERS, LineupValidatorService::MAX_MIDFIELDERS)) {
            throw new LineupValidationException(_d(Domains::DOMAIN_FRONTEND, 'Incorrect number of midfielders'));
        }

        $forwardCount = $players->getByPosition(Player::POSITION_F)->count();
        if (NumberHelper::isNotBetween($forwardCount, LineupValidatorService::MIN_FORWARDS, LineupValidatorService::MAX_FORWARDS)) {
            throw new LineupValidationException(_d(Domains::DOMAIN_FRONTEND, 'Incorrect number of forwards'));
        }

        return $players;
    }
}