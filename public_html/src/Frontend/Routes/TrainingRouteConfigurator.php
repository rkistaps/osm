<?php

declare(strict_types=1);

namespace OSM\Frontend\Routes;

use OSM\Frontend\Core\Middlewares\IsAuthorizedMiddleware;
use TheApp\Interfaces\RouterConfiguratorInterface;
use TheApp\Components\Router;

class TrainingRouteConfigurator implements RouterConfiguratorInterface
{
    private const PREFIX = '/training';

    /**
     * @inheritDoc
     */
    public function configureRouter(Router $router)
    {
        $router
            ->get(self::PREFIX, TrainingViewRequestHandler::class)
            ->withMiddleware(IsAuthorizedMiddleware::class);
    }
}
