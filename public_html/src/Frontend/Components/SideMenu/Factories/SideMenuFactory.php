<?php

declare(strict_types=1);

namespace OSM\Frontend\Components\SideMenu\Factories;

use OSM\Core\Models\User;
use OSM\Frontend\Components\SideMenu\Structures\SideMenu;
use OSM\Frontend\Components\SideMenu\Structures\SideMenuGroup;
use OSM\Frontend\Components\SideMenu\Structures\SideMenuItem;

class SideMenuFactory
{
    public function forUser(User $user): SideMenu
    {
        $menu = new SideMenu();

        $menu->groups[] = $this->buildTeamGroup();
        $menu->groups[] = $this->buildOfficeGroup();
        $menu->groups[] = $this->buildCupsGroup();
        $menu->groups[] = $this->buildCommunityGroup();
        $menu->groups[] = $this->buildUserGroup();

        return $menu;
    }

    public function buildTeamGroup(): SideMenuGroup
    {
        $group = new SideMenuGroup();
        $group->title = _d('frontend', 'Team');

        $group->items[] = (new SideMenuItem())
            ->setText(_d('frontend', 'Team'))
            ->setUrl('/team');

        return $group;
    }

    public function buildOfficeGroup(): SideMenuGroup
    {
        $group = new SideMenuGroup();
        $group->title = _d('frontend', 'Office');

        return $group;
    }

    public function buildCupsGroup(): SideMenuGroup
    {
        $group = new SideMenuGroup();
        $group->title = _d('frontend', 'Cups');

        return $group;
    }

    public function buildCommunityGroup(): SideMenuGroup
    {
        $group = new SideMenuGroup();
        $group->title = _d('frontend', 'Community');

        return $group;
    }

    public function buildUserGroup(): SideMenuGroup
    {
        $group = new SideMenuGroup();
        $group->title = _d('frontend', 'User');

        return $group;
    }
}
