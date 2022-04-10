<?php

declare(strict_types=1);

namespace OSM\Core\Database;

use Exception;
use Opis\Database\Database;
use OSM\Core\Database\Interfaces\DatabaseSeederInterface;
use OSM\Core\Database\Seeders\CountrySeeder;
use OSM\Core\Database\Seeders\PlayerNameSeeder;
use OSM\Core\Factories\GenericFactory;
use Psr\Log\LoggerInterface;

class DatabaseSeeder
{
    private array $seeders = [
        CountrySeeder::class,
        PlayerNameSeeder::class,
    ];

    private GenericFactory $genericFactory;
    private LoggerInterface $logger;
    private Database $database;

    public function __construct(
        GenericFactory $genericFactory,
        LoggerInterface $logger,
        Database $database
    ) {
        $this->genericFactory = $genericFactory;
        $this->logger = $logger;
        $this->database = $database;
    }

    public function seed()
    {
        $this->database->getConnection()->query('SET FOREIGN_KEY_CHECKS=0');

        foreach ($this->seeders as $seederClass) {
            $this->logger->info('Creating seeder: ' . $seederClass);

            /** @var DatabaseSeederInterface $seeder */
            $seeder = $this->genericFactory->get($seederClass);

            if (!$seeder || !($seeder instanceof DatabaseSeederInterface)) {
                throw new Exception('Bad seeder class');
            }

            $this->logger->info('Seeding');
            $seeder->seed();
        }

        $this->database->getConnection()->query('SET FOREIGN_KEY_CHECKS=1');
    }
}
