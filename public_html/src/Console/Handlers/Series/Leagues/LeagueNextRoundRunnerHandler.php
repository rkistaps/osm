<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Series\Leagues;

use OSM\Modules\Series\Leagues\Services\LeagueRunnerService;
use Psr\Log\LoggerInterface;
use TheApp\Interfaces\CommandHandlerInterface;

class LeagueNextRoundRunnerHandler implements CommandHandlerInterface
{
    private LoggerInterface $logger;
    private LeagueRunnerService $leagueRunnerService;

    public function __construct(
        LoggerInterface $logger,
        LeagueRunnerService $leagueRunnerService
    ) {
        $this->logger = $logger;
        $this->leagueRunnerService = $leagueRunnerService;
    }

    public function handle(array $params = [])
    {
        $leagueId = (int)$params['league-id'] ?? null;
        if ($leagueId) {
            $this->logger->info("Running next round for: " . $leagueId);
            $this->leagueRunnerService->runNextLeagueRoundIdByLeagueId($leagueId);
            return;
        }

        $this->logger->info('Running next round for all leagues');
        $this->leagueRunnerService->runNextRoundForAllLeagues();
    }
}
