<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Site\Services;

use OSM\Core\Repositories\ChampionshipRepository;
use OSM\Core\Repositories\CountryRepository;
use OSM\Core\Repositories\TeamRepository;
use OSM\Core\Repositories\UserRepository;
use OSM\Frontend\Modules\Site\ViewModels\RegistrationViewModel;

class RegistrationValidationService
{
    private UserRepository $userRepository;
    private TeamRepository $teamRepository;
    private CountryRepository $countryRepository;
    private ChampionshipRepository $championshipRepository;

    public function __construct(
        UserRepository $userRepository,
        TeamRepository $teamRepository,
        CountryRepository $countryRepository,
        ChampionshipRepository $championshipRepository
    ) {
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamRepository;
        $this->countryRepository = $countryRepository;
        $this->championshipRepository = $championshipRepository;
    }

    public function validateModel(RegistrationViewModel $model): bool
    {
        if (!$model->username) {
            $model->addError('username', 'Username cannot be empty');
        } else {
            $existingUser = $this->userRepository->findByUsername($model->username);
            if ($existingUser) {
                $model->addError('username', 'Username already taken');
            }
        }

        if (!$model->password) {
            $model->addError('password', 'Password cannot be empty');
        } elseif ($model->password !== $model->passwordAgain) {
            $model->addError('passwordAgain', 'Passwords do not match');
        }

        if (!$model->teamName) {
            $model->addError('teamName', 'Team name cannot be empty');
        } else {
            $existingTeam = $this->teamRepository->findByName($model->teamName);
            if ($existingTeam) {
                $model->addError('teamName', 'Team name already taken');
            }
        }

        $country = $this->countryRepository->findById($model->countryId);
        if (!$country) {
            $model->addError('countryId', 'Country not found');
        }

        $championship = $this->championshipRepository->findById($model->championshipId);
        if (!$championship) {
            $model->addError('championshipId', 'Championship not found');
        } elseif (!$championship->isLeague()) {
            $model->addError('championshipId', 'Incorrect championship type');
        }

        return $model->isValid();
    }
}
