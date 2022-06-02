<?php

declare(strict_types=1);

namespace OSM\Frontend\Routes;

use OSM\Frontend\Core\Middlewares\IsAuthorizedMiddleware;
use OSM\Frontend\Modules\Lineup\Handlers\LineupSaveTacticsHandler;
use OSM\Frontend\Modules\Lineup\Handlers\LineupViewRequestHandler;
use TheApp\Components\Router;
use TheApp\Interfaces\RouterConfiguratorInterface;

class LineupRouteConfigurator implements RouterConfiguratorInterface
{
    private const PREFIX = '/lineup';

    /**
     * @inheritDoc
     */
    public function configureRouter(Router $router)
    {
        $router->any(self::PREFIX, LineupViewRequestHandler::class)
            ->withMiddleware(IsAuthorizedMiddleware::class);

        $router->post(self::PREFIX . '/save-tactics', LineupSaveTacticsHandler::class)
            ->withMiddleware(IsAuthorizedMiddleware::class);
    }
}