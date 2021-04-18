<?php

declare(strict_types=1);

namespace OSM\Frontend\Core\Abstracts;

use OSM\Frontend\Traits\FromRequestTrait;

abstract class AbstractViewModel
{
    protected array $fieldErrors = [];

    use FromRequestTrait;

    public function addError(string $field, string $error): AbstractViewModel
    {
        $this->fieldErrors[$field] = $error;

        return $this;
    }

    public function getFieldError(string $field): string
    {
        return $this->fieldErrors[$field] ?? '';
    }

    public function getErrors(): array
    {
        return $this->fieldErrors;
    }

    public function isValid(): bool
    {
        return !$this->hasErrors();
    }

    public function hasErrors(string $field = null): bool
    {
        if ($field) {
            return !empty($this->fieldErrors[$field]);
        }

        return !empty($this->fieldErrors);
    }
}
