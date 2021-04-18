<?php

declare(strict_types=1);

namespace OSM\Frontend\Helpers;

use OSM\Frontend\Core\Abstracts\AbstractViewModel;

class ActiveHtml
{
    public static function fieldError(AbstractViewModel $model, string $field): string
    {
        if (!$model->hasErrors($field)) {
            return '';
        }

        return Html::tag('small', $model->getFieldError($field), ['class' => 'form-text text-danger']);
    }
}
