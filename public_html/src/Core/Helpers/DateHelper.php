<?php

declare(strict_types=1);

namespace OSM\Core\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function getDatetimeString(Carbon $carbon = null): string
    {
        $carbon = $carbon ?? Carbon::now();

        return $carbon->toDateTimeString();
    }
}
