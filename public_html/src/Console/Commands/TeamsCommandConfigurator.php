<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use OSM\Console\Handlers\Teams\TeamsCreationCommandHandler;
use OSM\Core\Repositories\TeamRepository;
use OSM\Modules\Teams\Lineups\Services\TeamLineupGeneratorService;
use Psr\Log\LoggerInterface;
use TheApp\Components\CommandRunner;
use TheApp\Interfaces\CommandConfiguratorInterface;

class TeamsCommandConfigurator implements CommandConfiguratorInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public const PREFIX = 'teams';

    public function configureCommands(CommandRunner $commandRunner)
    {
        /**
         * Create a new team
         * ./run teams/create -name="Royal Club" -userId=1 -countryId=1 --isDefault
         */
        $commandRunner->addCommand(self::PREFIX . '/create', TeamsCreationCommandHandler::class);

        $commandRunner->addCommand(self::PREFIX . '/findByName', function (string $name, TeamRepository $repository) {
            $team = $repository->findByName($name);

            $this->logger->info($team);
        });

        $commandRunner->addCommand(self::PREFIX . '/generate-default-lineup', function (
            int $teamId,
            TeamRepository $teamRepository,
            TeamLineupGeneratorService $lineupGeneratorService
        ) {
            $team = $teamRepository->findById($teamId);
            if (!$team) {
                $this->logger->info('Team not found');
                return;
            }

            $lineUp = $lineupGeneratorService->generateDefaultLineup($team);

            $this->logger->info('DONE. Lineup id: ' . $lineUp->id);
        });
    }
}
