<?php

declare(strict_types=1);

namespace OSM\Core\Database\Seeders;

use League\Flysystem\Filesystem;
use OSM\Core\Collections\CountryCollection;
use OSM\Core\Database\Interfaces\DatabaseSeederInterface;
use OSM\Core\Models\Country;
use OSM\Core\Models\PlayerName;
use OSM\Core\Repositories\CountryRepository;
use OSM\Core\Repositories\PlayerNameRepository;

class PlayerNameSeeder implements DatabaseSeederInterface
{
    private Filesystem $filesystem;
    private PlayerNameRepository $nameRepository;
    private CountryRepository $countryRepository;

    private ?CountryCollection $countryCollection = null;

    public function __construct(
        Filesystem $filesystem,
        PlayerNameRepository $nameRepository,
        CountryRepository $countryRepository
    ) {
        $this->filesystem = $filesystem;
        $this->nameRepository = $nameRepository;
        $this->countryRepository = $countryRepository;
    }

    public function seed()
    {
        $this->nameRepository->truncate();

        $this->seedNames();
        $this->seedSurnames();
    }

    public function seedNames()
    {
        $response = $this->filesystem->read('/data/names.csv');

        foreach (explode(PHP_EOL, $response) as $i => $line) {
            if (!$i) {
                continue;
            }
            $parts = explode(',', $line);

            $name = $parts[1] ?? null;
            $countryName = $parts[2] ?? null;

            if (!$name || !$countryName) {
                continue;
            }

            $country = $this->getCountry($countryName);
            if (!$country) {
                continue;
            }

            $this->nameRepository->createModel([
                'type' => PlayerName::TYPE_NAME,
                'value' => $name,
                'country_id' => $country->id,
            ], true);
        }
    }

    public function seedSurnames()
    {
        $response = $this->filesystem->read('/data/surnames.csv');

        foreach (explode(PHP_EOL, $response) as $i => $line) {
            if (!$i) {
                continue;
            }
            $parts = explode(',', $line);

            $surname = $parts[1] ?? null;
            $countryName = $parts[2] ?? null;

            if (!$surname || !$countryName) {
                continue;
            }

            $country = $this->getCountry($countryName);
            if (!$country) {
                continue;
            }

            $this->nameRepository->createModel([
                'type' => PlayerName::TYPE_SURNAME,
                'value' => $surname,
                'country_id' => $country->id,
            ], true);
        }
    }

    private function getCountry(string $countryName): ?Country
    {
        $this->countryCollection = $this->countryCollection ?? $this->countryRepository->findAll();

        return $this->countryCollection->first(fn(Country $country) => $country->name === $countryName);
    }
}
