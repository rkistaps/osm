<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Teams\Handlers;

use OSM\Core\Handlers\AbstractRequestHandler;
use OSM\Core\Models\Team;
use OSM\Core\Repositories\CountryRepository;
use OSM\Core\Repositories\TeamRepository;
use OSM\Core\Repositories\UserRepository;
use OSM\Frontend\Exceptions\Http\HttpNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TeamViewRequestHandler extends AbstractRequestHandler
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $teamId = $request->getAttribute('id', $request->getAttribute('active-team-id'));

        $team = $this->getTeam((int)$teamId);

        $user = $this->genericFactory->get(UserRepository::class)->findById($team->userId);
        $country = $this->genericFactory->get(CountryRepository::class)->findById($team->countryId);

        return $this->render('index', [
            'team' => $team,
            'user' => $user,
            'country' => $country,
        ]);
    }

    /**
     * @throws HttpNotFoundException
     */
    protected function getTeam(int $teamId = null): Team
    {
        $team = $this->genericFactory->get(TeamRepository::class)->findById($teamId);

        if (!$team) {
            throw new HttpNotFoundException(_d('frontend', 'Team not found'));
        }

        return $team;
    }
}
