<?php

declare(strict_types=1);

namespace OSM\Frontend\Components\System;

use OSM\Core\Structures\OSMState;
use OSM\Frontend\Components\AbstractComponent;

class System extends AbstractComponent
{
    public function render(): string
    {
        $state = $this->genericFactory->get(OSMState::class);

        return $this->renderView('index', [
            'state' => $state,
        ]);
    }
}
