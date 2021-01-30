<?php

declare(strict_types=1);

namespace OSM\Modules\Options\Interfaces;

use OSM\Modules\Options\Structures\OptionDefinition;

interface OptionGroupInterface
{
    /**
     * Get option group title
     * @return string
     */
    public function getTitle(): string;

    /**
     * Get option group description
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get unique option group key
     * @return string
     */
    public function getKey(): string;

    /**
     * Return array of option definitions
     * @return OptionDefinition[]
     */
    public function getOptionDefinitions(): array;
}
