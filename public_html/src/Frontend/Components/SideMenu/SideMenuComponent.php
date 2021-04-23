<?php

declare(strict_types=1);

namespace OSM\Frontend\Components\SideMenu;

use OSM\Frontend\Components\AbstractComponent;
use OSM\Frontend\Components\SideMenu\Factories\SideMenuFactory;
use OSM\Frontend\Modules\Site\Services\AuthorizationService;

class SideMenuComponent extends AbstractComponent
{
    public function render(): string
    {
        $authService = $this->genericFactory->get(AuthorizationService::class);

        $factory = $this->genericFactory->get(SideMenuFactory::class);
        $activeUser = $authService->getActiveUser();
        $activeTeam = $authService->getActiveTeam();

        return $this->renderView('index', [
            'sideMenu' => $factory->build($activeUser, $activeTeam),
        ]);
    }
}
