<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateMatchReportTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('match_reports', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->integer('match_id')->notNull();
            $table->string('event_type')->notNull();
            $table->string('report_type')->notNull();
            $table->integer('minute')->notNull();
            $table->integer('parent_report_id');
            $table->integer('match_report_text_id')->notNull();
            $table->integer('player_a_id');
            $table->integer('player_b_id');
            $table->integer('helper_a_id');
            $table->integer('helper_b_id');

            $table->foreign('match_id')
                ->references('matches', 'id')
                ->onDelete('cascade');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('match_reports');
    }
}
