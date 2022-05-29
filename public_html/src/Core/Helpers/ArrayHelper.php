<?php

declare(strict_types=1);

namespace OSM\Core\Helpers;

class ArrayHelper
{
    public static function mapUniqueFilter(callable $callable, array $data): array
    {
        return
            array_values(
                array_unique(
                    array_filter(
                        array_map(
                            $callable,
                            $data
                        )
                    )
                )
            );
    }
}