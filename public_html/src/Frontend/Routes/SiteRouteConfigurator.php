<?php

declare(strict_types=1);

namespace OSM\Frontend\Routes;

use OSM\Frontend\Core\Builders\ResponseBuilder;
use OSM\Frontend\Core\Middlewares\IsAuthorizedMiddleware;
use OSM\Frontend\Modules\Site\Handlers\IndexRequestHandler;
use OSM\Frontend\Modules\Site\Handlers\NewsRequestHandler;
use OSM\Frontend\Modules\Site\Handlers\ProcessLoginHandler;
use OSM\Frontend\Modules\Site\Handlers\RegisterRequestHandler;
use OSM\Frontend\Modules\Site\Services\AuthorizationService;
use Psr\Http\Message\ServerRequestInterface;
use TheApp\Components\Router;
use TheApp\Interfaces\RouterConfiguratorInterface;

class SiteRouteConfigurator implements RouterConfiguratorInterface
{
    public function configureRouter(Router $router)
    {
        # unauthorized routes
        $router->get('/', IndexRequestHandler::class);
        $router->any('/register', RegisterRequestHandler::class);
        $router->post('/process-login', ProcessLoginHandler::class);

        # authorized routes
        $router->get('/news', NewsRequestHandler::class)->withMiddleware(IsAuthorizedMiddleware::class);


        $router->get('/logout', function (
            ServerRequestInterface $request,
            AuthorizationService $authorizationService,
            ResponseBuilder $responseBuilder
        ) {
            $authorizationService->logoutActiveUser();

            return $responseBuilder->withRedirect('/')->build();
        });
    }
}
