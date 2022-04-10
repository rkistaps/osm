<?php

declare(strict_types=1);

namespace OSM\Frontend\Components\SideMenu\Structures;

use OSM\Core\Helpers\Traits\FromArrayTrait;

class SideMenuGroup
{
    use FromArrayTrait;

    public string $title;

    /** @var SideMenuItem[] */
    public array $items = [];
}
