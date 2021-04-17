<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Series\Leagues;

use OSM\Core\Repositories\ChampionshipLeagueRepository;
use OSM\Core\Repositories\ChampionshipRepository;
use OSM\Modules\Series\Leagues\Services\LeagueRunnerService;
use Psr\Log\LoggerInterface;

class LeagueRoundRunnerHandler implements \TheApp\Interfaces\CommandHandlerInterface
{
    private LeagueRunnerService $leagueRunnerService;
    private ChampionshipLeagueRepository $leagueRepository;
    private ChampionshipRepository $championshipRepository;
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger,
        LeagueRunnerService $leagueRunnerService,
        ChampionshipLeagueRepository $leagueRepository,
        ChampionshipRepository $championshipRepository
    ) {
        $this->leagueRunnerService = $leagueRunnerService;
        $this->leagueRepository = $leagueRepository;
        $this->championshipRepository = $championshipRepository;
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
