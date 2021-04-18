<?php

declare(strict_types=1);

namespace OSM\Frontend\Core\Builders;

use OSM\Frontend\Services\AlertService;
use TheApp\Components\Builders\ResponseBuilder as AppResponseBuilder;

class ResponseBuilder extends AppResponseBuilder
{
    private AlertService $alertService;

    public function __construct(
        AlertService $alertService
    ) {
        $this->alertService = $alertService;

        parent::__construct();
    }

    public function withError(string $errorMessage): ResponseBuilder
    {
        $this->alertService->error($errorMessage);

        return $this;
    }
}
