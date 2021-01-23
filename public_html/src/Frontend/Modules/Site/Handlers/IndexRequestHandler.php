<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Site\Handlers;

use Opis\Database\Database;
use OSM\Core\Handlers\AbstractRequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TheApp\Apps\WebApp;

class IndexRequestHandler extends AbstractRequestHandler
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        WebApp::getContainer()->get(Database::class);

        return $this->render('index');
    }
}
