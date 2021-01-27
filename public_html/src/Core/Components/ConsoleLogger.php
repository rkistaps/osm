<?php

declare(strict_types=1);

namespace OSM\Core\Components;

use Psr\Log\LoggerInterface;
use Romanato\ColoringoCLI\Coloringo;

class ConsoleLogger implements LoggerInterface
{
    private const PREFIX_INFO = 'INFO: ';
    private const PREFIX_WARNING = 'WARNING: ';
    private const PREFIX_ERROR = 'ERROR: ';

    private Coloringo $coloringo;

    public function __construct(Coloringo $coloringo)
    {
        $this->coloringo = $coloringo;
    }

    public function emergency($message, array $context = [])
    {
        echo $this->coloringo->out($message);
    }

    public function alert($message, array $context = [])
    {
        echo $this->coloringo->out($message);
    }

    public function critical($message, array $context = [])
    {
        echo $this->coloringo->out($message);
    }

    public function error($message, array $context = [])
    {
        echo $this->coloringo->out(self::PREFIX_ERROR . $message);
    }

    public function warning($message, array $context = [])
    {
        echo $this->coloringo->out(self::PREFIX_WARNING . $message);
    }

    public function notice($message, array $context = [])
    {
        echo $this->coloringo->out($message);
    }

    public function info($message, array $context = [])
    {
        echo $this->coloringo->out(self::PREFIX_INFO . $message);
    }

    public function debug($message, array $context = [])
    {
        echo $this->coloringo->out($message);
    }

    public function log($level, $message, array $context = [])
    {
        echo $this->coloringo->out($message);
    }
}
