<?php

declare(strict_types=1);

namespace OSM\Frontend\Services;

use OSM\Core\Interfaces\SessionInterface;

class SessionService implements SessionInterface
{
    private const SESSION_KEY_FLASH = '_flash';

    private array $flashValues = [];

    public function __construct()
    {
        $this->startSession();

        $this->flashValues = (array)$this->get(self::SESSION_KEY_FLASH, []);
        $this->clear(self::SESSION_KEY_FLASH);
    }

    public function set(string $key, $value)
    {
        $this->startSession();
        $_SESSION[$key] = $value;
    }

    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function clear(string $key)
    {
        unset($_SESSION[$key]);
    }

    public function setFlash(string $key, $value)
    {
        $currentValues = $this->get(self::SESSION_KEY_FLASH, []);
        $currentValues[$key] = $value;

        $this->set(self::SESSION_KEY_FLASH, $currentValues);
    }

    public function getFlash(string $key, $default = null)
    {
        return $this->flashValues[$key] ?? $default;
    }

    public function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}
