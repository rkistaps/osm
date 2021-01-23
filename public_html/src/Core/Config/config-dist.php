<?php

return [
    'templatePath' => APP_ROOT . '/src/Frontend/Templates',
    'router' => [
        'configurators' => [
            \OSM\Frontend\Routes\SiteRouteConfigurator::class,
        ],
    ],
    'command' => [
        'configurators' => [
            \OSM\Console\Commands\SiteCommandConfigurator::class,
        ],
    ],
];