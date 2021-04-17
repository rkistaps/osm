<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateChampionshipLeaguesTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('championship_leagues', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->integer('championship_id');
            $table->string('name')->notNull();
            $table->integer('level')->defaultValue(1)->notNull();
            $table->integer('hardness')->defaultValue(0)->notNull();

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
        $this->dropTable('championship_leagues');
    }
}
