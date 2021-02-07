<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateRegistryTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('registry', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->string('key');
            $table->string('value');

            $table->unique('key');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('registry');
    }
}
