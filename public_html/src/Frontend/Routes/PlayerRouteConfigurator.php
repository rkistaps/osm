<?php

declare(strict_types=1);

namespace OSM\Frontend\Routes;

use OSM\Frontend\Core\Middlewares\IsAuthorizedMiddleware;
use OSM\Frontend\Modules\Player\Handlers\PlayerViewRequestHandler;
use TheApp\Components\Router;
use TheApp\Interfaces\RouterConfiguratorInterface;

class PlayerRouteConfigurator implements RouterConfiguratorInterface
{
    private const PREFIX = '/players';

    public function configureRouter(Router $router)
    {
        $router->get(self::PREFIX . '/[i:id]', PlayerViewRequestHandler::class)
            ->withMiddleware(IsAuthorizedMiddleware::class);
    }
}