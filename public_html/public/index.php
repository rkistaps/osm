<?php

define('APP_ROOT', realpath(__DIR__ . '/..'));
define('APP_TYPE', 'frontend');

use Jasny\HttpMessage\Emitter;
use OSM\Core\Factories\ContainerFactory;
use OSM\Core\Factories\ServerRequestFactory;
use TheApp\Factories\AppFactory;

require APP_ROOT . '/vendor/autoload.php';

$container = ContainerFactory::build();
$app = AppFactory::webAppFromContainer($container);

$request = ServerRequestFactory::buildWithGlobals();
$response = $app->run($request);

$emitter = new Emitter();
$emitter->emit($response);
