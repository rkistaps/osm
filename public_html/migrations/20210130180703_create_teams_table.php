<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateTeamsTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('teams', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->string('name')->unique();
            $table->integer('user_id')->notNull();
            $table->integer('country_id')->notNull();
            $table->integer('supporters');
            $table->integer('stadium_size');
            $table->integer('rating');
            $table->string('training_priority');
            $table->string('status');
            $table->double('money');
            $table->integer('rating');
            $table->integer('is_default')->defaultValue(1);

            $table->index('user_id');
            $table->index('country_id');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('teams');
    }
}
