<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateOptionsTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('options', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->string('name');
            $table->string('value');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('options');
    }
}
