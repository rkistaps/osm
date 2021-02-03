<?php

declare(strict_types=1);

namespace OSM\Console\Handlers\Teams;

use OSM\Modules\Teams\Creation\Services\TeamCreationService;
use OSM\Modules\Teams\Creation\Structures\TeamCreationParams;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class TeamsCreationCommandHandler implements \TheApp\Interfaces\CommandHandlerInterface
{
    private ContainerInterface $container;
    private LoggerInterface $logger;

    public function __construct(
        ContainerInterface $container,
        LoggerInterface $logger
    ) {
        $this->container = $container;
        $this->logger = $logger;
    }

    public function handle(array $params = [])
    {
        $params = TeamCreationParams::fromArray($params);

        $service = $this->container->get(TeamCreationService::class);

        try {
            $team = $service->createTeam($params);

            $this->logger->info('Team created: ' . $team->id);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
        }
    }
}
