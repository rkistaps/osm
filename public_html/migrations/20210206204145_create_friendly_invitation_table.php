<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CreateFriendlyInvitationTable extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->createTable('friendly_invitations', function (\Opis\Database\Schema\CreateTable $table) {
            $table->integer('id')->autoincrement();
            $table->string('type')->notNull();
            $table->integer('home_team_id')->notNull();
            $table->integer('away_team_id')->notNull();
            $table->integer('round')->notNull();
            $table->boolean('seen')->defaultValue(false)->notNull();

            $table->index(['type', 'home_team_id']);
            $table->index(['type', 'away_team_id']);
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->dropTable('friendly_invitations');
    }
}
