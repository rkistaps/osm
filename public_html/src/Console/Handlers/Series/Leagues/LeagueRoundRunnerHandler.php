<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Series\Leagues;

use OSM\Modules\Series\Leagues\Services\LeagueRunnerService;

class LeagueRoundRunnerHandler implements \TheApp\Interfaces\CommandHandlerInterface
{
    public function __construct(
        LeagueRunnerService $leagueRunnerService
    ) { }

    public function handle(array $params = [])
    {
        // TODO: Implement handle() method.
    }
}
