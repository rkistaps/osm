<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Common\Services;

use OSM\Core\Models\ChampionshipTable;
use OSM\Core\Repositories\ChampionshipTableRepository;
use OSM\Modules\Series\Common\Structures\FixtureCreationParameters;
use OSM\Modules\Series\Common\Structures\TableCreationParameters;

class TableCreationService
{
    private ChampionshipTableRepository $tableRepository;
    private FixtureCreationService $fixtureCreationService;

    public function __construct(
        ChampionshipTableRepository $tableRepository,
        FixtureCreationService $fixtureCreationService
    ) {
        $this->tableRepository = $tableRepository;
        $this->fixtureCreationService = $fixtureCreationService;
    }

    public function createTable(TableCreationParameters $parameters)
    {
        $this->clearTableByChampionshipId($parameters->championshipId);

        foreach ($parameters->teams->all() as $team) {
            $table = new ChampionshipTable();
            $table->championshipId = $parameters->championshipId;
            $table->teamId = $team->id;

            $this->tableRepository->saveModel($table);
        }

        if ($parameters->writeFixtures) {
            $fixtureParams = new FixtureCreationParameters();
            $fixtureParams->championshipId = $parameters->championshipId;
            $fixtureParams->teams = $parameters->teams;

            $this->fixtureCreationService->createFixtures($fixtureParams);
        }
    }

    public function clearTableByChampionshipId(int $championshipId)
    {
        $this->tableRepository->deleteByChampionshipId($championshipId);
    }
}
