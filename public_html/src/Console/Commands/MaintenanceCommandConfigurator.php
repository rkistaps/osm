<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use OSM\Core\Database\DatabaseSeeder;
use TheApp\Components\CommandRunner;

class MaintenanceCommandConfigurator implements \TheApp\Interfaces\CommandConfiguratorInterface
{
    public function configureCommands(CommandRunner $commandRunner)
    {
        $commandRunner->addCommand('database/seed', function (DatabaseSeeder $seeder) {
            $seeder->seed();
        });
    }
}
