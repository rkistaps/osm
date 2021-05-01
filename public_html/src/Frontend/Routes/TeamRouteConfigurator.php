<?php

declare(strict_types=1);

namespace OSM\Frontend\Routes;

use OSM\Frontend\Core\Middlewares\IsAuthorizedMiddleware;
use OSM\Frontend\Modules\Teams\Handlers\TeamViewRequestHandler;
use TheApp\Components\Router;
use TheApp\Interfaces\RouterConfiguratorInterface;

class TeamRouteConfigurator implements RouterConfiguratorInterface
{
    private const PREFIX = '/teams';

    /**
     * @inheritDoc
     */
    public function configureRouter(Router $router)
    {
        $router
            ->get(self::PREFIX, TeamViewRequestHandler::class)
            ->withMiddleware(IsAuthorizedMiddleware::class);

        $router
            ->get(self::PREFIX . '/[i:id]', TeamViewRequestHandler::class)
            ->withMiddleware(IsAuthorizedMiddleware::class);
    }
}
