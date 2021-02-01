<?php

declare(strict_types=1);

namespace OSM\Modules\Players\Creation\Services;

use OSM\Core\Collections\PlayerNameCollection;
use OSM\Core\Components\ArrayCache;
use OSM\Core\Factories\ArrayCacheFactory;
use OSM\Core\Models\Country;
use OSM\Core\Models\PlayerName;
use OSM\Core\Repositories\PlayerNameRepository;
use OSM\Modules\Players\Creation\Structures\NameSurnameStructure;

class PlayerNameResolverService
{
    private PlayerNameRepository $nameRepository;
    private ArrayCache $arrayCache;

    public function __construct(
        PlayerNameRepository $nameRepository,
        ArrayCacheFactory $cacheFactory
    ) {
        $this->nameRepository = $nameRepository;
        $this->arrayCache = $cacheFactory->getForClass(self::class);
    }

    public function getForCountry(Country $country): NameSurnameStructure
    {
        /** @var PlayerNameCollection $entries */
        $entries = $this->arrayCache->getOrSet((string)$country->id, function () use ($country) {
            return $this->nameRepository->findForCountryId($country->id);
        });

        /** @var PlayerName $name */
        $name = $entries->where('type', PlayerName::TYPE_NAME)->random();

        /** @var PlayerName $surname */
        $surname = $entries->where('type', PlayerName::TYPE_SURNAME)->random();

        $result = new NameSurnameStructure();
        $result->name = $name ? $name->value : '';
        $result->surname = $surname ? $surname->value : '';

        return $result;
    }
}
