<?php

/** @var \OSM\Core\Structures\OSMState $state */

use OSM\Frontend\Helpers\Html;

?>
<div id='system'>
    <?= _d("frontend", "Server time") ?>: <?= $state->getCurrentDateTime() ?>.
    <?= _d("frontend", "Online") ?>:
    <?= Html::a(str_replace("[count]", 0, _d("frontend", "[count] users")), '/online') ?>
    (<?= Html::a(0, '/new-users') ?>)
</div>
