<?php

/** @var OSMState $state */

use OSM\Core\Structures\OSMState;
use OSM\Frontend\Helpers\Html;

?>
<div id='system'>
    <?= _d("frontend", "Server time") ?>: <?= $state->getCurrentDateTime() ?>.
    <?= _d("frontend", "Online") ?>:
    <?= Html::a(str_replace("[count]", '???', _d("frontend", "[count] users")), '/online') ?>
    (<?= Html::a('???', '/new-users') ?>)
</div>
