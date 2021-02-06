<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Friendlies\Exceptions;

use Exception;
use OSM\Frontend\Modules\Site\Interfaces\UserFacingError;
use Throwable;

class FriendlyAlreadyBookedException extends Exception implements UserFacingError
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ?: t('Other team already has a friendly in selected round');

        parent::__construct($message, $code, $previous);
    }
}
