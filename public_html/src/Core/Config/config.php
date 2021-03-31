<?php

$localConfig = require_once 'config-local.php';

return $localConfig + [
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
                \OSM\Frontend\Routes\SiteRouteConfigurator::class,
            ],
        ],
        'command' => [
            'configurators' => [
                \OSM\Console\Commands\SiteCommandConfigurator::class,
                \OSM\Console\Commands\UserCommandConfigurator::class,
                \OSM\Console\Commands\TeamsCommandConfigurator::class,
                \OSM\Console\Commands\MatchCommandConfigurator::class,
                \OSM\Console\Commands\BotCommandConfigurator::class,
                \OSM\Console\Commands\ChampionshipCommandConfigurator::class,
                \OSM\Console\Commands\LeagueCommandConfigurator::class,
            ],
        ],
    ];
