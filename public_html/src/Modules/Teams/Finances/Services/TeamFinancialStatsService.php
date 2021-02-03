<?php

declare(strict_types=1);

namespace OSM\Modules\Teams\Finances\Services;

use OSM\Core\Models\FinanceStats;
use OSM\Core\Models\Team;
use OSM\Core\Repositories\FinanceStatsRepository;

class TeamFinancialStatsService
{
    public const PERIOD_WEEK = 'week';
    public const PERIOD_SEASON = 'season';
    public const PERIOD_ALL_TIME = 'all-time';

    public const PERIODS = [
        self::PERIOD_WEEK,
        self::PERIOD_SEASON,
        self::PERIOD_ALL_TIME,
    ];

    private FinanceStatsRepository $repository;

    public function __construct(FinanceStatsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function updateStats(float $amount, string $event, Team $team)
    {
        $stats = $this->repository->findAll([
            'team_id' => $team->id,
            'event' => $event,
        ]);

        foreach (self::PERIODS as $period) {
            /** @var FinanceStats $entry */
            $entry = $stats->firstWhere('period', $period);
            $entry = $entry ?? $this->repository->createModel([
                    'team_id' => $team->id,
                    'period' => $period,
                    'event' => $event,
                    'amount' => 0,
                ]);

            $entry->amount += $amount;

            $this->repository->saveModel($entry);
        }
    }
}
