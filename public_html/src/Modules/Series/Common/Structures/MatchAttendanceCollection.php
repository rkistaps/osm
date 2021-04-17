<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Common\Structures;

use OSM\Core\Models\Match;

class MatchAttendanceCollection
{
    /** @var int[] */
    private array $data = [];

    public function addMatchAttendance(Match $match, int $attendance)
    {
        $this->data[$match->id] = $attendance;
    }

    public function getMatchAttendance(Match $match): int
    {
        return $this->data[$match->id] ?? 0;
    }
}
