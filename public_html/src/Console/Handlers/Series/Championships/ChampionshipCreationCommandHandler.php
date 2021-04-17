<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Series\Championships;

use OSM\Modules\Series\Championships\Creation\Services\ChampionshipCreationService;
use Psr\Log\LoggerInterface;

class ChampionshipCreationCommandHandler implements \TheApp\Interfaces\CommandHandlerInterface
{
    private ChampionshipCreationService $creationService;
    private LoggerInterface $logger;

    public function __construct(
        ChampionshipCreationService $creationService,
        LoggerInterface $logger
    ) {
        $this->creationService = $creationService;
        $this->logger = $logger;
    }

    public function handle(array $params = [])
    {
        $name = $params['name'] ?? '';
        $type = $params['type'] ?? '';

        if (!$name || !$type) {
            $this->logger->error('Missing type or name');
            return;
        }

        $championship = $this->creationService->createChampionship($name, $type);

        $this->logger->info('Championship created: ' . $championship->id);
    }
}
