<?php

use OSM\Console\Commands\BotCommandConfigurator;
use OSM\Console\Commands\ChampionshipCommandConfigurator;
use OSM\Console\Commands\LeagueCommandConfigurator;
use OSM\Console\Commands\MaintenanceCommandConfigurator;
use OSM\Console\Commands\MatchCommandConfigurator;
use OSM\Console\Commands\SiteCommandConfigurator;
use OSM\Console\Commands\TeamsCommandConfigurator;
use OSM\Console\Commands\UserCommandConfigurator;
use OSM\Frontend\Modules\Site\Handlers\ErrorHandler;
use OSM\Frontend\Routes\LineupRouteConfigurator;
use OSM\Frontend\Routes\PlayerRouteConfigurator;
use OSM\Frontend\Routes\SiteRouteConfigurator;
use OSM\Frontend\Routes\TeamRouteConfigurator;

return [
    'error_handler' => ErrorHandler::class,
    'templatePath' => APP_ROOT . '/src/Frontend/Templates',
    'database' => [
        'host' => '',
        'port' => '',
        'name' => '',
        'username' => '',
        'password' => '',
    ],
    'router' => [
        'configurators' => [
            SiteRouteConfigurator::class,
            TeamRouteConfigurator::class,
            LineupRouteConfigurator::class,
            PlayerRouteConfigurator::class,
        ],
    ],
    'command' => [
        'configurators' => [
            MaintenanceCommandConfigurator::class,
            SiteCommandConfigurator::class,
            UserCommandConfigurator::class,
            TeamsCommandConfigurator::class,
            MatchCommandConfigurator::class,
            BotCommandConfigurator::class,
            ChampionshipCommandConfigurator::class,
            LeagueCommandConfigurator::class,
        ],
    ],
];
