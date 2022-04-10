<?php

declare(strict_types=1);

use OSM\Core\Translations\Structures\Domains;
use Psr\Container\ContainerInterface;
use TheApp\Apps\App;

function t(string $text): string
{
    return td(Domains::DOMAIN_DEFAULT, $text);
}

function td(string $domain, string $text): string
{
    // todo implement translations
    return $text;
}

function getContainer(): ContainerInterface
{
    return App::getContainer();
}

function _d($domain, $message): string
{
    return dgettext($domain, $message);
}

function _f(string $text): string
{
    return _d('frontend', $text);
}