<?php

declare(strict_types=1);

namespace OSM\Core\Factories;

use OSM\Core\Structures\OSMState;

class OSMStateFactory
{
    public function build(): OSMState
    {
        $state = new OSMState();
        $state->setSeason(1);

        return $state;
    }
}
