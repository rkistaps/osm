<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Matches\Friendlies;

use OSM\Modules\Series\Friendlies\Services\FriendlyRunnerService;
use TheApp\Interfaces\CommandHandlerInterface;

class FriendlyRunRoundHandler implements CommandHandlerInterface
{
    private FriendlyRunnerService $friendlyRunnerService;

    public function __construct(
        FriendlyRunnerService $friendlyRunnerService
    ) {
        $this->friendlyRunnerService = $friendlyRunnerService;
    }

    public function handle(array $params = [])
    {
        $round = (int)($params['round'] ?? null);

        if ($round) {
            $this->friendlyRunnerService->runRound($round);
        } else {
            $this->friendlyRunnerService->runNextRound();
        }
    }
}
