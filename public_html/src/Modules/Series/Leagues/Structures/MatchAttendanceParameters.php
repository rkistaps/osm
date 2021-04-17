<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Structures;

use OSM\Core\Models\Match;

class MatchAttendanceParameters
{
    public int $level = 0;
    public int $hardness = 0;
    public int $homeFans = 0;
    public int $awayFans = 0;
    public int $homeTeamPlacement = 0;
    public int $awayTeamPlacement = 0;
    public string $ticketPriceLevel = Match::TICKET_PRICE_LEVEL_NORMAL;
    public int $staffLevel = 0;
    public float $multiplier = 1;

    /**
     * @param int $level
     * @return MatchAttendanceParameters
     */
    public function setLevel(int $level): MatchAttendanceParameters
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @param int $hardness
     * @return MatchAttendanceParameters
     */
    public function setHardness(int $hardness): MatchAttendanceParameters
    {
        $this->hardness = $hardness;
        return $this;
    }

    /**
     * @param int $homeFans
     * @return MatchAttendanceParameters
     */
    public function setHomeFans(int $homeFans): MatchAttendanceParameters
    {
        $this->homeFans = $homeFans;
        return $this;
    }

    /**
     * @param int $awayFans
     * @return MatchAttendanceParameters
     */
    public function setAwayFans(int $awayFans): MatchAttendanceParameters
    {
        $this->awayFans = $awayFans;
        return $this;
    }

    /**
     * @param int $homeTeamPlacement
     * @return MatchAttendanceParameters
     */
    public function setHomeTeamPlacement(int $homeTeamPlacement): MatchAttendanceParameters
    {
        $this->homeTeamPlacement = $homeTeamPlacement;
        return $this;
    }

    /**
     * @param int $awayTeamPlacement
     * @return MatchAttendanceParameters
     */
    public function setAwayTeamPlacement(int $awayTeamPlacement): MatchAttendanceParameters
    {
        $this->awayTeamPlacement = $awayTeamPlacement;
        return $this;
    }

    /**
     * @param string $ticketPriceLevel
     * @return MatchAttendanceParameters
     */
    public function setTicketPriceLevel(string $ticketPriceLevel): MatchAttendanceParameters
    {
        $this->ticketPriceLevel = $ticketPriceLevel;
        return $this;
    }

    /**
     * @param int $staffLevel
     * @return MatchAttendanceParameters
     */
    public function setStaffLevel(int $staffLevel): MatchAttendanceParameters
    {
        $this->staffLevel = $staffLevel;
        return $this;
    }

    /**
     * @param float|int $multiplier
     * @return MatchAttendanceParameters
     */
    public function setMultiplier($multiplier)
    {
        $this->multiplier = $multiplier;
        return $this;
    }
}
