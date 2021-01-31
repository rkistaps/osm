<?php

declare(strict_types=1);

namespace OSM\Modules\Teams\Finances\Services;

use OSM\Core\Helpers\DateHelper;
use OSM\Core\Models\FinanceLog;
use OSM\Core\Models\Team;
use OSM\Core\Repositories\FinanceLogRepository;
use OSM\Core\Repositories\TeamRepository;

class TeamFinancialService
{
    public const INCOME_EVENTS = [
        FinanceLog::EVENT_STARTING_MONEY,
    ];

    public const EXPENSE_EVENTS = [];

    public const EVENTS = self::INCOME_EVENTS + self::EXPENSE_EVENTS;

    private TeamRepository $teamRepository;
    private FinanceLogRepository $financeLogRepository;
    private TeamFinancialStatsService $statsService;

    public function __construct(
        TeamRepository $teamRepository,
        FinanceLogRepository $financeLogRepository,
        TeamFinancialStatsService $statsService
    ) {
        $this->teamRepository = $teamRepository;
        $this->financeLogRepository = $financeLogRepository;
        $this->statsService = $statsService;
    }

    public function depositFunds(float $amount, string $event, Team $team, bool $persistent = true)
    {
        if (!in_array($event, self::EVENTS)) {
            throw new \Exception('Unsupported event');
        }

        $this->statsService->updateStats($amount, $event, $team);
        $this->addLogEntry($amount, $event, $team);

        $team->money += $amount;
        if ($persistent) {
            $this->teamRepository->saveModel($team, ['money']);
        }
    }

    public function withdrawFunds(int $amount, string $event, Team $team, $persistent = true)
    {
        if (!in_array($event, self::EVENTS)) {
            throw new \Exception('Unsupported event');
        }

        $this->statsService->updateStats($amount, $event, $team);
        $this->addLogEntry($amount, $event, $team);

        $team->money -= $amount;

        if ($persistent) {
            $this->teamRepository->saveModel($team, ['money']);
        }
    }

    public function addLogEntry(float $amount, string $event, Team $team)
    {
        $this->financeLogRepository->createModel([
            'team_id' => $team->id,
            'event' => $event,
            'change' => $amount,
            'result' => $this->isIncomeEvent($event)
                ? $team->money + $amount
                : $team->money - $amount,
            'date' => DateHelper::getDatetimeString(),
        ], true);
    }

    protected function isIncomeEvent(string $event): bool
    {
        return in_array($event, self::INCOME_EVENTS);
    }
}
