<?php

declare(strict_types=1);

namespace OSM\Frontend\Helpers\Vue;

use OSM\Core\Helpers\StringHelper;
use OSM\Frontend\Helpers\Html;

class VueComponent
{
    private string $name;
    private array $properties = [];

    public function __construct(string $name, array $properties = [])
    {
        $this->name = $name;
        $this->properties = $properties;
    }

    public static function create(string $name, array $properties = []): VueComponent
    {
        return new self($name, $properties);
    }

    public function getTagName(): string
    {
        return StringHelper::toSnakeCase($this->name);
    }

    public function getComponentName(): string
    {
        return StringHelper::toPascal($this->name);
    }

    public function render(): string
    {
        return Html::tag($this->getTagName(), '', $this->properties);
    }
}
