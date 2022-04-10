<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use OSM\Console\Handlers\Series\Championships\ChampionshipCreationCommandHandler;
use OSM\Console\Handlers\Series\Leagues\LeagueLevelCreationCommandHandler;
use TheApp\Components\CommandRunner;
use TheApp\Interfaces\CommandConfiguratorInterface;

class ChampionshipCommandConfigurator implements CommandConfiguratorInterface
{
    private const PREFIX = 'championships';

    public function configureCommands(CommandRunner $commandRunner)
    {
        $commandRunner->addCommand(self::PREFIX . '/create', ChampionshipCreationCommandHandler::class);
        $commandRunner->addCommand(self::PREFIX . '/create-new-level', LeagueLevelCreationCommandHandler::class);
    }
}
