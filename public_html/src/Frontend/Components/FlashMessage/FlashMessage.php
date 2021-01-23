<?php

declare(strict_types=1);

namespace OSM\Frontend\Components\FlashMessage;

use League\Plates\Engine;
use OSM\Frontend\Components\AbstractComponent;
use OSM\Frontend\Services\AlertService;

class FlashMessage extends AbstractComponent
{
    private AlertService $alertService;

    public function __construct(
        Engine $engine,
        AlertService $alertService
    ) {
        parent::__construct($engine);
        $this->alertService = $alertService;
    }

    public function render(): string
    {
        return $this->renderView('index', [
            'alerts' => $this->alertService->getAlerts(),
        ]);
    }
}
