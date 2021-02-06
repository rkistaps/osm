<?php

declare(strict_types=1);

namespace OSM\Modules\Options\Structures;

use OSM\Core\Models\Option;
use OSM\Core\Translations\Structures\Domains;
use OSM\Modules\Options\Interfaces\OptionGroupInterface;

class PlayerOptionGroup implements OptionGroupInterface
{
    public const OPTION_EXPERIENCE_LIMIT = Option::GROUP_PLAYERS . '/experience-limit';

    public function getTitle(): string
    {
        return td(Domains::DOMAIN_BACKEND, 'Player options');
    }

    public function getDescription(): string
    {
        return td(Domains::DOMAIN_BACKEND, 'Player options');
    }

    public function getKey(): string
    {
        return Option::GROUP_PLAYERS;
    }

    public function getOptionDefinitions(): array
    {
        return [
            OptionDefinition::fromArray([
                'name' => self::OPTION_EXPERIENCE_LIMIT,
                'label' => td(Domains::DOMAIN_BACKEND, 'Experience limit'),
                'defaultValue' => 400,
            ]),
        ];
    }
}
