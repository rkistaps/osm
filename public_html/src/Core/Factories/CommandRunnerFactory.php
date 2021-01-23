<?php

declare(strict_types=1);

namespace OSM\Core\Factories;

use DI\Container;
use TheApp\Components\CommandRunner;
use TheApp\Factories\CommandHandlerFactory;
use TheApp\Interfaces\CommandConfiguratorInterface;
use TheApp\Interfaces\ConfigInterface;

class CommandRunnerFactory
{
    private Container $container;
    private CommandHandlerFactory $commandHandlerFactory;

    public function __construct(
        Container $container,
        CommandHandlerFactory $commandHandlerFactory
    ) {
        $this->container = $container;
        $this->commandHandlerFactory = $commandHandlerFactory;
    }

    public function fromConfig(ConfigInterface $config): CommandRunner
    {
        $runner = new CommandRunner(
            $this->container,
            $this->commandHandlerFactory
        );

        $configurators = $config->get('command.configurators', []);
        foreach ($configurators as $configuratorClass) {
            $configurator = $this->container->get($configuratorClass);

            if (is_a($configurator, CommandConfiguratorInterface::class)) {
                $configurator->configureCommands($runner);
            }
        }

        return $runner;
    }
}

