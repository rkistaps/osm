<?php

declare(strict_types=1);

namespace OSM\Frontend\Components\FlashMessage;

use OSM\Frontend\Components\AbstractComponent;
use OSM\Frontend\Services\AlertService;

class FlashMessage extends AbstractComponent
{
    public function render(): string
    {
        return $this->renderView('index', [
            'alerts' => $this->genericFactory->get(AlertService::class)->getAlerts(),
        ]);
    }
}
