<?php

namespace Tests\Helpers\FakeFactories;

use OSM\Core\Models\AbstractModel;

abstract class FakeModelFactory
{
    /**
     * Returns the ActiveRecord model class that will be mocked
     *
     * @return string
     */
    abstract public static function modelClass(): string;

    /**
     * Returns an associative array with fake data for each model attribute
     * @return array
     */
    abstract public static function fakeAttributes(): array;

    public static function create(array $data = []): AbstractModel
    {
        $modelClass = static::modelClass();
        $model = new $modelClass;

        $attributes = $data + static::fakeAttributes();
        foreach ($attributes as $attribute => $value) {
            $model->$attribute = $value;
        }

        return $model;
    }
}