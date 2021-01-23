<?php

declare(strict_types=1);

namespace OSM\Core\Factories;

use League\Plates\Engine;
use TheApp\Interfaces\ConfigInterface;

class TemplateEngineFactory
{
    public function fromConfig(ConfigInterface $config): Engine
    {
        return new Engine($config->get('templatePath') ?? '/');
    }
}
