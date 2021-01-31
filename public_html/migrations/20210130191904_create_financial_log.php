<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateFinancialLog extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('finance_logs', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->integer('team_id');
            $table->string('event');
            $table->float('change');
            $table->float('result');
            $table->dateTime('date');

            $table->foreign('team_id')
                ->references('teams', 'id')
                ->onDelete('cascade');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('finance_logs');
    }
}
