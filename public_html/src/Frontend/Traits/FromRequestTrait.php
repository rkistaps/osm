<?php

declare(strict_types=1);

namespace OSM\Frontend\Traits;

use OSM\Core\Helpers\StringHelper;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionProperty;

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
            $value = $data[$snakeCased];

            $reflectionProperty = new ReflectionProperty($obj, $property);
            $type = $reflectionProperty->getType()->getName();
            switch ($type) {
                case 'int':
                    $value = (int)$value;
                    break;
                case 'bool':
                    $value = (bool)$value;
                    break;
            }

            $obj->{$property} = $value;
        }

        return $obj;
    }


}
