<?php

declare(strict_types=1);

namespace OSM\Modules\Options\Repositories;

use OSM\Modules\Options\Interfaces\OptionGroupInterface;
use OSM\Modules\Options\Structures\StartingOptionGroup;

class OptionGroupRepository
{
    /**
     * Get option groups
     * @return OptionGroupInterface[]
     */
    public function getOptionGroups()
    {
        return [
            new StartingOptionGroup(),
        ];
    }
}
