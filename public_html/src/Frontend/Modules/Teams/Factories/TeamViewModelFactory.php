<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Teams\Factories;

use OSM\Core\Models\Team;
use OSM\Core\Repositories\ChampionshipLeagueRepository;
use OSM\Core\Repositories\CountryRepository;
use OSM\Core\Repositories\UserRepository;
use OSM\Frontend\Modules\Teams\Models\TeamViewModel;

class TeamViewModelFactory
{
    private UserRepository $userRepository;
    private CountryRepository $countryRepository;
    private ChampionshipLeagueRepository $championshipLeagueRepository;

    public function __construct(
        UserRepository $userRepository,
        CountryRepository $countryRepository,
        ChampionshipLeagueRepository $championshipLeagueRepository
    ) {
        $this->userRepository = $userRepository;
        $this->countryRepository = $countryRepository;
        $this->championshipLeagueRepository = $championshipLeagueRepository;
    }

    public function buildForTeam(Team $team): TeamViewModel
    {
        $model = new TeamViewModel();
        $model->team = $team;

        $model->user = $this->userRepository->findById($team->userId);
        $model->country = $this->countryRepository->findById($team->countryId);

        $model->league = $this->championshipLeagueRepository->findByChampionshipAndTeam($team->championshipId, $team->id);

        return $model;
    }
}
