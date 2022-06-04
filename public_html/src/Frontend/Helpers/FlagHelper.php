<?php

declare(strict_types=1);

namespace OSM\Frontend\Helpers;

use OSM\Core\Models\Country;

class FlagHelper
{
    public static function countryFlagLink(Country $country, array $options = []): string
    {
        $flagOptions = $options['flagOptions'] ?? [];
        unset($options['flagOptions']);

        return LinkHelper::countryWithContent($country, self::countryFlag($country, $flagOptions), $options);
    }

    public static function countryFlag(Country $country, array $options = []): string
    {
        return Html::img('/assets/images/flags/' . $country->name . '.png', $options);
    }

    public static function countryFlagLinkSmall(Country $country, array $options = []): string
    {
        $flagOptions = $options['flagOptions'] ?? [];
        unset($options['flagOptions']);

        return LinkHelper::countryWithContent($country, self::countryFlagSmall($country, $flagOptions), $options);
    }

    public static function countryFlagSmall(Country $country, array $options = []): string
    {
        return Html::img('/assets/images/flags_small/' . $country->name . '.png', $options);
    }
}