<?php

declare(strict_types=1);

namespace OSM\Modules\Bots\Creation\Services;

use OSM\Core\Models\Country;
use OSM\Core\Models\Registry;
use OSM\Core\Models\Team;
use OSM\Core\Models\User;
use OSM\Core\Repositories\CountryRepository;
use OSM\Core\Services\RegistryService;
use OSM\Modules\Teams\Creation\Services\TeamCreationService;
use OSM\Modules\Teams\Creation\Structures\TeamCreationParams;
use OSM\Modules\Users\Services\UserCreationService;

class BotCreationService
{
    private UserCreationService $userCreationService;
    private TeamCreationService $teamCreationService;
    private RegistryService $registryService;
    private CountryRepository $countryRepository;

    public function __construct(
        UserCreationService $userCreationService,
        TeamCreationService $teamCreationService,
        RegistryService $registryService,
        CountryRepository $countryRepository
    ) {
        $this->userCreationService = $userCreationService;
        $this->teamCreationService = $teamCreationService;
        $this->registryService = $registryService;
        $this->countryRepository = $countryRepository;
    }

    public function addBot(Country $country = null): array
    {
        $user = $this->createBotUser();
        $team = $this->createBotTeam($user, $country);

        return [
            'user' => $user,
            'team' => $team,
        ];
    }

    public function createBotTeam(User $user, Country $country = null): Team
    {
        $country = $country ?? $this->countryRepository->findRandom();

        $teamCreationParams = new TeamCreationParams();
        $teamCreationParams->isDefault = true;
        $teamCreationParams->userId = $user->id;
        $teamCreationParams->countryId = $country->id;
        $teamCreationParams->name = uniqid('Bot team '); // todo implement fancy bot team name functionality

        return $this->teamCreationService->createTeam($teamCreationParams);
    }

    public function createBotUser(): User
    {
        $botCounter = (int)$this->registryService->getValue(Registry::BOT_COUNTER, 0);
        $botCounter++;

        $this->registryService->setValue(Registry::BOT_COUNTER, $botCounter);

        return $this->userCreationService->create(
            uniqid('Bot '),
            ''
        );
    }
}
