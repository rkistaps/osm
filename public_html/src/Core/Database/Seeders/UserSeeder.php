<?php

declare(strict_types=1);

namespace OSM\Core\Database\Seeders;

use OSM\Core\Database\Interfaces\DatabaseSeederInterface;
use OSM\Modules\Users\Exceptions\UserCreationException;
use OSM\Modules\Users\Services\UserCreationService;
use Psr\Log\LoggerInterface;

class UserSeeder implements DatabaseSeederInterface
{
    private UserCreationService $userCreationService;
    private LoggerInterface $logger;

    public function __construct(
        UserCreationService $userCreationService,
        LoggerInterface $logger
    ) {
        $this->userCreationService = $userCreationService;
        $this->logger = $logger;
    }

    public function seed()
    {
        try {
            $this->userCreationService->create('admin', 'admin');
        } catch (UserCreationException $exception) {
            $this->logger->info('Failed to create admin user: ' . $exception->getMessage());
        }
    }
}
