<?php

use OSM\Frontend\Modules\Site\ViewModels\ErrorViewModel;
use OSM\Frontend\Templates\LayoutTypes;

/** @var ErrorViewModel $error */

$this->layout(LayoutTypes::TYPE_DEFAULT);

echo $error->title;