<?php

namespace OSM\Frontend\Helpers;

class Html
{
    protected static array $selfClosingTags = ['input'];

    public static function tag(string $tag, string $content = '', array $options = []): string
    {
        $result = '<' . $tag . ' ' . self::buildAttributes($options) . '>';

        return in_array($tag, self::$selfClosingTags) ? $result : $result . $content . '</' . $tag . '>';
    }

    public static function button(string $value, array $options = []): string
    {
        return self::tag('button', $value, $options);
    }

    public static function submitButton(string $value, array $options = []): string
    {
        $options['type'] = 'submit';
        $options['value'] = $value;

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

    public static function checkbox(string $name, bool $isChecked = false, array $options = []): string
    {
        // todo finish me
        return '';
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
}
