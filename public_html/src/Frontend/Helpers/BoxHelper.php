<?php

declare(strict_types=1);

namespace OSM\Frontend\Helpers;

class BoxHelper
{
    private static $items = [];

    public static function start(string $title, array $options = [])
    {
        self::$items[] = [
            'title' => $title,
            'options' => $options,
        ];

        ob_start();
    }

    public static function end(): string
    {
        $entry = array_pop(self::$items);
        $content = ob_get_clean();

        $boxOptions = ($entry['options'] ?? []) + ['class' => 'box'];

        return Html::tag(
            'div',
            Html::tag('div', $entry['title'] ?? '', ['class' => 'title']) .
            Html::tag('div', $content, ['class' => 'content']),
            $boxOptions
        );
    }
}
