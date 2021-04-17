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
        $this->clearTableByLeagueId($parameters->championshipLeagueId);

        foreach ($parameters->teams->all() as $team) {
            $table = new ChampionshipTable();
            $table->championshipLeagueId = $parameters->championshipLeagueId;
            $table->teamId = $team->id;

            $this->tableRepository->saveModel($table);
        }

        if ($parameters->writeFixtures) {
            $fixtureParams = new FixtureCreationParameters();
            $fixtureParams->championshipId = $parameters->championshipLeagueId;
            $fixtureParams->teams = $parameters->teams;

            $this->fixtureCreationService->createFixtures($fixtureParams);
        }
    }

    public function clearTableByLeagueId(int $championshipId)
    {
        $this->tableRepository->deleteByChampionshipId($championshipId);
    }
}
