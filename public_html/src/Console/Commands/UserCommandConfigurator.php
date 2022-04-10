<?php

declare(strict_types=1);

namespace OSM\Console\Commands;

use OSM\Core\Repositories\UserRepository;
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

        $commandRunner->addCommand(self::PREFIX . '/find', function (int $id, UserRepository $repository) {
            $user = $repository->findById($id);

            var_dump($user);
        });

        $commandRunner->addCommand(self::PREFIX . '/set-password', function (
            int $id,
            $password,
            UserCreationService $creationService,
            LoggerInterface $logger,
            UserRepository $userRepository
        ) {
            $user = $userRepository->findById($id);

            if ($user) {
                $user->password = $creationService->hashPassword($password);
                $userRepository->saveModel($user);
                $logger->info('Password changed');
                return;
            }

            $this->logger->error('User not found');
        });
    }
}
