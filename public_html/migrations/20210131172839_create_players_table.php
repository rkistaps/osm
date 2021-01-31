<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreatePlayersTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('players', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->string('name');
            $table->string('surname');
            $table->integer('age');
            $table->double('skill');
            $table->integer('talent');
            $table->integer('energy');
            $table->integer('injury_days')->defaultValue(0);
            $table->integer('country_id');
            $table->integer('team_id');
            $table->string('position', 1);
            $table->integer('experience');
            $table->string('speciality');
            $table->string('character');
            $table->double('salary');
            $table->integer('number');
            $table->boolean('is_youth')->defaultValue(false);

            $table->foreign('country_id')
                ->references('countries', 'id');

            $table->foreign('team_id')
                ->references('teams', 'id')
                ->onDelete('cascade');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('players');
    }
}
