<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Common\Services;

use OSM\Core\Models\Match;
use OSM\Core\Repositories\MatchRepository;
use OSM\Modules\Series\Common\Structures\FixtureCreationParameters;
use ScheduleBuilder;

class FixtureCreationService
{
    private MatchRepository $matchRepository;

    public function __construct(
        MatchRepository $matchRepository
    ) {
        $this->matchRepository = $matchRepository;
    }

    public function createFixtures(FixtureCreationParameters $parameters)
    {
        $rounds = ($parameters->teams->count() - 1) * $parameters->rounds;

        $scheduleBuilder = new ScheduleBuilder($parameters->teams->getIds(), $rounds);

        foreach ($scheduleBuilder->build() as $round => $pairs) {
            foreach ($pairs as $pair) {
                $match = new Match();
                $match->homeTeamId = $pair[0];
                $match->awayTeamId = $pair[1];
                $match->seriesRound = $round;
                $match->seriesId = $parameters->championshipId;
                $match->seriesType = Match::TYPE_CHAMPIONSHIP_LEAGUE;

                $this->matchRepository->saveModel($match);
            }
        }
    }
}
