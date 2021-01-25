<?php

declare(strict_types=1);

namespace OSM\Core\Abstracts;

use Opis\Database\Database;
use Opis\Database\Schema;
use Phpmig\Migration\Migration;
use Psr\Container\ContainerInterface;

class AbstractMigration extends Migration
{
    public function getContainer(): ContainerInterface
    {
        return parent::getContainer()[ContainerInterface::class];
    }

    protected function getDatabase(): Database
    {
        return $this->getContainer()->get(Database::class);
    }

    protected function getSchema(): Schema
    {
        return $this->getDatabase()->schema();
    }

    protected function createTable(string $tableName, callable $callable)
    {
        $this->getSchema()->create($tableName, $callable);
    }

    protected function alterTable(string $tableName, callable $callable)
    {
        $this->getSchema()->alter($tableName, $callable);
    }

    protected function dropTable(string $tableName)
    {
        $this->getSchema()->drop($tableName);
    }

    protected function renameTable(string $tableName, string $newName)
    {
        $this->getSchema()->renameTable($tableName, $newName);
    }

    protected function truncateTable(string $tableName)
    {
        $this->getSchema()->truncate($tableName);
    }
}
