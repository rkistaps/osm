<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use OSM\Core\Helpers\RandomHelper;
use OSM\Core\Interfaces\ModelDataHydratorInterface;
use OSM\Core\Repositories\CountryRepository;
use Psr\Log\LoggerInterface;
use TheApp\Components\CommandRunner;
use TheApp\Interfaces\CommandConfiguratorInterface;

class SiteCommandConfigurator implements CommandConfiguratorInterface
{
    public function configureCommands(CommandRunner $commandRunner)
    {
        $commandRunner->addCommand('test', function (LoggerInterface $logger) {
            $logger->info(RandomHelper::between(1.2, 3.4));
        });
    }
}
