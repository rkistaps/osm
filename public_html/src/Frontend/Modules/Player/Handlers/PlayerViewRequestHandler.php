<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Player\Handlers;

use OSM\Core\Repositories\CountryRepository;
use OSM\Core\Repositories\PlayerFaceRepository;
use OSM\Core\Repositories\TeamRepository;
use OSM\Frontend\Exceptions\Http\HttpNotFoundException;
use OSM\Modules\Players\Creation\Services\PlayerFaceImageCreationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PlayerViewRequestHandler extends AbstractPlayerRequestHandler implements RequestHandlerInterface
{
    /**
     * @throws HttpNotFoundException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $player = $this->getPlayer($request);

        $country = $this->genericFactory->get(CountryRepository::class)->findForPlayer($player);
        $team = $this->genericFactory->get(TeamRepository::class)->findForPlayer($player);

        $playerFace = $this->genericFactory->get(PlayerFaceRepository::class)->findForPlayer($player);
        $faceImage = $this->genericFactory->get(PlayerFaceImageCreationService::class)->getFaceImage($playerFace);

        return $this->render('index', [
            'player' => $player,
            'country' => $country,
            'team' => $team,
            'face' => $faceImage,
            'isOwner' => $this->isPlayerOwner($request),
        ]);
    }
}
