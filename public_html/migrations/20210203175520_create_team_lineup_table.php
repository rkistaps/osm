<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateTeamLineupTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('team_lineups', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->integer('team_id');
            $table->string('name')->notNull();
            $table->boolean('is_default')->defaultValue(false)->notNull();
            $table->string('passing_style')->notNull();
            $table->string('defensive_line')->notNull();
            $table->string('tactic')->notNull();
            $table->string('pressure')->notNull();

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
        $this->dropTable('team_lineups');
    }
}
