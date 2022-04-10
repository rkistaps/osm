<?php use OSM\Frontend\Helpers\AssetManager; ?>

<title>OneSkill Manager!</title>
<meta http-equiv='content-type' content="text/html; charset=utf-8"/>
<link rel='icon' href='/assets/images/html/star.png' type='image/x-icon'/>
<link rel='shortcut icon' href='/assets/images/html/star.png' type='image/x-icon'/>
<link rel="stylesheet" href="/assets/new-src/css/opensans.css" type="text/css"/>
<link rel="stylesheet" href="/assets/new-src/css/stylesheet.css" type="text/css"/>
<!-- CSS only -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<meta property="og:image" content="/assets/image/dark_logo.png"/>

<?php echo AssetManager::get()->renderRegisteredAssets(AssetManager::LOCATION_HEAD); ?>
