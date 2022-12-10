<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Teams\Handlers;

use OSM\Core\Handlers\AbstractRequestHandler;
use OSM\Frontend\Modules\Teams\Factories\TeamViewModelFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TeamViewRequestHandler extends AbstractRequestHandler
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $teamId = $request->getAttribute('id', $request->getAttribute('active-team-id'));
        $team = $this->getTeam((int)$teamId);

        $activeUserId = $request->getAttribute('active-user-id');

        return $this->render('index', [
            'model' => $this->genericFactory->get(TeamViewModelFactory::class)->buildForTeam($team),
            'isOwner' => $team->userId === $activeUserId,
        ]);
    }
}
