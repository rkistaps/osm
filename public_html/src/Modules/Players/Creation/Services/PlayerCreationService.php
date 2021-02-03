<?php

declare(strict_types=1);

namespace OSM\Modules\Players\Creation\Services;

use OSM\Core\Helpers\RandomHelper;
use OSM\Core\Models\Player;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Modules\Players\Creation\Structures\PlayerCreationParams;
use OSM\Modules\Players\Creation\Structures\PlayerFaceCreationParams;

class PlayerCreationService
{
    private PlayerRepository $playerRepository;
    private PlayerFaceCreationService $faceCreationService;
    private PlayerNameResolverService $nameResolverService;

    public function __construct(
        PlayerRepository $playerRepository,
        PlayerFaceCreationService $faceCreationService,
        PlayerNameResolverService $nameResolverService
    ) {
        $this->playerRepository = $playerRepository;
        $this->faceCreationService = $faceCreationService;
        $this->nameResolverService = $nameResolverService;
    }

    public function createPlayer(PlayerCreationParams $params): Player
    {
        $player = $this->playerRepository->createModel();
        $player->teamId = $params->team->id;
        $player->countryId = $params->country->id;

        $resolvedName = $this->nameResolverService->getForCountry($params->country);
        $player->name = $resolvedName->name;
        $player->surname = $resolvedName->surname;

        $player->age = $params->age;
        $player->skill = $params->skill;
        $player->talent = $params->talent;
        $player->character = $params->character;
        $player->speciality = $params->speciality;

        $player->position = $params->position ?? $this->getPosition();
        $player->isYouth = $params->isYouth;
        $player->energy = 100;
        $player->experience = 0;
        $player->salary = 0;

        $player = $this->playerRepository->saveModel($player);

        $faceParams = new PlayerFaceCreationParams();
        $faceParams->player = $player;
        $faceParams->canHaveFacialHair = $params->canHaveFacialHair;
        $faceParams->skinTones = array_filter(explode(',', $params->country->skinTones ?? ''));
        $faceParams->skinTones = $faceParams->skinTones ?: [1, 2, 3, 4, 5];

        $this->faceCreationService->createPlayerFace($faceParams);

        return $player;
    }

    public function getPosition(): string
    {
        return RandomHelper::getOneByChance([
            10 => Player::POSITION_G,
            30 => Player::POSITION_D,
            35 => Player::POSITION_M,
            25 => Player::POSITION_F,
        ]);
    }
}
