<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use TheApp\Components\CommandRunner;

class MatchCommandConfigurator implements \TheApp\Interfaces\CommandConfiguratorInterface
{
    private const PREFIX = 'matches';

    public function configureCommands(CommandRunner $commandRunner)
    {
        $commandRunner->addCommand(self::PREFIX . '/add-friendly', function () {
        });
    }
}
