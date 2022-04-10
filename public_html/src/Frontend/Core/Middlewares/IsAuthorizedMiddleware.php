<?php

declare(strict_types=1);

namespace OSM\Frontend\Core\Middlewares;

use OSM\Frontend\Core\Builders\ResponseBuilder;
use OSM\Frontend\Modules\Site\Services\AuthorizationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IsAuthorizedMiddleware implements MiddlewareInterface
{
    private AuthorizationService $authorizationService;
    private ResponseBuilder $responseBuilder;

    public function __construct(
        AuthorizationService $authorizationService,
        ResponseBuilder $responseBuilder
    ) {
        $this->authorizationService = $authorizationService;
        $this->responseBuilder = $responseBuilder;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->authorizationService->isAuthorized()) {
            return $this->responseBuilder->withRedirect('/', 302)->build();
        }

        $request = $request->withAttribute('user', $this->authorizationService->getActiveUser());
        $request = $request->withAttribute('team', $this->authorizationService->getActiveTeam());
        $request = $request->withAttribute('active-user-id', $this->authorizationService->getActiveUserId());
        $request = $request->withAttribute('active-team-id', $this->authorizationService->getActiveTeamId());

        return $handler->handle($request);
    }
}
