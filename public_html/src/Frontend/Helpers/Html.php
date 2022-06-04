<?php

namespace OSM\Frontend\Helpers;

class Html
{
    protected static array $selfClosingTags = ['input', 'img'];

    public static function openTag(string $tag, array $options = []): string
    {
        return '<' . $tag . ' ' . self::buildAttributes($options) . '>';
    }

    public static function closeTag(string $tag): string
    {
        return '</' . $tag . '>';
    }

    public static function tag(string $tag, ?string $content = '', array $options = []): string
    {
        $result = self::openTag($tag, $options);

        return in_array($tag, self::$selfClosingTags) ? $result : $result . $content . self::closeTag($tag);
    }

    public static function button(string $value, array $options = []): string
    {
        return self::tag('button', $value, $options);
    }

    public static function submitButton(string $value, string $name = null, array $options = []): string
    {
        $options['type'] = 'submit';
        $options['value'] = $value;
        $options['name'] = $name;

        return self::tag('input', '', $options);
    }

    public static function inputText(string $name, string $value = '', array $options = []): string
    {
        return self::input('text', $name, $value, $options);
    }

    public static function textarea(string $name, string $value, array $options = []): string
    {
        $options['name'] = $options['name'] ?? $name;
        return self::tag('textarea', $value, $options);
    }

    public static function inputNumber(string $name, string $value, array $options = []): string
    {
        return self::input('number', $name, $value, $options);
    }

    public static function inputPassword(string $name, string $value, array $options = []): string
    {
        return self::input('password', $name, $value, $options);
    }

    public static function input(string $type, string $name, string $value, array $options = []): string
    {
        $options['name'] = $options['name'] ?? $name;
        $options['type'] = $options['type'] ?? $type;
        $options['value'] = $options['value'] ?? $value;

        return self::tag('input', '', $options);
    }

    public static function checkbox(string $name, $value, bool $isChecked = false, array $options = []): string
    {
        if ($isChecked) {
            $options['checked'] = 'checked';
        }

        return self::input(
            'checkbox',
            $name,
            $value,
            $options
        );
    }

    public static function select(string $name, array $values, $selectedValue = null, array $options = []): string
    {
        $optionList = [];

        $placeholder = $options['placeholder'] ?? null;
        if ($placeholder) {
            unset($options['placeholder']);
            $optionList[] = self::tag('option', $placeholder);
        }

        foreach ($values as $id => $value) {
            $attributes = ['value' => $id];
            if ($id === $selectedValue) {
                $attributes['selected'] = 'selected';
            }
            $optionList[] = self::tag('option', $value, $attributes);
        }
        $content = implode(PHP_EOL, $optionList);

        $options['name'] = $name;

        return self::tag('select', $content, $options);
    }

    public static function a(string $name, string $href, array $options = []): string
    {
        $options['href'] = $options['href'] ?? $href;
        return self::tag('a', $name, $options);
    }

    public static function div(string $content, array $options = []): string
    {
        return self::tag('div', $content, $options);
    }

    public static function img(string $source, array $options = []): string
    {
        $options['src'] = $source;

        return self::tag('img', null, $options);
    }

    public static function buildAttributes(array $options): string
    {
        $attributes = [];
        foreach ($options as $name => $value) {
            $attributes[] = $name . '="' . htmlspecialchars($value) . '"';
        }

        return implode(" ", $attributes);
    }

    public static function label(string $content, array $options = []): string
    {
        return self::tag('label', $content, $options);
    }

    public static function startForm(string $action, array $options = [])
    {
        $options['method'] = $options['method'] ?? 'POST';
        $options['action'] = $action;

        ob_start();
        echo Html::openTag('form', $options);
    }

    public static function endForm(): string
    {
        echo self::closeTag('form');
        return ob_get_clean();
    }
}
