<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Player\Handlers;

use OSM\Core\Handlers\AbstractRequestHandler;
use OSM\Core\Models\Player;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Core\Translations\Structures\Domains;
use OSM\Frontend\Exceptions\Http\HttpNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractPlayerRequestHandler extends AbstractRequestHandler implements
    RequestHandlerInterface
{
    private ?Player $player = null;

    abstract public function handle(ServerRequestInterface $request): ResponseInterface;

    protected function getPlayer(ServerRequestInterface $request): ?Player
    {
        if ($this->player) {
            return $this->player;
        }

        $playerId = (int)$request->getAttribute('id');

        $player = $this->genericFactory->get(PlayerRepository::class)->findById($playerId);

        if (!$player) {
            throw new HttpNotFoundException(_d(Domains::DOMAIN_FRONTEND, 'Team not found'));
        }

        $this->player = $player;

        return $player;
    }

    public function isOwner(ServerRequestInterface $request): bool
    {
        return $this->getPlayer($request)->teamId === $request->getAttribute('active-team-id');
    }
}