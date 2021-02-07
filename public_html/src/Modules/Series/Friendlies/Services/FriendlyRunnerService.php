<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Friendlies\Services;

use OSM\Core\Models\Match;
use OSM\Core\Repositories\MatchRepository;
use OSM\Modules\Matches\Factories\MatchParameterFactory;
use OSM\Modules\Matches\Services\MatchRunnerService;

class FriendlyRunnerService
{
    private MatchRunnerService $matchRunnerService;
    private MatchRepository $matchRepository;
    private MatchParameterFactory $matchParameterFactory;

    public function __construct(
        MatchRunnerService $matchRunnerService,
        MatchRepository $matchRepository,
        MatchParameterFactory $matchParameterFactory
    ) {
        $this->matchRunnerService = $matchRunnerService;
        $this->matchRepository = $matchRepository;
        $this->matchParameterFactory = $matchParameterFactory;
    }

    public function runNextRound()
    {
        // todo pick round from registry
        $this->runRound(1);
        // todo update round to registry
    }

    public function runRound(int $round)
    {
        $matches = $this
            ->matchRepository
            ->findMatchesForSeries(Match::TYPE_FRIENDLY, $round)
            ->filter(fn(Match $match) => !$match->isPlayed);

        foreach ($matches->all() as $match) {
            $this->runFriendlyMatch($match);
        }
    }

    public function runFriendlyMatch(Match $match)
    {
        $parameters = $this->matchParameterFactory->buildForFriendlies();
        $result = $this->matchRunnerService->runMatch($match, $parameters);
    }
}
