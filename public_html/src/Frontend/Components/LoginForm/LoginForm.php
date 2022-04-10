<?php

declare(strict_types=1);

namespace OSM\Frontend\Components\LoginForm;

use OSM\Core\Interfaces\SessionInterface;
use OSM\Frontend\Components\AbstractComponent;

class LoginForm extends AbstractComponent
{
    public function render()
    {
        $authError = $this->genericFactory->get(SessionInterface::class)->getFlash('auth-error', false);

        return $this->renderView('index', [
            'error' => $authError,
        ]);
    }
}
