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
        $factory = $this->genericFactory->get(SideMenuFactory::class);
        $activeUser = $this->genericFactory->get(AuthorizationService::class)->getActiveUser();

        return $this->renderView('index', [
            'sideMenu' => $factory->forUser($activeUser),
        ]);
    }
}
