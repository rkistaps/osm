<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Services;

use OSM\Core\Exceptions\InvalidArgumentException;
use OSM\Core\Models\Championship;
use OSM\Core\Models\Match;
use OSM\Core\Repositories\ChampionshipRepository;
use OSM\Core\Repositories\MatchRepository;
use OSM\Modules\Matches\Services\MatchRunnerService;

class LeagueRunnerService
{
    private MatchRunnerService $matchRunnerService;
    private ChampionshipRepository $championshipRepository;
    private MatchRepository $matchRepository;

    public function __construct(
        MatchRunnerService $matchRunnerService,
        MatchRepository $matchRepository,
        ChampionshipRepository $championshipRepository
    ) {
        $this->matchRunnerService = $matchRunnerService;
        $this->championshipRepository = $championshipRepository;
        $this->matchRepository = $matchRepository;
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

        $this->runLeagueRound($championship, $championship->round);
    }

    public function runLeagueRound(Championship $championship, int $round)
    {
        if (!$championship->isLeague()) {
            throw new InvalidArgumentException('Invalid championship type');
        }

        $matches = $this->matchRepository->findUnplayedByRoundAndType($round, $championship->type);

        foreach ($matches->all() as $match) {
        }
    }
}
