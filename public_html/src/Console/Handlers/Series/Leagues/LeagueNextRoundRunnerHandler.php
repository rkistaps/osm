<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Series\Leagues;

use OSM\Core\Repositories\ChampionshipLeagueRepository;
use OSM\Core\Repositories\ChampionshipRepository;
use OSM\Modules\Series\Leagues\Services\LeagueRunnerService;
use Psr\Log\LoggerInterface;
use TheApp\Interfaces\CommandHandlerInterface;

class LeagueNextRoundRunnerHandler implements CommandHandlerInterface
{
    private LoggerInterface $logger;
    private LeagueRunnerService $leagueRunnerService;
    private ChampionshipRepository $championshipRepository;
    private ChampionshipLeagueRepository $leagueRepository;

    public function __construct(
        LoggerInterface $logger,
        LeagueRunnerService $leagueRunnerService,
        ChampionshipRepository $championshipRepository,
        ChampionshipLeagueRepository $leagueRepository
    ) {
        $this->logger = $logger;
        $this->leagueRunnerService = $leagueRunnerService;
        $this->championshipRepository = $championshipRepository;
        $this->leagueRepository = $leagueRepository;
    }

    public function handle(array $params = [])
    {
        $leagueId = $params['league-id'] ?? null;
        if ($leagueId) {
            $this->logger->info("Running next round for: " . $leagueId);
            $this->leagueRunnerService->runNextLeagueRoundIdByLeagueId($leagueId);
            return;
        }

        $this->logger->info('Running next round for all leagues');
        $this->leagueRunnerService->runNextRoundForAllLeagues();
    }
}
