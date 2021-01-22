<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Site\Handlers;

use OSM\Core\Handlers\AbstractRequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexRequestHandler extends AbstractRequestHandler
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('index');
    }
}
