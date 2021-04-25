<?php

declare(strict_types=1);

namespace OSM\Frontend\Exceptions\Http;

use Exception;
use Throwable;

class AbstractHttpException extends Exception
{
    public const HTTP_STATUS_NOT_FOUND = 404;

    /**
     * @var int HTTP status code, such as 403, 404, 500, etc.
     */
    public int $statusCode;

    public function __construct($status, $message = null, $code = 0, Throwable $previous = null)
    {
        $this->statusCode = $status;
        parent::__construct($message, $code, $previous);
    }
}
