<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use OSM\Console\Handlers\Series\Leagues\LeagueNextRoundRunnerHandler;
use OSM\Console\Handlers\Series\Leagues\LeagueRoundRunnerHandler;
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
    }
}
