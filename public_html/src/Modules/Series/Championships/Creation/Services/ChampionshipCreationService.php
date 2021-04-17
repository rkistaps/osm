<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Championships\Creation\Services;

use OSM\Core\Models\Championship;
use OSM\Core\Repositories\ChampionshipRepository;

class ChampionshipCreationService
{
    private ChampionshipRepository $repository;

    public function __construct(
        ChampionshipRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function createChampionship(string $name, string $type): Championship
    {
        $championship = new Championship();
        $championship->name = $name;
        $championship->type = $type;

        return $this->repository->saveModel($championship);
    }
}
