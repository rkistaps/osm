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

    /** @var Alert[] $alerts */
    private array $alerts = [];

    public function __construct(
        SessionInterface $session
    ) {
        $this->session = $session;
    }

    protected function loadFlashAlerts()
    {
        $this->alerts = array_map(
            fn($alertData) => Alert::fromArray($alertData),
            $this->session->getFlash(self::SESSION_KEY, [])
        );
    }

    /**
     * @return Alert[]
     */
    public function getAlerts(): array
    {
        return $this->alerts;
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

    public function addAlert(string $type, string $message, bool $flash = true)
    {
        if (!in_array($type, Alert::TYPES)) {
            return;
        }

        if (!$flash) {
            $this->alerts[] = (new Alert())
                ->setType($type)
                ->setMessage($message);

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
