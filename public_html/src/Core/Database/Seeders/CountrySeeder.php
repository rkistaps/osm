<?php

declare(strict_types=1);

namespace OSM\Core\Database\Seeders;

use OSM\Core\Database\Interfaces\DatabaseSeederInterface;
use OSM\Core\Repositories\CountryRepository;

class CountrySeeder implements DatabaseSeederInterface
{
    private array $data = [
        [
            'name' => 'Latvia',
            'short_name' => 'lva',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Estonia',
            'short_name' => 'est',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Lithuania',
            'short_name' => 'ltu',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Scotland',
            'short_name' => 'sct',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Czech Republic',
            'short_name' => 'cze',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Ukraine',
            'short_name' => 'ukr',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Denmark',
            'short_name' => 'dnk',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'England',
            'short_name' => 'eng',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'France',
            'short_name' => 'fra',
            'skin_tones' => '1,2,3,4,5',
        ],
        [
            'name' => 'Germany',
            'short_name' => 'deu',
            'skin_tones' => '1,2,3,4,5',
        ],
        [
            'name' => 'Greece',
            'short_name' => 'grc',
            'skin_tones' => '2,3,4',
        ],
        [
            'name' => 'Italy',
            'short_name' => 'ita',
            'skin_tones' => '2,3,4,5',
        ],
        [
            'name' => 'Netherlands',
            'short_name' => 'nld',
            'skin_tones' => '1,2,3,4,5',
        ],
        [
            'name' => 'Portugal',
            'short_name' => 'prt',
            'skin_tones' => '2,3,4,5',
        ],
        [
            'name' => 'Russia',
            'short_name' => 'rus',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Spain',
            'short_name' => 'esp',
            'skin_tones' => '2,3,4,5',
        ],
        [
            'name' => 'Sweden',
            'short_name' => 'swe',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Turkey',
            'short_name' => 'tur',
            'skin_tones' => '1,2,3,4,5',
        ],
        [
            'name' => 'Norway',
            'short_name' => 'nor',
            'skin_tones' => '1,2,3,4,5',
        ],
        [
            'name' => 'Romania',
            'short_name' => 'rou',
            'skin_tones' => '2,3,4',
        ],
        [
            'name' => 'Bosnia and Herzegovina',
            'short_name' => 'bih',
            'skin_tones' => '2,3,4',
        ],
        [
            'name' => 'USA',
            'short_name' => 'usa',
            'skin_tones' => '1,2,3,4,5',
        ],
        [
            'name' => 'Finland',
            'short_name' => 'fin',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Belgium',
            'short_name' => 'bel',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Poland',
            'short_name' => 'pol',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'China',
            'short_name' => 'chn',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Japan',
            'short_name' => 'jpn',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Brazil',
            'short_name' => 'bra',
            'skin_tones' => '3,4,5',
        ],
        [
            'name' => 'Argentina',
            'short_name' => 'arg',
            'skin_tones' => '2,3,4,5',
        ],
        [
            'name' => 'Austria',
            'short_name' => 'aut',
            'skin_tones' => '1,2,3',
        ],
        [
            'name' => 'Mexico',
            'short_name' => 'mex',
            'skin_tones' => '2,3,4,5',
        ],
        [
            'name' => 'Switzerland',
            'short_name' => 'che',
            'skin_tones' => '2,3,4,5',
        ],
        [
            'name' => 'Israel',
            'short_name' => 'isr',
            'skin_tones' => '2,3,4',
        ],
        [
            'name' => 'Ireland',
            'short_name' => 'irl',
            'skin_tones' => '2,3,4,5',
        ],
    ];

    private CountryRepository $countryRepository;

    public function __construct(
        CountryRepository $countryRepository
    ) {
        $this->countryRepository = $countryRepository;
    }

    public function seed()
    {
        $this->countryRepository->truncate();

        foreach ($this->data as $countryData) {
            $this->countryRepository->createModel($countryData, true);
        }
    }
}
