<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Player\Handlers;

use OSM\Core\Repositories\CountryRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlayerViewRequestHandler extends AbstractPlayerRequestHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $player = $this->getPlayer($request);

        $country = $this->genericFactory->get(CountryRepository::class)->findForPlayer($player);

        return $this->render('index', [
            'player' => $player,
            'country' => $country,
            'isOwner' => $this->isOwner($player, $request),
        ]);
    }
}
