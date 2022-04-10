<?php

use Opis\Database\Schema\CreateTable;
use OSM\Core\Abstracts\AbstractMigration;

class CreateCountryTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('countries', function (CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->string('name')->unique();
            $table->string('short_name', 3)->unique();
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('countries');
    }
}
