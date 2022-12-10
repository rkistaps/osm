<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Player\Handlers;

use OSM\Core\Handlers\AbstractRequestHandler;
use OSM\Core\Models\Player;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Core\Traits\ArrayCacheOwnerTrait;
use OSM\Core\Translations\Structures\Domains;
use OSM\Frontend\Exceptions\Http\HttpNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractPlayerRequestHandler extends AbstractRequestHandler implements
    RequestHandlerInterface
{
    use ArrayCacheOwnerTrait;

    protected const TEMPLATE_PATH = '/Player';

    abstract public function handle(ServerRequestInterface $request): ResponseInterface;

    protected function render(string $view, array $params = []): ResponseInterface
    {
        return parent::render(self::TEMPLATE_PATH . '/' . $view, $params);
    }

    /**
     * @throws HttpNotFoundException
     */
    protected function getPlayer(ServerRequestInterface $request): Player
    {
        $playerId = $request->getAttribute('id');

        return $this->getArrayCache()->getOrSet($playerId, function () use ($playerId) {
            $player = $this->genericFactory->get(PlayerRepository::class)->findById((int)$playerId);

            if (!$player) {
                throw new HttpNotFoundException(_d(Domains::DOMAIN_FRONTEND, 'Player not found'));
            }

            return $player;
        });
    }

    /**
     * @throws HttpNotFoundException
     */
    public function isPlayerOwner(ServerRequestInterface $request): bool
    {
        $player = $this->getPlayer($request);

        return $player->teamId === $request->getAttribute('active-team-id');
    }
}