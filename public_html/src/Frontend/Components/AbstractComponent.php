<?php

declare(strict_types=1);

namespace OSM\Frontend\Components;

use League\Plates\Engine;
use OSM\Core\Factories\GenericFactory;
use ReflectionClass;
use TheApp\Apps\WebApp;

abstract class AbstractComponent
{
    protected Engine $engine;
    protected GenericFactory $genericFactory;

    public function __construct(
        Engine $engine,
        GenericFactory $genericFactory
    ) {
        $this->engine = $engine;
        $this->genericFactory = $genericFactory;

        $this->engine->addFolder(get_called_class(), $this->getViewFolderPath());
    }

    /**
     * @return static
     */
    public static function build(): AbstractComponent
    {
        return WebApp::getContainer()->get(get_called_class());
    }

    protected function renderView(string $view, array $params = [])
    {
        return $this->engine->render(get_called_class() . '::' . $view, $params);
    }

    public function getViewFolderPath()
    {
        $class = new ReflectionClass($this);

        return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'Views';
    }
}