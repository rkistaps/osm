<?php

/** @var Alert[] $alerts */

use OSM\Frontend\Structures\Alert;

foreach ($alerts as $alert) {
    ?>
    <div class='flash-message <?= $alert->type ?>'>
        <p><?= $alert->message ?></p>
        <span title='Close' class='close'></span>
    </div>
    <?php
}