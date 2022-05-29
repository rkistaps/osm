<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup\Services;

use OSM\Core\Models\Team;
use OSM\Core\Models\TeamLineup;
use OSM\Core\Repositories\TeamLineupRepository;
use OSM\Frontend\Services\SessionService;

class TeamLineupSessionService
{
    private const SESSION_KEY = 'active-team-lineup-id';

    private SessionService $sessionService;
    private TeamLineupRepository $teamLineupRepository;

    public function __construct(
        SessionService $sessionService,
        TeamLineupRepository $teamLineupRepository
    ) {
        $this->sessionService = $sessionService;
        $this->teamLineupRepository = $teamLineupRepository;
    }

    public function getOrSet(Team $team): ?TeamLineup
    {
        $id = $this->sessionService->get(self::SESSION_KEY);
        if (!$id) {
            $lineup = $this->teamLineupRepository->getDefaultForTeamId($team->id);
            $this->set($lineup->id);

            return $lineup;
        }

        return $this->teamLineupRepository->findById($id);
    }

    public function set(int $teamLineupId)
    {
        $this->sessionService->set(self::SESSION_KEY, $teamLineupId);
    }

    public function clearSession()
    {
        $this->sessionService->clear(self::SESSION_KEY);
    }
}