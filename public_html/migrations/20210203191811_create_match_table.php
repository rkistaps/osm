<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;
use OSM\Core\Models\Match;

class CreateMatchTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('matches', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id');
            $table->integer('home_team_id')->notNull();
            $table->integer('away_team_id')->notNull();
            $table->integer('home_team_lineup_id');
            $table->integer('away_team_lineup_id');
            $table->string('series_type')->notNull();
            $table->integer('series_id');
            $table->integer('series_round');
            $table->integer('home_team_goals')->defaultValue(0)->notNull();
            $table->integer('away_team_goals')->defaultValue(0)->notNull();
            $table->boolean('is_played')->defaultValue(false)->notNull();
            $table->boolean('is_walkover')->defaultValue(false)->notNull();
            $table->string('ticket_price_level')->defaultValue(Match::TICKET_PRICE_LEVEL_NORMAL)->notNull();

            $table->index(['home_team_id', 'series_type']);
            $table->index(['away_team_id', 'series_type']);
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('matches');
    }
}
