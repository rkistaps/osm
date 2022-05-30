<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup\Handlers;

use OSM\Core\Handlers\AbstractRequestHandler;
use OSM\Core\Helpers\ArrayHelper;
use OSM\Core\Repositories\PlayerRepository;
use OSM\Core\Repositories\TeamLineupPlayerRepository;
use OSM\Core\Translations\Structures\Domains;
use OSM\Frontend\Modules\Lineup\Exceptions\LineupValidationException;
use OSM\Frontend\Modules\Lineup\Services\LineupSavingService;
use OSM\Frontend\Modules\Lineup\Services\TeamLineupSessionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LineupViewRequestHandler extends AbstractRequestHandler implements RequestHandlerInterface
{
    private TeamLineupPlayerRepository $lineupPlayerRepository;
    private PlayerRepository $playerRepository;
    private LineupSavingService $lineupSavingService;
    private TeamLineupSessionService $lineupSessionService;

    protected function init()
    {
        $this->lineupPlayerRepository = $this->genericFactory->get(TeamLineupPlayerRepository::class);
        $this->playerRepository = $this->genericFactory->get(PlayerRepository::class);
        $this->lineupSavingService = $this->genericFactory->get(LineupSavingService::class);
        $this->lineupSessionService = $this->genericFactory->get(TeamLineupSessionService::class);
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $team = $this->getActiveTeam($request);
        $lineup = $this->lineupSessionService->getOrSet($team);
        $lineupPlayers = $this->lineupPlayerRepository->findByLineupId($lineup->id);
        $players = $this->playerRepository->findSquadPlayersByTeam($team->id);

        if ($this->hasPostParam('save-lineup', $request)) {
            try {
                $postPlayerIds = $this->getSanitizedPlayerIds($request);
                $this->lineupSavingService->savePlayersForLineup(
                    $postPlayerIds,
                    $lineup
                );

                return $this->reloadWithSuccess($request, _d(Domains::DOMAIN_FRONTEND, 'Lineup players saved'));
            } catch (LineupValidationException $validationException) {
                $this->addErrorAlert($validationException->getMessage(), false);
            }
        }

        return $this->render('lineup', [
            'lineup' => $lineup,
            'lineupPlayers' => $lineupPlayers,
            'team' => $team,
            'players' => $players,
            'factory' => $this->genericFactory,
            'postPlayerIds' => $postPlayerIds ?? null,
        ]);
    }

    protected function getSanitizedPlayerIds(ServerRequestInterface $request): array
    {
        return ArrayHelper::mapUniqueFilter(
            fn($playerId) => (int) $playerId,
            $this->getPostParam('players', $request, [])
        );
    }
}