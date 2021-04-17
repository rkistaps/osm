<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateChampionshipsTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('championships', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->string('type')->notNull();
            $table->string('name')->notNull();
            $table->integer('round')->defaultValue(1)->notNull();
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('championships');
    }
}
