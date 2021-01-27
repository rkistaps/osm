<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class User extends AbstractModel
{
    public string $username;
    public string $password;
}
