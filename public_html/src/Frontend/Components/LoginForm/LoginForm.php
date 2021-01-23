<?php

declare(strict_types=1);

namespace OSM\Frontend\Components\LoginForm;

use OSM\Frontend\Components\AbstractComponent;

class LoginForm extends AbstractComponent
{
    public function render()
    {
        return $this->renderView('index');
    }
}
