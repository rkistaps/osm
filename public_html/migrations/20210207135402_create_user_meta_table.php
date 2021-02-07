<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateUserMetaTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('user_metas', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->integer('user_id');
            $table->string('key')->notNull();
            $table->string('value');

            $table->foreign('user_id')
                ->references('users', 'id')
                ->onDelete('cascade');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('user_metas');
    }
}
