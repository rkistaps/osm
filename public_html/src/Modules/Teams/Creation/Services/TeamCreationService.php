<?php

declare(strict_types=1);

namespace OSM\Modules\Teams\Creation\Services;

use OSM\Core\Models\FinanceLog;
use OSM\Core\Models\Team;
use OSM\Core\Repositories\TeamRepository;
use OSM\Modules\Options\Services\OptionValueService;
use OSM\Modules\Options\Structures\StartingOptionGroup;
use OSM\Modules\Players\Creation\Services\SquadCreationService;
use OSM\Modules\Players\Creation\Structures\SquadCreationParams;
use OSM\Modules\Teams\Creation\Structures\TeamCreationParams;
use OSM\Modules\Teams\Finances\Services\TeamFinancialService;

class TeamCreationService
{
    private TeamRepository $repository;
    private OptionValueService $optionValueService;
    private TeamFinancialService $financialService;
    private TeamCreationValidationService $validationService;
    private SquadCreationService $squadCreationService;

    public function __construct(
        TeamRepository $repository,
        OptionValueService $optionValueService,
        TeamFinancialService $financialService,
        TeamCreationValidationService $validationService,
        SquadCreationService $squadCreationService
    ) {
        $this->repository = $repository;
        $this->optionValueService = $optionValueService;
        $this->financialService = $financialService;
        $this->validationService = $validationService;
        $this->squadCreationService = $squadCreationService;
    }

    /**
     * @param TeamCreationParams $params
     * @return Team
     * @throws \OSM\Modules\Teams\Creation\Exceptions\TeamCreationValidationException
     */
    public function createTeam(TeamCreationParams $params): Team
    {
        $this->validationService->validate($params);

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
        $params = new SquadCreationParams();
        $params->team = $team;
        $players = $this->squadCreationService->generate($params);
        
        // create default lineup
        // todo me

        return $team;
    }
}
