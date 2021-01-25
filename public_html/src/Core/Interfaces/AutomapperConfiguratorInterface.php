<?php

declare(strict_types=1);

namespace OSM\Core\Interfaces;

use AutoMapperPlus\Configuration\AutoMapperConfig;

interface AutomapperConfiguratorInterface
{
    public function configure(AutoMapperConfig $config);
}
