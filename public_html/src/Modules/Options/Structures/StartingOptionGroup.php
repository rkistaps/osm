<?php

declare(strict_types=1);

namespace OSM\Modules\Options\Structures;

use OSM\Core\Models\Option;

class StartingOptionGroup implements \OSM\Modules\Options\Interfaces\OptionGroupInterface
{
    const OPTION_MONEY = Option::GROUP_STARTING . '/money';
    const OPTION_STADIUM_SIZE = Option::GROUP_STARTING . '/stadium-size';
    const OPTION_SUPPORTERS = Option::GROUP_STARTING . '/supporters';

    /**
     * Get option group title
     * @return string
     */
    public function getTitle(): string
    {
        return t('app', 'Starting options');
    }

    /**
     * Get option group description
     * @return string
     */
    public function getDescription(): string
    {
        return t('app', 'Starting option values');
    }

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return Option::GROUP_STARTING;
    }

    /**
     * @inheritDoc
     */
    public function getOptionDefinitions(): array
    {
        return [
            OptionDefinition::fromArray([
                'name' => self::OPTION_MONEY,
                'label' => t('app', 'Money'),
                'defaultValue' => 1000000,
            ]),
            OptionDefinition::fromArray([
                'name' => self::OPTION_SUPPORTERS,
                'label' => t('app', 'Supporters'),
                'defaultValue' => 1000,
            ]),
            OptionDefinition::fromArray([
                'name' => self::OPTION_STADIUM_SIZE,
                'label' => t('app', 'Stadium size'),
                'defaultValue' => 1000,
            ]),
        ];
    }
}
