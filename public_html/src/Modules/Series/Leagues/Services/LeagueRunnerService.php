<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Services;

use OSM\Core\Exceptions\InvalidArgumentException;
use OSM\Core\Models\Championship;
use OSM\Core\Models\ChampionshipLeague;
use OSM\Core\Models\Match;
use OSM\Core\Repositories\ChampionshipLeagueRepository;
use OSM\Core\Repositories\ChampionshipRepository;
use OSM\Core\Repositories\MatchRepository;
use OSM\Modules\Matches\Services\MatchRunnerService;

class LeagueRunnerService
{
    private MatchRunnerService $matchRunnerService;
    private ChampionshipRepository $championshipRepository;
    private MatchRepository $matchRepository;
    private ChampionshipLeagueRepository $leagueRepository;

    public function __construct(
        MatchRunnerService $matchRunnerService,
        MatchRepository $matchRepository,
        ChampionshipRepository $championshipRepository,
        ChampionshipLeagueRepository $leagueRepository
    ) {
        $this->matchRunnerService = $matchRunnerService;
        $this->championshipRepository = $championshipRepository;
        $this->matchRepository = $matchRepository;
        $this->leagueRepository = $leagueRepository;
    }

    public function runNextRoundForAllLeagues()
    {
        $championships = $this->championshipRepository->findByType(Match::TYPE_CHAMPIONSHIP_LEAGUE);
        foreach ($championships->all() as $championship) {
            $this->runNextRoundForChampionship($championship);
        }
    }

    public function runNextRoundForChampionship(Championship $championship)
    {
        if (!$championship->isLeague()) {
            throw new InvalidArgumentException('Invalid championship type');
        }

        $leagues = $this->leagueRepository->findAllByChampionshipId($championship->id);
        foreach ($leagues->all() as $league) {
            $this->runLeagueRound($championship, $league, $championship->round);
        }
    }

    public function runLeagueRound(Championship $championship, ChampionshipLeague $league, int $round)
    {
        $matches = $this->matchRepository->findUnplayedByRoundAndType($round, $championship->type);
        foreach ($matches->all() as $match) {
        }
    }
}
