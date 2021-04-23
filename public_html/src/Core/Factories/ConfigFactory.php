<?php

declare(strict_types=1);

namespace OSM\Core\Factories;

use TheApp\Factories\ConfigFactory as AppConfigFactory;
use TheApp\Interfaces\ConfigInterface;

class ConfigFactory extends AppConfigFactory
{
    public function build(): ConfigInterface
    {
        $global = require APP_ROOT . '/src/Core/Config/config.php';

        $local = [];
        if (file_exists(APP_ROOT . '/src/Core/Config/config-local.php')) {
            $local = require APP_ROOT . '/src/Core/Config/config-local.php';
        }

        return $this->fromArray($local + $global);
    }
}
