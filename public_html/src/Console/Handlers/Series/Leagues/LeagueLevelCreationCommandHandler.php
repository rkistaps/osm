<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Series\Leagues;

use OSM\Core\Repositories\ChampionshipRepository;
use OSM\Modules\Series\Leagues\Services\LeagueLevelCreationService;
use Psr\Log\LoggerInterface;
use TheApp\Interfaces\CommandHandlerInterface;
use Throwable;

class LeagueLevelCreationCommandHandler implements CommandHandlerInterface
{
    private LeagueLevelCreationService $service;
    private ChampionshipRepository $championshipRepository;
    private LoggerInterface $logger;

    public function __construct(
        LeagueLevelCreationService $service,
        ChampionshipRepository $championshipRepository,
        LoggerInterface $logger
    ) {
        $this->service = $service;
        $this->championshipRepository = $championshipRepository;
        $this->logger = $logger;
    }

    public function handle(array $params = [])
    {
        $id = $params['id'] ?? 0;
        if (!$id) {
            $this->logger->error('Missing id parameter');
            return;
        }

        $championship = $this->championshipRepository->findById((int)$id);
        if (!$championship) {
            $this->logger->error('Championship not found');
            return;
        }

        try {
            $this->service->createNewLeagueLevel($championship);
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage());
        }
    }
}
