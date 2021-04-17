<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Services;

use OSM\Core\Exceptions\InvalidArgumentException;
use OSM\Core\Models\Championship;
use OSM\Core\Models\ChampionshipLeague;
use OSM\Core\Models\Match;
use OSM\Core\Repositories\ChampionshipLeagueRepository;
use OSM\Core\Repositories\ChampionshipRepository;
use OSM\Core\Repositories\MatchRepository;
use OSM\Modules\Series\Common\Services\LeagueTableUpdatingService;
use Psr\Log\LoggerInterface;

class LeagueRunnerService
{
    private ChampionshipRepository $championshipRepository;
    private MatchRepository $matchRepository;
    private ChampionshipLeagueRepository $leagueRepository;
    private LoggerInterface $logger;
    private LeagueTableUpdatingService $leagueTableUpdatingService;
    private LeagueMatchRunnerService $matchRunnerService;
    private LeagueMatchIncomeService $incomeService;

    public function __construct(
        LoggerInterface $logger,
        MatchRepository $matchRepository,
        ChampionshipRepository $championshipRepository,
        ChampionshipLeagueRepository $leagueRepository,
        LeagueTableUpdatingService $leagueTableUpdatingService,
        LeagueMatchRunnerService $matchRunnerService,
        LeagueMatchIncomeService $incomeService
    ) {
        $this->matchRunnerService = $matchRunnerService;
        $this->championshipRepository = $championshipRepository;
        $this->matchRepository = $matchRepository;
        $this->leagueRepository = $leagueRepository;
        $this->logger = $logger;
        $this->leagueTableUpdatingService = $leagueTableUpdatingService;
        $this->incomeService = $incomeService;
    }

    public function runNextRoundForAllLeagues()
    {
        $championships = $this->championshipRepository->findByType(Match::TYPE_CHAMPIONSHIP_LEAGUE);
        foreach ($championships->all() as $championship) {
            $this->runNextRoundForChampionship($championship);
        }
    }

    public function runNextRoundForChampionship(Championship $championship)
    {
        if (!$championship->isLeague()) {
            throw new InvalidArgumentException('Invalid championship type');
        }

        $leagues = $this->leagueRepository->findAllByChampionshipId($championship->id);
        foreach ($leagues->all() as $league) {
            $this->runLeagueRound($championship, $league, $championship->round);
        }
    }

    public function runLeagueRound(Championship $championship, ChampionshipLeague $league, int $round)
    {
        $matches = $this->matchRepository->findUnplayedByRoundAndChampionship(
            $round,
            $championship,
            $league
        );

        // process match income
        $this->incomeService->processMatchIncome($matches, $championship, $league);

        foreach ($matches->all() as $match) {
            $this->matchRunnerService->runLeagueMatch($match, $league, $championship);
        }

        $this->leagueTableUpdatingService->updateChampionshipLeagueTable($championship, $league);
    }

    public function runNextLeagueRoundIdByLeagueId(int $leagueId)
    {
        $league = $this->getLeagueById($leagueId);
        $championship = $this->getChampionshipByLeague($league);

        $this->runLeagueRound(
            $championship,
            $league,
            $championship->round
        );
    }

    public function runLeagueRoundIdByLeagueId(int $leagueId, int $round)
    {
        $league = $this->getLeagueById($leagueId);
        $championship = $this->getChampionshipByLeague($league);

        $this->runLeagueRound(
            $championship,
            $league,
            $round
        );
    }

    protected function getLeagueById(int $leagueId): ChampionshipLeague
    {
        $league = $this->leagueRepository->findById($leagueId);
        if (!$league) {
            throw new \InvalidArgumentException('League not found');
        }

        return $league;
    }

    protected function getChampionshipByLeague(ChampionshipLeague $league): Championship
    {
        $championship = $this->championshipRepository->findById($league->championshipId);
        if (!$championship || !$championship->isLeague()) {
            throw new InvalidArgumentException('Invalid championship type');
        }

        return $championship;
    }
}
