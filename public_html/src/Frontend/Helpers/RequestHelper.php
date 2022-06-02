<?php

declare(strict_types=1);

namespace OSM\Frontend\Helpers;

use Psr\Http\Message\ServerRequestInterface;

class RequestHelper
{
    public static function getPost(ServerRequestInterface $request, string $parameter, $default = null)
    {
        return $request->getParsedBody()[$parameter] ?? $default;
    }
}