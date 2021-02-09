<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Services;

use OSM\Core\Models\Championship;
use OSM\Core\Repositories\ChampionshipLeagueRepository;
use OSM\Modules\Series\Leagues\Structures\LeagueCreationParameters;

class LeagueLevelCreationService
{
    private ChampionshipLeagueRepository $leagueRepository;
    private LeagueCreationService $leagueCreationService;

    public function __construct(
        ChampionshipLeagueRepository $leagueRepository,
        LeagueCreationService $leagueCreationService
    ) {
        $this->leagueRepository = $leagueRepository;
        $this->leagueCreationService = $leagueCreationService;
    }

    public function createNewLeagueLevel(Championship $championship)
    {
        if ($championship->type !== Championship::TYPE_LEAGUE) {
            throw new \InvalidArgumentException('Invalid championship type: ' . $championship->type);
        }

        $currentMaxLevel = $this->leagueRepository->getMaxLevelByChampionshipId($championship->id);
        $newLevel = $currentMaxLevel + 1;

        $params = new LeagueCreationParameters();
        $params->championshipId = $championship->id;
        $params->level = $newLevel;
        $params->addTeams = true;

        $leagueCount = $this->getLeagueCountForLevel($newLevel);
        for ($i = 0; $i !== $leagueCount; $i++) {
            $params->number = $i + 1;

            $this->leagueCreationService->createNewLeague($params);
        }
    }

    protected function getLeagueCountForLevel(int $level): int
    {
        return pow(2, $level - 1);
    }
}
