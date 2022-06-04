<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Player\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlayerViewRequestHandler extends AbstractPlayerRequestHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $player = $this->getPlayer($request);

        return $this->render('index', [
            'player' => $player,
            'isOwner' => $this->isOwner($player, $request),
        ]);
    }
}
