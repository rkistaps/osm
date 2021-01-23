<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use TheApp\Components\CommandRunner;
use TheApp\Interfaces\CommandConfiguratorInterface;

class SiteCommandConfigurator implements CommandConfiguratorInterface
{
    public function configureCommands(CommandRunner $commandRunner)
    {
        $commandRunner->addCommand('test', function () {
            echo 'Demo console command' . PHP_EOL;
        });
    }
}
