<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup\Services;

use Psr\Http\Message\RequestInterface;

class LineupSaveTacticsService
{
    public function __construct()
    {

    }

    public function processSave(RequestInterface $request): bool
    {
        return true;
    }
}