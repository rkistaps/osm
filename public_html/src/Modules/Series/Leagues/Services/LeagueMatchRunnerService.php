<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Services;

use OSM\Core\Factories\GenericFactory;
use OSM\Core\Models\Match;
use OSM\Modules\MatchEngine\MatchEngine;
use OSM\Modules\Matches\Factories\MatchParameterFactory;
use OSM\Modules\Matches\Services\MatchRunnerService;

class LeagueMatchRunnerService
{
    private MatchRunnerService $matchRunnerService;
    private MatchParameterFactory $matchParameterFactory;
    private GenericFactory $genericFactory;

    public function __construct(
        MatchParameterFactory $matchParameterFactory,
        GenericFactory $genericFactory,
        MatchRunnerService $matchRunnerService
    ) {
        $this->matchRunnerService = $matchRunnerService;
        $this->matchParameterFactory = $matchParameterFactory;
        $this->genericFactory = $genericFactory;
    }

    public function runLeagueMatch(Match $match)
    {
        $parameters = $this->matchParameterFactory->buildForMatch($match);
        $engine = $this->genericFactory->get(MatchEngine::class);

        $this->matchRunnerService->runMatch($engine, $match, $parameters);
    }
}
