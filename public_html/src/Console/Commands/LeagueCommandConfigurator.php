<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use OSM\Console\Handlers\Series\Leagues\LeagueNextRoundRunnerHandler;
use OSM\Console\Handlers\Series\Leagues\LeagueRoundRunnerHandler;
use OSM\Core\Repositories\ChampionshipLeagueRepository;
use OSM\Core\Repositories\ChampionshipRepository;
use OSM\Modules\Series\Common\Services\LeagueTableUpdatingService;
use Psr\Log\LoggerInterface;
use TheApp\Components\CommandRunner;
use TheApp\Interfaces\CommandConfiguratorInterface;

class LeagueCommandConfigurator implements CommandConfiguratorInterface
{
    private const PREFIX = 'leagues';

    public function configureCommands(CommandRunner $commandRunner)
    {
        /**
         * Run next round for given or all leagues
         * ./run leagues/run-next-round
         */
        $commandRunner->addCommand(self::PREFIX . '/run-next-round', LeagueNextRoundRunnerHandler::class);

        /**
         * Run given round for given or all leagues
         * ./run leagues/run-round
         */
        $commandRunner->addCommand(self::PREFIX . '/run-round', LeagueRoundRunnerHandler::class);

        /**
         * Update league table for league
         * ./run leagues/fix-table -leagueId=1
         */
        $commandRunner->addCommand(self::PREFIX . '/fix-table', function (
            int $leagueId,
            LoggerInterface $logger,
            ChampionshipLeagueRepository $leagueRepository,
            ChampionshipRepository $championshipRepository,
            LeagueTableUpdatingService $tableUpdatingService
        ) {
            $league = $leagueRepository->findById($leagueId);
            if (!$league) {
                $logger->error('League not found');
                return;
            }
            $championship = $championshipRepository->findById($league->championshipId);
            if (!$championship->isLeague()) {
                $logger->error('Incorrect championship');
                return;
            }

            $logger->info('Updating table for ' . $league->name);
            $tableUpdatingService->updateChampionshipLeagueTable($championship, $league);
        });
    }
}
