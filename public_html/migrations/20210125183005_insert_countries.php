<?php

declare(strict_types=1);

use OSM\Core\Abstracts\AbstractMigration;

class InsertCountries extends AbstractMigration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $countries = [
            [
                'name' => 'Latvia',
                'short_name' => 'lv',
            ],
            [
                'name' => 'Estonia',
                'short_name' => 'ee',
            ],
        ];

        foreach ($countries as $country) {
            $this->getDatabase()->insert($country)->into('countries');
        }
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->truncateTable('countries');
    }
}
