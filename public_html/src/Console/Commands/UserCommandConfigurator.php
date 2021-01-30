<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use OSM\Modules\Users\Exceptions\UserCreationException;
use OSM\Modules\Users\Services\UserCreationService;
use Psr\Log\LoggerInterface;
use TheApp\Components\CommandRunner;
use TheApp\Interfaces\CommandConfiguratorInterface;

class UserCommandConfigurator implements CommandConfiguratorInterface
{
    public const PREFIX = 'users';
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function configureCommands(CommandRunner $commandRunner)
    {
        $commandRunner->addCommand(self::PREFIX . '/create', function (
            $username,
            $password,
            UserCreationService $creationService
        ) {
            try {
                $user = $creationService->create($username, $password);
                $this->logger->info('User created: ' . $user->id);
            } catch (UserCreationException $exception) {
                $this->logger->error($exception->getMessage());
            }
        });
    }
}
