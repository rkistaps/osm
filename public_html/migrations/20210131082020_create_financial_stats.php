<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateFinancialStats extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('financial_stats', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->integer('team_id');
            $table->string('period');
            $table->string('event');
            $table->float('amount');

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
        $this->dropTable('financial_stats');
    }
}
