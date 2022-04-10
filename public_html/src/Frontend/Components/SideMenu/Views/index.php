<?php

use OSM\Frontend\Components\SideMenu\Structures\SideMenu;
use OSM\Frontend\Helpers\Html;

/** @var SideMenu $sideMenu */

?>
<?php foreach ($sideMenu->groups as $group) { ?>
    <ul class='menu'>
        <li class="head"><?= $group->title ?></li>
        <?php foreach ($group->items as $item) { ?>
            <li><?= Html::a($item->text, $item->url) ?></li>
        <?php } ?>
    </ul>
<?php } ?>
