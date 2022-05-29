<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Site\Services;

use OSM\Core\Components\ArrayCache;
use OSM\Core\Factories\GenericFactory;
use OSM\Core\Interfaces\SessionInterface;
use OSM\Core\Models\Team;
use OSM\Core\Models\User;
use OSM\Core\Repositories\TeamRepository;
use OSM\Core\Repositories\UserRepository;
use OSM\Frontend\Modules\Lineup\Services\TeamLineupSessionService;

class AuthorizationService
{
    private const SESSION_KEY_ACTIVE_USER_ID = 'active-user-id';
    private const SESSION_KEY_ACTIVE_TEAM_ID = 'active-team-id';

    private const CACHE_ACTIVE_TEAM = 'active-team';
    private const CACHE_ACTIVE_USER = 'active-user';

    private UserRepository $userRepository;
    private SessionInterface $session;
    private TeamRepository $teamRepository;
    private ArrayCache $arrayCache;
    private GenericFactory $factory;

    public function __construct(
        UserRepository $userRepository,
        TeamRepository $teamRepository,
        SessionInterface $session,
        ArrayCache $arrayCache,
        GenericFactory $factory
    ) {
        $this->userRepository = $userRepository;
        $this->session = $session;
        $this->teamRepository = $teamRepository;
        $this->arrayCache = $arrayCache;
        $this->factory = $factory;
    }

    public function authorizeUserByPassword(string $username, string $password): bool
    {
        $user = $this->userRepository->findByUsername($username);
        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->password)) {
            return false;
        }

        $this->authorizeUser($user);

        return true;
    }

    public function authorizeUser(User $user)
    {
        $defaultTeam = $this->teamRepository->findDefaultTeam($user);
        if ($defaultTeam) {
            $this->session->set(self::SESSION_KEY_ACTIVE_TEAM_ID, $defaultTeam->id);
        }

        $this->session->set(self::SESSION_KEY_ACTIVE_USER_ID, $user->id);
    }

    public function logoutActiveUser()
    {
        $this->session->clear(self::SESSION_KEY_ACTIVE_USER_ID);
        $this->session->clear(self::SESSION_KEY_ACTIVE_TEAM_ID);
        $this->factory->get(TeamLineupSessionService::class)->clearSession();
    }

    public function isAuthorized(): bool
    {
        return !!$this->session->get(self::SESSION_KEY_ACTIVE_USER_ID);
    }

    public function getActiveUser(): ?User
    {
        $userId = $this->getActiveUserId();

        return $this->arrayCache->getOrSet(self::CACHE_ACTIVE_USER, fn() => $this->userRepository->findById($userId));
    }

    public function getActiveTeam(): ?Team
    {
        $teamId = $this->getActiveTeamId();

        return $this->arrayCache->getOrSet(self::CACHE_ACTIVE_TEAM, fn() => $this->teamRepository->findById($teamId));
    }

    public function getActiveUserId(): ?int
    {
        return (int)$this->session->get(self::SESSION_KEY_ACTIVE_USER_ID);
    }

    public function getActiveTeamId(): ?int
    {
        return (int)$this->session->get(self::SESSION_KEY_ACTIVE_TEAM_ID);
    }
}
