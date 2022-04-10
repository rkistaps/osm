<?php

declare(strict_types=1);

namespace OSM\Frontend\Exceptions\Http;

use Throwable;

class HttpNotFoundException extends AbstractHttpException
{
    public function __construct($message = null, $code = 0, Throwable $previous = null)
    {
        parent::__construct(AbstractHttpException::HTTP_STATUS_NOT_FOUND, $message, $code, $previous);
    }
}
