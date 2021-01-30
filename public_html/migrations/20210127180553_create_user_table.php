<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateUserTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('users', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->string('username')->unique();
            $table->string('password');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
