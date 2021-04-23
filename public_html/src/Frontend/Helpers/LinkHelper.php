<?php

declare(strict_types=1);

namespace OSM\Frontend\Helpers;

use OSM\Core\Models\Country;
use OSM\Core\Models\Team;
use OSM\Core\Models\User;

class LinkHelper
{
    public static function country(Country $country, array $options = []): string
    {
        return Html::a($country->name, '/countries/' . $country->id, $options);
    }

    public static function user(User $user, array $options = []): string
    {
        return Html::a($user->username, '/users/' . $user->id, $options);
    }

    public static function team(Team $team, array $options = []): string
    {
        return Html::a($team->name, '/teams/' . $team->id, $options);
    }
}
