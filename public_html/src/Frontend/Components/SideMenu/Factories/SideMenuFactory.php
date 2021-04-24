<?php

declare(strict_types=1);

namespace OSM\Frontend\Components\SideMenu\Factories;

use OSM\Core\Models\Team;
use OSM\Core\Models\User;
use OSM\Frontend\Components\SideMenu\Structures\SideMenu;
use OSM\Frontend\Components\SideMenu\Structures\SideMenuGroup;
use OSM\Frontend\Components\SideMenu\Structures\SideMenuItem;

class SideMenuFactory
{
    public function build(User $user, ?Team $team): SideMenu
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

        $group->items[] = (new SideMenuItem())
            ->setText(_d('frontend', 'Players'))
            ->setUrl('/players');

        $group->items[] = (new SideMenuItem())
            ->setText(_d('frontend', 'Matches'))
            ->setUrl('/matches');

        $group->items[] = (new SideMenuItem())
            ->setText(_d('frontend', 'Training'))
            ->setUrl('/training');

        $group->items[] = (new SideMenuItem())
            ->setText(_d('frontend', 'Youths'))
            ->setUrl('/youths');

        return $group;
    }

    public function buildOfficeGroup(): SideMenuGroup
    {
        $group = new SideMenuGroup();
        $group->title = _d('frontend', 'Office');

        $pageData = [
            [
                'text' => _d('frontend', 'Staff'),
                'url' => '/staff',
            ],
            [
                'text' => _d('frontend', 'Facilities'),
                'url' => '/facilities',
            ],
            [
                'text' => _d('frontend', 'Economy'),
                'url' => '/economy',
            ],
            [
                'text' => _d('frontend', 'League'),
                'url' => '/league',
            ],
            [
                'text' => _d('frontend', 'Market'),
                'url' => '/market',
            ],
            [
                'text' => _d('frontend', 'Watch list'),
                'url' => '/watch-list',
            ],
        ];

        $group->items = array_map(
            fn(array $item) => SideMenuItem::fromArray($item),
            $pageData
        );

        return $group;
    }

    public function buildCupsGroup(): SideMenuGroup
    {
        $group = new SideMenuGroup();
        $group->title = _d('frontend', 'Cups');

        $pageData = [
            [
                'text' => _d('frontend', 'World cup'),
                'url' => '/world-cup',
            ],
            [
                'text' => _d('frontend', 'National cup'),
                'url' => '/national-cup',
            ],
            [
                'text' => _d('frontend', 'Champions league'),
                'url' => '/champions-league',
            ],
            [
                'text' => _d('frontend', 'OSM cup'),
                'url' => '/osm-cup',
            ],
            [
                'text' => _d('frontend', 'Promotions cup'),
                'url' => '/promotions-cup',
            ],
            [
                'text' => _d('frontend', 'Challenge cup'),
                'url' => '/challenge-cup',
            ],
            [
                'text' => _d('frontend', 'Custom cups'),
                'url' => '/custom-cups',
            ],
        ];

        $group->items = array_map(
            fn(array $item) => SideMenuItem::fromArray($item),
            $pageData
        );

        return $group;
    }

    public function buildCommunityGroup(): SideMenuGroup
    {
        $group = new SideMenuGroup();
        $group->title = _d('frontend', 'Community');

        $pageData = [
            [
                'text' => _d('frontend', 'Forum'),
                'url' => '/forum',
            ],
            [
                'text' => _d('frontend', 'Search'),
                'url' => '/search',
            ],
            [
                'text' => _d('frontend', 'Country'),
                'url' => '/country',
            ],
            [
                'text' => _d('frontend', 'Stats'),
                'url' => '/stats',
            ],
            [
                'text' => _d('frontend', 'Manual'),
                'url' => '/manual',
            ],
            [
                'text' => _d('frontend', 'News'),
                'url' => '/news',
            ],
        ];

        $group->items = array_map(
            fn(array $item) => SideMenuItem::fromArray($item),
            $pageData
        );

        return $group;
    }

    public function buildUserGroup(): SideMenuGroup
    {
        $group = new SideMenuGroup();
        $group->title = _d('frontend', 'User');

        $pageData = [
            [
                'text' => _d('frontend', 'Mail'),
                'url' => '/mail',
            ],
            [
                'text' => _d('frontend', 'Friends'),
                'url' => '/friends',
            ],
            [
                'text' => _d('frontend', 'Profile'),
                'url' => '/profile',
            ],
            [
                'text' => _d('frontend', 'Supporter'),
                'url' => '/supporter',
            ],
            [
                'text' => _d('frontend', 'My teams'),
                'url' => '/my-teams',
            ],
            [
                'text' => _d('frontend', 'Logout'),
                'url' => '/logout',
            ],
        ];

        $group->items = array_map(
            fn(array $item) => SideMenuItem::fromArray($item),
            $pageData
        );

        return $group;
    }
}
