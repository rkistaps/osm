<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateLeagueTableTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('championship_tables', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->integer('team_id')->notNull();
            $table->integer('championship_id')->notNull();
            $table->integer('wins')->defaultValue(0)->notNull();
            $table->integer('draws')->defaultValue(0)->notNull();
            $table->integer('losses')->defaultValue(0)->notNull();
            $table->integer('goals_forward')->defaultValue(0)->notNull();
            $table->integer('goals_against')->defaultValue(0)->notNull();
            $table->integer('points')->defaultValue(0)->notNull();
            $table->integer('place')->defaultValue(0)->notNull();

            $table->foreign('championship_id')
                ->references('championships', 'id')
                ->onDelete('cascade');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('championship_tables');
    }
}
