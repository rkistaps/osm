<?php

declare(strict_types=1);

use Opis\Database\Schema\AlterTable;
use OSM\Core\Abstracts\AbstractMigration;

class AlterChampionshipTablesTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->alterTable('championship_tables', function (AlterTable $table) {
            $table->renameColumn('championship_id', 'championship_league_id');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->alterTable('championship_tables', function (AlterTable $table) {
            $table->renameColumn('championship_league_id', 'championship_id');
        });
    }
}
