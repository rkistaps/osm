<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Matches;

use OSM\Core\Repositories\MatchRepository;
use OSM\Modules\Matches\Factories\MatchParameterFactory;
use OSM\Modules\Matches\Services\MatchRunnerService;
use Psr\Log\LoggerInterface;
use TheApp\Interfaces\CommandHandlerInterface;

class MatchRunnerHandler implements CommandHandlerInterface
{
    private MatchRepository $matchRepository;
    private MatchRunnerService $matchRunnerService;
    private LoggerInterface $logger;
    private MatchParameterFactory $matchParameterFactory;

    public function __construct(
        MatchRepository $matchRepository,
        MatchRunnerService $matchRunnerService,
        MatchParameterFactory $matchParameterFactory,
        LoggerInterface $logger
    ) {
        $this->matchRepository = $matchRepository;
        $this->matchRunnerService = $matchRunnerService;
        $this->logger = $logger;
        $this->matchParameterFactory = $matchParameterFactory;
    }

    public function handle(array $params = [])
    {
        $matchId = (int)($params['id'] ?? null);
        $match = $this->matchRepository->findById($matchId);
        if (!$match) {
            $this->logger->info('Match not found');
            return;
        } elseif ($match->isPlayed) {
            $this->logger->info('Match already played');
            return;
        }

        $matchParams = $this->matchParameterFactory->buildForMatch($match);
        $matchParams->isDryRun = (bool)($params['dryRun'] ?? true);

        $this->logger->info('Dry run: ' . $matchParams->isDryRun);

        $result = $this->matchRunnerService->runMatch($match, $matchParams);

        dd($result);
    }
}
