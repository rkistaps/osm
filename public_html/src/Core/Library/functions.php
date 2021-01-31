<?php

declare(strict_types=1);

use OSM\Core\Translations\Structures\Domains;
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

function getContainer(): \Psr\Container\ContainerInterface
{
    return App::getContainer();
}
