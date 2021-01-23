<?php

use League\Plates\Engine;
use OSM\Core\Factories\TemplateEngineFactory;
use TheApp\Components\CommandRunner;
use TheApp\Factories\CommandRunnerFactory;
use TheApp\Factories\ConfigFactory;
use TheApp\Factories\RouterFactory;
use TheApp\Interfaces\ConfigInterface;
use TheApp\Interfaces\RouterInterface;

return [
    ConfigInterface::class => fn(ConfigFactory $configFactory) => $configFactory->fromArray(require APP_ROOT . '/src/Core/Config/config.php'),
    RouterInterface::class => fn(RouterFactory $routerFactory, ConfigInterface $config) => $routerFactory->buildFromConfig($config),
    CommandRunner::class => fn(CommandRunnerFactory $commandRunnerFactory, ConfigInterface $config) => $commandRunnerFactory->fromConfig($config),
    Engine::class => fn(TemplateEngineFactory $factory, ConfigInterface $config) => $factory->fromConfig($config),
];
