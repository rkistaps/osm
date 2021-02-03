<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreatePlayerNameTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('player_names', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->integer('country_id');
            $table->string('type');
            $table->string('value');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('player_names');
    }
}
