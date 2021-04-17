<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Series\Leagues;

use OSM\Modules\Series\Leagues\Services\LeagueRunnerService;
use Psr\Log\LoggerInterface;

class LeagueRoundRunnerHandler implements \TheApp\Interfaces\CommandHandlerInterface
{
    private LeagueRunnerService $leagueRunnerService;
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger,
        LeagueRunnerService $leagueRunnerService
    ) {
        $this->leagueRunnerService = $leagueRunnerService;
        $this->logger = $logger;
    }

    public function handle(array $params = [])
    {
        $round = (int)($params['round'] ?? 0);
        if (!$round) {
            $this->logger->error('Invalid round');
            return;
        }

        $leagueId = (int)($params['league-id'] ?? null);
        if (!$leagueId) {
            $this->logger->error('Invalid league');
            return;
        }

        $this->leagueRunnerService->runLeagueRoundIdByLeagueId($leagueId, $round);
    }
}
