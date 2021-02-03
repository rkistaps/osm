<?php

declare(strict_types=1);

use Opis\Database\Schema\CreateTable;
use OSM\Core\Abstracts\AbstractMigration;

class CreateTeamLineupPlayerTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        return $this->createTable('team_lineup_players', function (CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->integer('player_id');
            $table->integer('team_lineup_id');

            $table->foreign('player_id')
                ->references('players', 'id')
                ->onDelete('cascade');

            $table->foreign('team_lineup_id')
                ->references('team_lineups', 'id')
                ->onDelete('cascade');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('team_lineup_players');
    }
}
