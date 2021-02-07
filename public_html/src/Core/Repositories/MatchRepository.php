<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\MatchCollection;
use OSM\Core\Models\Match;

/**
 * @method MatchCollection findAll(array $condition = [])
 * @method Match|null findById(int $id)
 */
class MatchRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'matches';
    }

    protected function getModelClassName(): string
    {
        return Match::class;
    }

    protected function getCollectionClassName(): string
    {
        return MatchCollection::class;
    }

    public function findMatchesForSeries(
        string $seriesType,
        int $round,
        ?int $seriesId = null
    ): MatchCollection {
        $cond = [
            'series_type' => $seriesType,
            'series_round' => $round,
        ];

        if ($seriesId) {
            $cond['series_id'] = $seriesId;
        }

        return $this->findAll($cond);
    }

    public function findByRoundTypeAndTeam(int $round, string $seriesType, int $teamId): ?Match
    {
        $query = $this->buildQuery([
            'series_round' => $round,
            'series_type' => $seriesType,
        ]);

        $query->andWhere(function ($query) use ($teamId) {
            $query->where('home_team_id')->is($teamId)
                ->orWhere('away_team_id')->is($teamId);
        });

        $result = $query->select()->fetchClass($this->getModelClassName())->first();

        return $result ? $result : null;
    }
}
