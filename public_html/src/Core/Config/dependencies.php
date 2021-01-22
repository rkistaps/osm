<?php

use TheApp\Factories\ConfigFactory;
use TheApp\Factories\RouterFactory;
use TheApp\Interfaces\ConfigInterface;
use TheApp\Interfaces\RouterInterface;

return [
    ConfigInterface::class => fn(ConfigFactory $configFactory) => $configFactory->fromArray(require APP_ROOT . '/src/Core/Config/config.php'),
    RouterInterface::class => fn(RouterFactory $routerFactory, ConfigInterface $config) => $routerFactory->buildFromConfig($config),
];
