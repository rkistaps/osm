<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class CountriesAddSkinTones extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->alterTable('countries', function (\Opis\Database\Schema\AlterTable $table) {
            $table->string('skin_tones');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->alterTable('countries', function (\Opis\Database\Schema\AlterTable $table) {
            $table->dropColumn('skin_tones');
        });
    }
}
