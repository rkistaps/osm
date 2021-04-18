<?php

declare(strict_types=1);

namespace OSM\Frontend\Routes;

use OSM\Frontend\Modules\Site\Handlers\IndexRequestHandler;
use OSM\Frontend\Modules\Site\Handlers\RegisterRequestHandler;
use TheApp\Components\Router;
use TheApp\Interfaces\RouterConfiguratorInterface;

class SiteRouteConfigurator implements RouterConfiguratorInterface
{
    public function configureRouter(Router $router)
    {
        $router->get('/', IndexRequestHandler::class);
        $router->any('/register', RegisterRequestHandler::class);
    }
}
