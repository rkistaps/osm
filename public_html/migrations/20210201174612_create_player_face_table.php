<?php

declare(strict_types=1);

use Opis\Database\Schema\CreateTable;
use OSM\Core\Abstracts\AbstractMigration;

class CreatePlayerFaceTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('player_faces', function (CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->integer('player_id');
            $table->integer('skin_tone');
            $table->integer('facial_hair_type');
            $table->integer('hair_type');
            $table->integer('hair_color');
            $table->integer('eye_type');
            $table->integer('eye_color');
            $table->integer('mouth_type');
            $table->integer('mouth_color');
            $table->integer('shirt_color');

            $table->foreign('player_id')
                ->references('players', 'id')
                ->onDelete('cascade');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('player_faces');
    }
}
