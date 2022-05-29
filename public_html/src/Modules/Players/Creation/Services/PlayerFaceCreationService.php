<?php

declare(strict_types=1);

namespace OSM\Modules\Players\Creation\Services;

use OSM\Core\Helpers\RandomHelper;
use OSM\Core\Models\PlayerFace;
use OSM\Core\Repositories\PlayerFaceRepository;
use OSM\Modules\Players\Creation\Structures\PlayerFaceCreationParams;

class PlayerFaceCreationService
{
    private PlayerFaceRepository $faceRepository;

    public function __construct(
        PlayerFaceRepository $faceRepository
    ) {
        $this->faceRepository = $faceRepository;
    }

    public function createPlayerFace(PlayerFaceCreationParams $params): PlayerFace
    {
        $face = $this->faceRepository->createModel();

        $face->playerId = $params->player->id;
        $face->skinTone = (int)$params->skinTones[rand(0, count($params->skinTones) - 1)];
        $face->hairType = rand(0, 6);

        $face->hairColor = $face->skinTone > 3
            ? RandomHelper::chance(50) ? 1 : 5
            : rand(1, 6);

        if ($params->canHaveFacialHair && RandomHelper::chance(50)) {
            $face->facialHairType = rand(0, 7);
        }

        $face->shirtColor = rand(0, 10);
        $face->eyeType = rand(1, 5);
        $face->eyeColor = rand(1, 4);
        $face->mouthType = rand(1, 4);
        $face->mouthColor = rand(1, 5);

        return $this->faceRepository->saveModel($face);
    }
}
