<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\ChampionshipLeagueCollection;
use OSM\Core\Models\AbstractModel;
use OSM\Core\Models\ChampionshipLeague;

/**
 * @method ChampionshipLeague saveModel(AbstractModel $model, array $properties = [])
 * @method ChampionshipLeagueCollection findAll(array $condition = [])
 * @method ChampionshipLeague|null findById(int $id)
 */
class ChampionshipLeagueRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'championship_leagues';
    }

    protected function getModelClassName(): string
    {
        return ChampionshipLeague::class;
    }

    protected function getCollectionClassName(): string
    {
        return ChampionshipLeagueCollection::class;
    }

    public function getMaxLevelByChampionshipId(int $championshipId): int
    {
        return (int)$this
            ->buildQuery([
                'championship_id' => $championshipId,
            ])
            ->max('level');
    }

    public function findAllByChampionshipId(int $championshipId): ChampionshipLeagueCollection
    {
        return $this->findAll(['championship_id' => $championshipId]);
    }

    public function findByChampionshipAndTeam(int $championshipId, int $teamId): ?ChampionshipLeague
    {
        return $this->buildQuery([
            'championship_id' => $championshipId,
            'championship_tables.team_id' => $teamId,
        ])
            ->join('championships', function ($join) {
                $join->on('championship_leagues.id', 'championships.id');
            })
            ->join('championship_tables', function ($join) {
                $join->on('championship_leagues.id', 'championship_tables.championship_league_id');
            })
            ->select('championship_leagues.*')
            ->fetchClass($this->getModelClassName())
            ->first() ?: null;
    }
}
