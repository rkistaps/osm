<?php

use OSM\Core\AppTypes;
use OSM\Core\Factories\ContainerFactory;
use TheApp\Factories\AppFactory;

define('APP_ROOT', realpath(__DIR__));
define('APP_TYPE', AppTypes::TYPE_CONSOLE);

require APP_ROOT . '/vendor/autoload.php';

$container = ContainerFactory::build();
$app = AppFactory::consoleAppFromContainer($container);

$app->run($argv);
