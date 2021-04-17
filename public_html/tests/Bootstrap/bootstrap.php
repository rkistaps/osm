<?php

use OSM\Core\AppTypes;
use OSM\Core\Factories\ContainerFactory;
use TheApp\Factories\AppFactory;

define('APP_ROOT', dirname(__DIR__, 2));

require APP_ROOT . '/vendor/autoload.php';

define('APP_TYPE', AppTypes::TYPE_CONSOLE);

$container = ContainerFactory::build();
$app = AppFactory::consoleAppFromContainer($container);
