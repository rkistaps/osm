<?php

declare(strict_types=1);

namespace OSM\Frontend\Services;

use OSM\Core\Interfaces\SessionInterface;
use OSM\Frontend\Structures\Alert;
use Throwable;

class AlertService
{
    private const SESSION_KEY = 'alerts';

    private SessionInterface $session;

    public function __construct(
        SessionInterface $session
    ) {
        $this->session = $session;
    }

    /**
     * @return Alert[]
     */
    public function getAlerts(): array
    {
        return array_map(
            fn($alertData) => Alert::fromArray($alertData),
            $this->session->getFlash(self::SESSION_KEY, [])
        );
    }

    public function success(string $message)
    {
        $this->addAlert(Alert::TYPE_SUCCESS, $message);
    }

    public function info(string $message)
    {
        $this->addAlert(Alert::TYPE_INFO, $message);
    }

    public function warning(string $message)
    {
        $this->addAlert(Alert::TYPE_WARNING, $message);
    }

    /**
     * @param string|Throwable $message
     */
    public function error($message)
    {
        $message = is_a($message, Throwable::class)
            ? $message->getMessage()
            : $message;

        $this->addAlert(Alert::TYPE_ERROR, $message);
    }

    public function addAlert(string $type, string $message)
    {
        if (!in_array($type, Alert::TYPES)) {
            return;
        }

        $currentAlerts = $this->session->getFlash(self::SESSION_KEY, []);
        $currentAlerts = is_array($currentAlerts) ? $currentAlerts : [];

        $currentAlerts[] = [
            'type' => $type,
            'message' => $message,
        ];

        $this->session->setFlash(self::SESSION_KEY, $currentAlerts);
    }
}
