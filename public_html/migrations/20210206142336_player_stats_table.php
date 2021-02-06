<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class PlayerStatsTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('player_stats', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->integer('player_id');
            $table->integer('team_id');
            $table->integer('season');
            $table->string('type');
            $table->integer('value');

            $table->foreign('player_id')
                ->references('players', 'id')
                ->onDelete('cascade');


            $table->index(['player_id', 'type', 'team_id']);
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('player_stats');
    }
}
