<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateTeamsTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('teams', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->string('name')->unique();
            $table->integer('user_id')->notNull();
            $table->integer('country_id')->notNull();
            $table->integer('supporters')->defaultValue(0)->notNull();
            $table->integer('stadium_size')->defaultValue(0)->notNull();
            $table->integer('rating')->defaultValue(0)->notNull();
            $table->string('training_priority')->notNull();
            $table->string('status')->notNull();
            $table->double('money')->defaultValue(0)->notNull();
            $table->integer('rating')->defaultValue(0)->notNull();
            $table->integer('is_default')->defaultValue(1)->notNull();

            $table->index('user_id');
            $table->index('country_id');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('teams');
    }
}
