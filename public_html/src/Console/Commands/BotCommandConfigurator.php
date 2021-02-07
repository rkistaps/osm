<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use OSM\Console\Handlers\Bots\BotCreationCommandHandler;
use TheApp\Components\CommandRunner;
use TheApp\Interfaces\CommandConfiguratorInterface;

class BotCommandConfigurator implements CommandConfiguratorInterface
{
    private const PREFIX = 'bots';

    public function configureCommands(CommandRunner $commandRunner)
    {
        $commandRunner->addCommand(self::PREFIX . '/add', BotCreationCommandHandler::class);
    }
}
