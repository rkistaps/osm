<?php

use OSM\Frontend\Components\FlashMessage\FlashMessage;
use OSM\Frontend\Components\Overview\Overview;
use OSM\Frontend\Components\SideMenu\SideMenuComponent;
use OSM\Frontend\Components\System\System;

?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
        'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php $this->insert('Partials/_head') ?>
</head>
<body>
<div id='logo_wrap'>
    <div id='topMenu'></div>
    <a href='/'>
        <img src='/assets/images/html/logo.png' alt=''/>
    </a>
</div>
<div class='width_wrap' id="app">
    <div class='top'>
        <?= System::build()->render() ?>
    </div>
    <div class='middle'>
        <div id='head'>
            <div id='slideshow'>
                <script language="JavaScript" type="text/javascript">
                    <?php
                    $slides = array_map(function ($index) {
                        return '/assets/images/slides/' . $index . '.png';
                    }, range(1, 9));
                    ?>
                    var slides = <?=json_encode($slides)?>;
                    var i = 0;
                </script>
                <div class='current' style='background-image:url(<?= json_encode($slides[0]) ?>)'></div>
                <div class='next' style='background-image:url(<?= json_encode($slides[1]) ?>)'></div>
            </div>
            <img class='overlay' src='/assets/images/html/top_overlay.png' alt=''/>
            <img class='tools' src='/assets/images/html/tools.png' alt=''/>
            <?= Overview::build()->render() ?>
        </div>
        <div class='body'>
            <div class="container-fluid p-0">
                <div class="row pt-3">
                    <div class="col-3">
                        <?= SideMenuComponent::build()->render() ?>
                    </div>
                    <div class="col-9">
                        <?= FlashMessage::build()->render() ?>
                        <?= $this->section('content'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id='footer'>
        <?php $this->insert('Partials/_footer') ?>
    </div>
</div>
<script src="https://kit.fontawesome.com/0466ae457f.js" crossorigin="anonymous"></script>
<script src="/dist/js/index.min.js"></script>
</body>
</html>
