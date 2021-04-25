<?php

declare(strict_types=1);

namespace OSM\Frontend\Helpers\Vue;

use OSM\Frontend\Helpers\Html;
use TheApp\Apps\App;

class VueApp
{
    private string $id;

    /** @var VueComponent[] */
    private array $components = [];

    public function __construct()
    {
        $this->id = 'app-' . str_random(10);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public static function create(): VueApp
    {
        return new self();
    }

    public static function get(): VueApp
    {
        return App::getContainer()->get(VueApp::class);
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'components' => collect($this->components)
                ->keyBy(fn(VueComponent $component) => $component->getTagName())
                ->map(fn(VueComponent $component) => $component->getComponentName())
                ->all(),
        ];
    }

    public function addComponent(VueComponent $component): VueApp
    {
        $this->components[] = $component;

        return $this;
    }

    public function render(): string
    {
        return Html::tag(
            'div',
            $this->renderComponents(),
            ['id' => $this->id]
        );
    }

    private function renderComponents(): string
    {
        $tags = array_map(
            fn(VueComponent $component) => $component->render(),
            $this->components
        );

        return implode($tags);
    }
}
