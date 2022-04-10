<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Site\Services;

use OSM\Frontend\Modules\Site\ViewModels\RegistrationViewModel;
use OSM\Modules\Teams\Creation\Services\TeamCreationService;
use OSM\Modules\Teams\Creation\Structures\TeamCreationParams;
use OSM\Modules\Users\Services\UserCreationService;

class RegistrationService
{
    private UserCreationService $userCreationService;
    private TeamCreationService $teamCreationService;
    private RegistrationValidationService $validationService;

    public function __construct(
        RegistrationValidationService $validationService,
        UserCreationService $userCreationService,
        TeamCreationService $teamCreationService
    ) {
        $this->userCreationService = $userCreationService;
        $this->teamCreationService = $teamCreationService;
        $this->validationService = $validationService;
    }

    public function processRegistration(RegistrationViewModel $model): bool
    {
        if (!$this->validationService->validateModel($model)) {
            return false;
        }

        $user = $this->userCreationService->create($model->username, $model->password);

        $teamCreationParams = (new TeamCreationParams())
            ->setCountryId($model->countryId)
            ->setIsDefault(true)
            ->setUserId($user->id)
            ->setName($model->teamName);

        $this->teamCreationService->createTeam($teamCreationParams);

        return true;
    }
}
