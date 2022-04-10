<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Site\Handlers;

use OSM\Core\Handlers\AbstractRequestHandler;
use OSM\Core\Interfaces\SessionInterface;
use OSM\Frontend\Modules\Site\Services\AuthorizationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProcessLoginHandler extends AbstractRequestHandler
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $username = $request->getParsedBody()['username'] ?? '';
        $password = $request->getParsedBody()['password'] ?? '';

        $service = $this->genericFactory->get(AuthorizationService::class);
        if ($service->authorizeUserByPassword($username, $password)) {
            return $this->redirect('/news');
        }

        $this->genericFactory->get(SessionInterface::class)->setFlash('auth-error', true);

        return $this->redirect('/');
    }
}
