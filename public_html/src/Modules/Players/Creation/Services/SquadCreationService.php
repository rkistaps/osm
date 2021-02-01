<?php

declare(strict_types=1);

namespace OSM\Modules\Players\Creation\Services;

use OSM\Core\Collections\PlayerCollection;
use OSM\Core\Models\Player;
use OSM\Core\Repositories\CountryRepository;
use OSM\Modules\Players\Creation\Factories\PlayerCreationParamFactory;
use OSM\Modules\Players\Creation\Structures\SquadCreationParams;

class SquadCreationService
{
    private PlayerCreationParamFactory $creationParamFactory;
    private PlayerCreationService $playerCreationService;
    private CountryRepository $countryRepository;

    public function __construct(
        PlayerCreationParamFactory $creationParamFactory,
        PlayerCreationService $playerCreationService,
        CountryRepository $countryRepository
    ) {
        $this->creationParamFactory = $creationParamFactory;
        $this->playerCreationService = $playerCreationService;
        $this->countryRepository = $countryRepository;
    }

    public function generate(SquadCreationParams $params): PlayerCollection
    {
        $players = new PlayerCollection();

        $country = $this->countryRepository->findById($params->team->countryId);

        // generate goalkeepers
        for ($i = $params->goalkeeperCount; $i > 0; $i--) {
            $playerParams = $this->creationParamFactory->forStartingPlayer($params->team, $country);
            $playerParams->position = Player::POSITION_G;
            $player = $this->playerCreationService->createPlayer($playerParams);

            $players->add($player);
        }

        // generate defenders
        for ($i = $params->defenderCount; $i > 0; $i--) {
            $playerParams = $this->creationParamFactory->forStartingPlayer($params->team, $country);
            $playerParams->position = Player::POSITION_D;
            $player = $this->playerCreationService->createPlayer($playerParams);

            $players->add($player);
        }

        // generate midfielders
        for ($i = $params->midfielderCount; $i > 0; $i--) {
            $playerParams = $this->creationParamFactory->forStartingPlayer($params->team, $country);
            $playerParams->position = Player::POSITION_M;
            $player = $this->playerCreationService->createPlayer($playerParams);

            $players->add($player);
        }

        // generate forwards
        for ($i = $params->forwardCount; $i > 0; $i--) {
            $playerParams = $this->creationParamFactory->forStartingPlayer($params->team, $country);
            $playerParams->position = Player::POSITION_F;
            $player = $this->playerCreationService->createPlayer($playerParams);

            $players->add($player);
        }
        
        return $players;
    }
}
