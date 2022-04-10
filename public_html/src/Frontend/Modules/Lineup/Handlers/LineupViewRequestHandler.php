<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup\Handlers;

use OSM\Core\Handlers\AbstractRequestHandler;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Core\Repositories\TeamLineupPlayerRepository;
use OSM\Core\Repositories\TeamLineupRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LineupViewRequestHandler extends AbstractRequestHandler implements RequestHandlerInterface
{
    private TeamLineupPlayerRepository $lineupPlayerRepository;
    private TeamLineupRepository $lineupRepository;
    private PlayerRepository $playerRepository;

    protected function init()
    {
        $this->lineupRepository = $this->genericFactory->get(TeamLineupRepository::class);
        $this->lineupPlayerRepository = $this->genericFactory->get(TeamLineupPlayerRepository::class);
        $this->playerRepository = $this->genericFactory->get(PlayerRepository::class);
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $team = $this->getActiveTeam($request);
        $lineup = $this->lineupRepository->getDefaultForTeamId($team->id);
        $lineupPlayers = $this->lineupPlayerRepository->findByLineupId($lineup->id);
        $players = $this->playerRepository->getSquadPlayersByTeam($team->id);

        return $this->render('lineup', [
            'lineup' => $lineup,
            'lineupPlayers' => $lineupPlayers,
            'team' => $team,
            'players' => $players,
            'factory' => $this->genericFactory,
        ]);
    }
}