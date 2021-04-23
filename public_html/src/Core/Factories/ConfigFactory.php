<?php

declare(strict_types=1);

namespace OSM\Core\Factories;

use OSM\Core\Components\ArrayCache;
use TheApp\Factories\ConfigFactory as AppConfigFactory;
use TheApp\Interfaces\ConfigInterface;

class ConfigFactory extends AppConfigFactory
{
    public function build(): ConfigInterface
    {
        $global = require APP_ROOT . '/src/Core/Config/config.php';

        $local = [];
        if (file_exists(APP_ROOT . '/src/Core/Config/config.php')) {
            $local = require APP_ROOT . '/src/Core/Config/config.php';
        }

        return $this->fromArray($global + $local);
    }
}
