<?php

declare(strict_types=1);

namespace OSM\Frontend\Traits;

use OSM\Core\Helpers\StringHelper;
use Psr\Http\Message\ServerRequestInterface;

trait FromRequestTrait
{
    /**
     * @param ServerRequestInterface $request
     * @return self
     */
    public static function fromRequest(ServerRequestInterface $request)
    {
        $calledClass = get_called_class();
        $obj = new $calledClass();

        $data = $request->getParsedBody() ?? [];

        foreach (get_class_vars(get_class($obj)) as $property => $default) {
            $snakeCased = StringHelper::toSnakeCase($property);
            if (!array_key_exists($snakeCased, $data)) {
                continue;
            }
            $obj->{$property} = $data[$snakeCased];
        }
        return $obj;
    }
}
