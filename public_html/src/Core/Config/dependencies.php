<?php

use AutoMapperPlus\AutoMapper;
use League\Plates\Engine;
use Opis\Database\Connection;
use Opis\Database\Database;
use OSM\Core\Factories\AutomapperFactory;
use OSM\Core\Factories\TemplateEngineFactory;
use OSM\Core\Interfaces\SessionInterface;
use OSM\Frontend\Services\SessionService;
use Psr\Container\ContainerInterface;
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
    SessionInterface::class => fn(ContainerInterface $container) => $container->get(SessionService::class),
    Database::class => function (ConfigInterface $config) {
        $connection = new Connection(
            'mysql:host=' . $config->get('database.host') . ';dbname=' . $config->get('database.name'),
            $config->get('database.username'),
            $config->get('database.password')
        );

        return new Database($connection);
    },
    AutoMapper::class => fn(ConfigInterface $config, AutoMapperFactory $autoMapperFactory) => $autoMapperFactory->fromConfig($config),
];
