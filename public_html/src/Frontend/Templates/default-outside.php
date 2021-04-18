<?php

use OSM\Frontend\Components\FlashMessage\FlashMessage;
use OSM\Frontend\Components\LoginForm\LoginForm;

?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
        'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <title>OneSkill Manager!</title>
    <meta http-equiv='content-type' content="text/html; charset=utf-8"/>
    <link rel='icon' href='/assets/images/html/star.png' type='image/x-icon'/>
    <link rel='shortcut icon' href='/assets/images/html/star.png' type='image/x-icon'/>
    <link rel="stylesheet" href="/assets/new-src/css/opensans.css" type="text/css"/>
    <link rel="stylesheet" href="/assets/new-src/css/stylesheet.css" type="text/css"/>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    
    <meta property="og:image" content="/assets/image/dark_logo.png"/>
</head>
<body>
<div id='logo_wrap'>
    <div id='topMenu'></div>
    <a id='loggedin_logo' href='index.php?page=news'><img src='/assets/images/html/logo.png' alt=''/></a>
</div>
<div class='width_wrap' id="app">
    <div class='top'></div>
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
            <?= LoginForm::build()->render() ?>
        </div>
        <div class='body'>
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-12 pt-3">
                        <?php echo FlashMessage::build()->render() ?>
                        <?php echo $this->section('content'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id='facebook'>
        <div class='borderhide'>
        </div>
    </div>
    <div id='footer'>
        <a href='?page=terms'>Terms and Conditions</a> - <a href='?page=privacy'>Privacy</a> - <a href='?page=rules'>Rules</a> - <a href='?page=osmstaff'>Staff</a> - <a class='fancybox' href='?page=main&method=fancy&show=contact_form'>Contact</a><a href='?page=bugs'> - Bug reports</a><br/>Copyright &copy; 2011 - 2019 OneSkill Manager<br/></div>
</div>

<script src="https://kit.fontawesome.com/0466ae457f.js" crossorigin="anonymous"></script>
<script src="/assets/js/index.min.js"></script>
<!--<script type="text/javascript" src="/assets/new-src/javascripts/jquery.js"></script>-->
<!--<script type="text/javascript" src="/assets/new-src/javascripts/jquery-ui.js"></script>-->
<!--<script type="text/javascript" src="/assets/new-src/javascripts/checkboxes.js"></script>-->
<!--<script type="text/javascript" src="/assets/new-src/javascripts/main.js?1"></script>-->
<!--<script type="text/javascript" src="/assets/new-src/javascripts/sortable.js"></script>-->
<!--<script type="text/javascript" src="/assets/new-src/javascripts/fancybox.js"></script>-->
<!--<script type="text/javascript" src="/assets/new-src/javascripts/scripts.js"></script>-->

</body>
</html>
