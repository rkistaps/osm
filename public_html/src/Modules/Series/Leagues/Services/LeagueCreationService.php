<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Services;

use OSM\Core\Collections\TeamCollection;
use OSM\Core\Helpers\StringHelper;
use OSM\Core\Models\ChampionshipLeague;
use OSM\Core\Repositories\ChampionshipLeagueRepository;
use OSM\Core\Repositories\TeamRepository;
use OSM\Modules\Bots\Creation\Services\BotCreationService;
use OSM\Modules\Series\Leagues\Structures\LeagueCreationParameters;

class LeagueCreationService
{
    private ChampionshipLeagueRepository $leagueRepository;
    private TeamRepository $teamRepository;
    private BotCreationService $botCreationService;

    public function __construct(
        ChampionshipLeagueRepository $leagueRepository,
        TeamRepository $teamRepository,
        BotCreationService $botCreationService
    ) {
        $this->leagueRepository = $leagueRepository;
        $this->teamRepository = $teamRepository;
        $this->botCreationService = $botCreationService;
    }

    public function createNewLeague(LeagueCreationParameters $params): ChampionshipLeague
    {
        $name = $params->name ?? $this->createLeagueName($params->level, $params->number);

        $league = new ChampionshipLeague();
        $league->championshipId = $params->championshipId;
        $league->name = $name;
        $league->level = $params->level;
        $league->hardness = 0;

        $league = $this->leagueRepository->saveModel($league);

        if ($params->addTeams) {
            $this->addTeamsToLeague($league);
        }

        return $league;
    }

    public function addTeamsToLeague(ChampionshipLeague $league)
    {
        $teams = $this->teamRepository->findTeamsWithoutChampionship();

        $missingTeamCount = 10 - $teams->count();
        if ($missingTeamCount) {
            $teams = $teams->merge($this->createBotTeams($missingTeamCount));
        }

        foreach ($teams->all() as $team) {
            $team->championshipId = $league->championshipId;
            $this->teamRepository->saveModel($team, ['championshipId']);
        }
    }

    public function createBotTeams(int $count): TeamCollection
    {
        $collection = new TeamCollection();

        for ($i = 0; $i != $count; $i++) {
            $result = $this->botCreationService->addBot();
            $collection->add($result->team);
        }

        return $collection;
    }

    public function createLeagueName(int $level, int $number): string
    {
        return StringHelper::getRomanNumerals($level) . '.' . $number;
    }
}
