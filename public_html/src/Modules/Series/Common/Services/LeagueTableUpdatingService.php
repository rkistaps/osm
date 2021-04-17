<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Common\Services;

use OSM\Core\Collections\ChampionshipTableCollection;
use OSM\Core\Models\Championship;
use OSM\Core\Models\ChampionshipLeague;
use OSM\Core\Models\ChampionshipTable;
use OSM\Core\Repositories\ChampionshipTableRepository;
use OSM\Core\Repositories\MatchRepository;

class LeagueTableUpdatingService
{
    private MatchRepository $matchRepository;
    private ChampionshipTableRepository $tableRepository;

    public function __construct(
        MatchRepository $matchRepository,
        ChampionshipTableRepository $tableRepository
    ) {
        $this->matchRepository = $matchRepository;
        $this->tableRepository = $tableRepository;
    }

    public function updateChampionshipLeagueTable(
        Championship $championship,
        ChampionshipLeague $league
    ) {
        $tableRows = $this->tableRepository->findByLeagueId($league->id);
        $tableRows->map(fn(ChampionshipTable $table) => $this->clearTableRow($table));

        $matches = $this->matchRepository->findPlayedByChampionshipAndLeague($championship, $league);
        foreach ($matches->all() as $match) {
            $homeTeam = $tableRows->getByTeamId($match->homeTeamId);
            $awayTeam = $tableRows->getByTeamId($match->awayTeamId);

            if ($match->isHomeTeamWin()) {
                $homeTeam->wins += 1;
                $awayTeam->losses += 1;

                $homeTeam->points += 3;
            } elseif ($match->isAwayTeamWin()) {
                $homeTeam->losses += 1;
                $awayTeam->wins += 1;

                $awayTeam->points += 3;
            } else {
                $homeTeam->draws += 1;
                $awayTeam->draws += 1;

                $homeTeam->points += 1;
                $awayTeam->points += 1;
            }

            $homeTeam->goalsForward += $match->homeTeamGoals;
            $homeTeam->goalsAgainst += $match->awayTeamGoals;

            $awayTeam->goalsForward += $match->awayTeamGoals;
            $awayTeam->goalsAgainst += $match->homeTeamGoals;
        }

        $this->saveCollection($tableRows);
    }

    public function saveCollection(ChampionshipTableCollection $collection)
    {
        $collection = $collection->sort(function (ChampionshipTable $a, ChampionshipTable $b) {
            if ($a->points > $b->points) {
                return -1;
            } elseif ($a->points < $b->points) {
                return 1;
            } elseif ($a->wins > $b->wins) {
                return -1;
            } elseif ($a->wins < $b->wins) {
                return 1;
            } elseif ($a->goalsForward > $b->goalsForward) {
                return -1;
            } elseif ($a->goalsForward < $b->goalsForward) {
                return 1;
            }

            return 0;
        });

        $place = 1;
        foreach ($collection->all() as $table) {
            $table->place = $place++;
            $this->tableRepository->saveModel($table);
        }
    }

    public function clearTableRow(ChampionshipTable $table): ChampionshipTable
    {
        $table->wins = 0;
        $table->draws = 0;
        $table->losses = 0;
        $table->goalsForward = 0;
        $table->goalsAgainst = 0;
        $table->points = 0;
        $table->place = 0;

        return $table;
    }
}
