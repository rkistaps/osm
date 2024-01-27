<?php

use OSM\Frontend\Components\FlashMessage\FlashMessage;
use OSM\Frontend\Components\Overview\Overview;
use OSM\Frontend\Components\SideMenu\SideMenuComponent;
use OSM\Frontend\Components\SlideShow\SlideShowComponent;
use OSM\Frontend\Components\System\System;
use OSM\Frontend\Helpers\AssetManager;

?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
        'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php $this->insert('Partials/_head') ?>
</head>
<body>
<div id="app">
    <div class="width_wrap" id="logo_wrap">
        <div id='topMenu'></div>
        <a href='/news'><img src='/assets/images/html/logo.png' alt=''/></a>
    </div>
    <div class='width_wrap'>
        <div class='top'>
            <?= System::build()->render() ?>
        </div>
        <div class='middle'>
            <div id='head'>
                <slideshow></slideshow>
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
</div>
<?php echo AssetManager::get()->renderRegisteredAssets(); ?>
<script src="https://kit.fontawesome.com/0466ae457f.js" crossorigin="anonymous"></script>

<script type="text/javascript">
    const VueAppData = <?php echo json_encode($vueApp->getData())?>;
</script>

<script src="/dist/js/index.bundle.js"></script>
</body>
</html>
