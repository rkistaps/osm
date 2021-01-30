<?php

declare(strict_types=1);

namespace OSM\Modules\Teams\Creation\Services;

use OSM\Core\Models\Team;
use OSM\Core\Repositories\TeamRepository;
use OSM\Modules\Options\Services\OptionValueService;
use OSM\Modules\Options\Structures\StartingOptionGroup;
use OSM\Modules\Teams\Creation\Structures\TeamCreationParams;

class TeamCreationService
{
    private TeamRepository $repository;
    private OptionValueService $optionValueService;

    public function __construct(
        TeamRepository $repository,
        OptionValueService $optionValueService
    ) {
        $this->repository = $repository;
        $this->optionValueService = $optionValueService;
    }

    public function createTeam(TeamCreationParams $params): Team
    {
        $team = $this->repository->createModel();
        $team->name = $params->name;
        $team->countryId = $params->countryId;
        $team->userId = $params->userId;
        $team->isDefault = $params->isDefault;

        $team->money = (float)$this->optionValueService->getOptionValue(StartingOptionGroup::OPTION_MONEY);
        $team->supporters = (int)$this->optionValueService->getOptionValue(StartingOptionGroup::OPTION_SUPPORTERS);
        $team->stadiumSize = (int)$this->optionValueService->getOptionValue(StartingOptionGroup::OPTION_STADIUM_SIZE);

        $team = $this->repository->saveModel($team);

        return $team;
    }
}
