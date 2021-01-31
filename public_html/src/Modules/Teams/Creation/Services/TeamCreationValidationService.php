<?php

declare(strict_types=1);

namespace OSM\Modules\Teams\Creation\Services;

use OSM\Core\Repositories\CountryRepository;
use OSM\Core\Repositories\TeamRepository;
use OSM\Core\Repositories\UserRepository;
use OSM\Modules\Teams\Creation\Exceptions\TeamCreationValidationException;
use OSM\Modules\Teams\Creation\Structures\TeamCreationParams;

class TeamCreationValidationService
{
    private TeamRepository $teamRepository;
    private UserRepository $userRepository;
    private CountryRepository $countryRepository;

    public function __construct(
        TeamRepository $teamRepository,
        UserRepository $userRepository,
        CountryRepository $countryRepository
    ) {
        $this->teamRepository = $teamRepository;
        $this->userRepository = $userRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     * @param TeamCreationParams $params
     * @return bool
     * @throws TeamCreationValidationException
     */
    public function validate(TeamCreationParams $params): bool
    {
        if (!$params->name) {
            throw new TeamCreationValidationException(t('Missing team name'));
        }

        $team = $this->teamRepository->findByName($params->name);
        if ($team) {
            throw new TeamCreationValidationException(t('Team name already taken'));
        }

        $user = $this->userRepository->findById($params->userId);
        if (!$user) {
            throw new TeamCreationValidationException(t('User not found'));
        }

        $country = $this->countryRepository->findById($params->countryId);
        if (!$country) {
            throw new TeamCreationValidationException(t('Country not found'));
        }

        return true;
    }
}
