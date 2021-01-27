<?php

declare(strict_types=1);

namespace OSM\Core\Factories;

use Opis\Database\Connection;
use Opis\Database\Database;
use TheApp\Interfaces\ConfigInterface;

class DatabaseFactory
{
    public function fromConfig(ConfigInterface $config): Database
    {
        $connection = new Connection(
            'mysql:host=' . $config->get('database.host') . ';dbname=' . $config->get('database.name'),
            $config->get('database.username'),
            $config->get('database.password')
        );

        return new Database($connection);
    }
}
