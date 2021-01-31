<?php

namespace OSM\Core\Helpers\Traits;

trait FromArrayTrait
{
    /**
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data = [])
    {
        $obj = new self();

        foreach (get_class_vars(get_class($obj)) as $property => $default) {
            if (!array_key_exists($property, $data)) {
                continue;
            }
            $obj->{$property} = $data[$property];
        }
        return $obj;
    }
}
