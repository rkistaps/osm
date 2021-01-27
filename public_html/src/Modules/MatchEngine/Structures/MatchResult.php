<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class MatchResult
 * @package OSM\Modules\MatchEngine\Structures
 */
class MatchResult
{
    public MatchStats $stats;
    public Lineup $homeTeamLineup;
    public Lineup $awayTeamLineup;
    public bool $isHomeTeamWalkover = false;
    public bool $isAwayTeamWalkover = false;

    /** @var MatchEvent[] */
    public array $events = [];

    /**
     * MatchResult constructor.
     */
    public function __construct()
    {
        $this->stats = new MatchStats();
    }

    public function addMatchEvent(MatchEvent $event)
    {
        $this->events[] = $event;
    }

    /**
     * @param MatchEvent[] $events
     */
    public function addMatchEvents(array $events)
    {
        $this->events = array_merge($this->events, $events);
    }

    public function homeTeamWins(): bool
    {
        return $this->stats->homeTeamGoals > $this->stats->awayTeamGoals || $this->isAwayTeamWalkover;
    }

    public function awayTeamWins(): bool
    {
        return $this->stats->homeTeamGoals < $this->stats->awayTeamGoals || $this->isHomeTeamWalkover;
    }

    public function isDraw(): bool
    {
        return $this->stats->homeTeamGoals === $this->stats->awayTeamGoals && !$this->isWalkover();
    }

    public function isWalkover(): bool
    {
        return $this->isHomeTeamWalkover || $this->isAwayTeamWalkover;
    }
}
