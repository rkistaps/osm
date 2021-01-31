<?php

declare(strict_types=1);

namespace OSM\Modules\Teams\Creation\Services;

use OSM\Core\Models\FinanceLog;
use OSM\Core\Models\Team;
use OSM\Core\Repositories\TeamRepository;
use OSM\Modules\Options\Services\OptionValueService;
use OSM\Modules\Options\Structures\StartingOptionGroup;
use OSM\Modules\Teams\Creation\Structures\TeamCreationParams;
use OSM\Modules\Teams\Finances\Services\TeamFinancialService;

class TeamCreationService
{
    private TeamRepository $repository;
    private OptionValueService $optionValueService;
    private TeamFinancialService $financialService;

    public function __construct(
        TeamRepository $repository,
        OptionValueService $optionValueService,
        TeamFinancialService $financialService
    ) {
        $this->repository = $repository;
        $this->optionValueService = $optionValueService;
        $this->financialService = $financialService;
    }

    public function createTeam(TeamCreationParams $params): Team
    {
        $team = $this->repository->createModel();
        $team->name = $params->name;
        $team->countryId = $params->countryId;
        $team->userId = $params->userId;
        $team->isDefault = $params->isDefault;

        $team->supporters = (int)$this->optionValueService->getOptionValue(StartingOptionGroup::OPTION_SUPPORTERS);
        $team->stadiumSize = (int)$this->optionValueService->getOptionValue(StartingOptionGroup::OPTION_STADIUM_SIZE);

        // save team
        $team = $this->repository->saveModel($team);

        // add starting money
        $money = (float)$this->optionValueService->getOptionValue(StartingOptionGroup::OPTION_MONEY);
        $this->financialService->depositFunds($money, FinanceLog::EVENT_STARTING_MONEY, $team);

        // create players
        // todo me

        // create default lineup
        // todo me

        return $team;
    }
}
