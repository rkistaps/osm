<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class AlterTeamsTableAddChampionship extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->alterTable('teams', function (\Opis\Database\Schema\AlterTable $table) {
            $table->integer('championship_id');

            $table->index('championship_id');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->alterTable('teams', function (\Opis\Database\Schema\AlterTable $table) {
            $table->dropColumn('championship_id');
        });
    }
}
