<?php

declare(strict_types=1);

namespace OSM\Frontend\Helpers;

use OSM\Core\Models\ChampionshipLeague;
use OSM\Core\Models\Country;
use OSM\Core\Models\Player;
use OSM\Core\Models\Team;
use OSM\Core\Models\User;

class LinkHelper
{
    public static function getCountryLink(Country $country): string
    {
        return '/countries/' . $country->id;
    }

    public static function countryWithContent(Country $country, string $content, array $options = []): string
    {
        return Html::a($content, self::getCountryLink($country), $options);
    }

    public static function country(Country $country, array $options = []): string
    {
        return Html::a($country->name, self::getCountryLink($country), $options);
    }

    public static function countryFlag(Country $country, array $options = []): string
    {
        $flag = FlagHelper::countryFlagSmall($country, $options);

        return self::countryWithContent($country, $flag, $options);
    }

    public static function countryBoth(Country $country, array $options = []): string
    {
        $flagOptions = $options['flag_options'] ?? [];
        if ($flagOptions) {
            unset($options['flag_options']);
        }

        return self::countryFlag($country, $flagOptions) . ' ' . self::country($country, $options);
    }

    public static function user(User $user, array $options = []): string
    {
        return Html::a($user->username, '/users/' . $user->id, $options);
    }

    public static function team(Team $team, array $options = []): string
    {
        return Html::a($team->name, '/teams/' . $team->id, $options);
    }

    public static function league(ChampionshipLeague $league = null): string
    {
        if (!$league) {
            return _d('frontend', 'No league');
        }

        return Html::a($league->name, '/leagues/' . $league->id);
    }

    public static function player(Player $player, array $options = []): string
    {
        return Html::a($player->getFullName(), '/players/' . $player->id, $options);
    }
}
