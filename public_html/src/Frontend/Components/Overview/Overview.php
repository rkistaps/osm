<?php

declare(strict_types=1);

namespace OSM\Frontend\Components\Overview;

use OSM\Core\Repositories\CountryRepository;
use OSM\Frontend\Components\AbstractComponent;
use OSM\Frontend\Modules\Site\Services\AuthorizationService;

class Overview extends AbstractComponent
{
    public function render(): string
    {
        $service = $this->genericFactory->get(AuthorizationService::class);
        $activeUser = $service->getActiveUser();
        $activeTeam = $service->getActiveTeam();
        $country = null;
        if ($activeTeam) {
            $country = $this->genericFactory->get(CountryRepository::class)->findById($activeTeam->countryId);
        }

        return $this->renderView('index', [
            'user' => $activeUser,
            'team' => $activeTeam,
            'country' => $country,
        ]);
    }
}
