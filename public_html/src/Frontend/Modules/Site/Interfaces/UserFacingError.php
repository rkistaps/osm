<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Site\Interfaces;

interface UserFacingError
{
    /**
     * @return string
     */
    public function getMessage();
}
