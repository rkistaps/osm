<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class User extends AbstractModel
{
    public int $id;
    public string $username;
    public string $password;
}
